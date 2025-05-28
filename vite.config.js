import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({                       // Was added after vite installation
            template: {
                base: null,
                includeAbsolute: false
            }
        })
    ],
    resolve: {                                        // Added to make Ziggy plugin work with Vite to be used in javascript
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue.es.js')
        }
    }
});
