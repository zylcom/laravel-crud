<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import Alert from "@/Components/Alert.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import UpdateProductForm from "./Partials/UpdateProductForm.vue";

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

                <SecondaryButton @click="show = true">Edit</SecondaryButton>
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
                    <span>Owner</span>
                    <span>{{ product.user.name }}</span>
                </div>

                <div>
                    <span>Created At</span>
                    <span>{{ product.created_at }}</span>
                </div>

                <div>
                    <span>Updated At</span>
                    <span>{{ product.updated_at }}</span>
                </div>
            </div>

            <UpdateProductForm :categories="categories" :show="show" :product="product" @close="closeModal" />
        </div>
    </AuthenticatedLayout>
</template>
