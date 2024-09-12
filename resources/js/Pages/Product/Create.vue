<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { useForm, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import NumberInput from "@/Components/NumberInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RadioInput from "@/Components/RadioInput.vue";
import TextInput from "@/Components/TextInput.vue";

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
        <div class="p-6">
            <h2 class="mb-6 text-lg font-semibold text-black sm:text-3xl">Create New Product</h2>

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
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
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

                    <div class="flex flex-col gap-y-1 rounded-md border border-gray-300 p-2 shadow-sm sm:flex-row sm:items-center sm:gap-8">
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

                <PrimaryButton
                    class="flex w-full justify-center text-center"
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    >Save</PrimaryButton
                >
            </form>
        </div>
    </AuthenticatedLayout>
</template>
