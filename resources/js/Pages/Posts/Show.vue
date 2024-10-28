<script setup>
import FollowButton from '@/Components/FollowButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    post: {
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
    <Head :title="post.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                >
                    {{ post.title }}
                </h2>
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('dashboard')"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                    >
                        ← Back to Posts
                    </Link>
                    <template v-if="post.user.id !== $page.props.auth.user.id">
                        <FollowButton
                            :user="post.user"
                            :is-following="isFollowing"
                        />
                    </template>
                    <Link
                        v-if="$page.props.auth.user.id === post.user_id"
                        :href="route('posts.edit', post.id)"
                        class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                    >
                        Edit Post
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6">
                        <div
                            class="mb-6 border-b border-gray-200 pb-6 dark:border-gray-700"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <p
                                            class="text-sm text-gray-600 dark:text-gray-400"
                                        >
                                            By {{ post.user?.name }}
                                        </p>
                                        <p
                                            class="mt-1 text-sm text-gray-500 dark:text-gray-500"
                                        >
                                            {{
                                                new Date(
                                                    post.created_at,
                                                ).toLocaleDateString()
                                            }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span
                                        :class="{
                                            'text-green-600 dark:text-green-400':
                                                post.is_published,
                                            'text-yellow-600 dark:text-yellow-400':
                                                !post.is_published,
                                        }"
                                        class="text-sm font-medium"
                                    >
                                        {{
                                            post.is_published
                                                ? 'Published'
                                                : 'Draft'
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="dark:prose-invert prose max-w-none">
                            <p
                                class="whitespace-pre-wrap text-gray-600 dark:text-gray-400"
                            >
                                {{ post.body }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
