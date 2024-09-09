<script setup lang="ts">
import ActionDropdown from "@/Components/ActionDropdown.vue";
import Table from "@/Components/Table.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps<{ products: any }>();

const dropdownIndex = ref<number | null>(null);

function openDropdown(id: number) {
    if (dropdownIndex.value === id) {
        dropdownIndex.value = null;
    } else {
        dropdownIndex.value = id;
    }
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
                    <h2 class="text-3xl mb-6 font-semibold text-black">Low Stock Products</h2>

                    <p v-if="products.length === 0">
                        Nothing to show, all products are in stock.
                        <Link class="underline" href="/dashboard/products">See all products</Link>
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
                            <tr class="border-b relative" :class="product.stock < 10 ? 'bg-red-100' : 'bg-white'" v-for="product in products" :key="product.id">
                                <th scope="row" class="px-6 py-4 font-medium">
                                    {{ product.name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ product.category }}
                                </td>
                                <td class="px-6 py-4">{{ product.price }}</td>
                                <td class="px-6 py-4">
                                    {{ product.stock }}
                                </td>
                                <td class="px-6 py-4">{{ product.status }}</td>
                                <td class="px-6 py-4">
                                    <ActionDropdown
                                        :productId="product.id"
                                        :isOpen="dropdownIndex === product.id"
                                        :productStatus="product.status"
                                        @open="openDropdown"
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
