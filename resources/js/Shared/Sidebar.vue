<template>
    <div class="drawer-side pt-0">
        <label for="my-drawer-2" class="drawer-overlay"></label>
        <ul class="menu overflow-y-auto w-80 text-base-content bg-base-200">
            <li class="bg-primary/75 text-base-100 hover:bg-primary/100 transition-all">
                <div class="navbar h-20 border-primary border-b-2">
                    <a class="normal-case text-xl">RiauCoder's</a>
                </div>
            </li>
            <!-- Sidebar content here -->
            <li :class="route().current('dashboard.*') ? 'bordered' : 'pl-1'">
                <Link :href="route('dashboard.index')">
                    <BaseIcon size="20" :path="mdiHome"/> Dashboard
                </Link>
            </li>
            <li :class="route().current('data.*') ? 'bordered' : 'pl-1'">
                <Link :href="route('data.index')">
                    <BaseIcon size="20" :path="mdiBallot"/> Data
                </Link>
            </li>
        </ul>

    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiHome, mdiBallot } from "@mdi/js";
</script>
