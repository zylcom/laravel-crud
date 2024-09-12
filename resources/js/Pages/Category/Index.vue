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
        <div class="bg-white relative overflow-x-auto w-auto p-6">
            <div class="flex justify-between mb-6 sm:items-center gap-2 flex-col sm:flex-row">
                <h2 class="text-lg sm:text-3xl font-semibold text-black">All Categories</h2>

                <Link
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
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
                            <th scope="col" class="hidden sm:table-cell px-6 py-3">Created At</th>
                            <th scope="col" class="hidden sm:table-cell px-6 py-3">Updated At</th>
                            <th scope="col" class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </template>

                    <template #tableBody>
                        <tr class="border-b border-b-gray-400 relative" v-for="category in categories" :key="category.id">
                            <td class="px-6 py-4">{{ category.id }}</td>
                            <td class="px-6 py-4">{{ category.name }}</td>
                            <td class="hidden sm:table-cell px-6 py-4">{{ category.created_at }}</td>
                            <td class="hidden sm:table-cell px-6 py-4">{{ category.updated_at }}</td>
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
