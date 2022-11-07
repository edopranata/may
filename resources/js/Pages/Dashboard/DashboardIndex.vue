<template>
    <Head title="Dashboard" />

    <Breadcrumb :links="breadcrumbs"/>

    <section class="px-4 grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
        <div class="stats shadow w-full border border-info overflow-hidden">
            <div class="stat">
                <div class="stat-title">Pendapatan</div>
                <div class="stat-value text-info">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(props.income) }}</div>
                <div class="stat-desc mt-1">Total pemasukan bulan ini</div>
                <div class="stat-actions flex justify-end">
                    <button class="btn btn-sm btn-info">Detail</button>
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
        <div class="stats shadow w-full border xl:col-span-1 overflow-hidden" :class="(props.income - props.expense) < 0 ? 'border-error' : 'border-info'">
            <div class="stat">
                <div class="stat-title">Laba / Rugi</div>
                <div class="stat-value" :class="(props.income - props.expense) < 0 ? 'text-error' : 'text-info'">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(props.income - props.expense) }}</div>
                <div class="stat-desc mt-1">Laba / Rugi bulan ini</div>
                <div class="stat-actions flex justify-end">
                    <button class="btn btn-sm flex justify-end" :class="(props.income - props.expense) < 0 ? 'btn-error ' : 'btn-info'">Detail</button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import Breadcrumb from "@/Shared/Breadcrumb.vue";

const breadcrumbs = [
    {
        "url": null,
        "label": "Dashboard"
    }
]

const props = defineProps({
    income: Object,
    expense: Object,
})
</script>
