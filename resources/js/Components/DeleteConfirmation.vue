<script setup lang="ts">
import { computed, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import Modal from "./Modal.vue";
import SecondaryButton from "./SecondaryButton.vue";

const props = defineProps<{ title: string; message: string; href: string; show: boolean }>();
const emit = defineEmits(["close"]);
const show = computed(() => props.show);
const disabled = ref(false);

router.on("start", () => (disabled.value = true));
router.on("finish", () => (disabled.value = false));
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="max-h-full overflow-y-auto p-1">
            <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>

            <p class="mt-1 text-sm text-gray-600">{{ message }}</p>

            <div class="mt-6 flex justify-end gap-x-3">
                <SecondaryButton @click="$emit('close')" title="Cancel">Cancel</SecondaryButton>

                <Link
                    method="delete"
                    as="button"
                    type="button"
                    title="Delete"
                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
                    :href="href"
                    :disabled="disabled"
                >
                    Delete
                </Link>
            </div>
        </div>
    </Modal>
</template>
