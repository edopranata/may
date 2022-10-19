<template>
    <Head title="Konfigurasi" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Konfigurasi</PageTitle>

    <section class="px-4 grid grid-cols-3 gap-4">

    </section>

</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"

import {Head, useForm} from '@inertiajs/inertia-vue3'

const breadcrumbs = [
    {
        "url": route('config.index'),
        "label": "Konfigurasi"
    },{
        "url": null,
        "label": "Default Biaya"
    }
]

const props = defineProps({
    driver: Object,
    loader: Object,
    car: Object,
})

const form = useForm({
    driver: props.driver ? props.driver : 0,
    loader: props.loader ? props.driver : 0,
    car: props.car ? props.driver : 0,
})
</script>
