<template>
    <Head title="Amprah Mobil" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Amprah Mobil</PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan proses perhitungan amprah mobil</h3>
            <p class="py-4">Klik Lihat Perhitungan amprah mobil, untuk mengetahui rincian dan total amprah mobil yang akan diterima</p>
            <div class="modal-action flex justify-between">
                <Link as="button" :disabled="props.trades.total < 1" :href="props.car_id ? route('transaction.invoice.car.show', props.car_id) : route('transaction.invoice.car.index')" class="btn btn-primary"><BaseIcon :path="mdiContentSave"/> Lihat Perhitungan Amprah Mobil</Link>
                <button type="button" @click="modal=false" class="btn btn-warning"><BaseIcon :path="mdiCancel"/> Batal</button>
            </div>
        </div>
    </div>


    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Mobil</span>
                    </label>
                    <div class="space-x-4">
                        <select :disabled="form.processing" v-model="form.car_id" class="select select-info select-bordered">
                            <option value="0">Pilih Mobil</option>
                            <option v-for="(item, index) in props.cars" :value="item.id" :key="item.id">{{ item.text.toUpperCase() }}</option>
                        </select>
                        <button :disabled="form.processing" @click="setFilter" class="btn">Filter</button>
                        <button :disabled="(props.car_id<1 || props.trades.total < 1)" @click="modal=true" class="btn btn-primary">Hitung Amprah Mobil</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Mobil</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                        <th class="py-3 px-6 text-right">Tonase</th>
                        <th class="py-3 px-6 text-right">Gaji (Rp / Kg)</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.trades.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.trades.data" >
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.trades.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.trade_date }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.car.no_pol }}</div>
                                <div class="text-sm opacity-50">{{ item.car.name }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-center">{{ item.details.length }} Petani</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.net_weight) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.car.price ? item.car.price.value : '' ) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format((item.car.price ? item.car.price.value : 0) * item.net_weight) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.trades.data.length" :links="props.trades.links" />

            </div>
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"
import Pagination from "@/Components/Pagination.vue"

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
        "label": "Amprah Mobil"
    }
]

const props = defineProps({
    car_id: String,
    cars: Array,
    trades: Object,
})

const form = useForm({
    car_id: props.car_id ?? 0,
})

const setFilter = () => {
    form.get(route('transaction.invoice.car.index'))
}

</script>
