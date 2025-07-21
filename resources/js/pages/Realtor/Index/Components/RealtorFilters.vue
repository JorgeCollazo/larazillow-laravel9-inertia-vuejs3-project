<template>
    <form action="">
        <div class="mb-4 mt-4 flex flex-wrap gap-2">
              <div class="flex flex-nowrap items-center gap-2">
                  <input v-model="filterForm.deleted" type="checkbox" id="deleted" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
                  <label for="deleted"></label>
              </div>
        </div>
    </form>
</template>

<script setup>
    import { reactive, watch } from 'vue';
    import { Inertia } from '@inertiajs/inertia';

    const filterForm = reactive({
        deleted: false,
    });

    // reactive / ref / computed. This is a getter: () => filterForm.deleted,. if you happen to have several you can wrap them in an array

    watch(
        // () => filterForm.deleted, (value, oldValue) => console.log(value, oldValue)
        filterForm, () => Inertia.get(
            route('realtor.realton-listing.Index'),
            filterForm,
            {
                preserveState: true,
                preserveScroll: true
            }
        )
    )

</script>

<style scoped>

</style>
