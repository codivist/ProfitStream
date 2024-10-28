<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    posts: {
        type: Array,
        required: true,
    },
    author: {
        type: Object,
        required: true,
    },
    isFollowing: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <Head :title="`Posts by ${author.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                >
                    Posts by {{ author.name }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6">
                        <div
                            v-if="!posts.length"
                            class="py-8 text-center text-gray-600 dark:text-gray-400"
                        >
                            No posts yet.
                        </div>

                        <div v-else class="space-y-6">
                            <div
                                v-for="post in posts"
                                :key="post.id"
                                class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0 dark:border-gray-700"
                            >
                                <div>
                                    <h3
                                        class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                                    >
                                        <Link
                                            :href="route('posts.show', post.id)"
                                            class="hover:text-indigo-600 dark:hover:text-indigo-400"
                                        >
                                            {{ post.title }}
                                        </Link>
                                    </h3>
                                    <p
                                        class="mt-2 text-sm text-gray-600 dark:text-gray-400"
                                    >
                                        {{
                                            new Date(
                                                post.published_at,
                                            ).toLocaleDateString()
                                        }}
                                    </p>
                                </div>
                                <p
                                    class="mt-3 text-gray-600 dark:text-gray-400"
                                >
                                    {{ post.body }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
