<template>
<!--    <MainLayout>--> <!-- Local Component Registration -->
    <h1>Index</h1>
    <Link href="/hello">Show Page</Link>
    <div>
        The message is {{ message }}
    </div>
<!--    </MainLayout>-->
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
// import MainLayout from "../../Layouts/MainLayout.vue";       // To use Persistent Layouts
// defineProps(['message'])             // Because we are using Composition API, You should define them using camelCase and variables that are being passed, Props are readonly
defineProps({
    message: String
})
// defineProps(
//     {
//         propA: String,                  // See documentation for further details (It is a good practice to provide as much information as you can, you'd see in the console when something goes wrong)
//         propB: [String, Number],
//         propC: {
//             required: true,
//             type: String
//         },
//     }
// )
</script>

<!--<script>         // To use Persistent layouts with composition API-->  <!--Can be removed after using Default Layout (app.js)-->
<!--import MainLayout from "../../Layouts/MainLayout.vue";-->

<!--export default {-->
<!--    layout: MainLayout      // This way Inertia will wrap your component with this layout-->
<!--}-->
<!--</script>-->


<style scoped>

</style>
