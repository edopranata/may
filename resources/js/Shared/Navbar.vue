<template>
    <div class="navbar sticky top-0 z-50 bg-base-200/80 h-20 flex justify-between md:justify-end border-b-2 border-primary print:hidden">
        <div class="flex-1 lg:hidden">
            <label for="my-drawer-2" class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </label>
        </div>

        <div class="flex-none">
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <BaseIcon :size="28" :path="mdiAccount"/>
                </label>
                <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-b-xl w-52 border-t-0 border-primary">
                    <li><Link :href="route('profile.index')" class="justify-between">{{ $page.props.auth.user.name}}</Link></li>
                    <li><Link :href="route('logout')" as="button" method="post">Logout</Link></li>
                </ul>
            </div>
        </div>
    </div>
    <notifications position="top right" class="mt-2" />
</template>

<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import BaseIcon from "@/Components/BaseIcon.vue";
import {mdiAccount} from "@mdi/js";
</script>

