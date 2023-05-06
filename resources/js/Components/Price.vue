<template>
    <span> {{ formattedPrice }}</span>
</template>

<script setup>
import {computed} from 'vue';

    const props = defineProps({
        price: [Number, String]
    })
const formattedPrice = computed(
    () => Number(props.price).toLocaleString( 'en-US',{ // This is a built-in function in JavaScript that allows you to convert a number to a string representation based on the language and formatting preferences of the user's locale.
            style: 'currency',
            currency: 'USD',
            maximumFractionDigits: 0
        }
    )
)
</script>

<style scoped>

</style>
