import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import plugin from 'flowbite/plugin';

export default {
    content: [
        './app/View/Components/**/*.php',
        './node_modules/flowbite/**/*.js',
        './public/js/*.js',
        './resources/views/**/*.blade.php',
        './resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './vendor/livewire-ui/modal/resources/views/*.blade.php',
    ],

    theme: {
        screens: {
            'xs': '475px',
            ...defaultTheme.screens,
        },
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        plugin
    ]
};
