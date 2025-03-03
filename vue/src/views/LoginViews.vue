<script setup lang="ts">
import { ref } from 'vue';
import API from '../../config';
import router from '@/router'
import { RouterLink } from 'vue-router';



const email = ref('')
const password = ref('')
const errors = ref<{email?: string; password?: string}>({})
const serverErrors = ref()

 function validate(){
    errors.value = {}
    serverErrors.value = null

    if(!email.value) {
        errors.value.email = 'Введите Вашу почту'
    }

    if(!password.value) {
        errors.value.password = 'Введите Ваш пароль'
    }

    return Object.keys(errors.value).length === 0
}


async function login() {
    if (!validate()) return

        const response = await fetch(`${API}/login`, {
         method: 'POST',
         headers: {'Content-Type': 'application/json'},
         body: JSON.stringify({email: email.value, password: password.value})
        })

        const result = await response.json()

        if (result.status === 200) {
            localStorage.setItem('auth', result.token)
            router.push('/')

        } else {
            serverErrors.value = 'Неверный логин или пароль'
}


}
</script>

<template>

<div
      class="text-center d-flex justify-content-center align-items-center vh-100"
    >
      <main style="max-width: 300px" class="form-signin w-100">
        <form @submit.prevent="login">
          <img
            src="./static/icon.svg"
            style="width: 70px"
            alt=""
            class="mb-4"
          />
          <h1 class="h3 mb-4">Вход в аккаунт</h1>
          <div class="form-floating mb-2">
            <input
              type="email"
              class="form-control"
              :class="{ 'is-invalid': errors.email }"
              id="floatingInput"
              placeholder="name@example.com"
              v-model="email"
            />
            <label for="floatingInput">Почта</label>
            <div v-if="errors.email" class="invalid-feedback"> {{ errors.email }}</div>
          </div>
          <div class="form-floating mb-2">
            <input
              type="password"
              class="form-control"
              :class="{ 'is-invalid': errors.password }"
              id="floatingPassword"
              placeholder="Password"
              v-model="password"
              
            />
            <label for="floatingPassword">Пароль</label>
            <div v-if="errors.password" class="invalid-feedback"> {{ errors.password }}</div>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit" >
            Войти
          </button>

          <div v-if="serverErrors" class="alert alert-danger mt-3"> {{ serverErrors }}</div>
          <div class="mt-4">
            Нет аккаунта? <RouterLink to="/register">Зарегистрироваться</RouterLink>
          </div>
          <p class="mt-4 mb-3 text-muted">© 2021-2024</p>
        </form>
      </main>
    </div>

</template>