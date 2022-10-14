<template>
    <Head title="Konfigurasi" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Konfigurasi</PageTitle>

    <section class="px-4 grid grid-cols-4 gap-4">
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Konfigurasi" :link="route('data.farmer.index')">Konfigurasi</PageMenu>
    </section>

</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageMenu from "@/Components/PageMenu.vue"
import PageTitle from "@/Components/PageTitle.vue"

import { Head } from '@inertiajs/inertia-vue3'
const breadcrumbs = [
    {
        "url": null,
        "label": "Konfigurasi"
    }
]
</script>
