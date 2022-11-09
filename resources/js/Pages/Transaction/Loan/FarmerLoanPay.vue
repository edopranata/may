<template>
    <Head title="Angsuran Pinjaman Petani" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Angsuran Pinjaman Petani</PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan proses pembayaran pinjaman</h3>
            <p class="py-4">Klik simpan untuk lanjutkan pembayaran atau klik simpan dan print untuk simpan pembayaran dan print</p>
            <div class="modal-action flex justify-between">
                <button type="button" @click="save" :disabled="!form.date || !form.amount"  class="btn btn-primary"><BaseIcon :path="mdiContentSave"/> Simpan</button>
                <button type="button" @click="save_print" :disabled="!form.date || !form.amount"  class="btn btn-primary"><BaseIcon :path="mdiPrinter"/> Simpan dan Print</button>
                <button type="button" @click="modal=false" class="btn btn-warning"><BaseIcon :path="mdiCancel"/> Batal</button>
            </div>
        </div>
    </div>

    <section class="px-4 grid md:grid-cols-2 gap-4">
        <div class="card w-full rounded-none border-2 border-warning shadow-xl">
            <div class="card-body">
                <h2 class="text-xl">Informasi Petani</h2>
                <div class="divider my-2"></div>
                <table class="w-full text-left text-base">
                    <tbody>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Nama Petani</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.farmer.name }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Alamat</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.farmer.address }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">No Handphone</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.farmer.phone }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Sisa Pinjaman</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(props.farmer.loan ? props.farmer.loan.balance : 0)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-warning shadow-xl">
            <div class="card-body">
                <form @submit.prevent="modal = true">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control w-ful">
                            <label class="label">
                                <span class="label-text">Tanggal Pembayaran</span>
                            </label>
                            <input :readonly="form.processing" v-model="form.date" type="date" class="input input-warning input-bordered w-full" />
                            <label class="label" v-if="form.errors.date">
                                <span class="label-text-alt text-error">{{ form.errors.date }}</span>
                            </label>
                        </div>
                        <div class="form-control w-ful">
                            <label class="label">
                                <span class="label-text">Invoice Number</span>
                            </label>
                            <input disabled v-model="form.invoice_number" type="text" class="input input-warning input-bordered w-full" />
                            <label class="label" v-if="form.errors.invoice_number">
                                <span class="label-text-alt text-error">{{ form.errors.invoice_number }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-control w-ful">
                        <label class="label">
                            <span class="label-text">Jumlah Agsuran</span>
                        </label>
                        <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.amount" placeholder="Jumlah Angsuran" class="input input-warning input-bordered w-full" />
                        <label class="label" v-if="form.errors.amount">
                            <span class="label-text-alt text-error">{{ form.errors.amount }}</span>
                        </label>
                    </div>

                    <div class="form-control w-ful">
                        <label class="label">
                            <span class="label-text">Keterangan</span>
                        </label>
                        <textarea :readonly="form.processing" v-model="form.description" type="text" placeholder="Keterangan" class="textarea textarea-warning textarea-bordered w-full"></textarea>
                        <label class="label" v-if="form.errors.description">
                            <span class="label-text-alt text-error">{{ form.errors.description }}</span>
                        </label>
                    </div>
                    <div class="card-actions justify-end mt-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>


<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

import {mdiContentSave, mdiCancel, mdiPrinter} from "@mdi/js"
import {Head, useForm} from "@inertiajs/inertia-vue3"
import VueNumberFormat from 'vue-number-format'
import {ref} from "vue";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": route('transaction.loan.farmer.index'),
        "label": "Pinjaman"
    },
    {
        "url": null,
        "label": "Angsuran pinjaman : " + props.farmer.name
    }
]

const modal = ref(false)
const btnProses = ref()

const props = defineProps({
    farmer: Object
})

const form = useForm({
    print: false,
    type: 'farmer',
    id: props.farmer.id,
    date: '',
    invoice_number: 'OTOMATIS',
    amount: '',
    description: ''
})

const save = () => {
    form.patch(route('transaction.loan.farmer.update', props.farmer.id), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const save_print = () => {
    form.print = true
    save()
}

const set_default_form = () => {
    form.clearErrors();
    form.reset()

    form.defaults({
        print: false,
        date: null,
        invoice_number: 'OTOMATIS',
        amount: null,
        description: null
    })

}
</script>
