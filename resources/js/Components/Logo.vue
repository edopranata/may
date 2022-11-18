<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <img class="h-16" :src="route('index') + '/logo.png'">
    <div class="flex flex-col justify-items-center">
        <div class="text-4xl font-bold underline">MAY-MAY</div>
        <div class="text-xs font-bold">HP: 0813-6500-1163</div>
        <div class="text-xs font-bold hidden">HP: 0813-6500-1163</div>
    </div>
</template>
