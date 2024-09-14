<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import Alert from "@/Components/Alert.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteConfirmation from "@/Components/DeleteConfirmation.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import UpdateProductForm from "./Partials/UpdateProductForm.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps<{
    product: any;
    categories: any;
}>();

const show = ref<boolean>(false);
const showDeleteConfirmationModal = ref(false);

function closeModal() {
    show.value = false;
}

function closeDeleteModal() {
    showDeleteConfirmationModal.value = false;
}

function deleteProduct() {
    router.delete(route("products.destroy", { id: props.product.id, redirect_to: "products.index" }));
}
</script>

<template>
    <Head title="Detail Product" />

    <AuthenticatedLayout>
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between border-b pb-3">
                <h2 class="text-lg font-semibold text-black sm:text-3xl">Details</h2>

                <div>
                    <DangerButton title="Delete product" class="mr-2" @click="showDeleteConfirmationModal = true">Delete</DangerButton>
                    <SecondaryButton title="Edit product" @click="show = true">Edit</SecondaryButton>
                </div>
            </div>

            <Alert />

            <div
                class="space-y-2 [&_div]:flex [&_div]:gap-x-4 [&_div_span:first-of-type]:basis-2/4 [&_div_span:first-of-type]:font-medium md:[&_div_span:first-of-type]:basis-1/4 [&_div_span:last-of-type]:basis-2/4 md:[&_div_span:last-of-type]:basis-3/4"
            >
                <div>
                    <span>ID</span>
                    <span>{{ product.id }}</span>
                </div>

                <div>
                    <span>Name</span>
                    <span>{{ product.name }}</span>
                </div>

                <div>
                    <span>Price</span>
                    <span>{{ product.price }}</span>
                </div>

                <div>
                    <span>Stock</span>
                    <span>{{ product.stock }}</span>
                </div>

                <div>
                    <span>Description</span>
                    <span>{{ product.description }}</span>
                </div>

                <div>
                    <span>Category</span>
                    <span>{{ product.category.name }}</span>
                </div>

                <div>
                    <span>Status</span>
                    <span>{{ product.status }}</span>
                </div>

                <div>
                    <span>Owner</span>
                    <span>{{ product.user.name }}</span>
                </div>

                <div>
                    <span>Created At</span>
                    <span>{{ product.created_at }}</span>
                </div>

                <div>
                    <span>Updated At</span>
                    <span>{{ product.updated_at }}</span>
                </div>
            </div>

            <DeleteConfirmation
                title="Delete Product"
                message="All of its resources will be permanently deleted."
                :show="showDeleteConfirmationModal"
                @close="closeDeleteModal"
                @delete="deleteProduct"
            />
            <UpdateProductForm :categories="categories" :show="show" :product="product" @close="closeModal" />
        </div>
    </AuthenticatedLayout>
</template>
