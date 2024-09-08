<script setup lang="ts">
defineProps<{
    isOpen: boolean;
    onClickHandler: () => void;
}>();
</script>

<template>
    <!-- Dropdown trigger button -->
    <button
        class="p-2 rounded-lg hover:bg-gray-100 mx-auto block"
        type="button"
        title="Action menu"
        @click="onClickHandler"
    >
        <slot name="trigger" />
    </button>

    <!-- Dropdown menu -->
    <Transition
        enter-from-class="scale-0 opacity-0"
        enter-active-class="transition-all duration-300 ease-out"
        enter-to-class="scale-100 opacity-100"
        leave-from-class="scale-100 opacity-100"
        leave-active-class="transition-all duration-300 ease-out"
        leave-to-class="scale-0 opacity-0"
    >
        <div
            class="p-1 absolute top-1/2 -translate-y-1/2 right-24 z-10 bg-white rounded-lg border shadow"
            v-show="isOpen"
        >
            <slot name="menu" />
        </div>
    </Transition>
</template>
