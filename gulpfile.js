var elixir = require('laravel-elixir');
require ('laravel-elixir-vueify');
require('laravel-elixir-imagemin');

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



elixir.config.images = {
    folder: 'img',
    outputFolder: 'img'
};

elixir(function(mix) {
    mix.sass('app.scss');
    mix.imagemin();
    mix.browserify('main.js');
    mix.browserify('init.js', './public/js/init.js');
});
