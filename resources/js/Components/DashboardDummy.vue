<script setup>
import PageTitle from '@/Components/PageTitle.vue'
import {Link} from '@inertiajs/inertia-vue3'
import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

const progress = ref(false)

Inertia.on('start', () => { progress.value = true })
Inertia.on('finish', () => { progress.value = false })

defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <PageTitle :classes="'bg-base-content'" class="">Insert Dummy</PageTitle>
    <section class="px-4 grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 ">
        <Link :disabled="progress" :href="route('dashboard.trade.reset')" method="post" as="button" type="button" class="btn col-span-3 btn-error">Reset</Link>

        <Link :disabled="progress" :href="route('dashboard.trade.create')" method="post" as="button" type="button" class="btn">Create Trades</Link>
        <Link :disabled="progress" :href="route('dashboard.trade.factory')" method="post" as="button" type="button" class="btn">Trade Factories</Link>
        <Link :disabled="progress" :href="route('dashboard.trade.update')" method="post" as="button" type="button" class="btn">Trades Update</Link>
    </section>
</template>
