<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Alert from "@/Components/Alert.vue";
import ProductActionDropdown from "@/Components/ProductActionDropdown.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Table from "@/Components/Table.vue";
import UpdateCategoryForm from "./Partials/UpdateCategoryForm.vue";
import DeleteConfirmation from "@/Components/DeleteConfirmation.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps<{
    category: any;
    categories: any;
}>();

const show = ref<boolean>(false);
const selectedIndex = ref<number | string | null>(null);
const showDeleteConfirmationModal = ref(false);

function changeSelectedIndex(id: number | string | null) {
    selectedIndex.value === id ? (selectedIndex.value = null) : (selectedIndex.value = id);
}

function closeModal() {
    show.value = false;
}

function closeDeleteModal() {
    showDeleteConfirmationModal.value = false;
}

function deleteCategory() {
    router.delete(route("categories.destroy", { id: props.category.id, redirect_to: "categories.index" }));
}
</script>

<template>
    <Head title="Detail Category" />

    <AuthenticatedLayout>
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between border-b pb-3">
                <h2 class="text-lg font-semibold text-black sm:text-3xl">Details</h2>

                <div>
                    <DangerButton title="Delete category" class="mr-2" @click="showDeleteConfirmationModal = true">Delete</DangerButton>
                    <SecondaryButton title="Edit category" @click="show = true">Edit</SecondaryButton>
                </div>
            </div>

            <Alert />

            <div
                class="space-y-2 [&_div]:flex [&_div]:gap-x-4 [&_div_span:first-of-type]:basis-2/4 [&_div_span:first-of-type]:font-medium md:[&_div_span:first-of-type]:basis-1/4 [&_div_span:last-of-type]:basis-2/4 md:[&_div_span:last-of-type]:basis-3/4"
            >
                <div>
                    <span>ID</span>
                    <span>{{ category.id }}</span>
                </div>

                <div>
                    <span>Name</span>
                    <span>{{ category.name }}</span>
                </div>

                <div>
                    <span>Created At</span>
                    <span>{{ category.created_at }}</span>
                </div>

                <div>
                    <span>Updated At</span>
                    <span>{{ category.updated_at }}</span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <h2 class="mb-6 border-b pb-3 text-lg font-semibold text-black sm:text-3xl">Products With This Category</h2>

            <p v-if="category.products.length === 0">Nothing to show.</p>

            <div class="overflow-x-auto" v-else>
                <Table>
                    <template #tableHead>
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Product name</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Stock</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </template>

                    <template #tableBody>
                        <tr
                            class="relative border-b border-b-gray-400"
                            :class="product.stock < 10 ? 'bg-red-100' : 'bg-white'"
                            v-for="product in category.products"
                            :key="product.id"
                        >
                            <td class="px-6 py-4">{{ product.id }}</td>
                            <th scope="row" class="px-6 py-4 font-medium">{{ product.name }}</th>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.stock }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">
                                <ProductActionDropdown
                                    :product="product"
                                    :categories="categories"
                                    :selectedIndex="selectedIndex"
                                    @changeSelectedIndex="changeSelectedIndex"
                                />
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>

        <DeleteConfirmation
            title="Delete Category"
            message="All of its resources and products with this category will be permanently deleted."
            :show="showDeleteConfirmationModal"
            @close="closeDeleteModal"
            @delete="deleteCategory"
        />
        <UpdateCategoryForm :show="show" :category="category" @close="closeModal" />
    </AuthenticatedLayout>
</template>
