<script setup lang="ts">
const model = defineModel<string>({ required: true });
</script>

<template>
    <input
        type="radio"
        v-model="model"
        class="h-4 w-4 cursor-pointer border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
    />
</template>
