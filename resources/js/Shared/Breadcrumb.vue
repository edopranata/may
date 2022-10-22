<template>
    <div class="breadcrumbs mb-4 border-b p-4 print:hidden">
        <ul>
            <li><Link :href="route('dashboard.index')"><BaseIcon :path="mdiHome"/></Link></li>
            <li v-for="link in links">
                <Component
                    :is="link.url ? Link : 'span'"
                    v-html="link.label"
                    :href="link.url"
                />
            </li>
        </ul>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { mdiHome } from '@mdi/js'
import BaseIcon from "@/Components/BaseIcon.vue";

const props = defineProps({
    links: Array
})
</script>

