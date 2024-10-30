<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    posts: {
        type: Array,
        required: true,
    },
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
        <div
            v-if="canLogin"
            class="p-6 text-right sm:fixed sm:right-0 sm:top-0"
        >
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >
                    Register
                </Link>
            </template>
        </div>

        <div v-if="!$page.props.auth.user" class="py-12">
            <div class="mx-auto mt-16 max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="flex flex-col items-center p-6 text-center">
                        <ApplicationLogo
                            class="h-20 w-20 fill-current text-gray-500 mb-8"
                        />
                        <h1
                            class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-100"
                        >
                            Welcome to the Profit Stream!
                        </h1>
                        <p class="py-6 text-gray-900 dark:text-gray-100">
                            A blog for savvy people who like to make money and
                            watch Star Wars
                        </p>
                        <p class="mb-6 text-gray-600 dark:text-gray-400">
                            Please log in or register to view and interact with
                            blog posts.
                        </p>
                        <div class="space-x-4">
                            <Link
                                :href="route('login')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md border border-indigo-600 px-4 py-2 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950"
                            >
                                Register
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="$page.props.auth.user" class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6">
                        <h2
                            class="mb-6 text-xl font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Latest Blog Posts
                        </h2>

                        <div
                            v-if="!posts.length"
                            class="py-8 text-center text-gray-600 dark:text-gray-400"
                        >
                            No posts available.
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
                                        By
                                        <Link
                                            :href="
                                                route(
                                                    'users.posts',
                                                    post.user.id,
                                                )
                                            "
                                            class="hover:text-indigo-600 dark:hover:text-indigo-400"
                                        >
                                            {{ post.user.name }}
                                        </Link>
                                        •
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
    </div>
</template>
