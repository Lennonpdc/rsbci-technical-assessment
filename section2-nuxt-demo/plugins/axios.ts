// plugins/axios.ts
import axios from 'axios'
import { defineNuxtPlugin } from 'nuxt/app'
import { useRouter } from 'vue-router'

export default defineNuxtPlugin(() => {
    const router = useRouter()

    // Create a custom Axios instance
    const api = axios.create({
        baseURL: import.meta.env.API_BASE_URL || 'http://127.0.0.1:8001',
        timeout: 10000,
    })

    // Response interceptor
    api.interceptors.response.use(
        response => response,
        error => {
            const status = error.response?.status

            switch (status) {
                case 401:
                    // Unauthorized: Error
                    error?.error('Session expired. Please try again.')
                    router.push('/home')
                    break
                case 422:
                    // Validation errors
                    const errors = error.response.data?.errors
                    if (errors) {
                        Object.values(errors).forEach((messages: any) => {
                            messages.forEach((msg: string) => error?.error(msg))
                        })
                    } else {
                        error?.error(error.response.data?.message || 'Validation error')
                    }
                    break
                case 500:
                    error?.error('Server error. Please try again later.')
                    console.error('Server Error:', error.response.data)
                    break
                default:
                    error?.error(error.response?.data?.message || 'An error occurred')
            }

            return Promise.reject(error)
        }
    )

    return {
        provide: {
            api,
        },
    }
})
