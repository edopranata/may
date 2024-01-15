<template>
    <Head title="Beli Sawit Petani"/>

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Beli Sawit Petani</PageTitle>

    <input id="modal-save" v-model="modal.save" class="modal-toggle" type="checkbox"/>
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan input timbangan kebun?</h3>
            <p class="py-4">Proses, dan lanjutkan ke halaman input data timbangan kebun petani</p>
            <div class="modal-action">
                <button ref="btn_save" class="btn" type="button" @click="save">Proses</button>
                <label class="btn btn-warning" for="modal-save">Batal</label>
            </div>
        </div>
    </div>

    <input id="modal-trade" v-model="modal.trade" class="modal-toggle" type="checkbox"/>
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan input timbangan atau hapus</h3>
            <div class="modal-action flex justify-between">
                <button :disabled="modal.deleted || form.processing" class="btn btn-error" @click.prevent="delete_trade" type="button">Hapus</button>
                <div class="flex space-x-2">
                    <Link v-if="modal.selected" :disabled="form.processing" :href="route('transaction.trade.edit', modal.selected.id)" as="button"
                          class="btn" type="button">Tambah / Edit
                    </Link>
                    <label  class="btn btn-warning" for="modal-trade">Batal</label>
                </div>
            </div>
        </div>
    </div>
    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <form>
                <div class="card-body grid md:grid-cols-4 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Tanggal Transaksi</span>
                        </label>
                        <input v-model="form.date" :readonly="form.processing" class="input input-info input-bordered w-full"
                               type="date" @focus="form.clearErrors('date')"/>
                        <label v-if="form.errors.date" class="label">
                            <span class="label-text-alt text-error">{{ form.errors.date }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Mobil</span>
                        </label>
                        <select v-model="form.car_id" :disabled="form.processing" class="select select-info select-bordered"
                                @focus="form.clearErrors('car_id')">
                            <option value="0">Pilih Mobil</option>
                            <option v-for="(item, index) in props.cars" :key="item.id" :value="item.id">
                                {{ item.text.toUpperCase() }}
                            </option>
                        </select>
                        <label v-if="form.errors.car_id" class="label">
                            <span class="label-text-alt text-error">{{ form.errors.car_id }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Supir</span>
                        </label>
                        <select v-model="form.driver_id" :disabled="form.processing"
                                class="select select-info select-bordered" @focus="form.clearErrors('driver_id')">
                            <option value="0">Pilih Supir</option>
                            <option v-for="(item, index) in props.drivers" :key="item.id" :value="item.id">
                                {{ item.text.toUpperCase() }}
                            </option>
                        </select>
                        <label v-if="form.errors.driver_id" class="label">
                            <span class="label-text-alt text-error">{{ form.errors.driver_id }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Uang Jalan</span>
                        </label>
                        <VueNumberFormat v-model:value="form.trade_cost"
                                         :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing"
                                         class="input input-info input-bordered w-full"/>
                        <label v-if="form.errors.trade_cost" class="label">
                            <span class="label-text-alt text-error">{{ form.errors.trade_cost }}</span>
                        </label>
                    </div>
                </div>
                <div class="card-actions justify-end p-8">
                    <button :disabled="form.processing" class="btn btn-primary" @click.prevent="modal.save=true">Input
                        Timbangan Kebun
                    </button>
                </div>
            </form>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6" rowspan="2">#</th>
                        <th class="py-3 px-6" rowspan="2">Tanggal</th>
                        <th class="py-3 px-6" rowspan="2">Supir</th>
                        <th class="py-3 px-6" rowspan="2">Petani</th>
                        <th class="py-3 px-6 border-b border-primary-content text-center" colspan="2">Timbangan Kebun
                        </th>
                        <th class="py-3 px-6 border-b border-primary-content text-center" colspan="2">Timbangan Pabrik
                        </th>
                        <th class="py-3 px-6" rowspan="2"></th>
                    </tr>
                    <tr>
                        <th class="py-3 px-6 text-right">Tonase</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6 text-right">Tonase</th>
                        <th class="py-3 px-6 text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in props.trades.data" v-if="props.trades.data.length"
                        class="hover:cursor-pointer group border-b" @click.prevent="open_modal_trade(index)">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.trades.from + index }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.trade_date }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.driver.name }}</div>
                                <div class="text-sm opacity-50">{{ item.car.no_pol }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-center">{{ item.details.length }} Petani</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{
                                Intl.NumberFormat('id-ID', {style: 'unit', unit: 'kilogram'}).format(item.gross_weight)
                            }}
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{
                                Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }).format(item.gross_total)
                            }}
                        </td>

                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">
                            {{ Intl.NumberFormat('id-ID', {style: 'unit', unit: 'kilogram'}).format(item.net_weight) }}
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{
                                Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }).format(item.net_total)
                            }}
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <BaseIcon :path="mdiArrowRight"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.trades.data.length" :links="props.trades.links"/>

            </div>
        </div>
    </section>
</template>

<script setup>

import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"
import Pagination from "@/Components/Pagination.vue"

import VueNumberFormat from "vue-number-format";
import {mdiArrowRight} from "@mdi/js"
import {Head, useForm, Link} from '@inertiajs/inertia-vue3'
import {reactive, ref, watch} from "vue";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Beli Sawit Petani"
    }
]
const modal = reactive({
    save: false,
    trade: false,
    selected: null,
    deleted: false
})

const btn_save = ref()

watch(modal, (data) => {
    if (data.save) {
        setTimeout(function () {
            btn_save.value.focus()
        }, 100)
    }
    if (!data.trade) {
        modal.selected = null
    }
});

const props = defineProps({
    cars: Array,
    drivers: Array,
    trades: Object,
})

const form = useForm({
    date: null,
    car_id: 0,
    driver_id: 0,
    trade_cost: 0
})


const save = () => {
    form.post(route('transaction.trade.store'), {
        onFinish: () => {
            modal.save = false;
        }
    });
}


const open_modal_trade = (index) => {
    modal.trade = true
    modal.selected = props.trades.data[index]
    modal.deleted = modal.selected === null || modal.selected?.details.length > 0
}
const delete_trade = () => {
    form.delete(route('transaction.trade.delete', modal.selected.id), {
        onFinish:  () => {
            modal.trade = false
        }
    })
}
</script>
