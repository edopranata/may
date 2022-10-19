<template>
    <Head title="Tukang Muat" />

    <input type="checkbox" id="modal-create" v-model="modal_save" class="modal-toggle" />
    <label for="modal-create" class="modal cursor-pointer">

        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Tambah data petani</h3>
            <form @submit.prevent="save">
                <div class="form-control w-full my-4 col-span-2">
                    <label class="label">Nama Tukang Muat</label>
                    <input :readonly="form_save.processing" v-model="form_save.name" type="text" placeholder="Nama Tukang Muat" class="input input-bordered w-full" />
                    <label class="label" v-if="form_save.errors.name">
                        <span class="label-text-alt text-error">{{ form_save.errors.name }}</span>
                    </label>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-control w-full my-4">
                        <label class="label">Biaya / Kg</label>
                        <input :readonly="form_save.processing" v-model="form_save.price" type="text" placeholder="Biaya / Kg" class="input input-bordered w-full" />
                        <label class="label" v-if="form_save.errors.price">
                            <span class="label-text-alt text-error">{{ form_save.errors.price }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full my-4">
                        <label class="label">No Telepon</label>
                        <input :readonly="form_save.processing" v-model="form_save.phone" type="text" placeholder="No Telepon" class="input input-bordered w-full" />
                        <label class="label" v-if="form_save.errors.phone">
                            <span class="label-text-alt text-error">{{ form_save.errors.phone }}</span>
                        </label>
                    </div>

                </div>
                <div class="form-control w-full my-4">
                    <label class="label">Alamat</label>
                    <textarea :readonly="form_save.processing" v-model="form_save.address" type="text" placeholder="Alamat" class="textarea textarea-bordered w-full"></textarea>
                    <label class="label" v-if="form_save.errors.address">
                        <span class="label-text-alt text-error">{{ form_save.errors.address }}</span>
                    </label>
                </div>
                <div class="flex justify-between">
                    <button :disabled="form_save.processing" type="submit" class="btn btn-primary" :class="form_save.processing ? 'loading' : ''">Save</button>
                </div>
            </form>

        </label>
    </label>

    <input type="checkbox" id="modal-edit" v-model="modal_edit" class="modal-toggle" />
    <label for="modal-edit" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Ubah Data Tukang Muat {{ form_edit.name }}</h3>
            <form @submit.prevent="update">
                <div class="form-control w-full my-4">
                    <label class="label">Nama Tukang Muat</label>
                    <input :readonly="form_edit.processing" v-model="form_edit.name" type="text" placeholder="Nama Tukang Muat" class="input input-bordered w-full" />
                    <label class="label" v-if="form_edit.errors.name">
                        <span class="label-text-alt text-error">{{ form_edit.errors.name }}</span>
                    </label>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-control w-full my-4">
                        <label class="label">Biaya / Kg</label>
                        <input :readonly="form_edit.processing" v-model="form_edit.price" type="text" placeholder="Biaya / Kg" class="input input-bordered w-full" />
                        <label class="label" v-if="form_edit.errors.price">
                            <span class="label-text-alt text-error">{{ form_edit.errors.price }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full my-4">
                        <label class="label">No Telepon</label>
                        <input :readonly="form_edit.processing" v-model="form_edit.phone" type="text" placeholder="No Telepon" class="input input-bordered w-full" />
                        <label class="label" v-if="form_edit.errors.phone">
                            <span class="label-text-alt text-error">{{ form_edit.errors.phone }}</span>
                        </label>
                    </div>
                </div>
                <div class="form-control w-full my-4">
                    <label class="label">Alamat</label>
                    <textarea :readonly="form_edit.processing" v-model="form_edit.address" type="text" placeholder="Alamat" class="textarea textarea-bordered w-full"></textarea>
                    <label class="label" v-if="form_edit.errors.address">
                        <span class="label-text-alt text-error">{{ form_edit.errors.address }}</span>
                    </label>
                </div>
                <div class="flex justify-between">
                    <button :disabled="form_edit.processing" type="submit" class="btn btn-primary" :class="form_edit.processing ? 'loading' : ''">Save</button>
                    <button :disabled="form_edit.processing" @click.prevent="destroy" type="button" class="btn btn-error" :class="form_edit.processing ? 'loading' : ''">Delete</button>
                </div>
            </form>

        </label>
    </label>

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Data Tukang Muat</PageTitle>

    <section class="px-4 grid gap-4">
        <div>
            <div class="flex justify-end items-center mb-4">
                <label @click="set_default_form" for="modal-create" class="btn modal-button">Tambah Tukang Muat Baru</label>
            </div>
            <table class="w-full text-left text-base">
                <thead class="text-sm uppercase bg-primary/20">
                <tr>
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 px-6">Nama Tukang Muat</th>
                    <th class="py-3 px-6">No Telepon</th>
                    <th class="py-3 px-6">Alamat</th>
                    <th class="py-3 px-6">Gaji / KG</th>
                    <th class="py-3 px-6"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="props.loaders.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.loaders.data" @click="edit(item.id)">
                    <th class="group-hover:bg-base-300 py-4 px-6">{{ props.loaders.from + index  }}</th>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ item.phone }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6" style="word-wrap: break-word"><p class="max-w-xs">{{ item.address }}</p> </td>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ item.price ? item.price.value : 0 }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                </tr>
                <tr v-else>
                    <td colspan="5" class="text-center border-b-2">No Data</td>
                </tr>
                </tbody>
            </table>
            <Pagination v-if="props.loaders.data.length" :links="props.loaders.links" />

        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import Pagination from "@/Components/Pagination.vue";
import PageTitle from "@/Components/PageTitle.vue";

import { Head, useForm } from '@inertiajs/inertia-vue3';
import { mdiArrowRight } from "@mdi/js/commonjs/mdi";
import { ref } from 'vue'

const breadcrumbs = [
    {
        "url": route('data.index'),
        "label": "Data"
    },{
        "url": null,
        "label": "Tukang Muat"
    }
]

const modal_save = ref(false)
const modal_edit = ref(false)
const loader_id = ref(null)

const form_save = useForm({
    name: '',
    price: props.price,
    phone: '',
    address: '',
})
const form_edit = useForm({
    name: '',
    price: props.price,
    phone: '',
    address: '',
})
const props = defineProps({
    loaders: {
        type: Object,
    },
    price: {
        type: Number,
        default: 0
    }
})

const save = () => {
    form_save.post(route('data.loader.store'), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const edit = (id) => {
    set_default_form()
    loader_id.value = id
    axios.get(route('data.loader.edit', id))
        .then( (res) => res.data)
        .then( (data) => {
            form_edit.name = data.name
            form_edit.address = data.address
            form_edit.phone = data.phone
            form_edit.price = data.price ? data.price.value : 0
            modal_edit.value = true
        })
}

const update = () => {
    form_edit.patch(route('data.loader.update', loader_id.value), {
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
        price:null,
        address:null,
        phone:null,
    })

    modal_edit.value = false
    modal_save.value = false
}

const destroy = () => {
    form_edit.delete(route('data.loader.destroy', loader_id.value), {
        onSuccess: () => {
            set_default_form()
        },
    });
}
</script>
