<script setup lang="ts">
import { computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RadioInput from "@/Components/RadioInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps<{ category: any; show: boolean }>();
const emit = defineEmits(["close"]);

const category = computed(() => props.category);
const show = computed(() => props.show);

const form = useForm({
    name: category.value.name,
});

function updateCategory() {
    form.patch(route("categories.update", category.value.id), {
        onError: () => {
            console.log(category.value);
            console.log(form);
        },
        onSuccess: () => {
            console.log(category.value);
            form.defaults({ ...form.data(), ...category.value });
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
            <h2 class="text-xl font-semibold text-black mb-6">Edit Category</h2>

            <form class="space-y-6" @submit.prevent="updateCategory">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Category name" autofocus required />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>


                <div class="flex gap-x-2 justify-end">
                    <SecondaryButton type="button" @click="$emit('close')">Cancel</SecondaryButton>

                    <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
