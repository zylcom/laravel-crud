<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    name: "",
});

function createCategory() {
    form.post(route("categories.store"), {
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
    <Head title="Create Category" />

    <AuthenticatedLayout>
        <div class="p-6">
            <h2 class="text-lg sm:text-3xl font-semibold text-black mb-6">Create New Category</h2>

            <form class="space-y-6" @submit.prevent="createCategory">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Category name" autofocus required />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <PrimaryButton class="w-full text-center flex justify-center" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
