import LoginViews from '@/views/LoginViews.vue'
import { createRouter, createWebHistory } from 'vue-router'
import '../assets/bootstrap.min.css'
import '../assets/bootstrap.min.js'
import TaskListViews from '@/views/TaskListViews.vue'
import RegisterViews from '@/views/RegisterViews.vue'

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
