<template>
  <MainLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="bg-gray-100 p-4 rounded-lg">
        <div class="h-12">
          <h2 class="text-lg font-bold">Your grid</h2>
        </div>
        <div class="flex justify-center mt-4">
            <div class="grid grid-cols-10 gap-0.5 w-full max-w-md mx-auto">
              <div
                v-for="(cell, index) in 100"
                :key="index"
                :class="[
                  'aspect-square rounded-md bg-gray-200',
                  isSelected(Math.floor(index / 10) + 1, (index % 10) + 1)
                    ? 'border-2 border-gray-500'
                    : '',
                ]"
              ></div>
            </div>
          </div>
      </div>

      <div class="bg-gray-100 p-4 rounded-lg">
        <div class="flex justify-between h-12">
          <h2 class="text-lg font-bold">Opponent's grid</h2>
          <button
            @click="endGame"
            class="px-4 py-2 h-10 bg-red-500 text-white rounded hover:bg-red-600"
          >
            End game
          </button>
        </div>
        <div class="flex justify-center mt-4">
          <div class="grid grid-cols-10 gap-0.5 w-full max-w-md mx-auto">
            <div
              v-for="cell in 100"
              :key="cell"
              class="aspect-square rounded-md bg-indigo-100 hover:bg-indigo-300 hover:cursor-pointer active:bg-indigo-700 bg-"
            ></div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

  <script setup>
import { computed, onUnmounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const grid = computed(() => props.grid || []);
const gameUuid = computed(() => props.gameUuid);

function isSelected(row, column) {
  return grid.value.some((cell) => cell.x === column && cell.y === row);
}

async function endGame() {
  try {
    if (gameUuid) {
      await router.post(route("game.cancel", { uuid: gameUuid.value }));
    }
  } catch (error) {
    console.error("Error ending the game:", error);
  }
}

const handleBeforeUnload = (event) => {
  endGame();
  event.preventDefault();
  event.returnValue = "";
};

window.addEventListener("beforeunload", handleBeforeUnload);

onUnmounted(() => {
  endGame();
  window.removeEventListener("beforeunload", handleBeforeUnload);
});
</script>
