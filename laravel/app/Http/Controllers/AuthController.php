<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request) {

        $request -> validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'lastName' => 'required',
            'firstName' => 'required'
        ]);

        $user = User::create([
            'email' => $request -> email,
            'password' => Hash::make($request -> password),
            'lastName' => $request -> lastName,
            'firstName' => $request -> firstName
        ]);

        $token = $user -> createToken('API Token') -> plainTextToken;

        return response() -> json([
            "status" => 201,
            "message"=> "User registered successfully",
            "token" => $token          
        ], 201);
    }

    public function login(Request $request) {
        $request -> validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request -> email) -> first();

        if($user && Hash::check($request -> password, $user -> password)){
            return response() -> json([
                "status" => 200,
                "message" => "Login successful",
                "token" => $user -> createToken('API Token') -> plainTextToken
            ], 200);           
        }
        
        return response() -> json([
            "status" => 401,
            "message" => "Invalid email or password",
        ], 401);           
    }


    public function logOut(Request $request) {
       try {
        $request -> user() -> currentAccessToken() -> delete();

        return response() -> json([
            "status" => 204,
            "message" => "Logout",          
        ], 204);
    } catch (Exception $e) {
           return response() -> json([
               "status" => 403,
               "message" => "Login failed",          
           ], 403);

       }
    }

}
