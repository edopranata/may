<template>
    <Head title="Amprah Mobil" />


    <section class="flex justify-center pt-5">
        <div class="w-3xl print:w-[100%]">

            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-gray-800 border-b-2 print:hidden mb-10">
                    <Link as="button" :href="route('report.income.index')" class="btn btn-sm mb-5"><BaseIcon :path="mdiArrowLeft"/> Ke Halaman Utama</Link>
                    <button class="btn btn-success btn-sm mb-5" onclick="window.print()"><BaseIcon :path="mdiPrinterPos"/> Print</button>
                </div>
            </div>


            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-b-2 border-gray-800 mb-4">
                    <div>Laporan Pengeluaran Bulanan</div>
                    <div>Posisi : {{ get_month(props.month) + ' ' + props.year}}</div>

                </div>
                <table class="w-full table-auto w-full text-xs">
                    <thead>
                    <tr class="border-y border-gray-800">
                        <th class="px-2 border-l border-gray-800">#</th>
                        <th class="px-2 border-l border-gray-800">Tanggal</th>
                        <th class="px-2 border-l border-gray-800 text-right">Pemasukan</th>
                        <th class="px-2 border-l border-gray-800 text-right">Pengeluaran</th>
                        <th class="px-2 border-r border-gray-800 text-right">Laba / Rugi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-y border-gray-800" v-if="props.incomes.length > 0" v-for="(item, index) in props.incomes">
                        <th class="px-2 border-l border-gray-800">{{ index + 1  }}</th>
                        <th class="px-2 border-l border-gray-800">{{ item.date  }}</th>
                        <td class="px-2 border-l border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.income)}}</td>
                        <td class="px-2 border-l border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.expense)}}</td>
                        <td class="px-2 border-x border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.net_income)}}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="5" class="text-center border-b-2">No Data</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="border-y border-gray-800" v-if="props.incomes.length > 0">
                        <th class="px-2 border-l border-gray-800"></th>
                        <th class="px-2 border-gray-800">Total</th>
                        <th class="px-2 border-l border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.income)}}</th>
                        <th class="px-2 border-l border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.expense)}}</th>
                        <th class="px-2 border-x border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.income - balance.expense)}}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</template>

<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3'
import {onMounted, reactive} from "vue"
import {mdiPrinterPos, mdiArrowLeft} from "@mdi/js"

import BaseIcon from "@/Components/BaseIcon.vue"
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
    console.info(income)
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

const get_month = (m) => {
    let month = [undefined, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
    return (!month[m] !== undefined) ? month[m] : ''
}
</script>
