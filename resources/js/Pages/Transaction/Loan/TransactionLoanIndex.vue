<template>
    <Head title="Transaksi" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Transaksi Pinjaman</PageTitle>
    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Pinjaman" :link="route('transaction.loan.farmer.index')">Pinjaman Petani</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Pinjaman" :link="route('transaction.loan.driver.index')">Pinjaman Supir</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Pinjaman" :link="route('transaction.loan.supervisor.index')">Pinjaman Mandor</PageMenu>

    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageMenu from "@/Components/PageMenu.vue"
import PageTitle from "@/Components/PageTitle.vue"

import { Head } from '@inertiajs/inertia-vue3'
const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Pinjaman"
    }
]
</script>
