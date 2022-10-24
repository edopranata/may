<template>
    <Head title="Transaksi Jual Beli" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Transaksi Jual Beli Sawit</PageTitle>

    <input type="checkbox" v-model="modal_save" id="modal-save" class="modal-toggle" />
    <label for="modal-save" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            <h3 class="text-lg font-bold text-center">Anda yakin data sudah benar?</h3>
            <div class="mt-8 flex justify-center">
                <button :disabled="form.processing" class="btn" @click.prevent="save">Simpan</button>
                <label :class="form.processing ? 'btn-disabled' : ''" for="modal-save" class="btn btn-warning ml-4" @click.prevent="modal_save=false">Batalkan</label>
            </div>
        </label>
    </label>

    <input type="checkbox" id="modal-edit" v-model="modal_loader" class="modal-toggle" />
    <label for="modal-edit" class="modal cursor-pointer">
        <label class="modal-box w-11/12 max-w-3xl relative" for="">
            <div class="grid grid-cols-2 gap-4">
                <h3 class="font-bold text-lg col-span-2">Tukang Muat</h3>
                <h4 class="font-bold text-md">Tidak dipilih</h4>
                <h4 class="font-bold text-md">Dipilih</h4>
                <div class="h-40 overflow-y-scroll border-2 bg-base-200">
                    <ul class="menu">
                        <li
                            v-for="(item, index) in data.loaders"
                            :key="index"
                            @click.prevent="addLoader(index)"
                        ><a class="flex justify-between"><span>{{ item.text }}</span><BaseIcon :path="mdiArrowRight"/></a></li>
                    </ul>
                </div>

                <div class="h-40 overflow-y-scroll border-2 bg-base-200">
                    <ul class="menu">
                        <li
                            v-for="(item, index) in form.loaders"
                            :key="index"
                            @click.prevent="removeLoader(index)"
                        ><a class="flex justify-between"><BaseIcon :path="mdiArrowLeft"/><span>{{ item.text }}</span></a></li>
                    </ul>
                </div>
            </div>
        </label>
    </label>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <form>
                <div class="card-body grid md:grid-cols-2 gap-10">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Tanggal Transaksi</span>
                            </label>
                            <input :readonly="form.processing" @focus="form.clearErrors('date')" v-model="form.date" type="date" placeholder="Tanggal Pinjaman" class="input input-info input-bordered w-full" />
                            <label class="label" v-if="form.errors.date">
                                <span class="label-text-alt text-error">{{ form.errors.date }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Pembelian dari petani</span>
                            </label>
                            <select @focus="form.clearErrors('farmer_id')" :disabled="form.processing" v-model="form.farmer_id" class="select select-info select-bordered">
                                <option value="0">Pilih Petani</option>
                                <option v-for="(item, index) in props.farmers" :value="item.id" :key="item.id">{{ item.text }}</option>
                            </select>
                            <label class="label" v-if="form.errors.farmer_id">
                                <span class="label-text-alt text-error">{{ form.errors.farmer_id }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Supir</span>
                            </label>
                            <select @focus="form.clearErrors('driver_id')" :disabled="form.processing" v-model="form.driver_id" class="select select-info select-bordered">
                                <option value="0">Pilih Supir</option>
                                <option v-for="(item, index) in props.drivers" :value="item.id" :key="item.id">{{ item.text }}</option>
                            </select>
                            <label class="label" v-if="form.errors.driver_id">
                                <span class="label-text-alt text-error">{{ form.errors.driver_id }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">&nbsp;</span>
                            </label>
                            <button type="button" @focus="form.clearErrors('loaders')" :disabled="form.processing" @click.prevent="modal_loader = true" class="btn">Tukang Muat {{ form.loaders.length > 0 ? (form.loaders.length) +' orang' : '' }}</button>
                            <label class="label" v-if="form.errors.loaders">
                                <span class="label-text-alt text-error">{{ form.errors.loaders }}</span>
                            </label>
                        </div>
                        <div class="divider mb-0 md:col-span-2">Timbangan & Harga</div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Timbangan Kebun</span>
                            </label>
                            <VueNumberFormat @focus="form.clearErrors('gross_weight')" :options="{ precision: 0, prefix: '', suffix: ' Kg', acceptNegative: false }" :readonly="form.processing" v-model:value="form.gross_weight" class="input input-info input-bordered w-full" />
                            <label class="label" v-if="form.errors.gross_weight">
                                <span class="label-text-alt text-error">{{ form.errors.gross_weight }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Harga Beli Dari Petani</span>
                            </label>
                            <VueNumberFormat @focus="form.clearErrors('buying_price')" :options="{ precision: 0, prefix: 'Rp. ', acceptNegative: false }" :readonly="form.processing" v-model:value="form.buying_price" class="input input-info input-bordered w-full" />
                            <label class="label" v-if="form.errors.buying_price">
                                <span class="label-text-alt text-error">{{ form.errors.buying_price }}</span>
                            </label>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Timbangan Pabrik</span>
                            </label>
                            <VueNumberFormat @focus="form.clearErrors('net_weight')" :options="{ precision: 0, prefix: '', suffix: ' Kg', acceptNegative: false }" :readonly="form.processing" v-model:value="form.net_weight" class="input input-info input-bordered w-full" />
                            <label class="label" v-if="form.errors.net_weight">
                                <span class="label-text-alt text-error">{{ form.errors.net_weight }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Harga Jual Ke Pabrik</span>
                            </label>
                            <VueNumberFormat @focus="form.clearErrors('selling_price')" :options="{ precision: 0, prefix: 'Rp. ', acceptNegative: false }" :readonly="form.processing" v-model:value="form.selling_price" class="input input-info input-bordered w-full" />
                            <label class="label" v-if="form.errors.selling_price">
                                <span class="label-text-alt text-error">{{ form.errors.selling_price }}</span>
                            </label>
                        </div>
                        <div class="form-control w-full md:col-span-2">
                            <label class="label">
                                <span class="label-text">Keterangan (optional)</span>
                            </label>
                            <input @focus="form.clearErrors('description')" :readonly="form.processing" v-model="form.description" type="text" placeholder="Keterangan (optional)" class="input input-info input-bordered w-full" />
                            <label class="label" v-if="form.errors.description">
                                <span class="label-text-alt text-error">{{ form.errors.description }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="mockup-window border border-base-300 md:col-span-2">
                            <table class="w-full text-left text-base border-t">
                                <tr class="border-b">
                                    <th class="pl-5 py-2 align-top">Tanggal</th>
                                    <td class="pl-5 py-2 align-top">{{ data.date }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="pl-5 py-2 align-top">Petani</th>
                                    <td class="pl-5 py-2 align-top">{{ data.farmer_name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="pl-5 py-2 align-top">Supir</th>
                                    <td class="pl-5 py-2 align-top">{{ data.driver_name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="pl-5 py-2 align-top">Tukang Muat</th>
                                    <td class="pl-5 py-2 align-top">
                                        <ol class="list-decimal ml-5">
                                            <li v-for="(item, index) in form.loaders"
                                                :key="index">{{ item.text }}</li>

                                        </ol>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="pl-5 py-2 align-top max-w-xs">Timbangan Kebun</th>
                                    <td class="pl-5 py-2 align-top">{{ data.gross }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="pl-5 py-2 align-top">Timbangan Pabrik</th>
                                    <td class="pl-5 py-2 align-top">{{ data.net }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="pl-5 py-2 align-top">Selisih Timbangan</th>
                                    <td class="pl-5 py-2 align-top">{{ data.deviation }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-actions justify-end p-8">
                    <button :disabled="form.processing" @click.prevent="modal_save=true" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </section>
</template>

<script setup>

import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"
import BaseIcon from "@/Components/BaseIcon.vue"

import { mdiArrowRight, mdiArrowLeft} from "@mdi/js";
import VueNumberFormat from 'vue-number-format'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import _ from "lodash";
import {reactive, watch, ref} from "vue";

const breadcrumbs = [
    {
        "url": route('transaction.index'),
        "label": "Transaksi"
    },
    {
        "url": null,
        "label": "Transaksi Jual Beli Sawit"
    }
]

const modal_loader = ref(false)
const modal_save = ref(false)

const props = defineProps({
    farmers: Array,
    drivers: Array,
    loaders: Array,
})
const data = reactive({
    date: '',
    gross:'',
    net: '',
    farmer_name: '',
    driver_name: '',
    deviation: '',
    loaders: props.loaders,
})
const form = useForm({
    date: null,
    farmer_id: 0,
    buying_price: null,
    gross_weight: null,
    selling_price: null,
    net_weight: null,
    description: null,

    driver_id: 0,
    loaders: [],
})

watch(() => _.cloneDeep(form), (current, old) => {
    data.date = current.date
    if(current.farmer_id){
        data.farmer_name = props.farmers.filter(farmer => farmer.id === current.farmer_id)[0].text
    }
    if(current.buying_price && current.net_weight){

        data.gross = Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(current.net_weight) + ' x ' + Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(current.buying_price) + ' = ' + Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(current.buying_price * current.net_weight)
    }
    if(current.selling_price && current.net_weight){
        data.net = Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(current.net_weight) + ' x ' + Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(current.selling_price) + ' = ' + Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(current.selling_price * current.net_weight)
    }
    if(data.gross && data.net){
        data.deviation = Intl.NumberFormat('id-ID', { style: 'unit', unit: 'kilogram'}).format(current.net_weight - current.gross_weight )
    }
    if(current.driver_id){
        data.driver_name = props.drivers.filter(driver => driver.id === current.driver_id)[0].text
    }
    if(current.loaders.length > 0){

    }

})

const addLoader = function (index){
    form.loaders.push({id: data.loaders[index].id, text: data.loaders[index].text})
    data.loaders.splice(index, 1)
}
const removeLoader = function (index){
    data.loaders.push({id: form.loaders[index].id, text: form.loaders[index].text})
    form.loaders.splice(index, 1)
}

const save = () => {
    form.post(route('transaction.trade.store'), {
        onFinish: () => {
            modal_save.value = false
        },
        onSuccess: () => {
            set_default_form()
        },
    });
}

const set_default_form = () => {

    form.clearErrors();
    form.defaults({
        date: '',
        farmer_id: 0,
        buying_price: 0,
        gross_weight: 0,
        selling_price: 0,
        net_weight: 0,
        description: '',

        driver_id: 0,
        loaders: [],
    })

    form.reset()

    data.loaders = props.loaders
    data.gross = null
    data.net = null
    data.farmer_name = null
    data.driver_name = null
    data.deviation = null

}
</script>
