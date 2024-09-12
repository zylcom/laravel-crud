<script setup lang="ts">
import { computed } from "vue";
import Modal from "./Modal.vue";
import SecondaryButton from "./SecondaryButton.vue";
import DangerButtonLink from "./DangerButtonLink.vue";

const props = defineProps<{ title: string; message: string; href: string; show: boolean }>();
const emit = defineEmits(["close"]);
const show = computed(() => props.show);
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="max-h-full overflow-y-auto p-1">
            <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>

            <p class="mt-1 text-sm text-gray-600">{{ message }}</p>

            <div class="mt-6 flex justify-end gap-x-3">
                <SecondaryButton @click="$emit('close')" title="Cancel">Cancel</SecondaryButton>

                <DangerButtonLink :href="href" method="delete" title="Delete" asLink>Delete</DangerButtonLink>
            </div>
        </div>
    </Modal>
</template>
