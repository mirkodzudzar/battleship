<template>
    <header class="bg-indigo-900 text-white py-4 px-6">
      <nav class="flex justify-between items-center">
        <div class="text-xl font-bold">Battleship</div>
        <ul class="flex space-x-4">
          <li><Link :href="route('home')">Home</Link></li>
          <li><Link :href="route('game.board.index')">Play Battleship</Link></li>
        </ul>
      </nav>
    </header>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3'
  </script>
