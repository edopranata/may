<template>
    <Head title="Timbangan Pabrik"/>

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Timbangan Pabrik</PageTitle>

    <input id="modal-save" v-model="modal_save" class="modal-toggle" type="checkbox"/>
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Data timbangan pabrik sudah benar?</h3>
            <p class="py-4">Simpan data dan lanjut tambahkan ke timbangan pabrik yang lainnya</p>
            <div class="modal-action">
                <button ref="btn_save" :disabled="form.processing" class="btn" type="button" @click="save">Simpan
                </button>
                <label class="btn btn-warning" for="modal-save">Batal</label>
            </div>
        </div>
    </div>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <form class="card-body" @submit.prevent="modal_save=true">
                <div class="grid md:grid-cols-4 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Tanggal Timbang Kebun</span>
                        </label>
                        <input :value="form.date" class="input input-info input-bordered w-full" disabled type="text"/>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Mobil</span>
                        </label>
                        <input :value="props.trade.car.no_pol.toUpperCase() + ' - ' + props.trade.car.name.toUpperCase()" class="input input-info input-bordered w-full"
                               disabled
                               type="text"/>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Supir</span>
                        </label>
                        <input :value="props.trade.driver.name.toUpperCase()" class="input input-info input-bordered w-full" disabled
                               type="text"/>
                    </div>
                    <div class="divider md:col-span-3 mb-1 mt-10">Data Timbangan & Harga</div>
                    <div></div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Timbangan Kebun Petani (Kg)</span>
                        </label>
                        <VueNumberFormat :options="{ precision: 0, prefix: '', suffix: ' Kg', isInteger: true }"
                                         :value="props.trade.gross_weight"
                                         class="input input-info input-bordered" disabled/>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Harga Beli Rata-Rata (Rp)</span>
                        </label>
                        <VueNumberFormat :options="{ precision: 2, prefix: 'Rp. ', suffix: '', decimal: ',' }" :value="props.trade.gross_price"
                                         class="input input-info input-bordered" disabled/>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Total Beli Dari Petani (Rp)</span>
                        </label>
                        <VueNumberFormat :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }"
                                         :value="props.trade.gross_total"
                                         class="input input-info input-bordered" disabled/>
                    </div>
                    <div></div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Timbangan Pabrik (Kg)</span>
                        </label>
                        <VueNumberFormat v-model:value="form.weight"
                                         :options="{ precision: 0, prefix: '', suffix: ' Kg', isInteger: true }"
                                         :readonly="form.processing" class="input input-info input-bordered"
                                         @focus="form.clearErrors('weight')"/>
                        <label class="label h-8">
                            <span v-if="form.errors.weight" class="label-text-alt text-error">{{
                                    form.errors.weight
                                }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Harga Jual Pabrik (Rp)</span>
                        </label>
                        <VueNumberFormat v-model:value="form.price"
                                         :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }"
                                         :readonly="form.processing" class="input input-info input-bordered"
                                         @focus="form.clearErrors('price')"/>
                        <label class="label h-8">
                            <span v-if="form.errors.price" class="label-text-alt text-error">{{
                                    form.errors.price
                                }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Total (Rp)</span>
                        </label>
                        <VueNumberFormat v-model:value="form.total"
                                         :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }" class="input input-info input-bordered" readonly/>
                    </div>
                    <div></div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Amprah Mobil (Rp / Kg)</span>
                        </label>
                        <VueNumberFormat v-model:value="form.car_fee"
                                         :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }" class="input input-info input-bordered"/>
                    </div>
                    <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Total Amprah Mobil (Rp)</span>
                    </label>
                    <VueNumberFormat v-model:value="form.car_price"
                                     :options="{ precision: 0, prefix: 'Rp. ', suffix: '', isInteger: true }" class="input input-info input-bordered" readonly/>
                </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">&nbsp;</span>
                        </label>
                        <button class="btn" type="submit">Simpan Timbangan Pabrik</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <div class="w-full overflow-y-auto">
                    <table class="w-full text-left text-base min-w-4xl">
                        <thead class="text-sm uppercase bg-primary/20">
                        <tr>
                            <th class="py-3 px-6">#</th>
                            <th class="py-3 px-6">Petani</th>
                            <th class="py-3 px-6 text-right">Berat</th>
                            <th class="py-3 px-6 text-right">Harga Beli Petani</th>
                            <th class="py-3 px-6 text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in props.trade.details" v-if="props.trade.details.length"
                            class="hover:cursor-pointer group border-b">
                            <td class="group-hover:bg-base-300 py-4 px-6">{{ index + 1 }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6">
                                <div>
                                    <div class="font-bold">{{ item.farmer.name }}</div>
                                    <div class="text-sm opacity-50">{{ item.farmer.phone }}</div>
                                </div>
                            </td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">
                                {{ Intl.NumberFormat('id-ID', {style: 'unit', unit: 'kilogram'}).format(item.weight) }}
                            </td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right ">{{
                                    Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(item.price)
                                }}
                            </td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{
                                    Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(item.total)
                                }}
                            </td>
                        </tr>
                        <tr v-if="props.trade.details.length" class="border-t">
                            <th class="group-hover:bg-base-300 py-4 px-6 text-right" colspan="2">Total</th>
                            <th class="group-hover:bg-base-300 py-4 px-6 text-right">{{
                                    Intl.NumberFormat('id-ID', {
                                        style: 'unit',
                                        unit: 'kilogram'
                                    }).format(props.trade.gross_weight)
                                }}
                            </th>
                            <td class="group-hover:bg-base-300 py-4 px-6"></td>
                            <th class="group-hover:bg-base-300 py-4 px-6 text-right">{{
                                    Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(props.trade.gross_total)
                                }}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>

import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

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
        "url": route('transaction.factory.index'),
        "label": "Timbangan Pabrik"
    },
    {
        "url": null,
        "label": props.trade.car.no_pol.toUpperCase() + ' - ' + props.trade.car.name.toUpperCase()
    }
]

const modal_save = ref(false)
const btn_save = ref()

watch(modal_save, (data) => {
    if (data) {
        setTimeout(function () {
            btn_save.value.focus()
        }, 100)
    }
});

const props = defineProps({
    trade: Object,
})

const form = useForm({
    date: props.trade.trade_date,
    car_fee: props.trade.car?.price.value,
    weight: 0,
    price: 0,
    total: 0,
    car_price: 0,
})

watch(() => _.cloneDeep(form), (current, old) => {
    if (current.weight) {
        form.car_price = current.weight * current.car_fee
        if(current.price)
            form.total = current.weight * current.price
    }
})

const save = () => {
    form.patch(route('transaction.factory.update', props.trade.id), {
        onFinish: () => {
            modal_save.value = false
        }
    });
}
</script>
