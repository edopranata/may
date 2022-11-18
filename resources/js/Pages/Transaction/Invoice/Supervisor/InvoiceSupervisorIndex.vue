<template>
    <Head title="Gaji Karyawan" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Gaji Karyawan</PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan proses perhitungan gaji mandor</h3>
            <p class="py-4">Klik Lihat Perhitungan gaji mandor, untuk mengetahui rincian dan total gaji mandor yang akan diterima</p>
            <div class="modal-action flex justify-between">
                <Link as="button" :disabled="!props.supervisor_id" :href="(props.supervisor_id) ? route('transaction.invoice.supervisor.show', props.supervisor_id) : route('transaction.invoice.supervisor.index')" class="btn btn-primary"><BaseIcon :path="mdiContentSave"/> Lihat Perhitungan Gaji</Link>
                <button type="button" @click="modal=false" class="btn btn-warning"><BaseIcon :path="mdiCancel"/> Batal</button>
            </div>
        </div>
    </div>


    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-4 gap-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Karyawan</span>
                    </label>
                    <Multiselect class="select select-bordered rounded"
                                 :searchable="true"
                                 v-model="form.supervisor_id"
                                 :options="props.supervisors"
                                 :aria-selected="props.supervisor_id"
                    />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Tanggal</span>
                    </label>
                    <input v-model="form.date" type="date" placeholder="Sampai Tanggal" class="input input-bordered w-full" />
                </div>
                <div class="grid grid-cols-2 gap-4 py-1">
                    <button :disabled="form.processing" @click="setFilter" class="btn mt-8">Filter</button>
                    <button :disabled="!props.supervisor_id" @click="modal=true" class="btn btn-primary mt-8">Hitung Gaji</button>

                </div>
            </div>

            <div class="card-body">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Invoice Number</th>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6 text-right">Pinjaman</th>
                        <th class="py-3 px-6 text-right">Bayar Pinjaman</th>
                        <th class="py-3 px-6 text-right">Diterima</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.invoices.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.invoices.data">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.invoices.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.invoice_number }}</div>
                                <div class="text-sm opacity-50">{{item.invoice_date }}</div>
                            </div>
                        </td>

                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.modelable ? item.modelable.name : '' }}</div>
                                <div class="text-sm opacity-50">{{ item.modelable ? item.modelable.phone : '' }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total_buy)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.loan)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.loan_installment)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </tr>
                    <tr v-else>
                        <td colspan="8" class="text-center border-b-2">No Data <Link v-if="props.invoices.current_page > 1" class="link link-primary" :href="route('report.invoice.search.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.invoices.data.length" :links="props.invoices.links" />

            </div>
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"
import Pagination from "@/Components/Pagination.vue"

import Multiselect from '@vueform/multiselect'
import { mdiArrowRight, mdiContentSave, mdiPrinter, mdiCancel } from "@mdi/js"
import {Head, useForm, Link} from '@inertiajs/inertia-vue3'
import {ref} from 'vue'

const modal = ref(false)
const btnProses = ref()

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": route('transaction.invoice.index'),
        "label": "Invoice"
    },
    {
        "url": null,
        "label": "Gaji Karyawan"
    }
]

const props = defineProps({
    supervisor_id: String,
    supervisors: Array,
    price: Number,
    date: String,
    invoices: Object,
})

const form = useForm({
    supervisor_id: props.supervisor_id ?? null,
    date: props.date ?? null,
})

const setFilter = () => {
    form.get(route('transaction.invoice.supervisor.index'))
}

</script>
