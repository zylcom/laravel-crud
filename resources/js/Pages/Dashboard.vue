<script setup lang="ts">
import ActionDropdown from "@/Components/ActionDropdown.vue";
import Alert from "@/Components/Alert.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import UpdateProductForm from "./Product/Partials/UpdateProductForm.vue";
import { CircleCheckBigIcon, CircleXIcon, EllipsisIcon, PencilIcon, Trash2Icon } from "lucide-vue-next";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps<{ products: any; categories: any }>();

const dropdownIndex = ref<number | null>(null);
const showEditModal = ref<boolean>(false);

function openDropdown(id: number) {
    dropdownIndex.value === id ? (dropdownIndex.value = null) : (dropdownIndex.value = id);
}

function closeModal() {
    showEditModal.value = false;
    dropdownIndex.value = null;
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white relative overflow-x-auto shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between mb-6 items-center">
                        <h2 class="text-3xl font-semibold text-black">Low Stock Products</h2>

                        <Link
                            type="button"
                            class="text-blue-700 rounded-full hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                            href="/dashboard/products"
                            >View all products</Link
                        >
                    </div>

                    <Alert />

                    <p v-if="products.length === 0">
                        Nothing to show, all products are in stock.
                    </p>

                    <Table v-else>
                        <template #tableHead>
                            <tr>
                                <th scope="col" class="px-6 py-3">Product name</th>
                                <th scope="col" class="px-6 py-3">Category</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                                <th scope="col" class="px-6 py-3">Stock</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </template>

                        <template #tableBody>
                            <tr
                                class="border-b border-b-gray-400 relative"
                                :class="product.stock < 10 ? 'bg-red-100' : 'bg-white'"
                                v-for="product in products"
                                :key="product.id"
                            >
                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{ product.name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ product.category.name }}
                                </td>
                                <td class="px-6 py-4">{{ product.price }}</td>
                                <td class="px-6 py-4">
                                    {{ product.stock }}
                                </td>
                                <td class="px-6 py-4">{{ product.status }}</td>
                                <td class="px-6 py-4">
                                    <ActionDropdown
                                        :isOpen="dropdownIndex === product.id"
                                        :onClickHandler="
                                            () => {
                                                openDropdown(product.id);
                                            }
                                        "
                                    >
                                        <template #trigger>
                                            <EllipsisIcon class="w-5 h-5" />
                                        </template>

                                        <template #menu>
                                            <div class="flex flex-col [&_button]:rounded divide-y">
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
                                                >
                                                    <span>
                                                        <Trash2Icon class="w-4 h-4" />
                                                        Delete
                                                    </span>
                                                </Link>

                                                <button
                                                    class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100"
                                                    :title="`${product.status === 'available' ? 'Disable' : 'Enable'} product`"
                                                >
                                                    <span v-if="product.status === 'available'">
                                                        <CircleXIcon class="w-4 h-4" />
                                                        Disable
                                                    </span>

                                                    <span v-else>
                                                        <CircleCheckBigIcon class="w-4 h-4" />
                                                        Enable
                                                    </span>
                                                </button>
                                            </div>
                                        </template>
                                    </ActionDropdown>

                                    <UpdateProductForm
                                        :categories="categories"
                                        :show="showEditModal && product.id === dropdownIndex"
                                        :product="product"
                                        @close="closeModal"
                                    />
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
