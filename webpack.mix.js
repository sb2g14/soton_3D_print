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
    .js('resources/assets/js/bootstrap.js', 'public/js')
    .js('resources/assets/js/login_validation.js', 'public/js')
    .js('resources/assets/js/register_validation.js', 'public/js')
    .js('resources/assets/js/reset_validation.js', 'public/js')
    .js('resources/assets/js/validations.js', 'public/js')
    .js('resources/assets/js/validate_form.js', 'public/js')
    .js('resources/assets/js/validate_form_issue_create.js', 'public/js')
    .js('resources/assets/js/validate_form_issue_comment.js', 'public/js')
    .js('resources/assets/js/validate_form_announcement_create.js', 'public/js')
    .js('resources/assets/js/validate_form_issue_resolve.js', 'public/js')
    .js('resources/assets/js/validate_form_online_job_reject.js', 'public/js')
    .js('resources/assets/js/validate_form_print_preview.js', 'public/js')
    .js('resources/assets/js/validate_form_online_print.js', 'public/js')

    .less('resources/assets/less/app.less', 'public/css');
