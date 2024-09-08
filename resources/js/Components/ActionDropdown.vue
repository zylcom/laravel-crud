<script setup lang="ts">
import { EllipsisIcon } from "lucide-vue-next";
//import { ref } from "vue";

defineProps<{
    isOpen: boolean;
    productId: number;
    productStatus: string;
}>();

defineEmits<{
    open: [id: number];
}>();
</script>

<template>
    <!-- Dropdown trigger button -->
    <button
        class="p-2 rounded-lg hover:bg-gray-100 mx-auto block"
        type="button"
        title="Action menu"
        @click="$emit('open', productId)"
    >
        <EllipsisIcon class="w-5 h-5" />
    </button>

    <!-- Dropdown menu -->
    <Transition
        enter-from-class="scale-0 opacity-0"
        enter-active-class="transition-all duration-300 ease-out"
        enter-to-class="scale-1 opacity-100"
        leave-from-class="scale-1 opacity-100"
        leave-active-class="transition-all duration-300 ease-out"
        leave-to-class="scale-0 opacity-0"
    >
        <button
            class="py-2 px-3 absolute top-1/2 -translate-y-1/2 right-24 z-10 bg-white rounded-lg border"
            :title="`${productStatus === 'available' ? 'Disable' : 'Enable'} product`"
            :class="
                productStatus === 'available'
                    ? 'hover:bg-red-100'
                    : 'hover:bg-green-100'
            "
            v-show="isOpen"
        >
            {{ productStatus === "available" ? "Disable" : "Enable" }}
        </button>
    </Transition>
</template>
