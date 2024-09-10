<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import RadioInput from "@/Components/RadioInput.vue";
import { Head } from "@inertiajs/vue3";
import { RefreshCwIcon } from "lucide-vue-next";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps<{
    categories: any;
}>();

const user = usePage().props.auth.user;
const form = useForm({
    name: "",
    price: 0,
    category_id: "",
    stock: 0,
    description: "",
    status: "unavailable",
    user_id: user.id,
});

function createProduct() {
    form.post(route("products.store"), {
        onError: () => {
            console.log(form);
        },
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Create Product" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Product</h2>
        </template>

        <div class="min-h-screen bg-white overflow-y-auto border p-4 rounded-md shadow max-w-screen-md mx-4 md:mx-auto my-2">
            <h2 class="text-xl font-semibold text-black mb-6">Create Product</h2>

            <form class="space-y-6" @submit.prevent="createProduct">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Product name" autofocus required />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="price" value="Price" />

                    <NumberInput
                        id="price"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.price"
                        placeholder="Product price e.g. 1000"
                        min="1"
                        required
                    />

                    <InputError :message="form.errors.price" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="category" value="Category" />

                    <select
                        id="category"
                        v-model="form.category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option selected disabled value="" class="text-gray-500">Choose a category</option>

                        <option v-for="category in categories" :key="category" :value="category.id">{{ category.name }}</option>
                    </select>

                    <InputError :message="form.errors.category_id" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="stock" value="Stock" />

                    <NumberInput
                        id="stock"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.stock"
                        min="0"
                        placeholder="Product stock e.g. 1000"
                        required
                    />

                    <InputError :message="form.errors.stock" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />

                    <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" placeholder="Product description" />

                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div>
                    <InputLabel value="Status" />

                    <div class="border border-gray-300 rounded-md shadow-sm p-2 flex items-center gap-8">
                        <div class="flex items-center">
                            <RadioInput
                                id="available"
                                value="available"
                                name="product-status"
                                v-model="form.status"
                                :checked="form.status === 'available'"
                                required
                            />
                            <InputLabel for="available" value="Available" class="ms-2 cursor-pointer" />
                        </div>

                        <div class="flex items-center">
                            <RadioInput
                                id="unavailable"
                                value="unavailable"
                                name="product-status"
                                v-model="form.status"
                                :checked="form.status === 'unavailable'"
                                required
                            />
                            <InputLabel for="unavailable" value="Unavailable" class="ms-2 cursor-pointer" />
                        </div>
                    </div>

                    <InputError :message="form.errors.status" class="mt-2" />
                </div>

                <div class="flex gap-x-2">
                    <!--               <button
                    type="button"
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                >
                    Cancel
</button>-->

                    <button
                        type="submit"
                        class="grow text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm justify-center items-center px-5 py-2.5 focus:outline-none flex gap-2"
                        :disabled="form.processing"
                    >
                        <RefreshCwIcon class="h-5 w-5 animate-spin" v-show="form.processing" />

                        Save
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
