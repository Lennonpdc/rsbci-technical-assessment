<script setup lang="ts">
import { ref } from 'vue'
import { useEmployeeStore } from '../../stores/employee'
import { onMounted } from 'vue'

const store = useEmployeeStore()

const fetchEmployees = () => store.fetchEmployees()
const toggleSort = () => {
    store.sortByName = store.sortByName === 'asc' ? 'desc' : 'asc'
    fetchEmployees()
}

const prevPage = () => {
    if (store.page > 1) {
        store.page--
        fetchEmployees()
    }
}

const nextPage = () => {
    if (store.page * store.perPage < store.total) {
        store.page++
        fetchEmployees()
    }
}

// Fetch on mount
onMounted(() => {
    fetchEmployees()
})

</script>

<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Employees List</h1>

        <div class="flex gap-4 mb-4">
            <select v-model="store.selectedDepartment" @change="fetchEmployees">
                <option v-for="department in store.departmentOptions" :key="department.id" :value="department.id">
                    {{ department.name }}
                </option>
            </select>

            <button @click="toggleSort" class="px-4 py-2 bg-blue-500 text-white rounded">
                Sort by Name ({{ store.sortByName }})
            </button>
        </div>

        <div v-if="store.isLoading">Page is loading...</div>

        <table v-else class="w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">Name</th>
                    <th class="border px-2 py-1">Email</th>
                    <th class="border px-2 py-1">Department</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sortedEmployee in store.sortedEmployees" :key="sortedEmployee.id">
                    <td class="border px-2 py-1">{{ sortedEmployee.id }}</td>
                    <td class="border px-2 py-1">{{ sortedEmployee.name }}</td>
                    <td class="border px-2 py-1">{{ sortedEmployee.email }}</td>
                    <td class="border px-2 py-1">{{ sortedEmployee.department }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex gap-2">
            <button @click="prevPage" :disabled="store.page === 1">Previous</button>
            <span>Page {{ store.page }}</span>
            <button @click="nextPage" :disabled="store.page * store.perPage >= store.total">Next</button>
        </div>
    </div>
</template>
