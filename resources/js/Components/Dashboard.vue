<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    posts: {
        type: Array,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    },
});

const deletePost = (id) => {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(route('posts.destroy', id));
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                >
                    Blog Posts
                </h2>
                <a
                    href="/posts/create"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700"
                >
                    New Post
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6">
                        <div
                            v-if="!posts"
                            class="py-8 text-center text-gray-600 dark:text-gray-400"
                        >
                            No posts yet. Create your first blog post!
                        </div>

                        <div v-else class="space-y-6">
                            <div
                                v-for="post in posts"
                                :key="post.id"
                                class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0 dark:border-gray-700"
                            >
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3
                                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                                        >
                                            <a
                                                :href="`/posts/${post.id}`"
                                                class="link"
                                                >{{ post.title }}</a
                                            >
                                        </h3>
                                        <p
                                            class="mt-2 text-sm text-gray-600 dark:text-gray-400"
                                        >
                                            By
                                            <Link
                                                :href="
                                                    route(
                                                        'users.posts',
                                                        post.user.id,
                                                    )
                                                "
                                                class="hover:text-indigo-600 dark:hover:text-indigo-400"
                                                >{{ post.user.name }}</Link
                                            >
                                            •
                                            {{
                                                new Date(
                                                    post.published_at,
                                                ).toLocaleDateString()
                                            }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex space-x-2"
                                        v-if="currentUser.id === post.user.id"
                                    >
                                        <Link
                                            :href="route('posts.edit', post.id)"
                                            class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deletePost(post.id)"
                                            class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <p
                                    class="mt-3 text-gray-600 dark:text-gray-400"
                                >
                                    {{ post.body }}
                                </p>

                                <div
                                    class="mt-2 text-sm"
                                    v-if="currentUser.id === post.user.id"
                                >
                                    <span
                                        :class="{
                                            'text-green-600 dark:text-green-400':
                                                post.is_published,
                                            'text-yellow-600 dark:text-yellow-400':
                                                !post.is_published,
                                        }"
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
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
