<template>
    <!--    <Link href="/listing">Listings</Link> &nbsp;-->
    <!--    <Link href="/listing/create">New Listing</Link>-->

    <!--    <div>The page with time: {{ timer }}</div>-->
    <!--    <div v-if="page.props.value.flash.success" class="success">      instead of this use a computed property like below-->
    <header
        class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div class="text-lg font-medium">
                    <Link :href="route('listing.Index')">Listings</Link>
                </div>
                <div
                    class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center">
                    <Link :href="route('listing.Index')">LaraZillow</Link>
                </div>
                <div class="flex items-center gap-4" v-if="user">
                    <div class="text-sm text-gray-500">{{ user.name }}</div>
                    <Link :href="route('listing.create')"
                          class="btn-primary">
                        + New Listing
                    </Link>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4 w-full">
        <div v-if="flashSuccess"
             class="mb-4 border rounded-md shadow-md border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2">
            <!-- page.props.value.flash (same here) -->
                        {{ flashSuccess }}
        </div>
        <!--    <span>Computed:  text-white font-medium p-2 rounded-md{{ y }}</span>-->
        <slot>Default</slot>    <!-- Inside here will be placed all the content from the child components that uses this layout-->
    </main>
</template>

<script setup>      /* Here you are using Composition API */
import {ref, computed} from "vue";
import {Link, usePage} from '@inertiajs/inertia-vue3';

// const timer = ref(0)        // It wraps everything into a proxy object, that's why the need to call value property

const page = usePage()          // Inertia Helper

const flashSuccess = computed(() => page.props.value.flash.success)      // This structure is defined in the HandleInertiaRequests Inertia Middleware

const user = computed(() => page.props.value.user)      // This structure is defined in the HandleInertiaRequests Inertia Middleware
console.log('user', user);
//page.props.value.flash.success

// const x = ref(0)
// const y = computed(() => x.value * 2)

// setInterval(() => timer.value++, 1000)  // No need to use single lines

</script>
