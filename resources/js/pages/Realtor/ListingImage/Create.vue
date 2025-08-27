<template>
    <Box v-if="listing.images.length" class="mt-4">
        <template #header>
            Upload New Images
        </template>
        <section class="flex items-center gap-2 my-4">
            <form @submit.prevent="upload">
                <input type="file" multiple @input="addFiles" class="border rounded-md file:px-4 file:py-4 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4">  <!-- name="images[]" no longer needed -->
                <button type="submit" class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed mx-2.5" :disabled="!canUpload">Upload</button>
                <button type="reset" class="btn-outline" @click="reset">Reset</button>
            </form>
        </section>
    </Box>
    <Box>
        <template #header> Current Listing Images </template>
        <section class="mt-4 grid grid-cols-3 gap-4">
            <div v-for="image in listing.images" :key="image.id" class="flex flex-col justify-between">
                <img :src="image.src" class="rounded-md h-full w-full" alt="house"/>
                <Link :href="route('realtor.listing.image.destroy', {listing: props.listing.id, image: image.id})"
                method="delete"
                as="button"
                class="btn-outline mt-2 text-xs">
                    Delete
                </Link>
            </div>
        </section>
    </Box>
</template>

<script setup>
import {computed} from "vue";
import Box from "@/Components/UI/Box.vue";
import {Link, useForm} from "@inertiajs/vue3";
import {Inertia} from "@inertiajs/inertia";
import {NProgress} from "nprogress";

const props = defineProps({
    listing: Object
})

Inertia.on('progress', (event) => {
    if (event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9);
    } else {
        NProgress.done();
    }
});

const form = useForm({
    images: []
})

const canUpload = computed(() => form.images.length)

const upload = () => {
    form.post(route('realtor.listing.image.store', {listing: props.listing.id}), {
        onSuccess: () => {
            alert('Images uploaded successfully!');
            form.reset('images');
        },
        preserveScroll: true,
        preserveState: true
    });
}

const addFiles = (event) => {
    for (const image of event.target.files) {
        form.images.push(image);
    }
}

const reset = () => {
    form.reset('images');
}

</script>

<style scoped>

</style>
