<template>
    <Head title="Invoice Petani" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Invoice Petani</PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box w-11/12 max-w-4xl" for="">
            <table class="w-full text-left text-base print:text-xs">
            <!-- head -->
                <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Pinjaman</th>
                        <th class="py-3 px-6">Total</th>
                        <th class="py-3 px-6">Jumlah Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                  <!-- row 1 -->
                    <tr>
                        <td class="py-3 px-6">
                            <div class="font-bold">{{ farmer.name }}</div>
                            <div class="text-sm opacity-50">{{ farmer.phone }}</div>
                        </td>
                        <td class="py-3 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(farmer.loan)  }}</td>
                        <td class="py-3 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(farmer.total)  }}</td>
                        <td class="py-3 px-6">{{ farmer.counts }} Trx</td>
                    </tr>
                </tbody>
            </table>
            <div class="modal-action flex justify-between space-x-4">
                <div class="flex space-x-4">
                    <Link as="button" :href="route('transaction.invoice.farmer.show', farmer.id)" class="btn btn-info">Buat Invoice</Link>
                    <Link as="button" :href="route('transaction.loan.farmer.show', farmer.id)" class="btn btn-primary">Tambah Pinjaman</Link>
                    <Link as="button" :href="route('transaction.loan.farmer.edit', farmer.id)" class="btn btn-secondary">Bayar Pinjaman</Link>
                </div>
                <button class="btn btn-error" @click="modal = false">Batalkan</button>
            </div>
        </div>
    </div>


    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-success shadow-xl">
            <div class="card-body">
                <div class="flex items-center mb-4">
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Cari Petani</span>
                        </label>
                        <input v-model="form_search.farmer" type="text" placeholder="Cari Petani" class="input input-success input-bordered" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-success shadow-xl">
            <div class="card-body">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Nama Petani</th>
                        <th class="py-3 px-6">Alamat</th>
                        <th class="py-3 px-6">No Telepon</th>
                        <th class="py-3 px-6">Jarak</th>
                        <th class="py-3 px-6">Total</th>
                        <th class="py-3 px-6">Jumlah Trx</th>
                        <th class="py-3 px-6">Pinjaman</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.farmers.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.farmers.data" @click="openModal(index)">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.farmers.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6" style="word-wrap: break-word"><p class="max-w-xs">{{ item.address }}</p> </td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.phone }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.distance }} Km</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.trades_total)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.trades_count }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.loan_total)}}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </tr>
                    <tr v-else>
                        <td colspan="9" class="text-center border-b-2">No Data <Link v-if="props.farmers.current_page > 1" class="link link-primary" :href="route('data.farmer.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.farmers.data.length" :links="props.farmers.links" />
            </div>
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"
import Pagination from "@/Components/Pagination.vue"

import { mdiArrowRight } from "@mdi/js";
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'
import {reactive, ref, watch} from "vue";
import {debounce} from "lodash";
import {Inertia} from "@inertiajs/inertia";

const modal = ref(false)
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
        "url": null,
        "label": "Invoice Petani"
    }
]

const props = defineProps({
    farmer: String,
    farmers: Object
})

const form_search = useForm({
    farmer: props.farmer,
})

watch(
    form_search,
    debounce(function (value) {
        Inertia.get(
            route('transaction.invoice.farmer.index'),
            {
                farmer: value.farmer,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500),
    { deep: true }
);
const farmer = reactive({
    id: 0,
    name: '',
    phone: '',
    address: '',
    distance: '',
    loan: '',
    counts: '',
    total: ''
})

const openModal = function (index){
    let data = props.farmers.data[index]

    farmer.id = data.id
    farmer.name = data.name
    farmer.phone = data.phone
    farmer.address = data.address
    farmer.distance = data.distance
    farmer.loan = data.loan_total
    farmer.total = data.trades_total
    farmer.counts = data.trades_count

    modal.value = true
}

</script>
