<template>
    <div class="flex flex-col min-h-screen">
      <header class="bg-indigo-900 text-white py-4 px-6">
        <nav class="flex justify-between items-center">
          <div class="text-xl font-bold">Battleship</div>
          <ul class="flex space-x-4">
            <li><a href="#">Home</a></li>
          </ul>
        </nav>
      </header>

      <main class="flex-1 py-8 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="bg-gray-100 p-4 rounded-lg">
            <h2 class="text-lg font-bold mb-4">Your grid</h2>
            <div class="flex justify-center">
              <table>
                <tbody>
                  <tr v-for="row in 10" :key="row">
                    <td
                      v-for="column in 10"
                      :key="column"
                      :class="[
                        'w-10 h-10 rounded-xl',
                        isYourCellSelected(row, column)
                          ? 'bg-indigo-500'
                          : 'bg-gray-200',
                      ]"
                    ></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="bg-gray-100 p-4 rounded-lg">
            <h2 class="text-lg font-bold mb-4">Opponent's grid</h2>
            <div class="flex justify-center">
              <table>
                <tbody>
                  <tr v-for="row in 10" :key="row">
                    <td
                      v-for="column in 10"
                      :key="column"
                      class="w-10 h-10 rounded-xl bg-gray-200"
                    ></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>

      <footer class="bg-indigo-900 text-white py-4 px-6">
        <div class="text-center">
          &copy; 2024 Battleship. All rights reserved.
        </div>
      </footer>
    </div>
  </template>

  <script setup>
  import { computed } from "vue";
  import { usePage } from "@inertiajs/vue3";

  const { props } = usePage();

  const yourGrid = computed(() => props.yourGrid || []);

  function isYourCellSelected(row, column) {
    return yourGrid.value.some((cell) => cell.x === column && cell.y === row);
  }
  </script>

