<template>
    <Head title="Invoice Pembayaran" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Cetak Ulang Invoice</PageTitle>
    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box w-11/12 max-w-5xl" for="">
            <table class="w-full text-left text-base">
                <!-- head -->
                <thead class="uppercase bg-primary/20">
                <tr>
                    <th class="py-1 px-2">Invoice Number</th>
                    <th class="py-1 px-2">Nama</th>
                    <th class="py-1 px-2 text-right" colspan="2">Rincian</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                <tr>
                    <td class="group-hover:bg-base-300 px-2 align-top" rowspan="4">
                        <div>
                            <div class="font-bold">{{ invoices.data[invoice_index].invoice_number }}</div>
                            <div class="text-sm opacity-50">{{invoices.data[invoice_index].invoice_date }}</div>
                        </div>
                    </td>
                    <td class="group-hover:bg-base-300 px-2 align-top" rowspan="4">
                        <div>
                            <div class="font-bold">{{ invoices.data[invoice_index].loan.modelable.name }}</div>
                            <div class="text-sm opacity-50">{{ invoices.data[invoice_index].loan.modelable.phone }}</div>
                        </div>
                    </td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold capitalize">Pinjaman Awal</td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(invoices.data[invoice_index].opening_balance)}}</td>
                </tr>
                <tr>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold capitalize">{{ invoices.data[invoice_index].status }}</td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(invoices.data[invoice_index].amount)}}</td>
                </tr>
                <tr>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold capitalize">Pinjaman Akhir</td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(invoices.data[invoice_index].opening_balance + invoices.data[invoice_index].amount)}}</td>
                </tr>
                </tbody>
            </table>
            <div class="modal-action flex justify-between space-x-4">
                <div class="flex space-x-4">
                    <Link as="button" :href="invoices.data[invoice_index].type ? invoices.data[invoice_index].type.url_print : ''" class="btn btn-success">Print Invoice</Link>
                </div>
                <button class="btn btn-error" @click="modal = false">Batalkan</button>
            </div>
        </div>
    </div>
    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <div class="flex items-center mb-4">
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Cari Nomor Invoice</span>
                        </label>
                        <input v-model="form_search.invoice" type="text" placeholder="Cari Invoice Number" class="input input-success input-bordered" />
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Cari Berdasarkan Nama</span>
                        </label>
                        <input v-model="form_search.search" type="text" placeholder="Cari Nama" class="input input-success input-bordered" />
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden badge-primary badge-secondary badge badge-accent badge-ghost badge-info badge-error"></div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Jenis Pembayaran</th>
                        <th class="py-3 px-6">Invoice Number</th>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6 text-right">Pinjaman Awal</th>
                        <th class="py-3 px-6 text-right">Bayar / Pinjam</th>
                        <th class="py-3 px-6 text-right">Saldo Akhir</th>
                        <th class="py-3 px-6 text-right">Status</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.invoices.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.invoices.data" @click="openModal(index)">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.invoices.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div :class="item.type.badge" class="badge badge-md" >{{ item.type.title }}</div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.invoice_number }}</div>
                                <div class="text-sm opacity-50">{{item.invoice_date }}</div>
                            </div>
                        </td>

                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.loan.modelable ? item.loan.modelable.name : '' }}</div>
                                <div class="text-sm opacity-50">{{ item.loan.modelable ? item.loan.modelable.phone : '' }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.opening_balance)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.amount)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.opening_balance + item.amount)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ item.status }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </tr>
                    <tr v-else>
                        <td colspan="9" class="text-center border-b-2">No Data <Link v-if="props.invoices.current_page > 1" class="link link-primary" :href="route('report.invoice.search.index')">Goto First Page</Link></td>
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
import Pagination from "@/Components/Pagination.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

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
        "url": route('report.invoice.index'),
        "label": "Cetak Invoice"
    },
    {
        "url": null,
        "label": "Cetak Ulang Invoice"
    },
]

const modal = ref(false)
const props = defineProps({
    search: String,
    invoice: String,
    invoices: Object
})

const form_search = useForm({
    search: props.search,
    invoice: props.invoice
})

watch(
    form_search,
    debounce(function (value) {
        Inertia.get(
            route('report.invoice.index'),
            {
                search: value.search,
                invoice: value.invoice,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500),
    { deep: true }
);

const invoice_index = ref(0)

const openModal = function (index){
    invoice_index.value = index
    modal.value = true
}
</script>
