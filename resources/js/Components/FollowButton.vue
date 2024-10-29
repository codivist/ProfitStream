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
        class="btn"
        :class="{
            'btn-secondary': !isFollowing,
            'btn-primary': isFollowing,
        }"
    >
        {{ isFollowing ? 'Unfollow' : 'Follow' }}
    </button>
</template>
