import { defineStore } from 'pinia'
import axios from 'axios'
import { ref, computed } from 'vue'
import type { Employee } from '../types/employee'

export const useEmployeeStore = defineStore('employeeStore', () => {
    const employees = ref<Employee[]>([])
    const total = ref<number>(0)
    const isLoading = ref<boolean>(false)
    const page = ref<number>(1)
    const perPage = ref<number>(10)
    const selectedDepartment = ref<number | undefined>(undefined)
    const departmentOptions = ref([
        { id: undefined, name: 'All Departments' },
        { id: 1, name: 'Engineering' },
        { id: 2, name: 'Finance' },
        { id: 3, name: 'HR' },
    ])

    const sortByName = ref<'asc' | 'desc'>('asc')

    const apiBase = import.meta.env.API_BASE_URL || 'http://127.0.0.1:8001'

    const fetchEmployees = async () => {
        isLoading.value = true
        try {
            const response = await axios.get(`${apiBase}/api/employees`, {
                params: {
                    page: page.value,
                    per_page: perPage.value,
                    department: selectedDepartment.value ?? undefined,
                    sort: sortByName.value,
                },
            })
            employees.value = response.data.data
            total.value = response.data.total
        } catch (error) {
            console.error('Failed to fetch employees', error)
        } finally {
            isLoading.value = false
        }
    }

    const sortedEmployees = computed(() => {
        return [...employees.value].sort((a, b) => {
            if (sortByName.value === 'asc') return a.name.localeCompare(b.name)
            return b.name.localeCompare(a.name)
        })
    })

    return {
        employees,
        total,
        isLoading,
        page,
        perPage,
        departmentOptions,
        selectedDepartment,
        sortByName,
        fetchEmployees,
        sortedEmployees,
    }
})
