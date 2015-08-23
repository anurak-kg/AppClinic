var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.less('app.less');
    mix.scripts(
        [
            'jQuery-2.1.4.min.js',
           // 'jquery-ui.min.js',
            'angular.min.js',
            'angular-route.min.js',
            'ng-table.js',
            'bootstrap.min.js',
            'ui-bootstrap-custom-0.13.1.min.js',
            'ui-bootstrap-custom-tpls-0.13.1.min.js',
            'select2.min.js',
            'select.min.js',
            'angular-sanitize.min.js',
            'bootstrap-datepicker.min.js',
            'bootstrap-datepicker.th.min.js',
            'typeahead.bundle.min.js',
            'bootstrap-tagsinput.min.js',
            'jquery.dataTables.min.js',
            'redactor.min.js',
            'handlebars-v3.0.3.js',
            'index.min.js',
            'bootstrap-toggle.min.js'
        ],
        'public/js/app.js'
    )
    ;
    mix.styles([
        'bootstrap.min.css',
        'font-awesome.min.css',
        'select2.css',
        'select2-bootstrap.css',
        'select.min.css',
        'AdminLTE.min.css',
        'index.min.css',
        'ionicons.min.css',
        'bootstrap-toggle.min.css'
        //'jquery-ui.min.css'

    ]);
});
