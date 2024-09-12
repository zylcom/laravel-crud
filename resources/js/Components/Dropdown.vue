<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from "vue";

const props = withDefaults(
    defineProps<{
        align?: "left" | "right" | "left-center" | "right-center";
        index?: number | string | null;
        selectedIndex?: number | string | null;
    }>(),
    {
        align: "right",
        index: null,
        selectedIndex: null,
    },
);
const emit = defineEmits(["changeSelectedIndex"]);

const index = computed(() => props.index);
const selectedIndex = computed(() => props.selectedIndex);
const show = ref(false);
const alignmentClasses = computed(() => {
    if (props.align === "left") {
        return "ltr:origin-top-left rtl:origin-top-right start-0";
    } else if (props.align === "left-center") {
        return "ltr:origin-top-left rtl:origin-top-right start-full -top-full";
    } else if (props.align === "right") {
        return "ltr:origin-top-right rtl:origin-top-left end-0";
    } else if (props.align === "right-center") {
        return "ltr:origin-top-right rtl:origin-top-left end-full -top-full";
    } else {
        return "origin-top";
    }
});

function closeOnEscape(e: KeyboardEvent) {
    if (show.value && e.key === "Escape") {
        show.value = false;
    }
}

function toggleDropdown() {
    if (selectedIndex.value === null && index.value === null) {
        show.value = !show.value;
    } else {
        show.value = true;
    }

    emit("changeSelectedIndex");
}

function hideDropdown() {
    show.value = false;

    emit("changeSelectedIndex");
}

onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));
</script>

<template>
    <div class="relative">
        <button class="mx-auto block rounded-lg p-2 hover:bg-gray-100" title="Open dropdown" role="button" type="button" @click="toggleDropdown">
            <span class="sr-only">Open dropdown</span>

            <slot name="trigger" />
        </button>

        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="show && selectedIndex === index"
                class="absolute z-50 my-2 whitespace-nowrap rounded-md bg-white shadow-lg"
                :class="[alignmentClasses]"
                style="display: none"
                @click="hideDropdown"
            >
                <div class="rounded-md p-1 ring-1 ring-black ring-opacity-5">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
