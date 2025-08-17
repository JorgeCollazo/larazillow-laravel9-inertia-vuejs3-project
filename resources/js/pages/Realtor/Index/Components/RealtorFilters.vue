<template>
    <form action="">
        <div class="mb-4 mt-4 flex flex-wrap gap-4">
          <div class="flex flex-nowrap items-center gap-2">
              <input v-model="filterForm.deleted" type="checkbox" id="deleted" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
              <label for="deleted">Deleted</label>
          </div>
          <div>
              <select v-model="filterForm.by" class="input-filter-l w-24">
                  <option value="created_at">Added</option>
                  <option value="price">Price</option>
              </select>
              <select v-model="filterForm.order" class="input-filter-r w-32">
                  <option v-for="option in sortOptions" :key="option.value" :value="option.value">
                      {{ option.label }}
                  </option>
              </select>
          </div>
        </div>
    </form>
</template>

<script setup>
    import { reactive, watch, computed } from 'vue';
    import { router } from '@inertiajs/vue3';
    import { debounce } from 'lodash';

    const props = defineProps({
        filters: Object
    })

    const sortLabels = {
        created_at: [
            { value: 'desc', label: 'Latest'},
            { value: 'asc', label: 'Oldest' }
        ],
        price: [
            { value: 'desc', label: 'Pricey' },
            { value: 'asc', label: 'Cheapest' }
        ]
    }

    const filterForm = reactive({
        deleted: props.filters.deleted ?? false,
        by: props.filters.by ?? 'created_at',
        order: props.filters.order ?? 'desc'
    });

    const sortOptions = computed( () => sortLabels[filterForm.by])

    // reactive / ref / computed. This is a getter: () => filterForm.deleted. if you happen to have several you can wrap them in an array

    const debouncedFilter = debounce((newValue) => {
        router.get(
            route('realtor.realton-listing.Index'),      // Ensure lowercase 'index'
            filterForm,//{ deleted: newValue },                  // Explicitly send the value
            {
                preserveState: true,
                preserveScroll: true
            }
        );
    }, 300);    // Debounce time in milliseconds

    watch(
        // () => filterForm.deleted, (value, oldValue) => console.log(value, oldValue)
        // The debounce function was used to avoid sending too many requests to the server when the user is typing or changing the filter. Because it now will only send requests when the clicking time is above 1000 milliseconds (1 second).
        // () => filterForm.deleted, // Watch an specific value
        () => ({ ...filterForm }), // Create a new object to trigger the watch
        () => {
            debouncedFilter();
        },
        // { deep: true }
    )

    // Reset order when by changes to ensure valid combinations
    // watch(
    //     () => filterForm.by,
    //     () => {
    //         filterForm.order = 'desc';
    //     }
    // );

</script>

<style scoped>

</style>
