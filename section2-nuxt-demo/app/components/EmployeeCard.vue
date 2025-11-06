<script setup lang="ts">
import type { Employee } from '../../types/employee'

defineProps<{
    employee: Employee
}>()

const defaultPicture = '/default-avatar.png' // fallback picture
</script>

<template>
    <div class="border rounded-lg p-4 shadow-md flex items-center gap-4">
        <!-- Employee Picture -->
        <img :src="employee.picture || '/cat-dev-pxls.jpg'" alt="Employee Photo" class="w-16 h-16 rounded-full" />

        <!-- Employee Info -->
        <div>
            <h2 class="font-bold text-lg">{{ employee.name }}</h2>
            <p class="text-gray-500">{{ employee.department }}</p>

            <!-- Slot for additional info -->
            <slot></slot>
        </div>
    </div>
</template>
