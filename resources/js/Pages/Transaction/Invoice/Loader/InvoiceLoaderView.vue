<template>
    <Head title="Amprah Mobil" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Amprah Mobil </PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal_save" class="modal-toggle" />
    <label for="modal-option" class="modal cursor-pointer modal-lg">

        <label class="modal-box w-11/12 max-w-3xl" for="">
            <div class="flex justify-between">
                <button type="button" @click="save" class="btn btn-primary"><BaseIcon :path="mdiContentSave"/> Simpan</button>
                <button type="button" @click="print" class="btn btn-success"><BaseIcon :path="mdiPrinter"/> Simpan dan Print Invoice</button>
                <button type="button" @click="modal_save=false" class="btn btn-warning"><BaseIcon :path="mdiCancel"/> Batal</button>
            </div>
        </label>
    </label>
    <section class="px-6 w-full">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
        <div class="card-body">
            <div class="flex justify-between space-x-4 items-start">
                <form @submit.prevent="" class="w-[50%]">
                    <div class="grid md:grid-cols-2 gap-4 print:hidden">
                        <div class="form-control w-full col-span-2">
                            <label class="label">No Nota / Invoice</label>
                            <input disabled v-model="form.invoice_number" type="text" placeholder="No Nota / Invoice" class="input input-bordered w-full" />
                            <label class="label" v-if="form.errors.invoice_number">
                                <span class="label-text-alt text-error">{{ form.errors.invoice_number }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">Tanggal Nota / Invoice</label>
                            <input :readonly="form.processing" v-model="form.invoice_date" type="date" placeholder="Tanggal Nota / Invoice" class="input input-bordered w-full" />
                            <label class="label" v-if="form.errors.invoice_date">
                                <span class="label-text-alt text-error">{{ form.errors.invoice_date }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">Upah Supir (Rp  / Kg)</label>
                            <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.car_fee" class="input input-bordered w-full" />
                            <label class="label" v-if="form.errors.car_fee">
                                <span class="label-text-alt text-error">{{ form.errors.car_fee }}</span>
                            </label>
                        </div>
                        <div class="flex justify-between col-span-2">
                            <button type="submit" @click="modal_save=true" class="btn btn-primary">Simpan</button>

                        </div>
                    </div>
                </form>
                <div class="grid text-sm grid-cols-1 w-[50%] print:w-[100%]">
                    <div class="grid grid-cols-5">
                        <span class="font-bold text-center px-4 py-2 border-l border-y col-span-2">Tanggal / Keterangan</span>
                        <span class="font-bold text-center px-4 py-2 border-l border-y">Banyaknya</span>
                        <span class="font-bold text-center px-4 py-2 border-l border-y">Harga</span>
                        <span class="font-bold text-center px-4 py-2 border-x border-y">Total</span>
                    </div>
                    <div class="grid grid-cols-5">
                        <span class="px-4 py-2 border-l font-bold col-span-2">Pembelian Sawit</span>
                        <span class="px-4 py-2 border-l"></span>
                        <span class="px-4 py-2 border-l"></span>
                        <span class="px-4 py-2 border-x"></span>
                    </div>
                    <div class="grid grid-cols-5" v-for="(item, index) in form.trades" :key="item.id">
                        <span class="px-4 border-l col-span-2">{{ item.trade_date }}</span>
                        <span class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.net_weight) }}</span>
                        <span class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.car_fee) }}</span>
                        <span class="px-4 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.net_weight * form.car_fee) }}</span>
                    </div>

                    <div class="grid grid-cols-5 border-y font-bold">
                        <span class="px-4 py-2 border-l text-right col-span-4">Total Diterima</span>
                        <span class="px-4 py-2 border-x text-right" >{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.total) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

import { mdiPrinter, mdiContentSave, mdiCancel } from "@mdi/js"
import {Head, useForm} from '@inertiajs/inertia-vue3'
import VueNumberFormat from "vue-number-format";
import {onMounted, watch, ref} from "vue";
import _ from "lodash";

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
        "url": route('transaction.invoice.car.index'),
        "label": "Amprah Mobil"
    },
    {
        "url": null,
        "label": props.car.name.toUpperCase()
    }
]

const modal_save = ref(false)

const form = useForm({
    print: false,
    invoice_date: '',
    invoice_number: 'OTOMATIS',
    car_id: props.car.id,
    trades: props.car.trades,
    car_fee: props.car.price ? props.car.price.value : 0,
    total: 0,
})

const props = defineProps({
    car: Object
})

const submit = () => {
    form.patch(route('transaction.invoice.car.update', props.car.id), {
        onFinish: () => {
            modal_save.value = false
        }
    });
}
const save = () => {
    form.print = false
    submit()
}
const print = () => {
    form.print=true
    submit()
}

onMounted( () => {
    getTotal()
})

watch(() => _.cloneDeep(form), (current, old) => {
    if(current.car_fee){
        getTotal()
    }
})

const getTotal = () => {
    let totals = form.trades.reduce((arr, trade) => {
        arr.push(trade.net_weight * form.car_fee)
        return (arr)
    }, []);

    totals = totals.reduce((arr, n) => {
        return arr += n
    }, 0)

    form.total = totals
}

</script>
