<script setup>
import Navbar from "@/Shared/Navbar.vue";
import Sidebar from "@/Shared/Sidebar.vue";

import {computed, watch} from "vue";
import {notify} from "@kyvg/vue3-notification";
import {usePage} from "@inertiajs/inertia-vue3";

const alert = computed(() => usePage().props.value.flash.alert);
watch(alert, (value, oldValue, onCleanup) => {

    if(value){
        notify({
            duration: 10000,
            title: value.title,
            text: value.message,
            type: value.type
        });
    }
})

</script>

<template>
    <div class="drawer drawer-mobile">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <Navbar />
            <!-- Page content here -->
            <div class="w-full">
                <slot/>
            </div>

        </div>
        <Sidebar/>
    </div>
</template>
