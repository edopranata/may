<template>
    <Head title="Transaksi Jual Beli" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Timbangan Kebun</PageTitle>

    <input type="checkbox" id="modal-save" v-model="modal_save" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Data timbangan sudah benar?</h3>
            <p class="py-4">Simpan data dan lanjut tambahkan data timbangan yang lainnya</p>
            <div class="modal-action">
                <button :disabled="form.processing" ref="btn_save" type="button" class="btn" @click="save">Tambah</button>
                <label for="modal-save" class="btn btn-warning">Batal</label>
            </div>
        </div>
    </div>

    <input type="checkbox" id="modal-delete" v-model="modal_delete" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg" v-if="form_delete.status">Tidak dapat dihapus, karena invoice telah terbit</h3>
            <h3 class="font-bold text-lg" v-else>Apakah data ini akan di hapus?</h3>
            <div class="modal-action">
                <button :disabled="form.processing || form_delete.status" ref="btn_delete" type="button" class="btn btn-error" @click="destroy">Hapus</button>
                <label for="modal-delete" class="btn btn-warning">Batal</label>
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
                        <label class="label">
                            <span class="label-text">Nama Petani</span>
                        </label>
                        <Multiselect class="select  select-bordered rounded"
                                     :searchable="true"
                                     v-model="form.farmer_id"
                                     :options="props.farmers"
                        />
                        <label class="label h-8">
                            <span v-if="form.errors.farmer_id" class="label-text-alt text-error">{{ form.errors.farmer_id }}</span>
                        </label>
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
<!--                    <div class="flex justify-between space-x-4 md:col-span-4 lg:col-span-5 xl:col-span-2">-->
                        <button :disabled="form.processing" type="submit" class="btn">Tambahkan</button>
                    </div>
                </div>
                <div class="w-full overflow-y-auto mt-10 md:mt-0">
                    <table class="w-full text-left text-base min-w-4xl">
                        <thead class="text-sm uppercase bg-primary/20">
                        <tr>
                            <th class="py-3 px-6">#</th>
                            <th class="py-3 px-6">Petani</th>
                            <th class="py-3 px-6 text-right">Berat</th>
                            <th class="py-3 px-6 text-right">Harga</th>
                            <th class="py-3 px-6 text-right">Total</th>
                            <th class="py-3 px-6">Invoice</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="props.trade.details.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.trade.details" @click.prevent="openModal(index)">
                            <td class="group-hover:bg-base-300 py-4 px-6">{{ index + 1 }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6">
                                <div>
                                    <div class="font-bold">{{ item.farmer.name }}</div>
                                    <div class="text-sm opacity-50">{{ item.farmer.phone }}</div>
                                </div>
                            </td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.weight) }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right ">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.price) }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.total) }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6"><div class="flex justify-between"><span class="badge badge-lg" :class="item.farmer_status ? 'badge-success' : 'badge-error'">{{ item.farmer_status ? 'Terbit' : 'Belum' }}</span><BaseIcon :path="mdiArrowRight" /></div> </td>
                        </tr>
                        <tr class="border-t" v-if="props.trade.details.length">
                            <th class="group-hover:bg-base-300 py-4 px-6 text-right" colspan="2">Total</th>
                            <th class="group-hover:bg-base-300 py-4 px-6 text-right">{{Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(props.trade.gross_weight) }}</th>
                            <td class="group-hover:bg-base-300 py-4 px-6"></td>
                            <th class="group-hover:bg-base-300 py-4 px-6 text-right">{{Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(props.trade.gross_total)}}</th>
                            <td class="group-hover:bg-base-300 py-4 px-6"></td>
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
import {Head, useForm} from '@inertiajs/inertia-vue3'
import {ref, watch} from "vue";
import _ from "lodash";

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
        "label": "Timbangan Kebun " + props.trade.car.no_pol.toUpperCase() + ' - ' + props.trade.car.name.toUpperCase()
    }
]

const modal_save = ref(false)
const modal_delete = ref(false)

const btn_save = ref()
const btn_delete = ref()
const opt_farmer = ref()

watch(modal_save, (data) => {
    if(data){
        setTimeout(function (){
            btn_save.value.focus()
        }, 100)
    }
});

watch(modal_delete, (data) => {
    if(data){
        setTimeout(function (){
            btn_delete.value.focus()
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

const form_delete = useForm({
    id: 0,
    farmer_id: 0,
    status: false,
})

const openModal = (index) => {
    let data = props.trade.details[index]
    form_delete.id = data.id
    form_delete.farmer_id = data.farmer_id
    form_delete.status = data.farmer_status ? true : false
    modal_delete.value = true
}

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
        onFinish: () => {
            modal_save.value = false
        }
    });
}


const destroy = () => {
    form_delete.delete(route('transaction.trade.destroy', form_delete.id), {
        onSuccess: () => {
            set_default_form_delete()
        },
        onFinish: () => {
            modal_delete.value = false
        }
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
    modal_save.value = false

    setTimeout(function (){
        opt_farmer.value.focus()
    }, 300)

}

const set_default_form_delete = () => {
    form_delete.clearErrors();
    form_delete.reset()

    form_delete.defaults({
        id: 0,
        farmer_id: 0,
    })
    modal_delete.value = false
}
</script>
