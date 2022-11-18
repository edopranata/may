<template>
    <Head title="Profile" />

    <input type="checkbox" id="modal-edit" v-model="modal_password" class="modal-toggle" />
    <label for="modal-edit" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            <h3 class="font-bold text-lg">Ubah Password</h3>
            <form @submit.prevent="password">
                    <div class="form-control w-full my-4">
                        <input :readonly="form.processing" v-model="form.current_password" type="password" placeholder="Password saat ini" class="input input-bordered w-full" />
                        <label class="label" v-if="form.errors.current_password">
                            <span class="label-text-alt text-error">{{ form.errors.current_password }}</span>
                        </label>
                    </div>
                    <div class="form-control w-full my-4">
                        <input :readonly="form.processing" v-model="form.password" type="password" placeholder="Password Baru" class="input input-bordered w-full" />
                        <label class="label" v-if="form.errors.password">
                            <span class="label-text-alt text-error">{{ form.errors.password }}</span>
                        </label>
                    </div>

                    <div class="form-control w-full my-4 col-span-2">
                        <input :readonly="form.processing" v-model="form.password_confirmation" type="password" placeholder="Ulangi Password Baru" class="input input-bordered w-full" />
                        <label class="label" v-if="form.errors.password_confirmation">
                            <span class="label-text-alt text-error">{{ form.errors.password_confirmation }}</span>
                        </label>
                    </div>
                <div class="flex justify-end">
                    <button @click="password" class="btn btn-info">Ganti Password</button>
                </div>
            </form>

        </label>
    </label>

    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Profile</PageTitle>

    <section class="px-4 grid gap-4 md:grid-cols-2">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Nama Lengkap</span>
                    </label>
                    <input v-model="form.name" type="text" placeholder="Nama Lengkap" class="input input-bordered w-full" />
                    <label class="label" v-if="form.errors.name">
                        <span class="label-text-alt text-error">{{ form.errors.name }}</span>
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input v-model="form.email" type="email" placeholder="Email" class="input input-bordered w-full" />
                    <label class="label" v-if="form.errors.email">
                        <span class="label-text-alt text-error">{{ form.errors.email }}</span>
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input v-model="form.username" type="text" placeholder="Username" class="input input-bordered w-full" />
                    <label class="label" v-if="form.errors.username">
                        <span class="label-text-alt text-error">{{ form.errors.username }}</span>
                    </label>
                </div>

                <div class="card-actions justify-between mt-4">
                    <button @click="save" class="btn btn-primary">Ubah Data</button>
                    <button @click="modal_password=true" type="button" class="btn btn-error">Ganti password</button>

                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import Pagination from "@/Components/Pagination.vue";
import PageTitle from "@/Components/PageTitle.vue";

import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import { mdiArrowRight } from "@mdi/js/commonjs/mdi";
import {ref, watch} from 'vue'
import {debounce} from "lodash";
import {Inertia} from "@inertiajs/inertia";

const breadcrumbs = [{
        "url": null,
        "label": "Profile"
    }
]

const modal_password = ref(false)


const form = useForm({
    name: props.user.name,
    email: props.user.email,
    username: props.user.username,
    current_password: '',
    password: '',
    password_confirmation: ''
})

const props = defineProps({
    user: {
        type: Object,
    },
})


const save = () => {
    form.patch(route('profile.update', props.user.id), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const password = () => {
    form.patch(route('profile.password', props.user.id), {
        onSuccess: () => {
            set_default_form()
        },
    });
}

const set_default_form = () => {
    form.clearErrors();
    form.reset()
    form.defaults({
        name:null,
        email:null,
        username:null,
        current_password:'',
        password: '',
        password_confirmation: ''
    })

    modal_password.value = false
}

</script>
