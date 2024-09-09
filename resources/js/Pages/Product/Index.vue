<script setup lang="ts">
import { CircleCheckBigIcon, CircleXIcon, EllipsisIcon, PencilIcon, Trash2Icon } from "lucide-vue-next";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import ActionDropdown from "@/Components/ActionDropdown.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import UpdateProductForm from "./Partials/UpdateProductForm.vue";

defineProps<{
    products: any;
    categories: Record<string, string>;
}>();

const dropdownIndex = ref<number | null>(null);
const showEditModal = ref<boolean>(false);

function openDropdown(id: number) {
    if (dropdownIndex.value === id) {
        dropdownIndex.value = null;
    } else {
        dropdownIndex.value = id;
    }
}

function closeModal() {
    showEditModal.value = false;
    dropdownIndex.value = null;
}
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white relative shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-3xl mb-6 font-semibold text-black">All Products</h2>

                    <p v-if="products.length === 0">Nothing to show.</p>

                    <div class="overflow-x-auto" v-else>
                        <Table>
                            <template #tableHead>
                                <tr>
                                    <th scope="col" class="px-6 py-3">Product name</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Price</th>
                                    <th scope="col" class="px-6 py-3">Stock</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Description</th>
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
                                        {{ product.category }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.price }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.stock }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.description }}
                                    </td>
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

                                                    <button
                                                        class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-red-100"
                                                        title="Delete product"
                                                    >
                                                        <span>
                                                            <Trash2Icon class="w-4 h-4" />
                                                            Delete
                                                        </span>
                                                    </button>

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
        </div>
    </AuthenticatedLayout>
</template>
