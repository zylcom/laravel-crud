<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import Alert from "@/Components/Alert.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import UserActionDropdown from "@/Components/UserActionDropdown.vue";
import ProductActionDropdown from "@/Components/ProductActionDropdown.vue";

defineProps<{ products: any; categories: any; users: any }>();

const selectedIndex = ref<number | string | null>(null);

function changeSelectedIndex(id: number | string | null) {
    selectedIndex.value === id ? (selectedIndex.value = null) : (selectedIndex.value = id);
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="bg-white relative overflow-x-auto w-auto p-6">
            <template v-if="$page.props.auth.user.role === 'admin'">
                <h2 class="text-lg sm:text-3xl mb-6 font-semibold text-black">Users With Low Products</h2>

                <Alert />

                <p v-if="users.length === 0">Nothing to show.</p>

                <div class="overflow-x-auto" v-else>
                    <Table>
                        <template #tableHead>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3">Product Count</th>
                            <th scope="col" class="px-6 py-3 text-center">Action</th>
                        </template>

                        <template #tableBody>
                            <tr
                                class="border-b border-b-gray-400 relative"
                                :class="user.role === 'admin' ? 'bg-blue-100' : 'bg-white'"
                                v-for="user in users"
                                :key="user.id"
                            >
                                <th scope="row" class="px-6 py-4 font-medium">{{ user.name }}</th>
                                <td class="px-6 py-4">{{ user.email }}</td>
                                <td class="px-6 py-4">{{ user.role }}</td>
                                <td class="px-6 py-4">{{ user.products.length }}</td>
                                <td class="px-6 py-4 text-center">
                                    <UserActionDropdown :user="user" :selectedIndex="selectedIndex" @changeSelectedIndex="changeSelectedIndex" />
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
            </template>

            <h2 class="text-lg mt-12 sm:text-3xl mb-6 font-semibold text-black">Low Stock Products</h2>

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
