<template>
    <Head title="Dashboard" />

    <breeadcrumb :links="breadcrumbs"/>

    <section class="px-4 flex flex-wrap gap-4">

    </section>

</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import Breeadcrumb from "@/Shared/Breeadcrumb.vue";

const breadcrumbs = [
    {
        "url": null,
        "label": "Dashboard"
    }
]
</script>
