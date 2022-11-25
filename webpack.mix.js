const mix = require('laravel-mix');
const postcssImport = require('postcss-import');
const tailwindcss = require('tailwindcss');

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

mix.copyDirectory('node_modules/popper.js/dist', 'node_modules/@popperjs/core/dist');
mix.copyDirectory('node_modules/popper.js/src', 'node_modules/@popperjs/core/src');
mix.copy('node_modules/popper.js/package.json', 'node_modules/@popperjs/core/package.json');
mix.copy('node_modules/popper.js/index.d.ts', 'node_modules/@popperjs/core/index.d.ts');
mix.copy('node_modules/popper.js/index.js.flow', 'node_modules/@popperjs/core/index.js.flow');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        postcssImport(),
        tailwindcss('tailwind.config.js'),
    ])
    // J'ai mis en commentaire !important à partir des classes align sur bootstrap pour ne pas trop interférer avec tailwindcsss
    // .css('node_modules/bootstrap/dist/css/bootstrap.css', 'resources/css/bootstrap/bootstrap.css')
    .css('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
    .css('resources/css/bootstrap/bootstrap.css', 'public/css/bootstrap.css');

require('laravel-mix-merge-manifest');

mix.setPublicPath('public').mergeManifest();

mix.js('resources/js/functions.js', 'js/functions.js')
    .js('Modules/Profile/Resources/assets/js/app.js', 'js/profile.js')
    .sass('Modules/Profile/Resources/assets/sass/app.scss', 'css/profile.css')
    .js('Modules/Right/Resources/assets/js/app.js', 'js/right.js')
    .sass('Modules/Right/Resources/assets/sass/app.scss', 'css/right.css')
    .js('Modules/Log/Resources/assets/js/app.js', 'js/log.js')
    .sass('Modules/Log/Resources/assets/sass/app.scss', 'css/log.css')
    .js('Modules/Customer/Resources/assets/js/app.js', 'js/customer.js')
    .sass('Modules/Customer/Resources/assets/sass/app.scss', 'css/customer.css')
    .js('Modules/Company/Resources/assets/js/app.js', 'js/company.js')
    .sass('Modules/Company/Resources/assets/sass/app.scss', 'css/company.css')
    .js('Modules/Monitoring/Resources/assets/js/app.js', 'js/monitoring.js')
    .sass('Modules/Monitoring/Resources/assets/sass/app.scss', 'css/monitoring.css');

mix.postCss('public/css/profile.css', 'public/css', [
    postcssImport(),
    tailwindcss('tailwind.config.js'),
]);

/*mix.copyDirectory('node_modules/tinymce/icons', 'public/js/icons');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/js/plugins');
mix.copyDirectory('node_modules/tinymce/skins', 'public/js/skins');
mix.copyDirectory('node_modules/tinymce/themes', 'public/js/themes');
mix.copy('node_modules/tinymce/jquery.tinymce.js', 'public/node_modules/tinymce/jquery.tinymce.js');
mix.copy('node_modules/tinymce/jquery.tinymce.min.js', 'public/node_modules/tinymce/jquery.tinymce.min.js');
mix.copy('node_modules/tinymce/tinymce.js', 'public/node_modules/tinymce/tinymce.js');
mix.copy('node_modules/tinymce/tinymce.min.js', 'public/node_modules/tinymce/tinymce.min.js');*/

if (mix.inProduction()) {
    mix.version();
}
