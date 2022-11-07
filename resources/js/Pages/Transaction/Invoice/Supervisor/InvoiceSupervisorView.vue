<template>
    <Head title="Gaji mandor" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Gaji mandor </PageTitle>

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
                            <label class="label">Gaji mandor</label>
                            <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.supervisor_fee" class="input input-bordered w-full" />
                            <label class="label" v-if="form.errors.supervisor_fee">
                                <span class="label-text-alt text-error">{{ form.errors.supervisor_fee }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">Pinjaman</label>
                            <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.loan" class="input input-bordered w-full" />
                            <label class="label" v-if="form.errors.loan">
                                <span class="label-text-alt text-error">{{ form.errors.loan }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">Angsuran Pinjaman</label>
                            <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.installment" class="input input-bordered w-full" />
                            <label class="label" v-if="form.errors.installment">
                                <span class="label-text-alt text-error">{{ form.errors.installment }}</span>
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
                        <span class="px-4 py-2 border-l font-bold col-span-2">Pembayaran Gaji</span>
                        <span class="px-4 py-2 border-l"></span>
                        <span class="px-4 py-2 border-l"></span>
                        <span class="px-4 py-2 border-x"></span>
                    </div>
                    <div class="grid grid-cols-5">
                        <span class="px-4 border-l col-span-2">{{ form.invoice_date }}</span>
                        <span class="px-4 border-l text-right"></span>
                        <span class="px-4 border-l text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.supervisor_fee) }}</span>
                        <span class="px-4 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.supervisor_fee) }}</span>
                    </div>
                    <div class="grid grid-cols-5" :class="!form.loan ? 'border-b' : ''">
                        <span class="px-4 pb-4 border-l col-span-2"></span>
                        <span class="px-4 pb-4 border-l"></span>
                        <span class="px-4 pb-4 border-l"></span>
                        <span class="px-4 pb-4 border-x text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.total) }}</span>
                    </div>

                    <div class="grid grid-cols-5" v-if="form.loan">
                        <span class="px-4 border-l font-bold col-span-2">Potongan</span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-x text-right font-bold"></span>
                    </div>
                    <div class="grid grid-cols-5" v-if="form.loan">
                        <span class="px-4 border-l col-span-2">Pinjaman Terakhir</span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-x text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.loan) }}</span>
                    </div>
                    <div class="grid grid-cols-5" v-if="form.loan">
                        <span class="px-4 border-l col-span-2">Bayar Pinjaman</span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-x text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.installment ? form.installment * -1 : 0) }}</span>
                    </div>
                    <div class="grid grid-cols-5" v-if="form.loan" :class="form.loan > 1 ? 'border-b' : ''">
                        <span class="px-4 border-l font-bold col-span-2">Sisa Pinjaman</span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-l"></span>
                        <span class="px-4 border-x text-right font-bold">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.loan - form.installment) }}</span>
                    </div>
                    <div class="grid grid-cols-5 border-y font-bold">
                        <span class="px-4 py-2 border-l text-right col-span-4">Total Diterima</span>
                        <span class="px-4 py-2 border-x text-right" >{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(form.supervisor_fee - form.installment) }}</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <table class="w-full text-left text-base">
                <thead class="text-sm uppercase bg-primary/20">
                <tr>
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 px-6">Invoice Number</th>
                    <th class="py-3 px-6">Nama</th>
                    <th class="py-3 px-6 text-right">Total</th>
                    <th class="py-3 px-6 text-right">Pinjaman</th>
                    <th class="py-3 px-6 text-right">Bayar Pinjaman</th>
                    <th class="py-3 px-6 text-right">Diterima</th>
                    <th class="py-3 px-6"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="props.invoices.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.invoices.data">
                    <th class="group-hover:bg-base-300 py-4 px-6">{{ props.invoices.from + index  }}</th>
                    <td class="group-hover:bg-base-300 py-4 px-6">
                        <div>
                            <div class="font-bold">{{ item.invoice_number }}</div>
                            <div class="text-sm opacity-50">{{item.invoice_date }}</div>
                        </div>
                    </td>

                    <td class="group-hover:bg-base-300 py-4 px-6">
                        <div>
                            <div class="font-bold">{{ item.modelable ? item.modelable.name : '' }}</div>
                            <div class="text-sm opacity-50">{{ item.modelable ? item.modelable.phone : '' }}</div>
                        </div>
                    </td>
                    <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total_buy)}}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.loan)}}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.loan_installment)}}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total)}}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                </tr>
                <tr v-else>
                    <td colspan="8" class="text-center border-b-2">No Data <Link v-if="props.invoices.current_page > 1" class="link link-primary" :href="route('report.invoice.search.index')">Goto First Page</Link></td>
                </tr>
                </tbody>
            </table>
            <Pagination v-if="props.invoices.data.length" :links="props.invoices.links" />
        </div>
    </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"
import Pagination from "@/Components/Pagination.vue"

import { mdiPrinter, mdiContentSave, mdiCancel, mdiArrowRight } from "@mdi/js"
import {Head, useForm, Link} from '@inertiajs/inertia-vue3'
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
        "url": route('transaction.invoice.supervisor.index'),
        "label": "Gaji mandor"
    },
    {
        "url": null,
        "label": props.supervisor.name
    }
]

const modal_save = ref(false)

const form = useForm({
    print: false,
    invoice_date: '',
    invoice_number: 'OTOMATIS',
    supervisor_id: props.supervisor.id,
    supervisor_fee: props.supervisor.price ? props.supervisor.price.value : 0,
    loan: props.supervisor.loan ? props.supervisor.loan.balance : 0,
    total: 0,
    installment: 0,
})

const props = defineProps({
    supervisor: Object,
    invoices: Object,
})

const submit = () => {
    form.patch(route('transaction.invoice.supervisor.update', props.supervisor.id), {
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
    if(current.supervisor_fee){
        getTotal()
    }
})

const getTotal = () => {
    form.total = form.supervisor_fee
}

</script>
