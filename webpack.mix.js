const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/jquery.dcjqaccordion.2.7.js", "public/js")
    .js("resources/js/jquery.nicescroll.js", "public/js")
    .js("resources/js/jquery.slimscroll.js", "public/js")
    .js("resources/js/jquery2.0.3.min.js", "public/js")
    .js("resources/js/morris.js", "public/js")
    .js("resources/js/raphael-min.js", "public/js")
    .js("resources/js/scripts.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .sourceMaps();
