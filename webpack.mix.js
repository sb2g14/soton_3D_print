const { mix } = require('laravel-mix');

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
    .js('resources/assets/js/approve_job_validation.js', 'public/js')
    .js('resources/assets/js/bootstrap.js', 'public/js')
    .js('resources/assets/js/edit_job_validation.js', 'public/js')
    .js('resources/assets/js/email_validation.js', 'public/js')
    .js('resources/assets/js/issue_validation.js', 'public/js')
    .js('resources/assets/js/login_validation.js', 'public/js')
    .js('resources/assets/js/message_validation.js', 'public/js')
    .js('resources/assets/js/new_printer_validation.js', 'public/js')
    .js('resources/assets/js/print_preview_validation.js', 'public/js')
    .js('resources/assets/js/printer_validation.js', 'public/js')
    .js('resources/assets/js/register_validation.js', 'public/js')
    .js('resources/assets/js/request_job_validation.js', 'public/js')
    .js('resources/assets/js/request_online_job_validation.js', 'public/js')
    .js('resources/assets/js/reset_validation.js', 'public/js')
    .js('resources/assets/js/update_issue_validation.js', 'public/js')
    .js('resources/assets/js/update_personal_validation.js', 'public/js')
    .js('resources/assets/js/validations.js', 'public/js')
    .js('resources/assets/js/validate_form.js', 'public/js')
    .less('resources/assets/less/app.less', 'public/css');
