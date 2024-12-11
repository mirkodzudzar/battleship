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
        <div class="bg-gray-200 p-4 rounded-lg">
          <h2 class="text-lg font-bold mb-4">Your grid</h2>

          <div class="flex justify-center">
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
                      'w-10 h-10 rounded-xl hover:bg-indigo-400 hover:cursor-pointer active:bg-indigo-800',
                      isSelected(row, column)
                        ? 'bg-indigo-600 hover:bg-indigo-800'
                        : 'bg-indigo-200',
                    ]"
                  ></td>
                </tr>
              </tbody>
            </table>
          </div>

          <button
            @click="sendDataToBackend"
            class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
          >
            Start
          </button>
        </div>

        <div class="bg-gray-200 p-4 rounded-lg">
          <h2 class="text-lg font-bold mb-4">Opponent's grid</h2>

          <div class="flex justify-center">
            <table>
              <table>
                <tbody>
                  <tr v-for="row in 10" :key="row">
                    <td
                      v-for="column in 10"
                      :key="column"
                      class="w-10 h-10 rounded-xl bg-gray-300"
                    ></td>
                  </tr>
                </tbody>
              </table>
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
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { route as routeFn } from "ziggy-js";

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

function sendDataToBackend() {
  const payload = Array.from(selectedCells.value).map((key) => {
    const [row, column] = key.split("-").map(Number);
    return { x: column, y: row };
  });

  console.log("Sending data to backend:", payload);

  router.post(routeFn("game.store"), payload, {
    onSuccess: (response) => {
      console.log("Game saved:", response);
    },
    onError: (errors) => {
      console.error("Error saving game:", errors);
    },
  });
}
</script>
