<template>
  <MainLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="bg-gray-100 p-4 rounded-lg">
        <div class="flex justify-between h-12">
          <h2 class="text-lg font-bold">Your grid</h2>
          <button
            @click="startGame"
            class="px-4 py-2 h-10 bg-green-500 text-white rounded hover:bg-green-600"
          >
            Start
          </button>
        </div>

        <div class="flex justify-center mt-4">
          <div class="grid grid-cols-10 gap-0.5 w-full max-w-md mx-auto">
            <div
              v-for="(cell, index) in 100"
              :key="index"
              :data-x="(index % 10) + 1"
              :data-y="Math.floor(index / 10) + 1"
              @click="toggleCell(Math.floor(index / 10) + 1, (index % 10) + 1)"
              :class="[
                'aspect-square rounded-md hover:bg-indigo-300 hover:cursor-pointer active:bg-indigo-700',
                isSelected(Math.floor(index / 10) + 1, (index % 10) + 1)
                  ? 'bg-indigo-500 hover:bg-indigo-700'
                  : 'bg-indigo-100',
              ]"
            ></div>
          </div>
        </div>
      </div>

      <div class="bg-gray-100 p-4 rounded-lg">
        <div class="h-12">
          <h2 class="text-lg font-bold mb-4">Opponent's grid</h2>
        </div>

        <div class="flex justify-center mt-4">
          <div class="grid grid-cols-10 gap-0.5 w-full max-w-md mx-auto">
            <div
              v-for="cell in 100"
              :key="cell"
              class="aspect-square rounded-md bg-gray-200"
            ></div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

  <script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const selectedCells = ref(new Set());

function toggleCell(row, column) {
  const key = `${row}-${column}`;
  if (selectedCells.value.has(key)) {
    selectedCells.value.delete(key);
  } else {
    selectedCells.value.add(key);
  }
}

function isSelected(row, column) {
  return selectedCells.value.has(`${row}-${column}`);
}

function startGame() {
  const payload = {
    moves: Array.from(selectedCells.value).map((key) => {
      const [row, column] = key.split("-").map(Number);
      return { x: column, y: row };
    }),
    token: window.guestToken,
  };

  router.post(route("game.store"), payload, {
    onError: (errors) => {
      console.error("Error starting game:", errors);
    },
  });
}
</script>
