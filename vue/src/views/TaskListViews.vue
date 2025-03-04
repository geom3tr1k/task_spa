<script setup lang="ts">
import MainMenu from '@/components/MainMenu.vue';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import API from '../../config';

let list = ref()
const route = useRoute()
const { id } = route.params

async function watchTasks() {

    const response = await fetch(`${API}/tasks/disk` , {
        headers: {'Authorization': `Bearer ${localStorage.getItem('auth')}`}
    })

    if (response.ok){
        const data = await response.json()
        console.log(data)
        list.value = data
    }
    
}

watchTasks()


async function deleteTask(id) {
    const response = await fetch(`${API}/tasks/${id}` , {
        method: 'DELETE',
        headers: {'Authorization': `Bearer ${localStorage.getItem('auth')}`}
    })

    if (response.ok) {
        watchTasks()
    }
}

</script>


<template>

    <div class="d-flex">
        <MainMenu />
        <div class="p-5 w-100 overflow-y-auto">
        <h3 class="mb-4">Мои task'и</h3>
        <div class="list-group"
        v-for="task in list">
          <div
            href="#"
            class="list-group-item align-items-center d-flex gap-3 py-3 "
          >
        
            <div class="row w-100 align-items-center">
              <div class="col"><b>Название</b> <br>{{ task.title }}</div>
              <div class="col text-muted"><b>Описание</b> <br>{{ task.description }}</div>
              <div class="col text-muted"><b>ID</b> <br>{{ task.id }}</div>
              <div class="col text-muted"><b>Дата завершения</b> <br>{{ task.dueDate }}</div>
              <div class="col d-flex justify-content-end">
                <div class="btn-group">
                 <button
                    type="button"
                    class="btn btn-light dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <span class="visually-hidden">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <RouterLink
                        class="dropdown-item align-items-center d-flex gap-2"
                        :to = '"/edit/" + task.id'
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 16 16"
                          fill="currentColor"
                          width="16"
                          height="16"
                        >
                          <path
                            d="M7.25 13.25V7.5h1.5v5.75a.75.75 0 0 1-1.5 0ZM8.75 2.75V5h.75a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1 0-1.5h.75V2.75a.75.75 0 0 1 1.5 0ZM2.25 9.5a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5H4.5V2.75a.75.75 0 0 0-1.5 0V9.5h-.75ZM10 10.25a.75.75 0 0 1 .75-.75h.75V2.75a.75.75 0 0 1 1.5 0V9.5h.75a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75ZM3 12v1.25a.75.75 0 0 0 1.5 0V12H3ZM11.5 13.25V12H13v1.25a.75.75 0 0 1-1.5 0Z"
                          />
                        </svg>
                        Редактировать</RouterLink
                      >
                    </li>
                    <li>
                      <RouterLink
                        class="dropdown-item align-items-center d-flex gap-2"
                        :to= '"/access/" + task.id'
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 16 16"
                          fill="currentColor"
                          width="16"
                          height="16"
                        >
                          <path
                            d="M8.5 4.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 13c.552 0 1.01-.452.9-.994a5.002 5.002 0 0 0-9.802 0c-.109.542.35.994.902.994h8ZM12.5 3.5a.75.75 0 0 1 .75.75v1h1a.75.75 0 0 1 0 1.5h-1v1a.75.75 0 0 1-1.5 0v-1h-1a.75.75 0 0 1 0-1.5h1v-1a.75.75 0 0 1 .75-.75Z"
                          />
                        </svg>
                        Права доступа</RouterLink
                      >
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                      <button @click="deleteTask(task.id)"
                        class="dropdown-item align-items-center text-danger d-flex gap-2"
                        href="#"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 16 16"
                          fill="currentColor"
                          width="16"
                          height="16"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z"
                            clip-rule="evenodd"
                          />
                        </svg>
                        Удалить</button
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>