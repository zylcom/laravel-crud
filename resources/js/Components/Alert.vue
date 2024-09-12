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
    <div class="mb-4 flex items-center rounded-lg bg-green-50 p-4 text-green-800" role="alert" v-if="flash.message && show">
        <span class="sr-only">Alert info</span>

        <div class="ms-3 text-sm font-medium">
            {{ flash.message }}
        </div>

        <button
            type="button"
            class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 p-1.5 text-green-500 hover:bg-green-200 focus:ring-2 focus:ring-green-400"
            aria-label="Close"
            @click="show = false"
        >
            <span class="sr-only">Close</span>
            <CircleXIcon class="h-5 w-5" />
        </button>
    </div>
</template>
