<template>
    <Head title="Amprah Mobil" />


    <section class="flex justify-center pt-5">
        <div class="w-3xl print:w-[100%]">

            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-gray-800 border-b-2 print:hidden mb-10">
                    <Link as="button" :href="route('report.index')" class="btn btn-sm mb-5"><BaseIcon :path="mdiArrowLeft"/> Ke Halaman Utama</Link>
                    <button class="btn btn-success btn-sm mb-5" onclick="window.print()"><BaseIcon :path="mdiPrinterPos"/> Print</button>
                </div>
            </div>

            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-b-2 border-gray-800 mb-4">
                    <div>Laporan Pinjaman</div>
                    <div>Posisi : {{ props.date }}</div>
                </div>
                <table class="w-full table-auto text-xs">
                    <thead>
                    <tr class="border-y border-gray-800">
                        <th class="px-2 border-l border-gray-800">#</th>
                        <th class="px-2 border-l border-gray-800 text-left">Kategori</th>
                        <th class="px-2 border-l border-gray-800 text-left" width="400">Nama</th>
                        <th class="px-2 border-x border-gray-800 text-right">Pinjaman</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-y border-gray-800" v-if="props.loans.length > 0" v-for="(item, index) in props.loans">
                        <th class="px-2 border-l border-gray-800">{{ index + 1  }}</th>
                        <th class="px-2 border-l border-gray-800 text-left">{{ item.type.title  }}</th>
                        <th class="px-2 border-l border-gray-800 text-left">{{ item.modelable.name  }}</th>
                        <td class="px-2 border-x border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total)}}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="5" class="text-center border-b-2">No Data</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="border-y border-gray-800" v-if="props.loans.length > 0">
                        <th class="px-2 border-l border-gray-800"></th>
                        <th class="px-2 border-gray-800 text-right" colspan="2">Total</th>
                        <th class="px-2 border-x border-gray-800 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.total)}}</th>
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
    loans: Array,
    date: String,
})

const balance = reactive({
    total: Number
})

onMounted( () =>{
    getTotal()
})

const getTotal = () => {
    let loan = props.loans.reduce((arr, items) => {
        arr.push(items.total)
        return (arr)
    }, []);

    balance.total = loan.reduce((arr, n) => {
        return arr += n
    }, 0)
}

</script>
