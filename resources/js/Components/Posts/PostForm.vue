<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        default: () => ({
            title: '',
            body: '',
            is_published: true,
        }),
    },
});

const form = useForm({
    title: props.post.title,
    body: props.post.body,
    is_published: props.post.is_published,
});

const submit = () => {
    if (props.post.id) {
        form.put(route('posts.update', props.post.id));
    } else {
        form.post(route('posts.store'));
    }
};

const cancel = () => {
    router.visit(
        window.history.length > 1 ? window.history.back() : route('dashboard'),
    );
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <InputLabel for="title" value="Title" />
            <TextInput
                id="title"
                v-model="form.title"
                type="text"
                class="mt-1 block w-full"
                required
            />
            <InputError :message="form.errors.title" class="mt-2" />
        </div>

        <div>
            <InputLabel for="body" value="Content" />
            <textarea
                id="body"
                v-model="form.body"
                class="textarea textarea-bordered w-full"
                rows="6"
                required
            />
            <InputError :message="form.errors.body" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input
                id="is_published"
                v-model="form.is_published"
                type="checkbox"
                class="checkbox-info checkbox"
            />
            <InputLabel
                for="is_published"
                value="Publish immediately"
                class="ml-2"
            />
        </div>

        <div class="flex items-center justify-between">
            <button type="button" class="btn btn-neutral" @click="cancel">
                Cancel
            </button>
            <PrimaryButton :disabled="form.processing">
                {{ props.post.id ? 'Update Post' : 'Create Post' }}
            </PrimaryButton>
        </div>
    </form>
</template>
