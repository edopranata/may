<script setup>
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import InputError from '@/Components/InputError.vue';
import Label from '@/Components/Label.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="hero min-h-screen max-w-5xl">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <div class="text-center lg:text-left">
                <h1 class="text-5xl font-bold">Login now!</h1>
                <p class="py-6">To access dashboard, please login to your account</p>
                <div class="flex" v-if="route().has('register')">
                    <Link :href="route('register')" class="btn btn-block btn-info">Register new account</Link>
                </div>
            </div>
            <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
                <form @submit.prevent="submit">
                    <div class="card-body">

                        <div class="form-control">
                            <Label for="email" value="Email" />
                            <Input v-model="form.email" autofocus id="email" type="text" placeholder="email" class="input-bordered" />
                            <InputError class="mt-1" :message="form.errors.email" />
                        </div>
                        <div class="form-control">
                            <Label for="password" value="password" />
                            <Input v-model="form.password" type="password" id="password" placeholder="password" class="input-bordered"/>
                            <InputError class="mt-1" :message="form.errors.password" />
                            <div class="block mt-2">
                                <Link v-if="canResetPassword" :href="route('password.request')"  class="label-text-alt link link-hover">Forgot password?</Link>
                            </div>
                        </div>
                        <div class="form-control mt-6">
                            <Button :disabled="form.processing" type="submit" class="btn-primary">Login</Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
