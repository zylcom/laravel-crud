<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps<{ products: any }>();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white relative overflow-x-auto shadow-sm sm:rounded-lg p-6"
                >
                    <h2>Low Stock Products</h2>

                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3">Category</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                                <th scope="col" class="px-6 py-3">Stock</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                :class="
                                    product.stock < 30
                                        ? 'bg-red-100'
                                        : 'bg-white'
                                "
                                v-for="product in products"
                                :key="product.id"
                            >
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
                                    {{ product.description }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
