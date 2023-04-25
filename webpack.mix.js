const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
    'resources/js/quepenny.js',
    'resources/js/dropdown.js',
    'resources/js/forms/import-items.js',
    'resources/js/resource-manager.js',
    'resources/js/toast.js',
], 'public/js/app.js');

mix.postCss('resources/css/quepenny.css', 'public/css/app.css', [
    require('postcss-import'),
    require('tailwindcss'),
]);

if (mix.inProduction()) {
    mix.version();
}
