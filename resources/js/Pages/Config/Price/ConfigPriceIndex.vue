<template>
    <Head title="Pengaturan" />

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Harga dan Biaya default </PageTitle>

    <input type="checkbox" id="modal-car" v-model="car_modal" class="modal-toggle" />
    <label for="modal-car" class="modal cursor-pointer">

        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Biaya mobil (Rp / Kg)</h3>
            <form @submit.prevent="updateCar">
                <div class="grid gap-4">
                    <div class="form-control w-full my-4">
                        <label class="label">Biaya Mobil</label>
                        <input :readonly="form_car.processing" v-model="form_car.value" type="number" placeholder="Biaya mobil (Rp / Kg)" class="input input-bordered w-full" />
                        <label class="label" v-if="form_car.errors.value">
                            <span class="label-text-alt text-error">{{ form_car.errors.value }}</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-between">
                    <button :disabled="form_car.processing" type="submit" class="btn btn-primary" :class="form_car.processing ? 'loading' : ''">Save</button>
                </div>
            </form>

        </label>
    </label>

    <input type="checkbox" id="modal-driver" v-model="driver_modal" class="modal-toggle" />
    <label for="modal-driver" class="modal cursor-pointer">

        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Upah Supir (Rp / Kg)</h3>
            <form @submit.prevent="updateDriver">
                <div class="grid gap-4">
                    <div class="form-control w-full my-4">
                        <label class="label">Upah Supir</label>
                        <input :readonly="form_driver.processing" v-model="form_driver.value" type="number" placeholder="Upah Supir (Rp / Kg)" class="input input-bordered w-full" />
                        <label class="label" v-if="form_driver.errors.value">
                            <span class="label-text-alt text-error">{{ form_driver.errors.value }}</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-between">
                    <button :disabled="form_driver.processing" type="submit" class="btn btn-primary" :class="form_driver.processing ? 'loading' : ''">Save</button>
                </div>
            </form>

        </label>
    </label>

    <input type="checkbox" id="modal-loader" v-model="loader_modal" class="modal-toggle" />
    <label for="modal-loader" class="modal cursor-pointer">

        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Upah Tukang Muat (Rp / Kg)</h3>
            <form @submit.prevent="updateLoader">
                <div class="grid gap-4">
                    <div class="form-control w-full my-4">
                        <label class="label">Upah Tukang Muat</label>
                        <input :readonly="form_loader.processing" v-model="form_loader.value" type="number" placeholder="Upah Tukang Muat (Rp / Kg)" class="input input-bordered w-full" />
                        <label class="label" v-if="form_loader.errors.value">
                            <span class="label-text-alt text-error">{{ form_loader.errors.value }}</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-between">
                    <button :disabled="form_loader.processing" type="submit" class="btn btn-primary" :class="form_loader.processing ? 'loading' : ''">Save</button>
                </div>
            </form>

        </label>
    </label>

    <section class="px-4 grid xl:grid-cols-4 md:grid-cols-3 gap-4">

        <div class="stats shadow">
            <div class="stat flex justify-between">
                <div>
                    <div class="stat-title">Biaya Mobil</div>
                    <div class="stat-value">Rp. {{ props.car }}</div>
                    <div class="stat-desc">Biaya / Kg</div>
                </div>
                <button class="btn btn-sm" @click="car_modal = true">Edit</button>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat flex justify-between">
                <div>
                    <div class="stat-title">Upah Supir</div>
                    <div class="stat-value">Rp. {{ props.driver }}</div>
                    <div class="stat-desc">Upah / Kg</div>
                </div>
                <button class="btn btn-sm" @click="driver_modal = true">Edit</button>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat flex justify-between">
                <div>
                    <div class="stat-title">Upah Tukang Muat</div>
                    <div class="stat-value">Rp. {{ props.loader }}</div>
                    <div class="stat-desc">Upah / Kg</div>
                </div>
                <button class="btn btn-sm" @click="loader_modal = true">Edit</button>
            </div>
        </div>
    </section>

</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue"
import PageTitle from "@/Components/PageTitle.vue"

import {Head, useForm} from "@inertiajs/inertia-vue3"
import {ref} from "vue";

const breadcrumbs = [
    {
        "url": route('config.index'),
        "label": "Pengaturan"
    },{
        "url": null,
        "label": "Default Biaya"
    }
]

const driver_modal = ref(false)
const loader_modal = ref(false)
const car_modal = ref(false)

const props = defineProps({
    driver: Number,
    loader: Number,
    car: Number,
})

const form_driver = useForm({
    name: 'driver',
    value: props.driver ? props.driver : 0,
})

const form_loader = useForm({
    name: 'loader',
    value: props.loader ? props.loader : 0,
})

const form_car = useForm({
    name: 'car',
    value: props.car ? props.car : 0,
})

const updateCar = () => {
    form_car.post(route('config.price.store'), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const updateDriver = () => {
    form_driver.post(route('config.price.store'), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const updateLoader = () => {
    form_loader.post(route('config.price.store'), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const set_default_form = () => {
    form_driver.clearErrors();
    form_loader.clearErrors();
    form_car.clearErrors();

    driver_modal.value = false
    loader_modal.value = false
    car_modal.value = false
}

</script>
