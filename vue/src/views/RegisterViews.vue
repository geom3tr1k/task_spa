<script setup lang="ts">
import { ref } from 'vue';
import API from '../../config';
import router from '@/router';


const firstName = ref('')
const lastName = ref('')
const email = ref('')
const password = ref('')
const erorrs = ref<{
    firstName?: string,
    lastName?: string,
    email?: string,
    password?: string,
}>({})

const serverErrors = ref()


function validate(){

    erorrs.value = {}
    serverErrors.value = null

    if(!firstName.value){
        erorrs.value.firstName = 'Введите Ваше имя'
    }
    if(!lastName.value){
        erorrs.value.lastName = 'Введите Ваше имя'
    }
    if(!email.value){
        erorrs.value.email = 'Введите Ваше имя'
    }
    if(!password.value){
        erorrs.value.password= 'Введите Ваше имя'
    }

    return Object.keys(erorrs.value).length === 0
}


async function register() {
 
    if(!validate()) return

    const response = await fetch(`${API}/register`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            email: email.value,
            password: password.value,
            lastName: lastName.value,
            firstName: firstName.value
        })
    }) 

    const result = await response.json()

    if(result.status === 201) {
        localStorage.setItem('auth', result.token)
        router.push('/')
    } else {
        serverErrors.value = result.message
    }
}


</script>

<template>

<div class="d-flex vh-100 justify-content-center align-items-center px-4">
      <div style="max-width: 600px">
        <main>
          <div class="mb-5 text-center">
            <img
              src="./static/icon.svg"
              style="width: 70px"
              alt=""
              class="mb-4 mx-auto d-block"
            />
            <h2>Регистрация</h2>
          </div>
          <div>
            <form class="needs-validation" @submit.prevent="register">
              <div class="row g-3">
                <div class="col-sm-6">
                  <label for="firstName" class="form-label">Имя</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': erorrs.firstName }"
                    id="firstName"
                    placeholder=""
                    v-model="firstName"
                  />
                  <div v-if="erorrs.firstName" class="invalid-feedback">
                    {{ erorrs.firstName }}
                  </div>
                </div>

                <div class="col-sm-6">
                  <label for="lastName" class="form-label">Фамилия</label>
                  <input
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': erorrs.lastName }"
                    id="lastName"
                    placeholder=""
                    v-model="lastName"
                  />
                  <div v-if="erorrs.lastName" class="invalid-feedback">
                    {{ erorrs.lastName }}
                  </div>
                </div>

                <div class="col-12">
                  <label for="email" class="form-label">Почта</label>
                  <input
                    type="email"
                    class="form-control"
                    :class="{ 'is-invalid': erorrs.email }"
                    id="email"
                    placeholder="you@example.com"
                    v-model="email"
                  />
                  <div v-if="erorrs.email" class="invalid-feedback">
                    {{ erorrs.email }}
                  </div>
                </div>

                <div class="col-12">
                  <label for="password" class="form-label">Пароль</label>
                  <input
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': erorrs.password }"
                    id="password"
                    placeholder="*******"
                    v-model="password"
                  />  
                  <div v-if="erorrs.password" class="invalid-feedback">
                    {{ erorrs.password }}
                  </div>
                </div>

                <div>
                    <button class="w-100 btn btn-primary btn-lg" type="submit">
                        Зарегистрироваться
                    </button>
                </div>
                <div v-if="serverErrors" class="alert-danger alert mt-3">
                    {{ serverErrors }}
                </div>
              </div>
            </form>
          </div>
        </main>
        <div class="mt-4">
          Уже есть аккаунт? <a href="./login.html">Войти</a>
        </div>
        <footer class="my-3 pt-3 text-muted text-center text-small">
          <p>© 2021-2024 File Storage</p>
        </footer>
      </div>
    </div>


</template>