<template>
    <Head title="Laporan" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Cetak Ulang Invoice</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Invoice" :link="route('report.invoice.index')">Cetak Invoice</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Invoice Pinjaman" :link="route('report.invoice.loan.index')">Cetak Invoice Pinjaman</PageMenu>
    </section>
    <PageTitle :classes="'bg-base-content'" class="">Laporan</PageTitle>

    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Laporan Transaksi" :link="route('report.trade.index')">Pendapatan Per Trip</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Laba / Rugi" :link="route('report.income.index')">Laba Rugi Bulanan</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Pengeluaran" :link="route('report.expense.index')">Rekap Pengeluaran</PageMenu>
    </section>

    <PageTitle :classes="'bg-base-content'" class="">Laporan Pinjaman</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Rekap Pinjaman" :link="route('report.loan.index')">Rekap Pinjaman</PageMenu>
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
        "label": "Laporan"
    }
]
</script>
