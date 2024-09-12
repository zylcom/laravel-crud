<script setup lang="ts">
import { computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";
import RadioInput from "@/Components/RadioInput.vue";
import { RefreshCwIcon } from "lucide-vue-next";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{ user: any; show: boolean }>();
const emit = defineEmits(["close"]);

const user = computed(() => props.user);
const show = computed(() => props.show);

const form = useForm({
    name: user.value.name,
    email: user.value.email,
    role: user.value.role,
});

function updateUser() {
    form.patch(route("users.update", user.value.id), {
        onError: () => {
            console.log(user.value);
            console.log(form);
        },
        onSuccess: () => {
            console.log(user.value);
            form.defaults({ ...form.data(), ...user.value });
            emit("close");
        },
    });
}

watch(show, (newValue) => {
    if (!newValue) {
        form.reset();
        form.clearErrors();
    }
});
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="max-h-full overflow-y-auto p-1">
            <h2 class="text-xl font-semibold text-black mb-6">Edit User</h2>

            <form class="space-y-6" @submit.prevent="updateUser">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Name" autofocus required />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" placeholder="Email" required />

                    <InputError :message="form.errors.email" class="mt-2" />
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

                <div class="flex gap-x-2 justify-end">
                    <SecondaryButton type="button" @click="$emit('close')">Cancel</SecondaryButton>

                    <PrimaryButton class="flex items-center justify-center gap-x-2" type="submit" :disabled="form.processing">
                        <RefreshCwIcon class="h-5 w-5 animate-spin" v-show="form.processing" />

                        Save
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
