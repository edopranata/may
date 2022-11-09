<template>
    <Head title="Pinjaman Mandor" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Pinjaman Mandor</PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan proses pengajuan pinjaman</h3>
            <p class="py-4">Klik simpan untuk lanjutkan pengajuan pinjaman atau klik simpan dan print untuk simpan pengajuan pinjaman dan print</p>
            <div class="modal-action flex justify-between">
                <button type="button" @click="save" :disabled="!form.date || !form.amount"  class="btn btn-primary"><BaseIcon :path="mdiContentSave"/> Simpan</button>
                <button type="button" @click="save_print" :disabled="!form.date || !form.amount"  class="btn btn-primary"><BaseIcon :path="mdiPrinter"/> Simpan dan Print</button>
                <button type="button" @click="modal=false" class="btn btn-warning"><BaseIcon :path="mdiCancel"/> Batal</button>
            </div>
        </div>
    </div>

    <section class="px-4 grid md:grid-cols-2 gap-4">
        <div class="card w-full rounded-none border-2 border-success shadow-xl">
            <div class="card-body">
                <h2 class="text-xl">Informasi Mandor</h2>
                <div class="divider my-2"></div>
                <table class="w-full text-left text-base">
                    <tbody>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Nama Mandor</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.supervisor.name }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Alamat</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.supervisor.address }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">No Handphone</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.supervisor.phone }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Pinjaman</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(props.supervisor.loan ? props.supervisor.loan.balance : 0)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-success shadow-xl">
            <div class="card-body">
                <form @submit.prevent="modal = true">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control w-ful">
                            <label class="label">
                                <span class="label-text">Tanggal Pinjaman</span>
                            </label>
                            <input :readonly="form.processing" v-model="form.date" type="date" placeholder="Tanggal Pinjaman" class="input input-success input-bordered w-full" />
                            <label class="label" v-if="form.errors.date">
                                <span class="label-text-alt text-error">{{ form.errors.date }}</span>
                            </label>
                        </div>
                        <div class="form-control w-ful">
                            <label class="label">
                                <span class="label-text">Invoice Number</span>
                            </label>
                            <input disabled v-model="form.invoice_number" type="text" class="input input-success input-bordered w-full" />
                            <label class="label" v-if="form.errors.invoice_number">
                                <span class="label-text-alt text-error">{{ form.errors.invoice_number }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-control w-ful">
                        <label class="label">
                            <span class="label-text">Jumlah Pinjaman</span>
                        </label>
                        <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.amount" placeholder="Jumlah Pinjaman" class="input input-success input-bordered w-full" />
                        <label class="label" v-if="form.errors.amount">
                            <span class="label-text-alt text-error">{{ form.errors.amount }}</span>
                        </label>
                    </div>

                    <div class="form-control w-ful">
                        <label class="label">
                            <span class="label-text">Keterangan</span>
                        </label>
                        <textarea :readonly="form.processing" v-model="form.description" type="text" placeholder="Keterangan" class="textarea textarea-success textarea-bordered w-full"></textarea>
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

const props = defineProps({
    supervisor: Object
})

const modal = ref(false)
const btnProses = ref()

const form = useForm({
    print: false,
    type: 'supervisor',
    id: props.supervisor.id,
    date: '',
    invoice_number: 'OTOMATIS',
    amount: '',
    description: ''
})
const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": route('transaction.loan.supervisor.index'),
        "label": "Pinjaman"
    },
    {
        "url": null,
        "label": "Mandor : " + props.supervisor.name
    }
]

const save = () => {
    form.post(route('transaction.loan.supervisor.store'), {
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
        invoice_number: 'OTOMATIS',
        print: false,
        date: null,
        amount: null,
        description: null
    })

}
</script>
