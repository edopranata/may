<template>
    <Head title="Biaya Operasional Mobil" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Biaya Operasional Mobil</PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan proses</h3>
            <p class="py-4">Klik simpan untuk simpan biaya operasional</p>
            <div class="modal-action flex justify-between">
                <button type="button" @click="save" class="btn btn-primary"><BaseIcon :path="mdiContentSave"/> Simpan Transaksi</button>
                <button type="button" @click="modal=false" class="btn btn-warning"><BaseIcon :path="mdiCancel"/> Batal</button>
            </div>
        </div>
    </div>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-4 gap-4">
                <div class="col-span-2 grid grid-cols-2 gap-4">
                    <div class="form-control w-full">
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
                    <div class="form-control w-full col-span-2">
                        <label class="label">
                            <span class="label-text">Mobil</span>
                        </label>
                        <select :disabled="form.processing" v-model="form.car_id" class="select select-info select-bordered">
                            <option value="0">Pilih Mobil</option>
                            <option v-for="(item, index) in props.cars" :value="item.value" :key="item.value">{{ item.label.toUpperCase() }}</option>
                        </select>
                        <label class="label" v-if="form.errors.car_id">
                            <span class="label-text-alt text-error">{{ form.errors.car_id }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Jenis Biaya</span>
                        </label>
                        <select :disabled="form.processing" v-model="form.name" class="select select-info select-bordered">
                            <option value="0">Pilih Jenis Biaya</option>
                            <option v-for="(item, index) in props.categories" :value="item.value" :key="item.value">{{ item.label.toUpperCase() }}</option>
                        </select>
                        <label class="label" v-if="form.errors.name">
                            <span class="label-text-alt text-error">{{ form.errors.name }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">Jumlah Pengeluaran</label>
                        <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.amount" class="input input-bordered w-full" />
                        <label class="label" v-if="form.errors.amount">
                            <span class="label-text-alt text-error">{{ form.errors.amount }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full col-span-2">
                        <label class="label">Keterangan</label>
                        <textarea v-model="form.description" :disabled="form.processing" class="textarea textarea-bordered" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4 py-1">
                        <button :disabled="form.processing" @click="modal = true" class="btn mt-8">Save</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="w-full mb-4">

                </div>
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Invoice Number</th>
                        <th class="py-3 px-6">Mobil</th>
                        <th class="py-3 px-6">Jenis</th>
                        <th class="py-3 px-6">Keterangan</th>
                        <th class="py-3 px-6 text-right">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.costs.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.costs.data" >
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.costs.from + index }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.invoice_date }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.invoice_number }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.car.no_pol }}</div>
                                <div class="text-sm opacity-50">{{ item.car.name }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.description }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format((item.amount)) }}</td>

                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.costs.data.length" :links="props.costs.links" />

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
        "url": route('transaction.cost.index'),
        "label": "Invoice"
    },
    {
        "url": null,
        "label": "Biaya Operasional Mobil"
    }
]

const props = defineProps({
    cars: Array,
    costs: Object,
    categories: Array,
})

const form = useForm({
    name: '',
    car_id: props.car_id ?? 0,
    invoice_number: 'OTOMATIS',
    amount: 0,
    invoice_date: '',
    description: '',
})

const save = () => {
    form.post(route('transaction.cost.store'), {
        onFinish: () => {
            modal.value = false
        }
    });
}


</script>
