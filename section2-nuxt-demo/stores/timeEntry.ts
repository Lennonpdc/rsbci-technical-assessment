// stores/timeEntry.ts
import { defineStore } from 'pinia'
import axios from 'axios'
import { ref, computed } from 'vue'
import type { TimeEntry } from '../types/timeEntries'


export const useTimeEntryStore = defineStore('timeEntryStore', () => {
    const entries = ref<TimeEntry[]>([])
    const total = ref<number>(0)
    const isLoading = ref<boolean>(false)
    const page = ref<number>(1)
    const perPage = ref<number>(10)

    const apiBase = import.meta.env.API_BASE_URL || 'http://127.0.0.1:8001'

    // Fetch time entries, optionally filtered by date range
    const fetchTimeEntries = async (employeeId: number, from?: string, to?: string) => {
        isLoading.value = true
        try {
            const response = await axios.get(`${apiBase}/api/employees/${employeeId}/time-entries`, {
                params: {
                    page: page.value,
                    per_page: perPage.value,
                    from,
                    to
                }
            })
            entries.value = response.data.data
            total.value = response.data.total
        } catch (error) {
            console.error('Failed to fetch time entries', error)
        } finally {
            isLoading.value = false
        }
    }

    // Create a new time entry
    const createTimeEntry = async (payload: { project_id: number; employee_id: number; hours: number; date: string }) => {
        isLoading.value = true
        try {
            const response = await axios.post(`${apiBase}/api/time-entries`, payload)
            entries.value.unshift(response.data) // add new entry at top
        } catch (error) {
            console.error('Failed to create time entry', error)
        } finally {
            isLoading.value = false
        }
    }

    const totalHours = computed(() => entries.value.reduce((sum, e) => sum + e.hours, 0))

    return {
        entries,
        total,
        isLoading,
        page,
        perPage,
        fetchTimeEntries,
        createTimeEntry,
        totalHours
    }
})
