<template>
    <div class="flex flex-col min-h-screen">
      <NavBar />

      <main class="flex-1 py-8 px-6">
        <slot />
      </main>

      <Footer />
    </div>
  </template>

  <script setup>
  import NavBar from '@/Components/NavBar.vue'
  import Footer from '@/Components/Footer.vue'
  </script>
