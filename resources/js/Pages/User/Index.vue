<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Alert from "@/Components/Alert.vue";
import Table from "@/Components/Table.vue";
import UserActionDropdown from "@/Components/UserActionDropdown.vue";

defineProps<{
    users: any;
}>();

const selectedIndex = ref<number | string | null>(null);

function changeSelectedIndex(id: number | string | null) {
    selectedIndex.value === id ? (selectedIndex.value = null) : (selectedIndex.value = id);
}
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="bg-white relative overflow-x-auto w-auto p-6">
            <div class="flex justify-between mb-6 sm:items-center gap-2 flex-col sm:flex-row">
                <h2 class="text-lg sm:text-3xl font-semibold text-black">All Users</h2>

                <Link
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    type="button"
                    href="/users/create"
                    >Create new user</Link
                >
            </div>

            <Alert />

            <p v-if="users.length === 0">Nothing to show.</p>

            <div class="overflow-x-auto" v-else>
                <Table>
                    <template #tableHead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="hidden sm:table-cell px-6 py-3">Created At</th>
                            <th scope="col" class="hidden sm:table-cell px-6 py-3">Updated At</th>
                            <th scope="col" class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </template>

                    <template #tableBody>
                        <tr
                            class="border-b border-b-gray-400 relative"
                            :class="user.role === 'admin' ? 'bg-blue-100' : 'bg-white'"
                            v-for="user in users"
                            :key="user.id"
                        >
                            <th scope="row" class="px-6 py-4 font-medium">{{ user.name }} {{ $page.props.auth.user.id === user.id ? "(You)" : "" }}</th>
                            <td class="px-6 py-4">{{ user.email }}</td>
                            <td class="px-6 py-4">{{ user.role }}</td>
                            <td class="hidden sm:table-cell px-6 py-4">{{ user.created_at }}</td>
                            <td class="hidden sm:table-cell px-6 py-4">{{ user.updated_at }}</td>
                            <td class="px-6 py-4 text-center">
                                <UserActionDropdown :user="user" :selectedIndex="selectedIndex" @changeSelectedIndex="changeSelectedIndex" />
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
