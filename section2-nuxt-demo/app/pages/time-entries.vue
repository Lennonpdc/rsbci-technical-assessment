<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useTimeEntryStore } from '../../stores/timeEntry'

const store = useTimeEntryStore()
const employeeId = 1 // replace with logged-in user id

onMounted(() => {
    store.fetchTimeEntries(employeeId)
})

const newEntry = ref({ project_id: 0, hours: 0, date: '' })
const addEntry = async () => {
    await store.createTimeEntry({ ...newEntry.value, employee_id: employeeId })
    newEntry.value = { project_id: 0, hours: 0, date: '' }
}
</script>


<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Time Entries</h1>

        <!-- New Entry Form -->
        <form @submit.prevent="addEntry" class="mb-6 flex gap-2 items-end">
            <div>
                <label>Project ID</label>
                <input type="number" v-model="newEntry.project_id" class="border px-2 py-1" />
            </div>
            <div>
                <label>Hours</label>
                <input type="number" v-model="newEntry.hours" class="border px-2 py-1" />
            </div>
            <div>
                <label>Date</label>
                <input type="date" v-model="newEntry.date" class="border px-2 py-1" />
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Add Entry</button>
        </form>

        <!-- Loading -->
        <div v-if="store.isLoading">Time entries is loading...</div>

        <!-- Entries Table -->
        <table v-else class="w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">Project ID</th>
                    <th class="border px-2 py-1">Hours</th>
                    <th class="border px-2 py-1">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="entry in store.entries" :key="entry.id">
                    <td class="border px-2 py-1">{{ entry.id }}</td>
                    <td class="border px-2 py-1">{{ entry.project_id }}</td>
                    <td class="border px-2 py-1">{{ entry.hours }}</td>
                    <td class="border px-2 py-1">{{ entry.date }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Total Hours -->
        <div class="mt-4 font-bold">
            Total Hours: {{ store.totalHours }}
        </div>
    </div>
</template>
