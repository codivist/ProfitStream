<script setup>
import PostForm from '@/Components/Posts/PostForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    post: {
        type: Object,
        required: true,
    },
    canEdit: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <Head title="Edit Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Edit Post
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6">
                        <PostForm :post="post" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
