<template>
    <Head title="Timbangan Pabrik" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Timbangan Pabrik</PageTitle>

    <input type="checkbox" id="modal-save" v-model="modal_save" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan input timbangan kebun?</h3>
            <p class="py-4">Proses, dan lanjutkan ke halaman input data timbangan kebun petani</p>
            <div class="modal-action">
                <button ref="btn_save" type="button" class="btn" @click="save">Proses</button>
                <label for="modal-save" class="btn btn-warning">Batal</label>
            </div>
        </div>
    </div>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-4 gap-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Tanggal Transaksi</span>
                    </label>
                    <input :disabled="form.processing" @focus="form.clearErrors('date')" v-model="form.date" type="date" class="input input-info input-bordered w-full" />
                    <label class="label" v-if="form.errors.date">
                        <span class="label-text-alt text-error">{{ form.errors.date }}</span>
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Mobil</span>
                    </label>
                    <select @focus="form.clearErrors('car_id')" :disabled="form.processing" v-model="form.car_id" class="select select-info select-bordered">
                        <option value="0">Pilih Mobil</option>
                        <option v-for="(item, index) in props.cars" :value="item.id" :key="item.id">{{ item.text.toUpperCase() }}</option>
                    </select>
                    <label class="label" v-if="form.errors.car_id">
                        <span class="label-text-alt text-error">{{ form.errors.car_id }}</span>
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Supir</span>
                    </label>
                    <select @focus="form.clearErrors('driver_id')" :disabled="form.processing" v-model="form.driver_id" class="select select-info select-bordered">
                        <option value="0">Pilih Supir</option>
                        <option v-for="(item, index) in props.drivers" :value="item.id" :key="item.id">{{ item.text.toUpperCase() }}</option>
                    </select>
                    <label class="label" v-if="form.errors.driver_id">
                        <span class="label-text-alt text-error">{{ form.errors.driver_id }}</span>
                    </label>
                </div>
                <div class="form-control flex justify-end">
                    <button :disabled="form.processing" @click="setFilter" class="btn mt-8">Filter</button>
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
                        <th class="py-3 px-6 text-right">Rata-rata Harga</th>
                        <th class="py-3 px-6 text-right">Tonase</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <Link as="tr" :href="route('transaction.factory.show', item.id)" v-if="props.trades.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.trades.data" >
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.trades.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.trade_date }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.car.no_pol }} - {{ item.car.name }}</div>
                                <div class="text-sm opacity-50">{{ item.driver.name }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-center">{{ item.details.length }} Petani</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.gross_price) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.gross_weight) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.gross_total) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </Link>
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

import { mdiArrowRight } from "@mdi/js"
import {Head, useForm, Link} from '@inertiajs/inertia-vue3'
import {ref} from "vue";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Timbangan Pabrik"
    }
]

const modal_save = ref(false)

const props = defineProps({
    date: String,
    car_id: String,
    driver_id: String,
    cars: Array,
    drivers: Array,
    trades: Object,
})

const form = useForm({
    date: props.date ?? null,
    car_id: props.car_id ?? 0,
    driver_id: props.driver_id ?? 0,
})

const setFilter = () => {
    form.get(route('transaction.factory.index'))
}

</script>
