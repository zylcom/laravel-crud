<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import Dropdown from "./Dropdown.vue";
import { EllipsisIcon, ExternalLink, PencilIcon, Trash2Icon } from "lucide-vue-next";
import { ref } from "vue";
import UpdateProductForm from "@/Pages/Product/Partials/UpdateProductForm.vue";
import DeleteConfirmation from "./DeleteConfirmation.vue";

const props = defineProps<{
    product: any;
    categories: any;
    selectedIndex: number | string | null;
}>();

const emit = defineEmits(["changeSelectedIndex"]);
const showEditModal = ref(false);
const showDeleteConfirmationModal = ref(false);

function closeModal() {
    showEditModal.value = false;

    emit("changeSelectedIndex", null);
}

function closeDeleteModal() {
    showDeleteConfirmationModal.value = false;

    emit("changeSelectedIndex", null);
}

function changeSelectedIndex() {
    emit("changeSelectedIndex", props.product.id);
}

function deleteProduct() {
    router.delete(route("products.destroy", { id: props.product.id, redirect_to: "products.index" }));
}
</script>

<template>
    <Dropdown align="right-center" :index="product.id" :selectedIndex="selectedIndex" @changeSelectedIndex="changeSelectedIndex">
        <template #trigger>
            <EllipsisIcon class="h-5 w-5" />
        </template>

        <template #content>
            <div class="flex flex-col divide-y [&_button]:rounded">
                <Link
                    :href="route('products.show', product.id)"
                    type="button"
                    title="View detail product"
                    class="p-1 hover:bg-gray-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2"
                >
                    <span>
                        <ExternalLink class="h-4 w-4" />
                        Detail
                    </span>
                </Link>

                <button class="p-1 hover:bg-gray-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2" title="Edit product" @click="showEditModal = true">
                    <span>
                        <PencilIcon class="h-4 w-4" />
                        Edit
                    </span>
                </button>

                <button
                    class="p-1 hover:bg-red-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2"
                    title="Delete product"
                    @click="showDeleteConfirmationModal = true"
                >
                    <span>
                        <Trash2Icon class="h-4 w-4" />
                        Delete
                    </span>
                </button>
            </div>
        </template>
    </Dropdown>

    <DeleteConfirmation
        title="Delete Product"
        message="All of its resources will be permanently deleted."
        :show="showDeleteConfirmationModal"
        @close="closeDeleteModal"
        @delete="deleteProduct"
    />
    <UpdateProductForm :categories="categories" :show="showEditModal" :product="product" @close="closeModal" />
</template>
