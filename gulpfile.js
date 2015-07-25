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

elixir(function(mix) {
    mix.less('app.less');
    mix.scripts(
        [
            'angular.min.js',
            'angular-route.min.js',
            'ng-table.js',
            'jQuery-2.1.4.min.js',
            'bootstrap.min.js',
            'ui-bootstrap-custom-0.13.1.min.js',
            'ui-bootstrap-custom-tpls-0.13.1.min.js'
        ],
        'public/js/app.js'
    );
});
