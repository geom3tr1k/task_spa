import LoginViews from '@/views/LoginViews.vue'
import { createRouter, createWebHistory } from 'vue-router'
import '../assets/bootstrap.min.css'
import '../assets/bootstrap.min.js'
import TaskListViews from '@/views/TaskListViews.vue'
import RegisterViews from '@/views/RegisterViews.vue'
import TaskAddViews from '@/views/TaskAddViews.vue'
import EditTasjViews from '@/views/EditTasjViews.vue'
import TaskAcessViews from '@/views/TaskAcessViews.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'taskList',
      component: TaskListViews,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginViews,
    },
    {
      path: '/register',
      name: 'reg',
      component: RegisterViews,
    },
    {
      path: '/add',
      name: 'Add',
      component: TaskAddViews,
    },
    {
      path: '/edit/:id',
      name: 'Edit',
      component: EditTasjViews,
    },
    {
      path: '/access/:id',
      name: 'Acess',
      component: TaskAcessViews,
    },
 
  ],
})

router.beforeEach(async(to)=>{
  const Auth = localStorage.getItem('auth')

  if (!Auth && to.name !== 'login' && to.name !== 'reg') {
    router.push('/login')
  } else if (Auth && (to.name == 'login' || to.name == 'reg')) {
    router.push('/')
  }
})
export default router
