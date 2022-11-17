<template>
    <Head title="Amprah Mobil" />


    <section class="flex justify-center pt-5">
        <div class="w-3xl print:w-[100%]">

            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-gray-800 border-b-2 print:hidden mb-10">
                    <Link as="button" :href="route('report.expense.index')" class="btn btn-sm mb-5"><BaseIcon :path="mdiArrowLeft"/> Ke Halaman Utama</Link>
                    <button class="btn btn-success btn-sm mb-5" onclick="window.print()"><BaseIcon :path="mdiPrinterPos"/> Print</button>
                </div>
            </div>


            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-b-2 border-gray-800 mb-4">
                    <div>Laporan Pengeluaran Bulanan</div>
                    <div>Posisi : {{ get_month(props.month) + ' ' + props.year}}</div>

                </div>
                <table class="table-auto w-full text-xs">
                    <thead>
                    <tr class="border-y border-gray-800">
                        <th class="px-2 border-l border-gray-800">#</th>
                        <th class="px-2 border-r border-gray-800">Tanggal</th>
                        <th class="px-2 border-x border-gray-800 text-right" v-for="(item, index) in props.types">{{ item.type }}</th>
                        <th class="px-2 border-r border-gray-800 text-right">Total Pengeluaran</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.expenses.length > 0" v-for="(item, index) in props.expenses">
                        <th class="px-2 border-l border-gray-800 ">{{ index + 1  }}</th>
                        <td class="px-2 border-r border-gray-800 ">{{ item.date  }}</td>
                        <td class="px-2 border-x border-gray-800 text-right" v-for="(value, index) in props.types">{{ filter_type(item.expense, value.type) ?  Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(filter_type(item.expense, value.type) ?? 0) : '-'}}  </td>
                        <td class="px-2 border-r border-gray-800 text-right">{{ (item.expense ? item.expense.balance : 0) > 0 ? Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.expense ? item.expense.balance : 0) : '-'}}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="4" class="text-center border-b-2">No Data</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="border-y border-gray-800" v-if="props.expenses.length > 0">
                        <th class="px-2 border-l border-gray-800"></th>
                        <th class="px-2 border-r border-gray-800 text-right">Total</th>
                        <th class="px-2 border-x border-gray-800 text-right" v-for="(value, index) in props.types">{{ value.balance > 0 ?  Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format( value.balance ) : ''}}</th>
                        <th class="px-2 border-r border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.expense)}}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</template>

<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3'
import {onMounted, reactive, ref} from "vue"
import {mdiPrinterPos, mdiArrowLeft} from "@mdi/js"

import BaseIcon from "@/Components/BaseIcon.vue"

const props = defineProps({
    expenses: Array,
    types: Array,
    year: Number,
    month: Number,
})

const balance = reactive({
    expense: Number,
    total: Array
})

onMounted( () =>{
    getTotal()
})

const getTotal = () => {
    let expense = props.expenses.reduce((arr, trade) => {
        arr.push(trade.expense ? trade.expense.balance : 0)
        return (arr)
    }, []);

    balance.expense = expense.reduce((arr, n) => {
        return arr += n
    }, 0)
}

const filter_type = (data, type) => {
    let amount = 0
    if(data && data.hasOwnProperty('details')){
        if(data.details.length > 0){
            amount = data.details.filter(function (e) {
                return e.type === type;
            })[0];
        }else{
            amount = 0
        }
    }
    return (amount || amount !== undefined) ? amount.amount : amount
}

const get_month = (m) => {
    let month = [undefined, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
    return (!month[m] !== undefined) ? month[m] : ''
}
</script>
