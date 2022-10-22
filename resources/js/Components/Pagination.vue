<template>
    <div class="mt-4 space-x-1 print:hidden">
        <Component
            :is="link.url ? Link : 'span'"
            v-for="link in links"
            v-html="link.label"
            :href="link.url"
            class="btn btn-sm rounded-none"
            :class="{'btn-primary': link.active }"
        />
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    links:{
        type: Array,
        required: true
    }
})
</script>
