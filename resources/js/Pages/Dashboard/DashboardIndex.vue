<template>
    <Head title="Dashboard" />

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Laba / Rugi</PageTitle>
    <section class="px-4 grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
        <div class="stats shadow w-full border border-success overflow-hidden">
            <div class="stat">
                <div class="stat-title">Pendapatan</div>
                <div class="stat-value text-success">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(props.income) }}</div>
                <div class="stat-desc mt-1">Total pemasukan bulan ini</div>
                <div class="stat-actions flex justify-end">
                    <button class="btn btn-sm btn-success">Detail</button>
                </div>
            </div>
        </div>
        <div class="stats shadow w-full border border-error overflow-hidden">
            <div class="stat">
                <div class="stat-title">Pengeluaran</div>
                <div class="stat-value">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(props.expense) }}</div>
                <div class="stat-desc mt-1">Total pengeluaran bulan ini</div>
                <div class="stat-actions flex justify-end">
                    <button class="btn btn-sm btn-error flex justify-end">Detail</button>
                </div>
            </div>
        </div>
        <div class="stats shadow w-full border xl:col-span-1 overflow-hidden" :class="(props.income - props.expense) < 0 ? 'border-error' : 'border-success'">
            <div class="stat">
                <div class="stat-title">Laba / Rugi</div>
                <div class="stat-value" :class="(props.income - props.expense) < 0 ? 'text-error' : 'text-success'">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(props.income - props.expense) }}</div>
                <div class="stat-desc mt-1">Laba / Rugi bulan ini</div>
                <div class="stat-actions flex justify-end">
                    <button class="btn btn-sm flex justify-end" :class="(props.income - props.expense) < 0 ? 'btn-error ' : 'btn-success'">Detail</button>
                </div>
            </div>
        </div>
    </section>

    <PageTitle :classes="'bg-base-content'" class="">Pinjaman</PageTitle>
    <section class="px-4 grid md:grid-cols-1 xl:grid-cols-3 gap-4">
        <div class="stats shadow w-full border border-error overflow-hidden">
            <div class="stat">
                <div class="stat-title">Pinjaman</div>
                <div class="stat-value md:text-xl lg:text-3xl">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(props.loan ?? 0) }}</div>
                <div class="stat-actions flex justify-end">
                    <button class="btn btn-sm btn-error flex justify-end">Detail</button>
                </div>
            </div>
        </div>
        <div class="stats shadow border stats-vertical lg:stats-horizontal border-error xl:col-span-2" :class="'lg:grid lg:grid-cols-'+props.loans.length">
            <div v-for="(item, index) in props.loans" class="stat">
                <div class="stat-title">Pinjaman {{ item.name }}</div>
                <div class="stat-value md:text-xl lg:text-3xl">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.balance ?? 0) }}</div>
                <div class="stat-actions flex justify-end">
                    <button class="btn btn-sm btn-error flex justify-end hidden">Detail</button>
                </div>
            </div>

        </div>
    </section>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';

import PageTitle from  "@/Components/PageTitle.vue"
import Breadcrumb from "@/Shared/Breadcrumb.vue";

const breadcrumbs = [
    {
        "url": null,
        "label": "Dashboard"
    }
]

const props = defineProps({
    loan: Number,
    loans: Object,
    income: Number,
    expense: Number,
})
</script>
