<template>
    <Head title="Invoice Petani" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Cetak Ulang Invoice Petani</PageTitle>

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
        "url": route('report.invoice.index'),
        "label": "Cetak Invoice"
    },
    {
        "url": null,
        "label": "Cetak Ulang Invoice Petani"
    },
]

const props = defineProps({
    invoices: Object
})
</script>
