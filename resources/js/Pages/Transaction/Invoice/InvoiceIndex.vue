<template>
    <Head title="Invoice" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Invoice</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-success text-success-content hover:shadow-xl hover:bg-success/80" title="Invoice" :link="route('transaction.invoice.farmer.index')">Invoice Petani</PageMenu>
        <PageMenu class="bg-success text-success-content hover:shadow-xl hover:bg-success/80" title="Invoice / Gaji" :link="route('transaction.invoice.farmer.index')">Invoice Supir</PageMenu>
        <PageMenu class="bg-success text-success-content hover:shadow-xl hover:bg-success/80" title="Invoice / Gaji" :link="route('transaction.invoice.farmer.index')">Invoice Tukang Muat</PageMenu>
    </section>
</template>

<script setup>

import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import PageMenu from "@/Components/PageMenu.vue"

import {Head} from '@inertiajs/inertia-vue3'


const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Invoice"
    }
]


</script>
