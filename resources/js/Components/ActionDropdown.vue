<script setup lang="ts">
import { /*CircleCheckBigIcon, CircleXIcon,*/ EllipsisIcon, ExternalLink, PencilIcon, Trash2Icon } from "lucide-vue-next";
import { Link, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import UpdateProductForm from "@/Pages/Product/Partials/UpdateProductForm.vue";

const emit = defineEmits(["toggle"]);
const props = defineProps<{
    product: any;
    categories: any;
    dropdownIndex: number | null;
}>();

const showEditModal = ref<boolean>(false);
const product = computed(() => props.product);
const disabled = ref<boolean>(false);

router.on("start", () => {
    disabled.value = true;
});

router.on("finish", () => {
    disabled.value = false;
});

function closeModal() {
    showEditModal.value = false;

    emit("toggle", product.value.id);
}
</script>

<template>
    <button class="p-2 rounded-lg hover:bg-gray-100 mx-auto block" type="button" title="Action menu" @click="$emit('toggle', product.id)">
        <EllipsisIcon class="w-5 h-5" />
    </button>

    <Transition
        enter-from-class="scale-0 opacity-0"
        enter-active-class="transition-all duration-300 ease-out"
        enter-to-class="scale-100 opacity-100"
        leave-from-class="scale-100 opacity-100"
        leave-active-class="transition-all duration-300 ease-out"
        leave-to-class="scale-0 opacity-0"
    >
        <div class="p-1 absolute top-1/2 -translate-y-1/2 right-24 z-10 bg-white rounded-lg border shadow" v-show="dropdownIndex === product.id">
            <div class="flex flex-col [&_button]:rounded divide-y">
                <Link
                    :href="route('products.show', product.id)"
                    type="button"
                    title="View detail product"
                    class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100"
                >
                    <span>
                        <ExternalLink class="w-4 h-4" />
                        Detail
                    </span>
                </Link>

                <button
                    class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100"
                    title="Edit product"
                    @click="showEditModal = true"
                >
                    <span>
                        <PencilIcon class="w-4 h-4" />
                        Edit
                    </span>
                </button>

                <Link
                    :href="route('products.destroy', product.id)"
                    as="button"
                    method="delete"
                    type="button"
                    title="Delete product"
                    class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-red-100"
                    :disabled="disabled"
                >
                    <span>
                        <Trash2Icon class="w-4 h-4" />
                        Delete
                    </span>
                </Link>

                <!-- <button
                    class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100"
                    :title="`${product.status === 'available' ? 'Disable' : 'Enable'} product`"
                    :disabled="disabled"
                >
                    <span v-if="product.status === 'available'">
                        <CircleXIcon class="w-4 h-4" />
                        Disable
                    </span>

                    <span v-else>
                        <CircleCheckBigIcon class="w-4 h-4" />
                        Enable
                    </span>
                </button> -->
            </div>
        </div>
    </Transition>

    <UpdateProductForm :categories="categories" :show="showEditModal && product.id === dropdownIndex" :product="product" @close="closeModal" />
</template>
