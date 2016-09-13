// Disable notifications
process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

elixir(function (mix) {
    mix.scripts(['resources/assets/js/jquery.js'], 'public/compiled/jquery.js');
    mix.scripts(['resources/assets/js/jquery-migrate.js'], 'public/compiled/jquery-migrate.js');
    mix.scriptsIn("resources/assets/js/plugins", "public/compiled/plugins.js");
    mix.scriptsIn("resources/assets/js/app", "public/compiled/app.js");
    mix.scriptsIn("resources/assets/js/ie9", "public/compiled/ie9.js");
    mix.scriptsIn("resources/assets/js/lang/es", "public/compiled/lang/es.js");

    mix.less('resources/assets/less/style.less', "public/compiled/less.css");

    mix.stylesIn("resources/assets/css", "public/compiled/app.css");

    mix.version(getVersionFiles());
    mix.copy("resources/assets/fonts", "public/fonts");
    mix.copy("resources/assets/fonts", "public/build/fonts");
    mix.copy("resources/assets/fonts", "public/build/compiled/fonts");
    mix.copy("resources/assets/images", "public/build/images");
    mix.copy("resources/assets/default_images", "public/uploads/default_images");
    mix.copy("resources/assets/img", "public/build/img");
    mix.copy("resources/assets/sounds", "public/build/sounds");

    mix.copy("resources/assets/images", "public/build/compiled/images");
    mix.copy("resources/assets/img", "public/build/compiled/img");
});

function getVersionFiles() {
    return [
        'compiled/jquery.js',
        'compiled/jquery-migrate.js',
        'compiled/plugins.js',
        'compiled/app.js',
        'compiled/ie9.js',
        'compiled/lang/es.js',
        'compiled/app.css',
        'compiled/less.css'
    ];
}
