<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

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
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
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
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
            />
            <InputLabel
                for="is_published"
                value="Publish immediately"
                class="ml-2"
            />
        </div>

        <PrimaryButton :disabled="form.processing">
            {{ props.post.id ? 'Update Post' : 'Create Post' }}
        </PrimaryButton>
    </form>
</template>
