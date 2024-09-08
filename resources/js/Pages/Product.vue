<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    CircleCheckBigIcon,
    CircleXIcon,
    EllipsisIcon,
    PencilIcon,
    Trash2Icon,
} from "lucide-vue-next";
import ActionDropdown from "@/Components/ActionDropdown.vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps<{
    products: any;
}>();

const dropdownIndex = ref<number | null>(null);
const showEditModal = ref<boolean>(false);
const form = useForm<{
    name: string;
    price: number;
    category: string;
    stock: number;
    description: string;
    status: string;
}>({
    name: "",
    price: 0,
    category: "",
    stock: 0,
    description: "",
    status: "",
});

function openDropdown(id: number) {
    if (dropdownIndex.value === id) {
        dropdownIndex.value = null;
    } else {
        dropdownIndex.value = id;
    }
}

function closeModal() {
    showEditModal.value = false;
    dropdownIndex.value = null;
}
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white relative shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-3xl mb-6 font-semibold text-black">
                        All Products
                    </h2>

                    <p v-if="products.length === 0">Nothing to show.</p>

                    <div class="overflow-x-auto" v-else>
                        <Table>
                            <template #tableHead>
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">Price</th>
                                    <th scope="col" class="px-6 py-3">Stock</th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Description
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </template>

                            <template #tableBody>
                                <tr
                                    class="border-b relative"
                                    :class="
                                        product.stock < 10
                                            ? 'bg-red-100'
                                            : 'bg-white'
                                    "
                                    v-for="product in products"
                                    :key="product.id"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium"
                                    >
                                        {{ product.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ product.category }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.price }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.stock }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <ActionDropdown
                                            :isOpen="
                                                dropdownIndex === product.id
                                            "
                                            :onClickHandler="
                                                () => {
                                                    openDropdown(product.id);
                                                }
                                            "
                                        >
                                            <template #trigger>
                                                <EllipsisIcon class="w-5 h-5" />
                                            </template>

                                            <template #menu>
                                                <div
                                                    class="flex flex-col [&_button]:rounded divide-y"
                                                >
                                                    <button
                                                        class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100"
                                                        title="Edit product"
                                                        @click="
                                                            showEditModal = true
                                                        "
                                                    >
                                                        <span>
                                                            <PencilIcon
                                                                class="w-4 h-4"
                                                            />
                                                            Edit
                                                        </span>
                                                    </button>

                                                    <button
                                                        class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-red-100"
                                                        title="Delete product"
                                                    >
                                                        <span>
                                                            <Trash2Icon
                                                                class="w-4 h-4"
                                                            />
                                                            Delete
                                                        </span>
                                                    </button>

                                                    <button
                                                        class="p-1 [&_span]:flex [&_span]:items-center [&_span]:gap-2 hover:bg-gray-100"
                                                        :title="`${product.status === 'available' ? 'Disable' : 'Enable'} product`"
                                                    >
                                                        <span
                                                            v-if="
                                                                product.status ===
                                                                'available'
                                                            "
                                                        >
                                                            <CircleXIcon
                                                                class="w-4 h-4"
                                                            />
                                                            Disable
                                                        </span>

                                                        <span v-else>
                                                            <CircleCheckBigIcon
                                                                class="w-4 h-4"
                                                            />
                                                            Enable
                                                        </span>
                                                    </button>
                                                </div>
                                            </template>
                                        </ActionDropdown>

                                        <Modal
                                            :show="
                                                showEditModal &&
                                                dropdownIndex === product.id
                                            "
                                            @close="closeModal"
                                        >
                                            <div
                                                class="max-w-screen-sm max-h-full overflow-y-auto p-1"
                                            >
                                                <h2
                                                    class="text-xl font-semibold text-black mb-6"
                                                >
                                                    Edit Product
                                                </h2>

                                                <form class="space-y-6">
                                                    <div>
                                                        <InputLabel
                                                            for="name"
                                                            value="Name"
                                                        />

                                                        <TextInput
                                                            id="name"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            v-model="form.name"
                                                            placeholder="Product name"
                                                            required
                                                            autofocus
                                                        />
                                                    </div>

                                                    <div>
                                                        <InputLabel
                                                            for="price"
                                                            value="Price"
                                                        />

                                                        <input
                                                            id="price"
                                                            type="number"
                                                            class="mt-1 block w-full"
                                                            v-model="form.price"
                                                            placeholder="Product price e.g. 1000"
                                                            min="0"
                                                            required
                                                        />
                                                    </div>

                                                    <div>
                                                        <InputLabel
                                                            for="category"
                                                            value="Category"
                                                        />

                                                        <TextInput
                                                            id="category"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            v-model="
                                                                form.category
                                                            "
                                                            placeholder="Product category"
                                                            required
                                                        />
                                                    </div>

                                                    <div>
                                                        <InputLabel
                                                            for="stock"
                                                            value="Stock"
                                                        />

                                                        <input
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
                                                        <InputLabel
                                                            for="description"
                                                            value="Description"
                                                        />

                                                        <TextInput
                                                            id="description"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            v-model="
                                                                form.description
                                                            "
                                                            placeholder="Product description"
                                                            required
                                                        />
                                                    </div>

                                                    <div>
                                                        <InputLabel
                                                            for="status"
                                                            value="Status"
                                                        />

                                                        <TextInput
                                                            id="status"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            v-model="
                                                                form.status
                                                            "
                                                            placeholder="Product status"
                                                            required
                                                        />
                                                    </div>

                                                    <div class="flex gap-x-2">
                                                        <button
                                                            type="button"
                                                            class="grow focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                                            @click="closeModal"
                                                        >
                                                            Cancel
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none"
                                                        >
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </Modal>
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
