<script setup lang="ts">
import ActionDropdown from "@/Components/ActionDropdown.vue";
import Alert from "@/Components/Alert.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps<{ products: any; categories: any }>();

const selectedIndex = ref<number | null>(null);

function changeSelectedIndex(id: number) {
    selectedIndex.value === id ? (selectedIndex.value = null) : (selectedIndex.value = id);
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="bg-white relative overflow-x-auto w-auto p-6">
            <h2 class="text-lg sm:text-3xl mb-6 font-semibold text-black">Low Stock Products</h2>

            <Alert />

            <p v-if="products.length === 0">Nothing to show, all products are in stock.</p>

            <div class="overflow-x-auto" v-else>
                <Table>
                    <template #tableHead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Product name</th>
                            <th scope="col" class="hidden md:table-cell px-6 py-3">Category</th>
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
                            <th scope="row" class="px-6 py-4 font-medium">{{ product.name }}</th>
                            <td class="hidden md:table-cell px-6 py-4">{{ product.category.name }}</td>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.stock }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
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
