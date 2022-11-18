<template>
    <Head title="Invoice Pembayaran" />

    <Breadcrumb :links="breadcrumbs"/>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <div class="flex items-center mb-4">
                    <div class="form-control p-1 max-w-md w-full">
                        <label class="label">
                            <span class="label-text">Cari Nomor Invoice</span>
                        </label>
                        <Multiselect class="select w-full select-bordered rounded"
                                     :searchable="true"
                                     v-model="form.loan_id"
                                     :options="props.loans"
                        />
                    </div>
                    <div class="form-control p-1 max-w-md w-full">
                        <label class="label">
                            <span class="label-text">&nbsp;</span>
                        </label>
                        <Link class="btn" as="button" :href="route('report.loan.details')" :data="{ loan_id: form.loan_id }">Lihat</Link>
                    </div>
                </div>


                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Keterangan</th>
                        <th class="py-3 px-6 text-right">Saldo Awal</th>
                        <th class="py-3 px-6 text-right">Bayar / Pinjam</th>
                        <th class="py-3 px-6 text-right">Saldo Akhir</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-if="props.details" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.details.details">
                            <th class="group-hover:bg-base-300 py-4 px-6">{{ index +1 }}</th>
                            <td class="group-hover:bg-base-300 py-4 px-6">{{ item.invoice_date }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6">{{ item.description }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.opening_balance)}}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.amount)}}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.opening_balance + item.amount)}}</td>

                        </tr>
                        <tr v-else>
                            <td colspan="9" class="text-center border-b-2">No Data <Link v-if="props.invoices.current_page > 1" class="link link-primary" :href="route('report.invoice.search.index')">Goto First Page</Link></td>
                        </tr>
                    </tbody>
                </table>
<!--                <Pagination v-if="props.invoices.data.length" :links="props.invoices.links" />-->
            </div>
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

import Multiselect from '@vueform/multiselect'
import {mdiArrowRight} from '@mdi/js'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'
import {reactive, ref, watch} from "vue";
import {debounce} from "lodash";
import {Inertia} from "@inertiajs/inertia";

const breadcrumbs = [
    {
        "url": route('report.index'),
        "label": "Laporan"
    },
    {
        "url": route('report.loan.index'),
        "label": "Pinjaman"
    },
    {
        "url": null,
        "label": "Rincian Pinjaman"
    },
]

const modal = ref(false)
const props = defineProps({
    loans: Object,
    details: Array,
    loan_id: String
})

const form = useForm({
    loan_id: props.loan_id
})

</script>
