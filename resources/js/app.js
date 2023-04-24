// Removed ./bootstrap import because it was deleted

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import MainLayout from "../js/Layouts/MainLayout.vue";

createInertiaApp({
    resolve: async (name) => {                                                              // Tweaks in resolve function
        const pages = import.meta.glob('./pages/**/*.vue', {eager: true})   // glob is a special function of vite to load multiple files/components/modules
        // return (await pages[`./pages/${name}.vue`]) // This line returns the specific component for the given page name (commented to use Default Layouts)
        const page = (await pages[`./pages/${name}.vue`])               // This is a function call but due to it is an async function we need to use that keyword, note that if we didnt put that the function would be called immediately and maybe page wouldn't have value yet, and cause an runtime error.
        page.default.layout = page.default.layout || MainLayout         // Setting the Default layout for this page

        return page             //  Finally, return the page component now you can remove From show and Index the persistent layout
    },
    setup({el, App, props, plugin}) {             // Because inertia will be in control of vue app, Destructuring the object that is being passed, it like converting into variables an object properties
        createApp({render: () => h(App, props)})
            .use(plugin)
            .mount(el)
    },
})











