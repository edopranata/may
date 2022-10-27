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
                <button :disabled="form.processing" ref="btn_save" type="button" class="btn" @click="save">Tambah</button>
                <label for="modal-save" class="btn btn-warning">Batal</label>
            </div>
        </div>
    </div>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-3 gap-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Tanggal Transaksi</span>
                    </label>
                    <input readonly v-model="form.date" type="date" class="input input-info input-bordered w-full" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Mobil</span>
                    </label>
                    <input readonly type="text" :value="props.trade.car.no_pol.toUpperCase() + ' - ' + props.trade.car.name.toUpperCase()" class="input input-info input-bordered w-full" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Supir</span>
                    </label>
                    <input readonly type="text" :value="props.trade.driver.name.toUpperCase()" class="input input-info input-bordered w-full" />
                </div>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <form @submit.prevent="modal_save=true" class="card-body">
                <div class="grid md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    <div class="form-control w-full md:col-span-2 lg:col-span-3 xl:col-span-2">
                        <select @focus="form.clearErrors('farmer_id')" :disabled="form.processing" v-model="form.farmer_id" class="select select-info select-bordered">
                            <option value="0">Pilih Petani</option>
                            <option v-for="(item, index) in props.farmers" :value="item.id" :key="item.id">{{ item.text }}</option>
                        </select>
                        <label class="label" v-if="form.errors.farmer_id">
                            <span class="label-text-alt text-error">{{ form.errors.farmer_id }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <VueNumberFormat @focus="form.clearErrors('weight')" :options="{ precision: 0, prefix: '', suffix: ' Kg', isInteger: true }" :readonly="form.processing" v-model:value="form.weight" class="input input-info input-bordered" />
                        <label class="label" v-if="form.errors.weight">
                            <span class="label-text-alt text-error">{{ form.errors.weight }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <VueNumberFormat @focus="form.clearErrors('price')" :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }" :readonly="form.processing" v-model:value="form.price" class="input input-info input-bordered" />
                        <label class="label" v-if="form.errors.price">
                            <span class="label-text-alt text-error">{{ form.errors.price }}</span>
                        </label>
                    </div>
                    <div class="flex justify-between space-x-4 md:col-span-4 lg:col-span-5 xl:col-span-2">
                        <div class="form-control w-full min-w-xs">
                            <VueNumberFormat :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }" readonly v-model:value="form.total" class="input input-info input-bordered" />
                        </div>
                        <button :disabled="form.processing" type="submit" class="btn">Tambahkan</button>
                    </div>
                </div>
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">No Polisi</th>
                        <th class="py-3 px-6">Berat</th>
                        <th class="py-3 px-6">Harga</th>
                        <th class="py-3 px-6">Total</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.trade.details.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.trade.details">
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ index + 1 }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.farmer.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.weight) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 ">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.price) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.total) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </section>
</template>

<script setup>

import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

import {mdiArrowRight} from '@mdi/js'
import VueNumberFormat from 'vue-number-format'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import {ref, watch} from "vue";
import _ from "lodash";

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
    trade: Object,
    farmers: Array
})

const form = useForm({
    date: props.trade.trade_date,
    farmer_id: 0,
    weight: 0,
    price: 0,
    total: 0
})


watch(() => _.cloneDeep(form), (current, old) => {
    if(current.weight && current.price){
        form.total = current.weight * current.price
    }
})
const save = () => {
    form.patch(route('transaction.trade.update', props.trade.id), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const set_default_form = () => {
    form.clearErrors();
    form.reset()

    form.defaults({
        date: props.trade.trade_date,
        farmer_id: 0,
        weight: 0,
        price: 0,
        total:0
    })
}
</script>
