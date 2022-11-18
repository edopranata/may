<template>
    <Head title="Pendapatan Per Trip" />

    <Breadcrumb :links="breadcrumbs"/>
    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <div class="grid md:grid-cols-4">
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Tanggal Awal</span>
                        </label>
                        <input :disabled="form.processing" v-model="form.start_date" type="date" placeholder="Tanggal Awal" class="input input-info input-bordered" />

                        <label class="label" v-if="form.errors.start_date">
                            <span class="label-text-alt text-error">{{ form.errors.start_date }}</span>
                        </label>
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Tanggal Akhir</span>
                        </label>
                        <input :disabled="form.processing" v-model="form.end_date" type="date" placeholder="Tanggal Akhir" class="input input-info input-bordered" />

                        <label class="label" v-if="form.errors.end_date">
                            <span class="label-text-alt text-error">{{ form.errors.end_date }}</span>
                        </label>
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">&nbsp;</span>
                        </label>
                        <div class="flex space-x-4">
                            <button type="button" class="btn" @click="form.post(route('report.trade.index'), { onSuccess: () => {getTotal()}})">Filter </button>
<!--                            <Link :disabled="props.expenses.length < 1" as="button" class="btn" :href="route('print.expense.index')" :data="{ month: form.month, year: form.year }"><BaseIcon :path="mdiPrinter"/> Print </Link>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden badge-primary badge-secondary badge badge-accent badge-ghost badge-info badge-error"></div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl" v-if="props.trades">
            <div class="card-body grid gap-4">
                <table class="w-full text-left text-base text-xs">
                    <thead class="uppercase bg-primary/20">
                    <tr>
                        <th class="py-2 px-2">#</th>
                        <th class="py-2 px-2">Tanggal</th>
                        <th class="py-2 px-2">Mobil</th>
                        <th class="py-2 px-2">Supir</th>
                        <th class="py-2 px-2 text-right">Uang Jalan</th>
                        <th class="py-2 px-2 text-right">Beli Sawit</th>
                        <th class="py-2 px-2 text-right">Amprah Mobil</th>
                        <th class="py-2 px-2 text-right">Upah Supir</th>
                        <th class="py-2 px-2 text-right">Upah Muat</th>
                        <th class="py-2 px-2 text-right">Jual Sawit</th>
                        <th class="py-2 px-2 text-right">Laba / Rugi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="hover:cursor-pointer group border-b" v-if="props.trades" v-for="(item, index) in props.trades">
                        <th class="group-hover:bg-base-300 py-2 px-2">{{ index + 1 }}</th>
                        <td class="group-hover:bg-base-300 py-2 px-2">{{ item.trade_date }}</td>
                        <td class="group-hover:bg-base-300 py-2 px-2">
                            <div>
                                <div class="font-bold">{{ item.car.no_pol }}</div>
                                <div class="text-sm opacity-50">{{item.car.name.toUpperCase() }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-2 px-2">
                            <div>
                                <div class="font-bold">{{ item.driver.name.toUpperCase() }}</div>
                                <div class="text-sm opacity-50">{{item.driver.phone }}</div>
                            </div>
                        </td>
                        <td class="group-hover:bg-base-300 py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.trade_cost)}}</td>
                        <td class="group-hover:bg-base-300 py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.details_sum_total)}}</td>
                        <td class="group-hover:bg-base-300 py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format((item.car_fee * item.net_weight))}}</td>
                        <td class="group-hover:bg-base-300 py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format((item.driver_fee * item.net_weight))}}</td>
                        <td class="group-hover:bg-base-300 py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format((item.loader_fee * item.net_weight))}}</td>
                        <td class="group-hover:bg-base-300 py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.net_total)}}</td>
                        <td class="group-hover:bg-base-300 py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(get_net_income(item))}}</td>
                    </tr>

                    </tbody>
                    <tfoot class="bg-primary/20" v-if="props.trades">
                    <tr>
                        <th class="py-2 px-2 text-right" colspan="4">Total</th>
                        <th class="py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(subtotal.trade_cost) }}</th>
                        <th class="py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(subtotal.gross_total) }}</th>
                        <th class="py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(subtotal.car_fee) }}</th>
                        <th class="py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(subtotal.driver_fee) }}</th>
                        <th class="py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(subtotal.loader_fee) }}</th>
                        <th class="py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(subtotal.net_total) }}</th>
                        <th class="py-2 px-2 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(subtotal.net_income) }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"

import {Head, useForm} from '@inertiajs/inertia-vue3'
import {onMounted, reactive} from "vue";

const breadcrumbs = [
    {
        "url": route('report.index'),
        "label": "Laporan"
    },
    {
        "url": null,
        "label": "Pendapatan Per Trip"
    }
]

const form = useForm({
    start_date: props.start_date,
    end_date: props.end_date,
})

const props = defineProps({
    trades: Array,
    start_date: String,
    end_date: String,
})

const balance = reactive({
    trade_cost: [],
    gross_total: [],
    car_fee: [],
    driver_fee: [],
    loader_fee: [],
    net_total: [],
    net_income: [],
})

const subtotal = reactive({
    trade_cost: 0,
    gross_total: 0,
    car_fee: 0,
    driver_fee: 0,
    loader_fee: 0,
    net_total: 0,
    net_income: 0,
})
onMounted( () =>{
    getTotal()
})

const getTotal = () => {
    reset_total()
    if(props.trades){
        props.trades.reduce((arr, trade) => {
            let cost = trade.trade_cost + trade.details_sum_total + (trade.car_fee * trade.net_weight) + (trade.driver_fee * trade.net_weight) + (trade.loader_fee * trade.net_weight)

            balance.trade_cost.push(trade.trade_cost)
            balance.gross_total.push(trade.gross_total)
            balance.car_fee.push(trade.car_fee * trade.net_weight)
            balance.driver_fee.push(trade.driver_fee * trade.net_weight)
            balance.loader_fee.push(trade.loader_fee * trade.net_weight)
            balance.net_total.push(trade.net_total)
            balance.net_income.push(trade.net_total - cost)
        }, []);

        subtotal.trade_cost = balance.trade_cost.reduce((arr, n) => {
            return arr +=n
        }, 0)
        subtotal.gross_total = balance.gross_total.reduce((arr, n) => {
            return arr +=n
        }, 0)
        subtotal.car_fee = balance.car_fee.reduce((arr, n) => {
            return arr +=n
        }, 0)
        subtotal.driver_fee = balance.driver_fee.reduce((arr, n) => {
            return arr +=n
        }, 0)
        subtotal.loader_fee = balance.loader_fee.reduce((arr, n) => {
            return arr +=n
        }, 0)
        subtotal.net_total = balance.net_total.reduce((arr, n) => {
            return arr +=n
        }, 0)
        subtotal.net_income = balance.net_income.reduce((arr, n) => {
            return arr +=n
        }, 0)
    }
}

const reset_total = () => {
    balance.trade_cost = []
    balance.gross_total = []
    balance.car_fee = []
    balance.driver_fee = []
    balance.loader_fee = []
    balance.net_total = []
    balance.net_income = []

    subtotal.trade_cost = 0
    subtotal.gross_total = 0
    subtotal.car_fee = 0
    subtotal.driver_fee = 0
    subtotal.loader_fee = 0
    subtotal.net_total = 0
    subtotal.net_income = 0
}

const get_net_income = (item) => {
    let cost = item.trade_cost + item.details_sum_total + (item.car_fee * item.net_weight) + (item.driver_fee * item.net_weight) + (item.loader_fee * item.net_weight)
    return item.net_total - cost

}
</script>
