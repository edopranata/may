<template>
    <Head title="Pinjaman" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Pinjaman</PageTitle>

</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"

import { Head } from '@inertiajs/inertia-vue3'

const breadcrumbs = [
    {
        "url": route('transaction.loan.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Pinjaman"
    }
]
</script>
