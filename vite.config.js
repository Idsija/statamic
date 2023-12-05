import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr:{
            host: process.env.DDEV_HOSTNAME,
            protocol : 'wss'
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/site.scss',
                'resources/js/site.js',
                // Control Panel assets.
                // https://statamic.dev/extending/control-panel#adding-css-and-js-assets
                // 'resources/css/cp.css',
                // 'resources/js/cp.js',
            ],
            refresh: true,
        }),
        // vue2(),
    ],
});
