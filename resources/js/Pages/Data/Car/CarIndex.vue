<template>
    <Head title="Mobil" />

    <input type="checkbox" id="modal-create" v-model="modal_save" class="modal-toggle" />
    <label for="modal-create" class="modal cursor-pointer">

        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Tambah data mobil</h3>
            <form @submit.prevent="save">
                <div class="form-control w-full my-4">
                    <label class="label">Merk Mobil</label>
                    <input :readonly="form_save.processing" v-model="form_save.name" type="text" placeholder="Merk Mobil" class="input input-bordered w-full" />
                    <label class="label" v-if="form_save.errors.name">
                        <span class="label-text-alt text-error">{{ form_save.errors.name }}</span>
                    </label>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="form-control w-full my-4 col-span-2">
                        <label class="label">No Polisi</label>
                        <input :readonly="form_save.processing" v-model="form_save.no_pol" type="text" placeholder="No Polisi" class="input input-bordered w-full" />
                        <label class="label" v-if="form_save.errors.no_pol">
                            <span class="label-text-alt text-error">{{ form_save.errors.no_pol }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full my-4">
                        <label class="label">Tahun</label>
                        <input :readonly="form_save.processing" v-model="form_save.year" type="number" placeholder="Tahun" class="input input-bordered w-full" />
                        <label class="label" v-if="form_save.errors.year">
                            <span class="label-text-alt text-error">{{ form_save.errors.year }}</span>
                        </label>
                    </div>
                </div>
                <div class="form-control w-full my-4">
                    <label class="label">Keterangan</label>
                    <textarea :readonly="form_save.processing" v-model="form_save.description" type="text" placeholder="Keterangan" class="textarea textarea-bordered w-full"></textarea>
                    <label class="label" v-if="form_save.errors.description">
                        <span class="label-text-alt text-error">{{ form_save.errors.description }}</span>
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
            <h3 class="font-bold text-lg">Ubah Data Mobil {{ form_edit.no_pol }}</h3>
            <form @submit.prevent="update">
                <div class="form-control w-full my-4">
                    <label class="label">Merk Mobil</label>
                    <input :readonly="form_edit.processing" v-model="form_edit.name" type="text" placeholder="Merk Mobil" class="input input-bordered w-full" />
                    <label class="label" v-if="form_edit.errors.name">
                        <span class="label-text-alt text-error">{{ form_edit.errors.name }}</span>
                    </label>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="form-control w-full my-4 col-span-2">
                        <label class="label">No Polisi</label>
                        <input :readonly="form_edit.processing" v-model="form_edit.no_pol" type="text" placeholder="No Polisi" class="input input-bordered w-full" />
                        <label class="label" v-if="form_edit.errors.no_pol">
                            <span class="label-text-alt text-error">{{ form_edit.errors.no_pol }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full my-4">
                        <label class="label">Tahun </label>
                        <input :readonly="form_edit.processing" v-model="form_edit.year" type="number" placeholder="Tahun" class="input input-bordered w-full" />
                        <label class="label" v-if="form_edit.errors.year">
                            <span class="label-text-alt text-error">{{ form_edit.errors.year }}</span>
                        </label>
                    </div>
                </div>
                <div class="form-control w-full my-4">
                    <label class="label">Keterangan</label>
                    <textarea :readonly="form_edit.processing" v-model="form_edit.description" type="text" placeholder="Keterangan" class="textarea textarea-bordered w-full"></textarea>
                    <label class="label" v-if="form_edit.errors.description">
                        <span class="label-text-alt text-error">{{ form_edit.errors.description }}</span>
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
    <PageTitle :classes="'bg-base-content'" class="">Data Mobil</PageTitle>

    <section class="px-4 grid gap-4">
        <div>
            <div class="flex justify-between items-center mb-4">
                <div class="form-control">
                    <input v-model="form_search.search" type="text" placeholder="Search…" class="input input-bordered" />
                </div>
                <label @click="set_default_form" for="modal-create" class="btn modal-button">Tambah Mobil Baru</label>
            </div>
            <table class="w-full text-left text-base">
                <thead class="text-sm uppercase bg-primary/20">
                <tr>
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 px-6">Merk Mobil</th>
                    <th class="py-3 px-6">Keterangan</th>
                    <th class="py-3 px-6">No Polisi</th>
                    <th class="py-3 px-6">Tahun</th>
                    <th class="py-3 px-6"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="props.cars.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.cars.data" @click="edit(index)">
                    <th class="group-hover:bg-base-300 py-4 px-6">{{ props.cars.from + index  }}</th>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6 max-w-xs">{{ item.description }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6 ">{{ item.no_pol }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6">{{ item.year }}</td>
                    <td class="group-hover:bg-base-300 py-4 px-6"><BaseIcon :path="mdiArrowRight" /></td>
                </tr>
                <tr v-else>
                    <td colspan="5" class="text-center border-b-2">No Data</td>
                </tr>
                </tbody>
            </table>
            <Pagination v-if="props.cars.data.length" :links="props.cars.links" />

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
import {ref, watch} from 'vue'
import {debounce} from "lodash";
import {Inertia} from "@inertiajs/inertia";

const breadcrumbs = [
    {
        "url": route('data.index'),
        "label": "Data"
    },{
        "url": null,
        "label": "Mobil"
    }
]

const modal_save = ref(false)
const modal_edit = ref(false)
const car_id = ref(null)

const form_save = useForm({
    name: '',
    no_pol: '',
    description: '',
    year: ''
})
const form_edit = useForm({
    name: '',
    no_pol: '',
    description: '',
    year: ''
})
const props = defineProps({
    search: String,
    cars: {
        type: Object,
    },
})

const form_search = useForm({
    search: props.search
})

watch(
    form_search,
    debounce((value) => {
        Inertia.get(
            route('data.car.index'),
            { search: value.search },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500)
);

const save = () => {
    form_save.post(route('data.car.store'), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const edit = (index) => {
    set_default_form()
    let data = props.cars.data[index]
    car_id.value = data.id

    form_edit.name = data.name
    form_edit.description = data.description
    form_edit.no_pol = data.no_pol
    form_edit.year = data.year
    modal_edit.value = true

}

const update = () => {
    form_edit.patch(route('data.car.update', car_id.value), {
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
        description:null,
        no_pol:null,
        year:null,
    })

    form_save.defaults({
        name:null,
        description:null,
        no_pol:null,
        year:null,
    })

    modal_edit.value = false
    modal_save.value = false
}

const destroy = () => {
    form_edit.delete(route('data.car.destroy', car_id.value), {
        onSuccess: () => {
            set_default_form()
        },
    });
}
</script>
