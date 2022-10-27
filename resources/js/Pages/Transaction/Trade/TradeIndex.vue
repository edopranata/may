<template>
    <Head title="Transaksi Jual Beli" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Transaksi Jual Beli Sawit</PageTitle>

    <input type="checkbox" id="modal-save" v-model="modal_save" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Congratulations random Internet user!</h3>
            <p class="py-4">You've been selected for a chance to get one year of subscription to use Wikipedia for free!</p>
            <div class="modal-action">
                <button ref="btn_save" type="button" class="btn" @click="save">Proses</button>
                <label for="modal-save" class="btn btn-warning">Batal</label>
            </div>
        </div>
    </div>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <form>
                <div class="card-body grid md:grid-cols-3 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Tanggal Transaksi</span>
                        </label>
                        <input :readonly="form.processing" @focus="form.clearErrors('date')" v-model="form.date" type="date" class="input input-info input-bordered w-full" />
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
                            <option v-for="(item, index) in props.cars" :value="item.id" :key="item.id">{{ item.text }}</option>
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
                            <option v-for="(item, index) in props.drivers" :value="item.id" :key="item.id">{{ item.text }}</option>
                        </select>
                        <label class="label" v-if="form.errors.driver_id">
                            <span class="label-text-alt text-error">{{ form.errors.driver_id }}</span>
                        </label>
                    </div>
                </div>
                <div class="card-actions justify-end p-8">
                    <button :disabled="form.processing" @click.prevent="modal_save=true" class="btn btn-primary">Input Timbangan Kebun</button>
                </div>
            </form>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">No Polisi</th>
                        <th class="py-3 px-6">Supir</th>
                        <th class="py-3 px-6">Jumlah</th>
                        <th class="py-3 px-6">Tonase</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.trades.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.trades.data">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.trades.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.car.no_pol }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 max-w-xs">{{ item.driver.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 ">{{ item.trades.length }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.trades.length }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
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
import BaseIcon from "@/Components/BaseIcon.vue"

import { mdiArrowRight } from "@mdi/js"
import {Head, useForm} from '@inertiajs/inertia-vue3'
import {ref, watch} from "vue";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Transaksi Jual Beli Sawit"
    }
]

const modal_save = ref(false)
const btn_save = ref()

watch(modal_save, (data) => {
    if(data){
        setTimeout(function (){
            btn_save.value.focus()
        }, 100)
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
})

const save = () => {
    form.post(route('transaction.trade.store'));
}
</script>
