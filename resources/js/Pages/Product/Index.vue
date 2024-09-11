<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import ActionDropdown from "@/Components/ActionDropdown.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import { ref } from "vue";
import Alert from "@/Components/Alert.vue";

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
            <div class="flex justify-between mb-6 items-center gap-x-2">
                <h2 class="text-lg sm:text-3xl font-semibold text-black">All Products</h2>

                <Link
                    type="button"
                    class="text-blue-700 text-xs rounded-full hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium sm:text-sm px-5 py-2 text-center"
                    href="/dashboard/products/create"
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
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.stock }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">
                                <ActionDropdown :product="product" :categories="categories" :dropdownIndex="selectedIndex" @toggle="changeSelectedIndex" />
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
