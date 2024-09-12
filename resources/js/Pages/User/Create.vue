<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RadioInput from "@/Components/RadioInput.vue";
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    name: "",
    email: "",
    role: "user",
    password: "",
    password_confirmation: "",
});

function createUser() {
    form.post(route("users.store"), {
        onError: () => {
            console.log(form);
            form.reset("password", "password_confirmation");
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
            <h2 class="text-lg sm:text-3xl font-semibold text-black mb-6">Create New User</h2>

            <form class="space-y-6" @submit.prevent="createUser">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="User name" autofocus required />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" placeholder="Email" required />

                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div>
                    <InputLabel value="Role" />

                    <div class="border border-gray-300 rounded-md shadow-sm p-2 flex items-center gap-8">
                        <div class="flex items-center">
                            <RadioInput id="user" value="user" name="user-role" v-model="form.role" :checked="form.role === 'user'" />
                            <InputLabel for="user" value="User" class="ms-2 cursor-pointer" />
                        </div>

                        <div class="flex items-center">
                            <RadioInput id="admin" value="admin" name="user-role" v-model="form.role" :checked="form.role === 'admin'" />
                            <InputLabel for="admin" value="Admin" class="ms-2 cursor-pointer" />
                        </div>
                    </div>

                    <InputError :message="form.errors.role" class="mt-2" />
                </div>

                <PrimaryButton
                    class="w-full text-center flex justify-center"
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    >Save</PrimaryButton
                >
            </form>
        </div>
    </AuthenticatedLayout>
</template>
