<template>
    <Head title="Invoice Pembayaran Petani" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Cetak Ulang Invoice Petani</PageTitle>
    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box w-11/12 max-w-5xl" for="">
            <table class="w-full text-left text-base">
                <!-- head -->
                <thead class="uppercase bg-primary/20">
                <tr>
                    <th class="py-1 px-2">Invoice Number</th>
                    <th class="py-1 px-2">Nama Petani</th>
                    <th class="py-1 px-2 text-right" colspan="2">Rincian</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                <tr>
                    <td class="group-hover:bg-base-300 px-2 align-top" rowspan="4">
                        <div>
                            <div class="font-bold">{{ invoice.invoice_number }}</div>
                            <div class="text-sm opacity-50">{{invoice.invoice_date }}</div>
                        </div>
                    </td>
                    <td class="group-hover:bg-base-300 px-2 align-top" rowspan="4">
                        <div>
                            <div class="font-bold">{{ invoice.name }}</div>
                            <div class="text-sm opacity-50">{{ invoice.phone }}</div>
                        </div>
                    </td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">Total</td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(invoice.total_buy)}}</td>
                </tr>
                <tr>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">Pinjaman</td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(invoice.loan)}}</td>
                </tr>
                <tr>
                    <td class="group-hover:bg-base-300 px-2 text-right">Bayar Pinjaman</td>
                    <td class="group-hover:bg-base-300 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(invoice.loan_installment)}}</td>
                </tr>
                <tr>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">Uang Diterima</td>
                    <td class="group-hover:bg-base-300 px-2 text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(invoice.total)}}</td>
                </tr>
                </tbody>
            </table>
            <div class="modal-action flex justify-between space-x-4">
                <div class="flex space-x-4">
                    <Link as="button" :href="route('print.invoice.farmer.show', invoice.id)" class="btn btn-success">Print Invoice</Link>
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
                            <span class="label-text">Nomor Invoice</span>
                        </label>
                        <input v-model="form_search.invoice" type="text" placeholder="Cari Invoice Number" class="input input-success input-bordered" />
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Cari Petani</span>
                        </label>
                        <input v-model="form_search.farmer" type="text" placeholder="Cari Petani" class="input input-success input-bordered" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Invoice Number</th>
                        <th class="py-3 px-6">Nama Petani</th>
                        <th class="py-3 px-6">Alamat</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6 text-right">Pinjaman</th>
                        <th class="py-3 px-6 text-right">Bayar Pinjaman</th>
                        <th class="py-3 px-6 text-right">Diterima</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.invoices.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.invoices.data" @click="openModal(index)">
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
                        <td class="group-hover:bg-base-300 py-4 px-6" style="word-wrap: break-word"><p class="max-w-xs">{{ item.modelable ? item.modelable.address : ''}}</p> </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total_buy)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.loan)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.loan_installment)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </tr>
                    <tr v-else>
                        <td colspan="9" class="text-center border-b-2">No Data <Link v-if="props.invoices.current_page > 1" class="link link-primary" :href="route('report.invoice.farmer.index')">Goto First Page</Link></td>
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
        "label": "Cetak Ulang Invoice Petani"
    },
]

const modal = ref(false)
const props = defineProps({
    farmer: String,
    invoice: String,
    invoices: Object
})

const form_search = useForm({
    farmer: props.farmer,
    invoice: props.invoice
})

watch(
    form_search,
    debounce(function (value) {
        Inertia.get(
            route('report.invoice.farmer.index'),
            {
                farmer: value.farmer,
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

const invoice = reactive({
    id: 0,
    invoice_number: '',
    invoice_date: '',
    name: '',
    phone: '',
    total_buy: '',
    loan: '',
    loan_installment: '',
    total: '',
})

const openModal = function (index){
    let data = props.invoices.data[index]

    invoice.id = data.id
    invoice.invoice_number = data.invoice_number
    invoice.invoice_date = data.invoice_date
    invoice.name = data.modelable.name
    invoice.phone = data.modelable.phone
    invoice.total_buy = data.total_buy
    invoice.loan = data.loan
    invoice.loan_installment = data.loan_installment
    invoice.total = data.total

    modal.value = true
}
</script>
