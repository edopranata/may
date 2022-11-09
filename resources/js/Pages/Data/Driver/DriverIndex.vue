<template>
    <Head title="Supir" />

    <input type="checkbox" id="modal-create" v-model="modal_save" class="modal-toggle" />
    <label for="modal-create" class="modal cursor-pointer">

        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Tambah Data Supir</h3>
            <form @submit.prevent="save">

                <div class="grid gap-4">
                    <div class="form-control w-full">
                        <label class="label">Nama Supir</label>
                        <input :readonly="form_save.processing" v-model="form_save.name" type="text" placeholder="Nama Supir" class="input input-bordered w-full" />
                        <label class="label" v-if="form_save.errors.name">
                            <span class="label-text-alt text-error">{{ form_save.errors.name }}</span>
                        </label>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="form-control w-full">
                        <label class="label">Biaya (Gaji / Kg)</label>
                        <input :readonly="form_save.processing" v-model="form_save.price" type="text" placeholder="Biaya (Gaji / Kg)" class="input input-bordered w-full" />
                        <label class="label" v-if="form_save.errors.price">
                            <span class="label-text-alt text-error">{{ form_save.errors.price }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full col-span-2">
                        <label class="label">No Telepon</label>
                        <input :readonly="form_save.processing" v-model="form_save.phone" type="text" placeholder="No Telepon" class="input input-bordered w-full" />
                        <label class="label" v-if="form_save.errors.phone">
                            <span class="label-text-alt text-error">{{ form_save.errors.phone }}</span>
                        </label>
                    </div>
                </div>
                <div class="form-control w-full">
                    <label class="label">Alamat Supir</label>
                    <textarea :readonly="form_save.processing" v-model="form_save.address" type="text" placeholder="Alamat Supir" class="textarea textarea-bordered w-full"></textarea>
                    <label class="label" v-if="form_save.errors.address">
                        <span class="label-text-alt text-error">{{ form_save.errors.address }}</span>
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">Pinjaman Awal <span class="text-xs">Kosongkan bila tidak ada</span> </label>
                    <VueNumberFormat :options="{ precision: 0, prefix: 'Rp ', isInteger: true }" :readonly="form_save.processing" v-model:value="form_save.loan" class="input input-bordered w-full" />
                    <label class="label" v-if="form_save.errors.loan">
                        <span class="labelP-alt text-error">{{ form_save.errors.loan }}</span>
                    </label>
                </div>
                <div class="flex justify-between mt-10">
                    <button :disabled="form_save.processing" type="submit" class="btn btn-primary" :class="form_save.processing ? 'loading' : ''">Save</button>
                </div>
            </form>

        </label>
    </label>

    <input type="checkbox" id="modal-edit" v-model="modal_edit" class="modal-toggle" />
    <label for="modal-edit" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Ubah Data Supir {{ form_edit.name }}</h3>
            <form @submit.prevent="update">
                <div class="grid gap-4">
                    <div class="form-control w-full">
                        <label class="label">Nama Supir</label>
                        <input :readonly="form_edit.processing" v-model="form_edit.name" type="text" placeholder="Nama Supir" class="input input-bordered w-full" />
                        <label class="label" v-if="form_edit.errors.name">
                            <span class="label-text-alt text-error">{{ form_edit.errors.name }}</span>
                        </label>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="form-control w-full">
                        <label class="label">Biaya (Gaji / Kg)</label>
                        <input :readonly="form_edit.processing" v-model="form_edit.price" type="text" placeholder="Biaya (Gaji / Kg)" class="input input-bordered w-full" />
                        <label class="label" v-if="form_edit.errors.price">
                            <span class="label-text-alt text-error">{{ form_edit.errors.price }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full col-span-2">
                        <label class="label">No Telepon</label>
                        <input :readonly="form_edit.processing" v-model="form_edit.phone" type="text" placeholder="No Telepon" class="input input-bordered w-full" />
                        <label class="label" v-if="form_edit.errors.phone">
                            <span class="label-text-alt text-error">{{ form_edit.errors.phone }}</span>
                        </label>
                    </div>
                </div>
                <div class="form-control w-full">
                    <label class="label">Alamat Supir</label>
                    <textarea :readonly="form_edit.processing" v-model="form_edit.address" type="text" placeholder="Alamat Supir" class="textarea textarea-bordered w-full"></textarea>
                    <label class="label" v-if="form_edit.errors.address">
                        <span class="label-text-alt text-error">{{ form_edit.errors.address }}</span>
                    </label>
                </div>
                <div class="flex justify-between mt-10">
                    <button :disabled="form_edit.processing" type="submit" class="btn btn-primary" :class="form_edit.processing ? 'loading' : ''">Save</button>
                    <button :disabled="form_edit.processing" @click.prevent="destroy" type="button" class="btn btn-error" :class="form_edit.processing ? 'loading' : ''">Delete</button>
                </div>
            </form>
        </label>
    </label>

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Data Supir</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <div class="flex justify-between items-center mb-4">
                    <div class="form-control">
                        <input v-model="form_search.search" type="text" placeholder="Search…" class="input input-bordered" />
                    </div>
                    <label @click="set_default_form" for="modal-create" class="btn modal-button">Tambah Supir Baru</label>
                </div>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Nama Supir</th>
                        <th class="py-3 px-6">No Telepon</th>
                        <th class="py-3 px-6">Alamat</th>
                        <th class="py-3 px-6">Gaji / KG</th>
                        <th class="py-3 px-6"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.drivers.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.drivers.data" @click="edit(index)">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.drivers.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.phone }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6" style="word-wrap: break-word"><p class="max-w-xs">{{ item.address }}</p> </td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.price ? item.price.value : 0)  }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                    </tr>
                    <tr v-else>
                        <td colspan="6" class="text-center border-b-2">No Data <Link v-if="props.drivers.current_page > 1" class="link link-primary" :href="route('data.driver.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.drivers.data.length" :links="props.drivers.links" />
            </div>
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import Pagination from "@/Components/Pagination.vue";
import PageTitle from "@/Components/PageTitle.vue";

import VueNumberFormat from "vue-number-format";
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import { mdiArrowRight } from "@mdi/js/commonjs/mdi";
import {ref, watch} from 'vue'
import {debounce} from "lodash";
import {Inertia} from "@inertiajs/inertia";

const breadcrumbs = [
    {
        "url": route('data.index'),
        "label": "Data"
    },{
        "url": null,
        "label": "Supir"
    }
]

const modal_save = ref(false)
const modal_edit = ref(false)
const driver_id = ref(null)

const form_save = useForm({
    name: '',
    loan: 0,
    phone: '',
    price: props.price,
    address: '',
})
const form_edit = useForm({
    name: '',
    phone: '',
    price: props.price,
    address: '',
})
const props = defineProps({
    search: String,
    drivers: {
        type: Object,
    },
    price: {
        type: Number,
        default: 0
    }
})

const form_search = useForm({
    search: props.search
})

watch(
    form_search,
    debounce((value) => {
        Inertia.get(
            route('data.driver.index'),
            { search: value.search },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500)
);

const save = () => {
    form_save.post(route('data.driver.store'), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const edit = (index) => {
    set_default_form()
    let data = props.drivers.data[index]

    driver_id.value = data.id

    form_edit.name = data.name
    form_edit.address = data.address
    form_edit.phone = data.phone
    form_edit.price = data.price ? data.price.value : 0
    modal_edit.value = true

}

const update = () => {
    form_edit.patch(route('data.driver.update', driver_id.value), {
        onSuccess: () => {
            set_default_form()

        },
    });
}

const set_default_form = () => {
    form_edit.clearErrors();
    form_save.clearErrors();
    form_edit.reset()
    form_save.reset()

    form_edit.defaults({
        name:null,
        price:null,
        address:null,
        phone:null,
    })

    form_save.defaults({
        name:null,
        loan: 0,
        price:null,
        address:null,
        phone:null,
    })

    modal_edit.value = false
    modal_save.value = false
}

const destroy = () => {
    form_edit.delete(route('data.driver.destroy', driver_id.value), {
        onSuccess: () => {
            set_default_form()
        },
    });
}
</script>
