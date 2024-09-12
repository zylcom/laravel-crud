<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Alert from "@/Components/Alert.vue";
import Table from "@/Components/Table.vue";
import CategoryActionDropdown from "@/Components/CategoryActionDropdown.vue";

defineProps<{
    categories: any;
}>();

const selectedIndex = ref<number | string | null>(null);

function changeSelectedIndex(id: number | string | null) {
    selectedIndex.value === id ? (selectedIndex.value = null) : (selectedIndex.value = id);
}
</script>

<template>
    <Head title="Categories" />

    <AuthenticatedLayout>
        <div class="relative w-auto overflow-x-auto bg-white p-6">
            <div class="mb-6 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                <h2 class="text-lg font-semibold text-black sm:text-3xl">All Categories</h2>

                <Link
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25"
                    type="button"
                    href="/categories/create"
                    >Create new category</Link
                >
            </div>

            <Alert />

            <p v-if="categories.length === 0">Nothing to show.</p>

            <div class="overflow-x-auto" v-else>
                <Table>
                    <template #tableHead>
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="hidden px-6 py-3 sm:table-cell">Created At</th>
                            <th scope="col" class="hidden px-6 py-3 sm:table-cell">Updated At</th>
                            <th scope="col" class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </template>

                    <template #tableBody>
                        <tr class="relative border-b border-b-gray-400" v-for="category in categories" :key="category.id">
                            <td class="px-6 py-4">{{ category.id }}</td>
                            <td class="px-6 py-4">{{ category.name }}</td>
                            <td class="hidden px-6 py-4 sm:table-cell">{{ category.created_at }}</td>
                            <td class="hidden px-6 py-4 sm:table-cell">{{ category.updated_at }}</td>
                            <td class="px-6 py-4 text-center">
                                <CategoryActionDropdown :category="category" :selectedIndex="selectedIndex" @changeSelectedIndex="changeSelectedIndex" />
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
