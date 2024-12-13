<template>
  <MainLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="bg-gray-100 p-4 rounded-lg">
        <h2 class="text-lg font-bold">Your grid</h2>

        <div class="flex justify-center mt-4">
          <table>
            <tbody>
              <tr v-for="row in 10" :key="row">
                <td
                  v-for="column in 10"
                  :key="column"
                  :class="[
                    'w-10 h-10 rounded-xl',
                    isCellSelected(row, column)
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
        <div class="flex justify-between">
          <h2 class="text-lg font-bold">Opponent's grid</h2>

          <button
            @click="endGame"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
          >
            End game
          </button>
        </div>

        <div class="flex justify-center mt-4">
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
import { computed, onUnmounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const grid = computed(() => props.grid || []);
const gameUuid = computed(() => props.gameUuid);

function isCellSelected(row, column) {
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


