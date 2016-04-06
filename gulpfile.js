var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    var siteTheme = 'yeti';
    
        // copy angular to public directory
    mix.copy('./node_modules/angular/angular.min.js', 'public/js/angular.min.js')
        
        // copy font awesome fonts folder to public css directory
        .copy('./node_modules/font-awesome/fonts', 'public/build/fonts')
        
        // create app.js to be used by other scripts
        .scripts([
            './node_modules/jquery/dist/jquery.js',
            './node_modules/bootstrap/dist/js/bootstrap.js'
        ], 'resources/assets/js/app.js')

        // create app.css for global theme settings
        .styles([
            './node_modules/bootswatch/' + siteTheme + '/bootstrap.css',
            './node_modules/animate.css/animate.css',
            './node_modules/font-awesome/css/font-awesome.css',
            'global.css'
        ], 'public/css/app.css')
            
        // create register.js
        .scripts([
            'app.js',
            './node_modules/zxcvbn/dist/zxcvbn.js',
            'services/auth.service.js',
            'pages/register/register.controller.final.js',
            'pages/register/register.app.final.js'
        ], 'public/js/register.js')
            
        
        // version files
        .version([
            'css/app.css',
            'js/register.js'
        ]);

});
