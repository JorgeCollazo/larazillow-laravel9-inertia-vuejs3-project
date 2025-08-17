// Removed ./bootstrap import because it was deleted

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'
// import MainLayout from "../js/Layouts/MainLayout.vue";
import MainLayout from "@/Layouts/MainLayout.vue";  // You can now use this notation instead of relative path like above because of the configuration in the jsconfig.json file
import { ZiggyVue } from "ziggy";       // we were able to import it because we defined an alias for it in the vite.config file
import { InertiaProgress } from "@inertiajs/progress";
import '../css/app.css'

    InertiaProgress.init({
    delay: 0,
    color: '#29d',
    includeCSS: 'true',
    showSpinner: 'true',
})

createInertiaApp({          // Setup for Vue 3 from Inertia Docs This will allow you to use Default layouts
    resolve: async (name) => {                                                              // Tweaks in resolve function
        const pages = import.meta.glob('./pages/**/*.vue', {eager: true})   // glob is a special function of vite to load multiple files/components/modules
        // return (await pages[`./pages/${name}.vue`]) // This line returns the specific component for the given page name (commented to use Default Layouts)
        const page = (await pages[`./pages/${name}.vue`])               // This is a function call but due to it is an async function we need to use that keyword, note that if we didn't put that the function would be called immediately and maybe page wouldn't have value yet, and cause a runtime error.
        page.default.layout = page.default.layout || MainLayout         // Setting the Default layout for this page so you don't have to use export default anymore in your components (see Show.vue or index.vue), if you weren't to use this default layout you can use the later export component commented section

        return page             //  Finally, return the page component now you can remove From show and Index the persistent layout
    },
    setup({el, App, props, plugin}) {             // Because inertia will be in control of vue app, Destructuring the object that is being passed, it like converting into variables an object properties
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)                  // Registering the Zyggyvue plugin
            .mount(el)
    },
})











