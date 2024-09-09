<script setup lang="ts">
import { computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";
import NumberInput from "@/Components/NumberInput.vue";
import RadioInput from "@/Components/RadioInput.vue";
import { RefreshCwIcon } from "lucide-vue-next";

const props = defineProps<{ product: any; show: boolean; categories: Record<string, string> }>();
const emit = defineEmits(["close"]);

const product = computed(() => props.product);
const show = computed(() => props.show);

const form = useForm({
    name: product.value?.name || "",
    price: product.value?.price || 1,
    category: product.value?.category || "",
    stock: product.value?.stock || 0,
    description: product.value?.description || "",
    status: product.value?.status || "unavailable",
});

function updateProduct() {
    form.patch(route("products.update", product.value.id), {
        onSuccess: () => {
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
            <h2 class="text-xl font-semibold text-black mb-6">Edit Product</h2>

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
                        v-model="form.category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option selected value="">Choose a category</option>

                        <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
                    </select>
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
                </div>

                <div>
                    <InputLabel for="description" value="Description" />

                    <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" placeholder="Product description" />
                </div>

                <div>
                    <InputLabel value="Status" />

                    <div class="border border-gray-300 rounded-md shadow-sm p-2 flex items-center gap-8">
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
                </div>

                <div class="flex gap-x-2">
                    <button
                        type="button"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                        @click="$emit('close')"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="grow text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm justify-center items-center px-5 py-2.5 me-2 mb-2 focus:outline-none flex gap-2"
                        :disabled="form.processing"
                    >
                        <RefreshCwIcon class="h-5 w-5 animate-spin" v-show="form.processing" />

                        Save
                    </button>
                </div>
            </form>
        </div>
    </Modal>
</template>
