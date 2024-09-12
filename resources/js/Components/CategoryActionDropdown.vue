<script setup lang="ts">
import { EllipsisIcon, ExternalLink, PencilIcon, Trash2Icon } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import DeleteConfirmation from "./DeleteConfirmation.vue";
import Dropdown from "./Dropdown.vue";
import UpdateCategoryForm from "@/Pages/Category/Partials/UpdateCategoryForm.vue";

const props = defineProps<{
    category: any;
    selectedIndex: number | string | null;
}>();

const emit = defineEmits(["changeSelectedIndex"]);
const showEditModal = ref(false);
const showDeleteConfirmationModal = ref(false);

function closeModal() {
    showEditModal.value = false;

    emit("changeSelectedIndex", null);
}

function closeDeleteModal() {
    showDeleteConfirmationModal.value = false;

    emit("changeSelectedIndex", null);
}

function changeSelectedIndex() {
    emit("changeSelectedIndex", props.category.id);
}
</script>

<template>
    <Dropdown align="right-center" :index="category.id" :selectedIndex="selectedIndex" @changeSelectedIndex="changeSelectedIndex">
        <template #trigger>
            <EllipsisIcon class="h-5 w-5" />
        </template>

        <template #content>
            <div class="flex flex-col divide-y [&_button]:rounded">
                <Link
                    :href="route('categories.show', category.id)"
                    type="button"
                    title="View detail category"
                    class="p-1 hover:bg-gray-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2"
                >
                    <span>
                        <ExternalLink class="h-4 w-4" />
                        Detail
                    </span>
                </Link>

                <button class="p-1 hover:bg-gray-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2" title="Edit category" @click="showEditModal = true">
                    <span>
                        <PencilIcon class="h-4 w-4" />
                        Edit
                    </span>
                </button>

                <button
                    class="p-1 hover:bg-red-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2"
                    title="Delete category"
                    @click="showDeleteConfirmationModal = true"
                >
                    <span>
                        <Trash2Icon class="h-4 w-4" />
                        Delete
                    </span>
                </button>
            </div>
        </template>
    </Dropdown>

    <DeleteConfirmation
        title="Delete category"
        message="All of its resources and products with this category will be permanently deleted."
        :href="route('categories.destroy', category.id)"
        :show="showDeleteConfirmationModal"
        @close="closeDeleteModal"
    />

    <UpdateCategoryForm :show="showEditModal" :category="category" @close="closeModal" />
</template>
