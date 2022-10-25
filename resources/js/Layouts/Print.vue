<script setup>

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
    <slot/>
</template>
