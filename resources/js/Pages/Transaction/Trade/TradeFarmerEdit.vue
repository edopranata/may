<template>
    <Head title="Transaksi Jual Beli" />
    <div class="hidden bg-warning"></div>
    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Perubahan data Timbangan Kebun {{ props.trade.farmer.name }}</PageTitle>

    <input type="checkbox" id="modal-save" v-model="modal_save" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-5">{{ props.trade.farmer_status ? 'Invoice telah terbit, Ubah data timbangan?' : 'Ubah data timbangan?' }}</h3>
            <p class="p-4 rounded-lg" :class="props.trade.farmer_status !== null ? 'bg-error' : 'bg-warning'">{{ props.trade.farmer_status ? 'Merubah data timbangan akan merubah Invoice yang sudah di terbitkan dan merubah laporan pendapatan / pengeluaran!' : 'Apkah anda yakin akan merubah data timbangan?' }}</p>
            <div class="modal-action">
                <button :disabled="form.processing" ref="btn_save" type="button" class="btn" @click="save">Ubah</button>
                <label for="modal-save" class="btn btn-warning">Batal</label>
            </div>
        </div>
    </div>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <form @submit.prevent="modal_save=true" class="card-body">
                <div class="grid md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    <div class="form-control w-full md:col-span-2 lg:col-span-3 xl:col-span-2">
                        <label class="label">
                            <span class="label-text">Nama Petani</span>
                        </label>
                        <input type="text" :value="props.trade.farmer.name" class="input input-bordered" readonly />
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Berat</span>
                        </label>
                        <VueNumberFormat @focus="form.clearErrors('weight')" :options="{ precision: 0, prefix: '', suffix: ' Kg', isInteger: true }" :readonly="form.processing" v-model:value="form.weight" class="input  input-bordered" />
                        <label class="label h-8">
                            <span v-if="form.errors.weight" class="label-text-alt text-error">{{ form.errors.weight }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Harga Beli</span>
                        </label>
                        <VueNumberFormat @focus="form.clearErrors('price')" :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }" :readonly="form.processing" v-model:value="form.price" class="input  input-bordered" />
                        <label class="label h-8">
                            <span v-if="form.errors.price" class="label-text-alt text-error">{{ form.errors.price }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Total</span>
                        </label>
                        <div class="form-control w-full">
                            <VueNumberFormat :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }" readonly v-model:value="form.total" class="input  input-bordered" />
                        </div>
                    </div>
                    <div class="form-control w-full pt-9">
                        <!-- <div class="flex justify-between space-x-4 md:col-span-4 lg:col-span-5 xl:col-span-2">-->
                        <button :disabled="form.processing" type="submit" class="btn btn-primary">Ubah Data</button>
                    </div>
                </div>
                <div class="w-full overflow-y-auto mt-10 md:mt-0">
                    <h2 class="text-2xl p-2 font-bold">Data yang sudah terinput</h2>
                    <table class="w-full text-left text-base min-w-4xl">
                        <thead class="text-sm uppercase bg-primary/20">
                        <tr>
                            <th class="py-3 px-6">#</th>
                            <th class="py-3 px-6">Petani</th>
                            <th class="py-3 px-6 text-right">Berat</th>
                            <th class="py-3 px-6 text-right">Harga</th>
                            <th class="py-3 px-6 text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="props.trade" class="hover:cursor-pointer group border-b">
                            <td class="group-hover:bg-base-300 py-4 px-6">{{ 1 }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6">
                                <div>
                                    <div class="font-bold">{{ props.trade.farmer.name }}</div>
                                    <div class="text-sm opacity-50">{{ props.trade.farmer.phone }}</div>
                                </div>
                            </td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(props.trade.weight) }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right ">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(props.trade.price) }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(props.trade.total) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </section>
</template>

<script setup>

import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

import Multiselect from '@vueform/multiselect'
import {mdiArrowRight} from '@mdi/js'
import VueNumberFormat from 'vue-number-format'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'
import {ref, watch} from "vue";
import _ from "lodash";
import Input from "@/Components/Input.vue";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": route('transaction.trade.index'),
        "label": "Beli Sawit Petani"
    },
    {
        "url": null,
        "label": "Timbangan Kebun " + props.trade.farmer.name
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
})

const form = useForm({
    weight: props.trade.weight,
    price: props.trade.price,
    total: props.trade.total,
    difference_total: 0,
})



watch(() => _.cloneDeep(form), (current, old) => {
    if(current.weight && current.price){
        form.total = current.weight * current.price
        form.difference_total =  current.total - props.trade.total
    }
})

const save = () => {
    form.patch(route('transaction.trade.farmer', props.trade.id), {
        onSuccess: () => {
            set_default_form()
        },
        onFinish: () => {
            modal_save.value = false
        }
    });
}


const set_default_form = () => {
    form.clearErrors();
    form.reset()

    form.defaults({
        weight: 0,
        price: 0,
        total:0
    })

    modal_save.value = false

}

</script>
