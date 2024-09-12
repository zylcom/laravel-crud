<script setup lang="ts">
import { computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import NumberInput from "@/Components/NumberInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RadioInput from "@/Components/RadioInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps<{ product: any; show: boolean; categories: any }>();
const emit = defineEmits(["close"]);

const product = computed(() => props.product);
const show = computed(() => props.show);

const form = useForm({
    name: product.value.name,
    price: product.value.price,
    category_id: product.value.category.id,
    stock: product.value.stock,
    description: product.value.description,
    status: product.value.status,
});

function updateProduct() {
    form.patch(route("products.update", product.value.id), {
        onError: () => {
            console.log(product.value);
            console.log(form);
        },
        onSuccess: () => {
            console.log(product.value);
            form.defaults({ ...form.data(), ...product.value });
            emit("close");
        },
    });
}

watch(show, (newValue) => {
    if (!newValue) form.reset();
});
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="max-h-full overflow-y-auto p-1">
            <h2 class="mb-6 text-xl font-semibold text-black">Edit Product</h2>

            <form class="space-y-6" @submit.prevent="updateProduct">
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
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
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

                    <div class="flex items-center gap-8 rounded-md border border-gray-300 p-2 shadow-sm">
                        <div class="flex items-center">
                            <RadioInput id="available" value="available" name="product-status" v-model="form.status" :checked="form.status === 'available'" />
                            <InputLabel for="available" value="Available" class="ms-2 cursor-pointer" />
                        </div>

                        <div class="flex items-center">
                            <RadioInput
                                id="unavailable"
                                value="unavailable"
                                name="product-status"
                                v-model="form.status"
                                :checked="form.status === 'unavailable'"
                            />
                            <InputLabel for="unavailable" value="Unavailable" class="ms-2 cursor-pointer" />
                        </div>
                    </div>

                    <InputError :message="form.errors.status" class="mt-2" />
                </div>

                <div class="flex justify-end gap-x-2">
                    <SecondaryButton type="button" @click="$emit('close')">Cancel</SecondaryButton>

                    <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
