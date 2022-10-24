<template>
    <Head title="Invoice Petani" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Invoice Petani </PageTitle>

    <section class="px-4 flex justify-between space-x-4 items-start">
        <div class="grid md:grid-cols-2 gap-4 w-[50%] print:hidden">
            <div class="form-control w-full">
                <label class="label">No Nota / Invoice</label>
                <input disabled v-model="form.invoice_number" type="text" placeholder="No Nota / Invoice" class="input input-bordered w-full" />
                <label class="label" v-if="form.errors.invoice_number">
                    <span class="label-text-alt text-error">{{ form.errors.invoice_number }}</span>
                </label>
            </div>
            <div class="form-control w-full">
                <label class="label">Tanggal Nota / Invoice</label>
                <input :readonly="form.processing" v-model="form.invoice_date" type="date" placeholder="Tanggal Nota / Invoice" class="input input-bordered w-full" />
                <label class="label" v-if="form.errors.invoice_date">
                    <span class="label-text-alt text-error">{{ form.errors.invoice_date }}</span>
                </label>
            </div>

            <div class="form-control w-full">
                <label class="label">Pinjaman</label>
                <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" readonly v-model:value="form.loan" class="input input-bordered w-full" />
                <label class="label" v-if="form.errors.loan">
                    <span class="label-text-alt text-error">{{ form.errors.loan }}</span>
                </label>
            </div>
            <div class="form-control w-full">
                <label class="label">Angsuran Pinjaman</label>
                <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.installment" class="input input-bordered w-full" />
                <label class="label" v-if="form.errors.installment">
                    <span class="label-text-alt text-error">{{ form.errors.installment }}</span>
                </label>
            </div>

        </div>
        <div class="grid text-sm grid-cols-1 w-[50%] print:w-[100%]">
            <div class="grid grid-cols-5">
                <span class="font-bold text-center px-4 py-2 border-l border-y col-span-2">Tanggal / Keterangan</span>
                <span class="font-bold text-center px-4 py-2 border-l border-y">Banyaknya</span>
                <span class="font-bold text-center px-4 py-2 border-l border-y">Harga</span>
                <span class="font-bold text-center px-4 py-2 border-x border-y">Total</span>
            </div>
            <div class="grid grid-cols-5">
                <span class="px-4 py-2 border-l font-bold col-span-2">Pembelian Sawit</span>
                <span class="px-4 py-2 border-l"></span>
                <span class="px-4 py-2 border-l"></span>
                <span class="px-4 py-2 border-x"></span>
            </div>
            <div class="grid grid-cols-5" v-for="(item, index) in form.trades" :key="item.id">
                <span class="px-4 border-l col-span-2">{{ item.trade_date }}</span>
                <span class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.net_weight) }}</span>
                <span class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.buying_price) }}</span>
                <span class="px-4 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.net_weight * item.buying_price) }}</span>
            </div>

            <div class="grid grid-cols-5" :class="!form.loan ? 'border-b' : ''">
                <span class="px-4 pb-4 border-l col-span-2"></span>
                <span class="px-4 pb-4 border-l"></span>
                <span class="px-4 pb-4 border-l"></span>
                <span class="px-4 pb-4 border-x text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.total) }}</span>
            </div>

            <div class="grid grid-cols-5" v-if="form.loan">
                <span class="px-4 border-l font-bold col-span-2">Potongan</span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-x text-right font-bold"></span>
            </div>
            <div class="grid grid-cols-5" v-if="form.loan">
                <span class="px-4 border-l col-span-2">Pinjaman Terakhir</span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-x text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.loan) }}</span>
            </div>
            <div class="grid grid-cols-5" v-if="form.loan">
                <span class="px-4 border-l col-span-2">Bayar Pinjaman</span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.installment ? form.installment * -1 : 0) }}</span>
            </div>
            <div class="grid grid-cols-5" v-if="form.loan" :class="form.loan > 1 ? 'border-b' : ''">
                <span class="px-4 border-l font-bold col-span-2">Sisa Pinjaman</span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-l"></span>
                <span class="px-4 border-x text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.loan - form.installment) }}</span>
            </div>
            <div class="grid grid-cols-5 border-b font-bold">
                <span class="px-4 py-2 border-l text-right col-span-4">Total Diterima</span>
                <span class="px-4 py-2 border-x text-right" >{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.total - form.installment) }}</span>
            </div>
        </div>
        <div class="text-sm grid grid-cols-1 hidden">
            <div class="border flex flex-col justify-between">
                <table class="w-full">
                    <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2 border" width="">Tanggal / Keterangan</th>
                        <th class="px-4 py-2 border" width="100">Banyaknya</th>
                        <th class="px-4 py-2 border" width="120">Harga</th>
                        <th class="px-4 py-2 border" width="120">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="px-4 py-2 border-l font-bold">Pembelian Sawit</td>
                        <td class="px-4 py-2 border-l"></td>
                        <td class="px-4 py-2 border-l"></td>
                        <td class="px-4 py-2 border-l"></td>
                    </tr>
                    <tr v-for="(item, index) in form.trades" :key="item.id">
                        <td class="px-4 border-l">{{ item.trade_date }}</td>
                        <td class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.net_weight) }}</td>
                        <td class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.buying_price) }}</td>
                        <td class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.net_weight * item.buying_price) }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 pb-4 border-l"></td>
                        <td class="px-4 pb-4 border-l"></td>
                        <td class="px-4 pb-4 border-l"></td>
                        <td class="px-4 pb-4 border-l text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.total) }}</td>
                    </tr>
                    <tr v-if="form.loan">
                        <td class="px-4 border-l font-bold">Pinjaman</td>
                        <td class="px-4 border-l"></td>
                        <td class="px-4 border-l"></td>
                        <td class="px-4 border-l text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.loan) }}</td>
                    </tr>
                    <tr v-if="form.loan">
                        <td class="px-4 border-l">Bayar Pinjaman</td>
                        <td class="px-4 border-l"></td>
                        <td class="px-4 border-l"></td>
                        <td class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.installment ? form.installment * -1 : 0) }}</td>
                    </tr>
                    <tr v-if="form.loan">
                        <td class="px-4 border-l font-bold">Sisa Pinjaman</td>
                        <td class="px-4 border-l"></td>
                        <td class="px-4 border-l"></td>
                        <td class="px-4 border-l text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.loan - form.installment) }}</td>
                    </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                    <tr>
                        <th class="px-4 py-2 border text-right" colspan="3">Total</th>
                        <th class="px-4 py-2 border text-right" width="120" >{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.total - form.installment) }}</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>

<script setup>

import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"

import {Head, useForm} from '@inertiajs/inertia-vue3'
import VueNumberFormat from "vue-number-format";
import {onMounted, watch} from "vue";
import _ from "lodash";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": route('transaction.invoice.index'),
        "label": "Invoice / Gaji"
    },
    {
        "url": route('transaction.invoice.farmer.index'),
        "label": "Invoice Petani"
    },
    {
        "url": null,
        "label": props.farmer.name
    }
]

const form = useForm({
    invoice_date: '',
    invoice_number: 'OTOMATIS',
    farmer_id: props.farmer.id,
    trades: props.farmer.trades,
    loan: props.farmer.loan ? props.farmer.loan.balance : 0,
    total: 0,
    installment: 0,
})

const props = defineProps({
    farmer: Object
})

onMounted( () =>{
    getTotal()
    window.print()
})

watch(() => _.cloneDeep(form), (current, old) => {

})

const getTotal = () => {
    let total = form.trades.reduce((arr, trade) => {
        arr.push(trade.total_buy)
        return (arr)
    }, []);

    total = total.reduce((arr, n) => {
        return arr += n
    }, 0)

    form.total = total
}

</script>
