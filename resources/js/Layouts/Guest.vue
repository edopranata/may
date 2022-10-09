<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <div class="navbar bg-base-100">
            <div class="flex-1">
                <Link :href="route('index')" class="btn btn-ghost normal-case text-xl">Home</Link>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal p-0">
                    <li v-if="$page.props.auth.user" ><Link :href="route('dashboard.index')">Dashboard</Link></li>
                    <template v-else>
                        <li><Link :href="route('login')">Login</Link></li>
                        <li><Link :href="route('register')">Register</Link></li>
                    </template>
                </ul>
            </div>
        </div>
        <div class="min-h-screen flex justify-center">
            <slot/>
        </div>
        <footer class="footer p-10 bg-neutral text-neutral-content">
            <div>
                <span class="footer-title">Services</span>
                <a class="link link-hover">Branding</a>
                <a class="link link-hover">Design</a>
                <a class="link link-hover">Marketing</a>
                <a class="link link-hover">Advertisement</a>
            </div>
            <div>
                <span class="footer-title">Company</span>
                <a class="link link-hover">About us</a>
                <a class="link link-hover">Contact</a>
                <a class="link link-hover">Jobs</a>
                <a class="link link-hover">Press kit</a>
            </div>
            <div>
                <span class="footer-title">Legal</span>
                <a class="link link-hover">Terms of use</a>
                <a class="link link-hover">Privacy policy</a>
                <a class="link link-hover">Cookie policy</a>
            </div>
            <div>
                <span class="footer-title">Legal</span>
                <a class="link link-hover">Terms of use</a>
                <a class="link link-hover">Privacy policy</a>
                <a class="link link-hover">Cookie policy</a>
            </div>
            <div>
                <span class="footer-title">Legal</span>
                <a class="link link-hover">Terms of use</a>
                <a class="link link-hover">Privacy policy</a>
                <a class="link link-hover">Cookie policy</a>
            </div>
        </footer>
    </div>
</template>
