<template>
    <Head title="Beli Sawit Petani" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'">Beli Sawit Petani</PageTitle>

    <input type="checkbox" id="modal-save" v-model="modal_save" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Lanjutkan input timbangan kebun?</h3>
            <p class="py-4">Proses, dan lanjutkan ke halaman input data timbangan kebun petani</p>
            <div class="modal-action">
                <button ref="btn_save" type="button" class="btn" @click="save">Proses</button>
                <label for="modal-save" class="btn btn-warning">Batal</label>
            </div>
        </div>
    </div>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <form>
                <div class="card-body grid md:grid-cols-4 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Tanggal Transaksi</span>
                        </label>
                        <input :readonly="form.processing" @focus="form.clearErrors('date')" v-model="form.date" type="date" class="input input-info input-bordered w-full" />
                        <label class="label" v-if="form.errors.date">
                            <span class="label-text-alt text-error">{{ form.errors.date }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Mobil</span>
                        </label>
                        <select @focus="form.clearErrors('car_id')" :disabled="form.processing" v-model="form.car_id" class="select select-info select-bordered">
                            <option value="0">Pilih Mobil</option>
                            <option v-for="(item, index) in props.cars" :value="item.id" :key="item.id">{{ item.text.toUpperCase() }}</option>
                        </select>
                        <label class="label" v-if="form.errors.car_id">
                            <span class="label-text-alt text-error">{{ form.errors.car_id }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Supir</span>
                        </label>
                        <select @focus="form.clearErrors('driver_id')" :disabled="form.processing" v-model="form.driver_id" class="select select-info select-bordered">
                            <option value="0">Pilih Supir</option>
                            <option v-for="(item, index) in props.drivers" :value="item.id" :key="item.id">{{ item.text.toUpperCase() }}</option>
                        </select>
                        <label class="label" v-if="form.errors.driver_id">
                            <span class="label-text-alt text-error">{{ form.errors.driver_id }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Uang Jalan</span>
                        </label>
                        <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form.processing" v-model:value="form.trade_cost" class="input input-info input-bordered w-full" />
                        <label class="label" v-if="form.errors.trade_cost">
                            <span class="label-text-alt text-error">{{ form.errors.trade_cost }}</span>
                        </label>
                    </div>
                </div>
                <div class="card-actions justify-end p-8">
                    <button :disabled="form.processing" @click.prevent="modal_save=true" class="btn btn-primary">Input Timbangan Kebun</button>
                </div>
            </form>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6" rowspan="2">#</th>
                        <th class="py-3 px-6" rowspan="2">Tanggal</th>
                        <th class="py-3 px-6" rowspan="2">Supir</th>
                        <th class="py-3 px-6" rowspan="2">Petani</th>
                        <th class="py-3 px-6 border-b border-primary-content text-center" colspan="2">Timbangan Kebun</th>
                        <th class="py-3 px-6 border-b border-primary-content text-center" colspan="2">Timbangan Pabrik</th>
                        <th class="py-3 px-6" rowspan="2"></th>
                    </tr>
                    <tr>
                        <th class="py-3 px-6 text-right">Tonase</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6 text-right">Tonase</th>
                        <th class="py-3 px-6 text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <Link as="tr" :href="route('transaction.trade.edit', item.id)" v-if="props.trades.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.trades.data" >
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.trades.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.trade_date }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>
                                <div class="font-bold">{{ item.driver.name }}</div>
                                <div class="text-sm opacity-50">{{ item.car.no_pol }}</div>
                            </div></td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-center">{{ item.details.length }} Petani</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.gross_weight) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.gross_total) }}</td>

                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(item.net_weight) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.net_total) }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </Link>
                    </tbody>
                </table>
                <Pagination v-if="props.trades.data.length" :links="props.trades.links" />

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
import { mdiArrowRight } from "@mdi/js"
import {Head, useForm, Link} from '@inertiajs/inertia-vue3'
import {ref, watch} from "vue";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Beli Sawit Petani"
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
    cars: Array,
    drivers: Array,
    trades: Object,
})

const form = useForm({
    date: null,
    car_id: 0,
    driver_id: 0,
    trade_cost: 0
})

const save = () => {
    form.post(route('transaction.trade.store'), {
        onFinish: () => {
            modal_save.value = false;
        }
    });
}
</script>
