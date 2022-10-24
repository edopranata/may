<template>
    <div class="drawer-side pt-0 print:hidden">
        <label for="my-drawer-2" class="drawer-overlay"></label>
        <ul class="menu overflow-y-auto w-80 text-base-content bg-base-200 print:hidden">
            <li class="bg-primary/75 text-base-100 hover:bg-primary/100 transition-all">
                <div class="navbar h-20 border-primary border-b-2">
                    <a class="normal-case text-xl">RiauCoder's</a>
                </div>
            </li>
            <!-- Sidebar content here -->
            <li>
                <Link :class="routePath.current.startsWith('/dashboard') ? 'border-l-4 border-primary bg-base-400' : 'pl-5'" :href="route('dashboard.index')">
                    <BaseIcon size="20" :path="mdiHome"/> Dashboard
                </Link>
            </li>
            <li>
                <Link :class="routePath.current.startsWith('/data') ? 'border-l-4 border-primary bg-base-400' : 'pl-5'" :href="route('data.index')">
                    <BaseIcon size="20" :path="mdiBallot"/> Data
                </Link>
            </li>
            <li>
                <Link :class="routePath.current.startsWith('/config') ? 'border-l-4 border-primary bg-base-400' : 'pl-5'" :href="route('config.index')">
                    <BaseIcon size="20" :path="mdiCog"/> Konfigurasi
                </Link>
            </li>
            <li>
                <Link :class="routePath.current.startsWith('/transaction') ? 'border-l-4 border-primary bg-base-400' : 'pl-5'" :href="route('transaction.index')">
                    <BaseIcon size="20" :path="mdiCash"/> Transaksi
                </Link>
            </li>
            <li>
                <Link :class="routePath.current.startsWith('/report') ? 'border-l-4 border-primary bg-base-400' : 'pl-5'" :href="route('report.index')">
                    <BaseIcon size="20" :path="mdiNoteEdit"/> Report
                </Link>
            </li>
        </ul>

    </div>
</template>

<script setup>
import {Link, usePage} from "@inertiajs/inertia-vue3";
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiHome, mdiBallot, mdiCog, mdiCash, mdiNoteEdit } from "@mdi/js";
import {computed, onMounted, reactive, watch} from "vue";

const currentRoute = computed(() => usePage().url.value);
const routePath = reactive({
    current: ''
})
watch(currentRoute, (value, oldValue, onCleanup) => {
    if(value){
        routePath.current = value
    }
})

onMounted( () => {
    routePath.current = usePage().url.value
})
</script>
