<script setup lang="ts">
import MainMenu from '@/components/MainMenu.vue';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import API from '../../config';
import router from '@/router';

const title = ref('')
const description = ref('')
const dueDate = ref ('')
const erorrs = ref<{title?: string, description?: string, dueDate?: string, }>({})

const route = useRoute()
const {id} = route.params

function validate(){
    erorrs.value = {}
    if(!title.value) {
        erorrs.value.title = 'Введите название'
    }
    if(!description.value) {
        erorrs.value.description = 'Введите название'
    }
    if(!dueDate.value) {
        erorrs.value.dueDate = 'Введите название'
    }

    return Object.keys(erorrs.value).length === 0
}

async function edit(id){
    if (!validate()) return

    const response = await fetch(`${API}/tasks/${id}`,{
        method: 'POST',
        headers: {'Content-Type': 'application/json','Authorization': `Bearer ${localStorage.getItem('auth')}`},
        body: JSON.stringify({
            title: title.value,
            description: description.value,
            dueDate: dueDate.value
        })
    })

    if (response.ok) {
        router.push('/')
    } 
}

</script>

<template>

    <div class="d-flex">
        <MainMenu />
        <div class="p-5 w-100 overflow-y-auto overflow-y-auto ">
        <h3 class="mb-4">Редактирование задачи</h3>
        <div>
          <h4 class="mb-3">Задача {{ id }}</h4>
          <form class="needs-validation" @submit.prevent    ="edit(id)">
            <div class="row g-3 mb-4 d-flex ">
              <div class="col-sm-6">
                <label for="fileName" class="form-label">Название</label>
                <input
                  type="text"
                  class="form-control"
                  id="fileName"
                  placeholder=""
                  required
                  v-model="title"
                />
                <div v-if="erorrs.title" class="invalid-feedback">{{erorrs.title}}</div>
              </div>
              <div class="col-sm-6">
                <label for="fileName" class="form-label">Описание</label>
                <input
                  type="text"
                  class="form-control"
                  id="fileName"
                  placeholder=""
                  required
                  v-model="description"
                />
                <div v-if="erorrs.description" class="invalid-feedback">{{erorrs.description}}</div>
              </div>
              <div class="col-sm-6">
                <label for="fileName" class="form-label">Срок выполнения</label>
                <input
                  type="text"
                  class="form-control"
                  id="fileName"
                  placeholder=""
                  required
                  v-model="dueDate"
                />
                <div v-if="erorrs.dueDate" class="invalid-feedback">{{erorrs.dueDate}}</div>
              </div>
              
            </div>
            <div class="col-sm-6 d-flex align-items-end">
              <button class="btn btn-primary" type="submit">Сохранить</button>
            </div>
        </form>
          <RouterLink class="d-flex align-items-center gap-1" to="/"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor"
              width="16"
              height="16"
            >
              <path
                fill-rule="evenodd"
                d="M12.5 9.75A2.75 2.75 0 0 0 9.75 7H4.56l2.22 2.22a.75.75 0 1 1-1.06 1.06l-3.5-3.5a.75.75 0 0 1 0-1.06l3.5-3.5a.75.75 0 0 1 1.06 1.06L4.56 5.5h5.19a4.25 4.25 0 0 1 0 8.5h-1a.75.75 0 0 1 0-1.5h1a2.75 2.75 0 0 0 2.75-2.75Z"
                clip-rule="evenodd"
              />
            </svg>
            Назад</RouterLink
          >
        </div>
      </div>
    </div>
</template>