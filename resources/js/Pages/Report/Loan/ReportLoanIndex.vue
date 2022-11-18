<template>
    <Head title="Laporan" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Pinjaman</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Pinjaman" :link="route('print.loan.index')">Daftar Semua Pinjaman</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Pinjaman" :link="route('report.loan.details')">Rincian Pinjaman</PageMenu>
    </section>

</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageMenu from "@/Components/PageMenu.vue"
import PageTitle from "@/Components/PageTitle.vue"

import { Head } from '@inertiajs/inertia-vue3'
const breadcrumbs = [
    {
        "url": route('report.index'),
        "label": "Laporan"
    },

    {
        "url": null,
        "label": "Pinjaman"
    }
]
</script>
