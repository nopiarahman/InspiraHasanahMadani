const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

//import package from node_modules folder -- Cleave.js
mix.copy('node_modules/cleave.js/dist/cleave.min.js', 'public/js');
mix.copy('node_modules/cleave.js/dist/addons/cleave-phone.id.js', 'public/js/addons');
/* jquery */
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js');
/* popper.js */
mix.copy('node_modules/@popperjs/core/dist/umd/popper.js', 'public/js');
mix.copy('node_modules/@popperjs/core/dist/umd/popper.js.map', 'public/js');
/* bootstrap.js */
mix.copy('node_modules/bootstrap/dist/js/bootstrap.js', 'public/js');
mix.copy('node_modules/bootstrap/dist/js/bootstrap.js.map', 'public/js');
mix.copy('node_modules/bootstrap/dist/css/bootstrap.css', 'public/css');