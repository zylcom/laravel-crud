<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import UpdateProductForm from "./Partials/UpdateProductForm.vue";
import { ref } from "vue";
import Alert from "@/Components/Alert.vue";

defineProps<{
    product: any;
    categories: any;
}>();

const show = ref<boolean>(false);

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

                <button
                    class="text-blue-700 rounded-full hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                    @click="show = true"
                >
                    Edit
                </button>
            </div>

            <Alert />

            <div
                class="[&_div]:flex [&_div]:gap-x-4 space-y-2 [&_div_span:first-of-type]:font-medium [&_div_span:first-of-type]:basis-2/4 [&_div_span:last-of-type]:basis-2/4 md:[&_div_span:first-of-type]:basis-1/4 md:[&_div_span:last-of-type]:basis-3/4"
            >
                <div>
                    <span>ID</span>
                    <span>{{ product.id }}</span>
                </div>

                <div>
                    <span>Name</span>
                    <span>{{ product.name }}</span>
                </div>

                <div>
                    <span>Price</span>
                    <span>{{ product.price }}</span>
                </div>

                <div>
                    <span>Stock</span>
                    <span>{{ product.stock }}</span>
                </div>

                <div>
                    <span>Description</span>
                    <span>{{ product.description }}</span>
                </div>

                <div>
                    <span>Category</span>
                    <span>{{ product.category.name }}</span>
                </div>

                <div>
                    <span>Status</span>
                    <span>{{ product.status }}</span>
                </div>

                <div>
                    <span>Created At</span>
                    <span>{{
                        new Intl.DateTimeFormat("id-ID", { year: "numeric", month: "short", day: "numeric" }).format(new Date(product.created_at))
                    }}</span>
                </div>

                <div>
                    <span>Updated At</span>
                    <span>{{
                        new Intl.DateTimeFormat("id-ID", { year: "numeric", month: "short", day: "numeric" }).format(new Date(product.updated_at))
                    }}</span>
                </div>
            </div>

            <UpdateProductForm :categories="categories" :show="show" :product="product" @close="closeModal" />
        </div>
    </AuthenticatedLayout>
</template>
