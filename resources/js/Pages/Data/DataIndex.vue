<template>
    <Head title="Master data" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Master Data</PageTitle>

    <section class="px-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-4">
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Master Data" :link="route('data.farmer.index')">Petani</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Master Data" :link="route('data.car.index')">Mobil</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Master Data" :link="route('data.driver.index')">Supir</PageMenu>
        <PageMenu class="bg-primary text-primary-content hover:shadow-xl hover:bg-primary/90" title="Master Data" :link="route('data.loader.index')">Tukang Muat</PageMenu>
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
        "label": "Data"
    }
]
</script>
