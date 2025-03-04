<script setup lang="ts">
import MainMenu from '@/components/MainMenu.vue';
import { ref } from 'vue';
import API from '../../config';
import router from '@/router';

const title = ref('')
const description = ref('')
const dueDate = ref('')
const erorrs = ref<{title?: string, description?: string, dueDate?: string}>({})

function validate(){
    erorrs.value = {}

    if (!title.value) {
        erorrs.value.title = 'Введите название'
    }
    if (!description.value) {
        erorrs.value.description = 'Введите описание'
    }
    if (!dueDate.value) {
        erorrs.value.dueDate = 'Введите дату'
    }

    return Object.keys(erorrs.value).length === 0

}

async function add(){
    if (!validate()) return

    const response = await fetch(`${API}/tasks`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json','Authorization': `Bearer ${localStorage.getItem('auth')}`},
        body: JSON.stringify({ title: title.value, description: description.value, dueDate: dueDate.value }),
    
    })

    if (response.ok) {
        router.push('/')
    }
}

</script>

<template>
    <div class="d-flex">
        <MainMenu />
  <div class="d-flex vh-100 w-100 justify-content-center align-items-center">
    <div style="max-width: 600px; width: 100%">
      <main class="p-4 border rounded shadow bg-white">
        <div class="mb-5 text-center">
          <img src="./static/icon.svg" style="width: 70px" alt="" class="mb-4 mx-auto d-block"/>
          <h2>Добавление новой задачи</h2>
        </div>
        <form class="needs-validation" @submit.prevent="add">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control":class="{ 'is-invalid': erorrs.title }"
              id="title" v-model="title" />
              <div v-if="erorrs.title" class="invalid-feedback">
                      {{ erorrs.title }}
                    </div>
            </div>

            <div class="col-sm-6">
              <label for="dueDate" class="form-label">Дата завершения</label>
              <input type="text" class="form-control" :class="{ 'is-invalid': erorrs.dueDate }" id="dueDate" v-model="dueDate" />
              <div v-if="erorrs.dueDate" class="invalid-feedback">
                      {{ erorrs.dueDate }}
                    </div>
            </div>

            <div class="col-12">
              <label for="description" class="form-label">Описание задачи</label>
              <input type="text" class="form-control" :class="{ 'is-invalid': erorrs.description }" id="description" v-model="description" />
              <div v-if="erorrs.description" class="invalid-feedback">
                      {{ erorrs.description }}
                    </div>
            </div>

            <div>
              <button class="w-100 btn btn-primary btn-lg" type="submit">
                Добавить
              </button>
            </div>
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
    
</template>