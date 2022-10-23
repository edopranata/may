<template>
    <div class="m-4 flex justify-between items-center space-x-2 print:hidden">
        <h1 class="flex-none text-2xl font-bold uppercase text-base"><slot /></h1>
        <div class="flex-1 max-w-full">
            <div class="h-2" :class="classes"></div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    classes:{
        type: String,
        default: 'bg-secondary/75'
    }
})
</script>

