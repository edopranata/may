<template>
    <Head title="Transaksi" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Transaksi Jual Beli Sawit</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-info text-info-content hover:shadow-xl hover:bg-info/80" title="Transaksi Beli" :link="route('transaction.trade.index')">Beli Sawit Petani</PageMenu>
        <PageMenu class="bg-secondary text-secondary-content hover:shadow-xl hover:bg-secondary/80" title="Jual Ke Pabrik" :link="route('transaction.factory.index')">Timbangan Pabrik</PageMenu>
    </section>

    <PageTitle :classes="'bg-base-content'" class="">Pembuatan Invoice, Pembayaran Gaji dan Pinjaman</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-success text-success-content hover:shadow-xl hover:bg-success/80" title="Buat Invoice" :link="route('transaction.invoice.index')">Buat Invoice Pembayaran</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Pinjaman" :link="route('transaction.loan.index')">Pinjam atau Bayar Pinjaman</PageMenu>
    </section>

    <PageTitle :classes="'bg-base-content'" class="">Biaya Operasional</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-error text-error-content hover:shadow-xl hover:bg-error/80" title="Biaya Operasional" :link="route('transaction.cost.index')">Biaya Ops. Mobil</PageMenu>
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
        "label": "Transaksi"
    }
]
</script>
