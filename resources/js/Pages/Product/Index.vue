<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import Alert from "@/Components/Alert.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProductActionDropdown from "@/Components/ProductActionDropdown.vue";
import Table from "@/Components/Table.vue";

defineProps<{
    products: any;
    categories: any;
}>();

const selectedIndex = ref<number | null>(null);

function changeSelectedIndex(id: number) {
    selectedIndex.value === id ? (selectedIndex.value = null) : (selectedIndex.value = id);
}
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <div class="p-6">
            <div class="flex justify-between mb-6 sm:items-center gap-2 flex-col sm:flex-row">
                <h2 class="text-lg sm:text-3xl font-semibold text-black">All Products</h2>

                <Link
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    type="button"
                    href="/products/create"
                    >Create new product</Link
                >
            </div>

            <Alert />

            <p v-if="products.length === 0">Nothing to show.</p>

            <div class="overflow-x-auto" v-else>
                <Table>
                    <template #tableHead>
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Product name</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3" v-if="$page.props.auth.user.role === 'admin'">Owner</th>
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
                            <td class="px-6 py-4">{{ product.id }}</td>
                            <th scope="row" class="px-6 py-4 font-medium">{{ product.name }}</th>
                            <td class="px-6 py-4">{{ product.category.name }}</td>
                            <td class="px-6 py-4" v-if="$page.props.auth.user.role === 'admin'">{{ product.user.name }}</td>
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
    </AuthenticatedLayout>
</template>
