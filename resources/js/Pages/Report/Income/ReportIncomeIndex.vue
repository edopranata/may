<template>
    <Head title="Laporan" />

    <Breadcrumb :links="breadcrumbs"/>
    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <div class="grid md:grid-cols-4">
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Bulan</span>
                        </label>
                        <select :disabled="form.processing" v-model="form.month" class="select select-info select-bordered">
                            <option value="0">Bulan</option>
                            <option v-for="(month, index) in 12" :value="month" :key="index">{{ month }}</option>
                        </select>
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Tahun</span>
                        </label>
                        <input :disabled="form.processing" v-model="form.year" type="number" placeholder="Tahun" class="input input-success input-bordered" />
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">&nbsp;</span>
                        </label>
                        <button type="button" class="btn" @click="form.get(route('report.income.index'))">Filter </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden badge-primary badge-secondary badge badge-accent badge-ghost badge-info badge-error"></div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-3 gap-4">
                <table class="w-full text-left text-base md:col-span-2">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Pemasukan</th>
                        <th class="py-3 px-6">Pengeluaran</th>
                        <th class="py-3 px-6">Laba / Rugi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.incomes.length > 0" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.incomes">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ index + 1  }}</th>
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ item.date  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.income)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.expense)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.net_income)}}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="4" class="text-center border-b-2">No Data</td>
                    </tr>
                    </tbody>
                    <tfoot class="bg-primary/20">
                    <tr v-if="props.incomes.length > 0">
                        <th class="py-4 px-6"></th>
                        <th class="py-4 px-6">Total</th>
                        <th class="py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.income)}}</th>
                        <th class="py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.expense)}}</th>
                        <th class="py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.income - balance.expense)}}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"

import {Head, useForm} from '@inertiajs/inertia-vue3'
import {onMounted, reactive} from "vue";
const breadcrumbs = [
    {
        "url": null,
        "label": "Laporan"
    }
]

const form = useForm({
    year: props.year,
    month: props.month,
})

const props = defineProps({
    incomes: Array,
    types: Array,
    year: String,
    month: String,
})
const balance = reactive({
    income: Number,
    expense: Number
})
onMounted( () =>{
    getTotal()
})

const getTotal = () => {
    let income = props.incomes.reduce((arr, trade) => {
        arr.push(trade.income)
        return (arr)
    }, []);

    balance.income = income.reduce((arr, n) => {
        return arr += n
    }, 0)

    let expense = props.incomes.reduce((arr, trade) => {
        arr.push(trade.expense)
        return (arr)
    }, []);

    balance.expense = expense.reduce((arr, n) => {
        return arr += n
    }, 0)

}
</script>
