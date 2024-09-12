<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Dropdown from "./Dropdown.vue";
import { EllipsisIcon, ExternalLink, PencilIcon, Trash2Icon } from "lucide-vue-next";
import UpdateUserForm from "@/Pages/User/Partials/UpdateUserForm.vue";
import { ref } from "vue";
import DeleteConfirmation from "./DeleteConfirmation.vue";

const props = defineProps<{
    user: any;
    selectedIndex: number | string | null;
}>();

const emit = defineEmits(["changeSelectedIndex"]);
const showEditModal = ref<boolean>(false);
const showDeleteConfirmationModal = ref<boolean>(false);

function closeEditModal() {
    showEditModal.value = false;

    emit("changeSelectedIndex", null);
}

function closeDeleteModal() {
    showDeleteConfirmationModal.value = false;

    emit("changeSelectedIndex", null);
}

function changeSelectedIndex() {
    emit("changeSelectedIndex", props.user.id);
}
</script>

<template>
    <Dropdown :index="user.id" :selectedIndex="selectedIndex" @changeSelectedIndex="changeSelectedIndex">
        <template #trigger>
            <EllipsisIcon class="w-5 h-5" />
        </template>

        <template #content>
            <div class="flex flex-col [&_button]:rounded divide-y">
                <Link
                    :href="route('users.show', user.id)"
                    type="button"
                    title="View detail user"
                    class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100"
                >
                    <span>
                        <ExternalLink class="w-4 h-4" />
                        Detail
                    </span>
                </Link>

                <button class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100" title="Edit user" @click="showEditModal = true">
                    <span>
                        <PencilIcon class="w-4 h-4" />
                        Edit
                    </span>
                </button>

                <button
                    class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-red-100"
                    title="Delete user"
                    @click="showDeleteConfirmationModal = true"
                >
                    <span>
                        <Trash2Icon class="w-4 h-4" />
                        Delete
                    </span>
                </button>
            </div>
        </template>
    </Dropdown>

    <DeleteConfirmation
        title="Delete User"
        message="All of its resources and data products owned by this user will be permanently deleted."
        :href="route('users.destroy', user.id)"
        :show="showDeleteConfirmationModal"
        @close="closeDeleteModal"
    />

    <UpdateUserForm :show="showEditModal" :user="user" @close="closeEditModal" />
</template>
