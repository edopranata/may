<template>
    <Head title="Amprah Mobil" />

    <section class="flex justify-center pt-5">
        <div class="w-3xl print:w-[100%]">

            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-gray-800 border-b-2 print:hidden mb-10">
                    <Link as="button" :href="route('report.index')" class="btn btn-sm mb-5"><BaseIcon :path="mdiArrowLeft"/> Ke Halaman Utama</Link>

                    <button class="btn btn-success btn-sm mb-5" onclick="window.print()"><BaseIcon :path="mdiPrinterPos"/> Print</button>
                </div>
                <div class="flex justify-between">
                    <div class="font-bold "></div>
                    <div class="text-left w-[35%] mb-5">
                        <div class="border-gray-800 border-b pb-1">Kepada</div>
                        <div class="border-gray-800 border-b pb-1">{{ invoice.loan.modelable.name.toUpperCase() }}</div>
                    </div>
                </div>
                <div class="flex justify-between mb-2">
                    <div class="font-bold">No Nota : {{ invoice.invoice_number }}</div>
                    <div class="font-bold text-right">{{ invoice.invoice_date }}</div>
                </div>

                <div class="grid grid-cols-5">
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y col-span-2">Tanggal / Keterangan</span>
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y">Pinjaman Sebelumnya</span>
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y">Bayar / Pinjam</span>
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-x border-gray-800 border-y">Total Pinjaman</span>
                </div>
                <div class="grid grid-cols-5">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-x">&nbsp;</span>
                </div>
                <div class="grid grid-cols-5">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2">{{ invoice.invoice_date }}</span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-x"></span>
                </div>
                <div class="grid grid-cols-5">
                    <span class="px-4 border-gray-800 border-l col-span-2">{{ invoice.description }}</span>
                    <span class="px-4 border-gray-800 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.opening_balance) }}</span>
                    <span class="px-4 border-gray-800 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.amount) }}</span>
                    <span class="px-4 border-gray-800 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.opening_balance + invoice.amount) }}</span>
                </div>
                <div class="grid grid-cols-5">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-x">&nbsp;</span>
                </div>
                <div class="grid grid-cols-5">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-x">&nbsp;</span>
                </div>

                <div class="grid grid-cols-5 border-gray-800 border-y-2 font-bold">
                    <span class="px-4 py-1 border-gray-800 border-l text-right col-span-4">Saldo Akhir Pinjaman</span>
                    <span class="px-4 py-1 border-gray-800 border-x text-right" >{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.opening_balance + invoice.amount) }}</span>
                </div>

                <div class="grid grid-cols-6 mt-8 gap-y-12">
                    <div class="font-bold text-center"></div>
                    <div class="font-bold text-center">Tanda Terima</div>
                    <div class="font-bold text-center"></div>
                    <div class="font-bold text-center"></div>
                    <div class="font-bold text-center">Hormat kami,</div>
                    <div class="font-bold text-center"></div>

                    <div class="font-bold text-center"></div>
                    <div class="font-bold text-center border-b-2 border-gray-800"></div>
                    <div class="font-bold text-center"></div>
                    <div class="font-bold text-center"></div>
                    <div class="font-bold text-center border-b-2 border-gray-800"></div>
                    <div class="font-bold text-center"></div>

                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3'
import {onMounted, reactive, ref} from "vue"
import {mdiPrinterPos, mdiArrowLeft} from "@mdi/js"

import BaseIcon from "@/Components/BaseIcon.vue"

const trade = reactive({
    total: Number,
})
const props = defineProps({
    invoice: Object
})

const createLine = reactive({
    value: 0
})

</script>
