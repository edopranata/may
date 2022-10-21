<template>
    <Head title="Pinjaman Supir" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Pinjaman Supir</PageTitle>

    <input type="checkbox" id="modal-option" v-model="modal" class="modal-toggle" />
    <label for="modal-option" class="modal cursor-pointer modal-lg">

        <label class="modal-box relative" for="">
            <span class="px-4 grid grid-cols-2 gap-4">
                <span class="overflow-x-auto col-span-2">
                  <table class="w-full text-left text-base">
                    <!-- head -->
                    <thead class="text-sm uppercase bg-primary/20">
                      <tr>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Pinjaman</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- row 1 -->
                      <tr>
                        <td class="py-3 px-6">
                            <div class="font-bold">{{ driver.name }}</div>
                            <div class="text-sm opacity-50">{{ driver.phone }}</div>
                        </td>
                        <td class="py-3 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(driver.loan)  }}</td>
                      </tr>
                    </tbody>
                  </table>
                </span>
                <Link as="button" :href="driver.id ? route('transaction.loan.driver.show', driver.id) : ''" class="btn btn-xl btn-success btn-block pt-10 pb-14">Pengajuan Pinjaman</Link>
                <Link as="button" :disabled="driver.loan < 1" :href="driver.id ? route('transaction.loan.driver.edit', driver.id) : ''" class="btn btn-xl btn-warning btn-block pt-10 pb-14">Pembayaran Pinjaman</Link>
            </span>

        </label>
    </label>
    <section class="px-4 grid xl:grid-cols-4 md:grid-cols-3 gap-4 mb-4">
        <div class="form-control">
            <input v-model="form_search.search" type="text" placeholder="Search…" class="input input-bordered" />
        </div>
    </section>
    <section class="px-4 grid gap-4">

        <div>
            <table class="w-full text-left text-base">
                <thead class="text-sm uppercase bg-primary/20">
                <tr>
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 px-6">Nama Petani</th>
                    <th class="py-3 px-6">Alamat</th>
                    <th class="py-3 px-6">No Telepon</th>
                    <th class="py-3 px-6">Pinjaman</th>
                    <th class="py-3 px-6"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="props.drivers.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.drivers.data" @click="openModal(index)">
                    <th class="group-hover:bg-base-300 py-4 px-6">{{ props.drivers.from + index  }}</th>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6" style="word-wrap: break-word"><p class="max-w-xs">{{ item.address }}</p> </td>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ item.phone }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.loan ? item.loan.balance : 0)}}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                </tr>
                <tr v-else>
                    <td colspan="5" class="text-center border-b-2">No Data</td>
                </tr>
                </tbody>
            </table>
            <Pagination v-if="props.drivers.data.length" :links="props.drivers.links" />
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"
import Pagination from "@/Components/Pagination.vue"

import { mdiArrowRight } from "@mdi/js";
import {Head, Link, useForm} from "@inertiajs/inertia-vue3"
import {reactive, ref, watch} from "vue"
import {debounce} from "lodash";
import {Inertia} from "@inertiajs/inertia";

const modal = ref(false)

const props = defineProps({
    search: String,
    drivers: Object
})

const form_search = useForm({
    search: props.search
})

watch(
    form_search,
    debounce((value) => {
        Inertia.get(
            route('transaction.loan.driver.index'),
            { search: value.search },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500)
);

const driver = reactive({
    id: 0,
    name: '',
    phone: '',
    address: '',
    loan: '',
})
const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Pinjaman Supir"
    }
]

const openModal = function (index){
    let data = props.drivers.data[index]

    driver.id = data.id
    driver.name = data.name
    driver.phone = data.phone
    driver.address = data.address
    driver.distance = data.distance
    driver.loan = data.loan ? data.loan.balance : 0

    modal.value = true
}
</script>
