<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { CircleXIcon } from "lucide-vue-next";
import { computed, ref, watch } from "vue";

const page = usePage();
const flash = computed(() => page.props.flash);
const show = ref(flash.value.message ? true : false);

watch(flash, (newValue) => {
    if (newValue) {
        show.value = true;
    }
});
</script>

<template>
    <div
        class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
        role="alert"
        v-if="flash.message && show"
    >
        <span class="sr-only">Alert info</span>

        <div class="ms-3 text-sm font-medium">
            {{ flash.message }}
        </div>

        <button
            type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
            aria-label="Close"
            @click="show = false"
        >
            <span class="sr-only">Close</span>
            <CircleXIcon class="w-5 h-5" />
        </button>
    </div>
</template>
