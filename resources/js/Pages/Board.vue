<template>
  <MainLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="bg-gray-100 p-4 rounded-lg">
        <div class="flex justify-between">
          <h2 class="text-lg font-bold">Your grid</h2>

          <button
            @click="startGame"
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
          >
            Start
          </button>
        </div>

        <div class="flex justify-center mt-4">
          <table>
            <tbody>
              <tr v-for="row in 10" :key="row">
                <td
                  v-for="column in 10"
                  :key="column"
                  :data-x="column"
                  :data-y="row"
                  @click="toggleCell(row, column)"
                  :class="[
                    'w-10 h-10 rounded-xl hover:bg-indigo-300 hover:cursor-pointer active:bg-indigo-700',
                    isSelected(row, column)
                      ? 'bg-indigo-500 hover:bg-indigo-700'
                      : 'bg-indigo-100',
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
  </MainLayout>
</template>

<script setup>
import { ref } from "vue";

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
