<template>
    <Link as="div" :href="props.link" class="stats rounded-none hover:cursor-pointer transition-all	">
        <div class="stat">
            <div class="stat-title" v-text="props.title"></div>
            <div class="stat-value md:text-2xl">
                <slot />
            </div>
            <div class="stat-actions flex justify-end">
                <BaseIcon :path="mdiArrowRight"/>
            </div>
        </div>
    </Link>
</template>

<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiArrowRight } from "@mdi/js";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    title: {
        type: String,
        default: "Data"
    },
    link: {
        type: String,
        default: null
    }

})
</script>


