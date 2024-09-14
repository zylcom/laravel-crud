<script setup lang="ts">
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Modal from "./Modal.vue";
import SecondaryButton from "./SecondaryButton.vue";
import DangerButton from "./DangerButton.vue";

const props = defineProps<{ title: string; message: string; href?: string; show: boolean }>();
const emit = defineEmits(["close", "delete"]);
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

                <DangerButton title="Delete" @click="$emit('delete')" :disabled="disabled">Delete</DangerButton>
            </div>
        </div>
    </Modal>
</template>
