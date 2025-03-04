<script setup lang="ts">
import { useRouter } from 'vue-router';
import  API  from '../../config'

const router = useRouter()

async function logOut(){
    const result = await fetch(`${API}/logout`, {
        headers: [
            ['Content-Type', 'application/json'], 
            ['Authorization', `Bearer ${localStorage.getItem('auth')}`]]
    })

    localStorage.removeItem('auth')

    router.push('/login')
}
</script>

<template>


<div
        class="d-flex flex-column vh-100 flex-shrink-0 p-3 text-white bg-dark"
        style="width: 280px"
      >
        <RouterLink
          to="/"
          class="d-flex align-items-center mb-3 gap-3 mb-md-0 me-md-auto text-white text-decoration-none"
        >
          <img src="./static/icon.svg" style="width: 30px" alt="" />
          <span class="fs-4">Task Storage</span>
        </RouterLink>
        <hr />
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <RouterLink
              to="/"
              class="nav-link text-white d-flex align-items-center gap-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                width="16"
                height="16"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                  clip-rule="evenodd"
                />
              </svg>
              Мои файлы
            </RouterLink>
          </li>
         
          <li class="nav-item">
            <RouterLink
              to="/add"
              class="nav-link text-white d-flex align-items-center gap-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                width="16"
                height="16"
              >
                <path
                  d="M11.47 1.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1-1.06 1.06l-1.72-1.72V7.5h-1.5V4.06L9.53 5.78a.75.75 0 0 1-1.06-1.06l3-3ZM11.25 7.5V15a.75.75 0 0 0 1.5 0V7.5h3.75a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9a3 3 0 0 1 3-3h3.75Z"
                />
              </svg>
              Добавить
            </RouterLink>
          </li>
        </ul>
        <hr />
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <button @click="logOut"
              class="nav-link text-white d-flex align-items-center gap-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                width="16"
                height="16"
              >
                <path
                  fill-rule="evenodd"
                  d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z"
                  clip-rule="evenodd"
                />
              </svg>
              Выйти
            </button>
          </li>
        </ul>
      </div>

</template>