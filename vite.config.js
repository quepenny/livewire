import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/quepenny.css',
                'resources/js/quepenny.js'
            ],
            refresh: true,
        }),
    ],
});