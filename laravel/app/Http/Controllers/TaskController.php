<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function addTasks(Request $request) {
        $validData = $request -> validate([
            'title' => 'required',
            'description' => 'required',
            'dueDate' => 'required'
        ]);

        $validData['dueDate'] = Carbon::parse($validData['dueDate'])->toDateTimeString();

        try {
            $user = $request -> user();
            $task = $user -> createdTasks()->create($validData);
            $task->users()->attach($user->id);

            return response() -> json([
                "id" => $task -> id,
                "title" => $validData['title'],
                "description" =>  $validData['description'],
                "dueDate" =>  $validData['dueDate'],
                "authorId" => $task -> creator
              
            ], 200);
        } catch(Exception $e) {
            return response() -> json([
                "status" => 400,
                "message" => "Invalid input data"              
            ], 400);
        }
        
    }


    public function disk(Request $request) {
        $tasks = $request->user()->createdTasks()
            ->with(['users:id,email']) // Загружаем соавторов
            ->select("id", "title", "description", "dueDate", "creator as authorId")
            ->get()
            ->map(function ($task) {
                return [
                    "id" => $task->id,
                    "title" => $task->title,
                    "description" => $task->description,
                    "dueDate" => $task->dueDate,
                    "authorId" => $task->authorId,
                    "collaborators" => $task->users
                        ->where('id', '!=', $task->authorId) // Исключаем автора
                        ->map(function ($user) {
                            return [
                                "id" => $user->id,
                                "email" => $user->email
                            ];
                        })->values() // Сбрасываем ключи массива
                ];
            });
    
        return response()->json($tasks);
    }
    

    public function getTask(Request $request, $taskId) {
        $task = Task::with('users:id,email') 
            ->where('id', $taskId)
            ->first(); 
    
        if (!$task) {
            return response()->json([
                "status" => 404,
                "message" => "Task not found"
            ], 404);
        }
    
    
        return response()->json([
            "id" => $task->id,
            "title" => $task->title,
            "description" => $task->description,
            "dueDate" => $task->dueDate,
            "authorId" => $task->creator,
            "collaborators" => $task->users
                ->where('id', '!=', $task->creator) // Исключаем автора
                ->map(fn($user) => [
                    "id" => $user->id,
                    "email" => $user->email
                ])
                ->values() // Сбрасываем индексы
        ]);
    }
    
    
    public function uploadTasks(Request $request, string $id) {
        $validData = $request -> validate([
            'title' => 'required',
            'description' => 'required',
            'dueDate' => 'required',
        ]);

        $validData['dueDate'] = Carbon::parse($validData['dueDate'])->toDateTimeString();


        $task = Task::find($id);
        $userId = Auth::id(); 

        if ($task->creator !== $userId ) {
            return response()->json([
                "success" => false,
                "message" => "You are not the creator of this task"
            ], 403); }

            $task->update([
                'title' => $validData['title'],
                'description' => $validData['description'],
                'dueDate' => $validData['dueDate']
            ]);
            


        return response() -> json([
            "id" => $task -> id,
            "title" => $validData['title'],
            "description" =>  $validData['description'],
            "dueDate" =>  $validData['dueDate'],
            "authorId" => $task -> creator
          
        ], 200);    

    }

    public function deleteTask(Request $request, string $id){
        $task = Task::find($id);
        $userId = Auth::id(); 

        if ($task->creator !== $userId ) {
            return response()->json([
                "success" => false,
                "message" => "You are not the creator of this task"
            ], 403); };
        $task->users()->detach();
        $task -> delete();
        return response() -> json(
       200);
    }
    

    public function addUser(Request $request, string $id){

        $validData = $request -> validate([
            "email"=> "required|email"
        ]);

        $user = User::where('email', $request -> email) -> first();
       
        if (!$id) {
            return response() -> json([
                'message' => 'No task'
            ], 404);};

    
        $task = Task::find($id);
        $userId = Auth::id(); 

        if ($request->user()-> id !== $userId ) {
            return response()->json([
                    "success" => false,
                    "message" => "You are not the creator of this task"
            ], 403); };
            if (!$task->users->contains($user->id)) {
                $task->users()->attach($user->id);
           } else {
                return response()->json(['message' => 'This user is already added']);
           };

    }


    public function deleteUser(Request $request,  $id){
        $validData = $request->validate([
            "email"=> "string|required|email"
        ]);
        $task = Task::find($id);
        $userId = Auth::id(); 


        if($request->user()->email === $validData["email"]){
            return response()->json(["message"=>"You try delete yourself"]);
        }
        
        $user = User::where("email", $validData["email"])->first();
        
        if ($request->user()->id === $userId) {
            $task->users()->detach($user->id);
            
        };      
        
    }

    public function getCol(Request $request, $taskId) {
        $task = Task::with('users:id,email') 
            ->where('id', $taskId)
            ->first(); 
    
        if (!$task) {
            return response()->json([
                "status" => 404,
                "message" => "Task not found"
            ], 404);
        }
    
    
        return response()->json([
            "collaborators" => $task->users
                ->where('id', '!=', $task->creator) // Исключаем автора
                ->map(fn($user) => [
                    "id" => $user->id,
                    "email" => $user->email
                ])
                ->values() // Сбрасываем индексы
        ]);
    }
}
