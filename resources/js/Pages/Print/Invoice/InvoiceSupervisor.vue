<template>
    <Head title="Amprah Mobil" />


    <section class="flex justify-center pt-5">
        <div class="w-3xl print:w-[100%]">

            <div class="grid text-sm grid-cols-1 w-full">
                <div class="flex justify-between border-gray-800 border-b-2 print:hidden mb-10">
                    <Link as="button" :href="route('report.invoice.index')" class="btn btn-sm mb-5"><BaseIcon :path="mdiArrowLeft"/> Ke Halaman Utama</Link>

                    <button class="btn btn-success btn-sm mb-5" onclick="window.print()"><BaseIcon :path="mdiPrinterPos"/> Print</button>
                </div>
                <div class="flex justify-between">
                    <div class="flex space-x-4">
                        <Logo/>
                    </div>
                    <div class="text-left w-[35%] mb-5">
                        <div class="border-gray-800 border-b pb-1">Kepada</div>
                        <div class="border-gray-800 border-b pb-1">{{ invoice.modelable.name.toUpperCase() }}</div>
                    </div>
                </div>
                <div class="flex justify-between mb-2">
                    <div class="font-bold">No Nota : {{ invoice.invoice_number }}</div>
                    <div class="font-bold text-right">{{ invoice.invoice_date }}</div>
                </div>

                <div class="grid grid-cols-5">
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y col-span-2">Tanggal / Keterangan</span>
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y">Banyaknya</span>
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-l border-gray-800 border-y">Harga</span>
                    <span class="font-bold text-center px-4 py-1 border-gray-800 border-x border-gray-800 border-y">Total</span>
                </div>
                <div class="grid grid-cols-5">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2">Tanggal Bayar</span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-x"></span>
                </div>
                <div class="grid grid-cols-5">
                    <span class="px-4 border-gray-800 border-l col-span-2">{{ props.invoice.invoice_date }}</span>
                    <span class="px-4 border-gray-800 border-l text-right"></span>
                    <span class="px-4 border-gray-800 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(props.invoice.total_buy) }}</span>
                    <span class="px-4 border-gray-800 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(props.invoice.total) }}</span>
                </div>
                <div class="grid grid-cols-5" v-for="n in createLine.value">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-x text-right font-bold">&nbsp;</span>
                </div>
                <div class="grid grid-cols-5" :class="!invoice.loan ? 'border-gray-800 border-b' : ''">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2" :class="!invoice.loan > 1 ? 'pb-4' : ''">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l" :class="!invoice.loan > 1 ? 'pb-4' : ''">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-l" :class="!invoice.loan > 1 ? 'pb-4' : ''">&nbsp;</span>
                    <span class="px-4 border-gray-800 border-x text-right font-bold" :class="!invoice.loan > 1 ? 'pb-4' : ''">&nbsp;</span>
                </div>

                <div class="grid grid-cols-5" v-if="invoice.loan">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2">Potongan</span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-x text-right font-bold"></span>
                </div>
                <div class="grid grid-cols-5" v-if="invoice.loan">
                    <span class="px-4 border-gray-800 border-l col-span-2">Pinjaman Terakhir</span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-x text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.loan) }}</span>
                </div>
                <div class="grid grid-cols-5" v-if="invoice.loan">
                    <span class="px-4 border-gray-800 border-l col-span-2">Bayar Pinjaman</span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-l"></span>
                    <span class="px-4 border-gray-800 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.loan_installment ? invoice.loan_installment * -1 : 0) }}</span>
                </div>
                <div class="grid grid-cols-5" v-if="invoice.loan" :class="invoice.loan > 1 ? 'border-gray-800 border-b' : ''">
                    <span class="px-4 border-gray-800 border-l font-bold col-span-2" :class="invoice.loan > 1 ? 'pb-4' : ''">Sisa Pinjaman</span>
                    <span class="px-4 border-gray-800 border-l" :class="invoice.loan > 1 ? 'pb-4' : ''"></span>
                    <span class="px-4 border-gray-800 border-l" :class="invoice.loan > 1 ? 'pb-4' : ''"></span>
                    <span class="px-4 border-gray-800 border-x text-right font-bold" :class="invoice.loan > 1 ? 'pb-4' : ''">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.loan - invoice.loan_installment) }}</span>
                </div>
                <div class="grid grid-cols-5 border-gray-800 border-y-2 font-bold">
                    <span class="px-4 py-1 border-gray-800 border-l text-right col-span-4">Total Diterima</span>
                    <span class="px-4 py-1 border-gray-800 border-x text-right" >{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(invoice.total - invoice.loan_installment) }}</span>
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
import Logo from "@/Components/Logo.vue";

const trade = reactive({
    total: Number,
})
const props = defineProps({
    invoice: Object
})

const createLine = reactive({
    value: 0
})

onMounted( () => {
    const loanLine = props.invoice.loan ? 4 : 0
    createLine.value = 8 - (loanLine)

})
</script>
