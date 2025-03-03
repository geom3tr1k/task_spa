<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div>
    <router-view v-slot="{ Component }">
      <Transition name="fade" mode="out-in">
        <component :is="Component" />
      </Transition>
    </router-view>
  </div>
</template>

<style>
/* Анимация появления */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}

/* Исчезновение */
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

