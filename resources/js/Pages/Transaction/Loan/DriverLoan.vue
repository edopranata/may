<template>
    <Head title="Pinjaman Supir" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Pinjaman Supir</PageTitle>


    <section class="px-4 grid md:grid-cols-2 gap-4">
        <div class="card w-full rounded-none border-2 border-success shadow-xl">
            <div class="card-body">
                <h2 class="text-xl">Informasi Supir</h2>
                <div class="divider my-2"></div>
                <table class="w-full text-left text-base">
                    <tbody>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Nama Supir</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.driver.name }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Alamat</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.driver.address }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">No Handphone</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ props.driver.phone }}</td>
                    </tr>
                    <tr class="group border-b">
                        <th class="group-hover:bg-base-200 py-4 px-6">Pinjaman</th>
                        <td class="group-hover:bg-base-200 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(props.driver.loan ? props.driver.loan.balance : 0)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-success shadow-xl">
            <div class="card-body">
                <form @submit.prevent="save">
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

import {Head, Link, useForm} from "@inertiajs/inertia-vue3"
import VueNumberFormat from 'vue-number-format'

const props = defineProps({
    driver: Object
})

const form = useForm({
    type: 'driver',
    id: props.driver.id,
    date: '',
    amount: '',
    description: ''
})
const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": route('transaction.loan.driver.index'),
        "label": "Pinjaman"
    },
    {
        "url": null,
        "label": "Supir : " + props.driver.name
    }
]

const save = () => {
    form.post(route('transaction.loan.driver.store'), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const set_default_form = () => {
    form.clearErrors();
    form.reset()

    form.defaults({
        date: null,
        amount: null,
        description: null
    })

}
</script>
