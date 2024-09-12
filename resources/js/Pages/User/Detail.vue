<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Alert from "@/Components/Alert.vue";
import ProductActionDropdown from "@/Components/ProductActionDropdown.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Table from "@/Components/Table.vue";
import UpdateUserForm from "./Partials/UpdateUserForm.vue";

defineProps<{
    user: any;
    categories: any;
}>();

const show = ref<boolean>(false);
const selectedIndex = ref<number | string | null>(null);

function changeSelectedIndex(id: number | string | null) {
    selectedIndex.value === id ? (selectedIndex.value = null) : (selectedIndex.value = id);
}

function closeModal() {
    show.value = false;
}
</script>

<template>
    <Head title="Detail Product" />

    <AuthenticatedLayout>
        <div class="p-6">
            <div class="flex justify-between items-center mb-6 border-b pb-3">
                <h2 class="text-lg sm:text-3xl font-semibold text-black">Details</h2>

                <SecondaryButton @click="show = true">Edit</SecondaryButton>
            </div>

            <Alert />

            <div
                class="[&_div]:flex [&_div]:gap-x-4 space-y-2 [&_div_span:first-of-type]:font-medium [&_div_span:first-of-type]:basis-2/4 [&_div_span:last-of-type]:basis-2/4 md:[&_div_span:first-of-type]:basis-1/4 md:[&_div_span:last-of-type]:basis-3/4"
            >
                <div>
                    <span>ID</span>
                    <span>{{ user.id }}</span>
                </div>

                <div>
                    <span>Name</span>
                    <span>{{ user.name }}</span>
                </div>

                <div>
                    <span>Email</span>
                    <span>{{ user.email }}</span>
                </div>

                <div>
                    <span>Role</span>
                    <span>{{ user.role }}</span>
                </div>

                <div>
                    <span>Email Verified At</span>
                    <span>{{ user.email_verified_at || "Not verified" }}</span>
                </div>

                <div>
                    <span>Created At</span>
                    <span>{{ user.created_at }}</span>
                </div>

                <div>
                    <span>Updated At</span>
                    <span>{{ user.updated_at }}</span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <h2 class="text-lg sm:text-3xl font-semibold mb-6 border-b pb-3 text-black">Products Owned By This User</h2>

            <p v-if="user.products.length === 0">Nothing to show.</p>

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
                            v-for="product in user.products"
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

        <UpdateUserForm :show="show" :user="user" @close="closeModal" />
    </AuthenticatedLayout>
</template>
