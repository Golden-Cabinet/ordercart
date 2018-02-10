let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

   mix.scripts([
    'node_modules/datatables.net/js/jquery.dataTables.js',
    'node_modules/ca-datatables-bs4/dist/carbonAtom-dataTables-bootstrap4.min.js',
    'public/formula_functions.js',
    'public/json2.js',
    'public/order_functions.js',
    'public/page_functions.js',
   ],'public/js/site.js');

   mix.styles([
    'node_modules/datatables.net-dt/css/jquery.dataTables.css',
    'node_modules/ca-datatables-bs4/dist/carbonAtom-dataTables-bootstrap4.min.css',
       'node_modules/typeface-josefin-sans/index.css',
       'node_modules/typeface-im-fell-english-sc/index.css'
   ], 'public/css/site.css')   
