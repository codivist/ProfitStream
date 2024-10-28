<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    isFollowing: {
        type: Boolean,
        required: true,
    },
});

const toggleFollow = () => {
    if (props.isFollowing) {
        router.delete(route('users.unfollow', props.user.id));
    } else {
        router.post(route('users.follow', props.user.id));
    }
};
</script>

<template>
    <button
        @click="toggleFollow"
        class="rounded-md px-4 py-2 text-sm font-medium transition-colors"
        :class="{
            'bg-indigo-600 text-white hover:bg-indigo-700': !isFollowing,
            'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600':
                isFollowing,
        }"
    >
        {{ isFollowing ? 'Unfollow' : 'Follow' }}
    </button>
</template>
