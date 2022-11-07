<template>
    <Head title="Invoice" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Invoice Pembayaran Petani</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-error text-error-content hover:shadow-xl hover:bg-error/80" title="Invoice" :link="route('transaction.invoice.farmer.index')">Invoice Pembayaran Petani</PageMenu>
    </section>
    <PageTitle :classes="'bg-base-content'">Pembayaran Gaji</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-accent text-accent-content hover:shadow-xl hover:bg-accent/80" title="Invoice / Gaji" :link="route('transaction.invoice.driver.index')">Gaji Supir</PageMenu>
        <PageMenu class="bg-accent text-accent-content hover:shadow-xl hover:bg-accent/80" title="Invoice / Gaji" :link="route('transaction.invoice.car.index')">Amprah Mobil</PageMenu>
        <PageMenu class="bg-accent text-accent-content hover:shadow-xl hover:bg-accent/80" title="Invoice / Gaji" :link="route('transaction.invoice.loader.index')">Gaji Tukang Muat</PageMenu>
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
