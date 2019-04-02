var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    // the public path you will use in Symfony's asset() function - e.g. asset('build/some_file.js')
    .setManifestKeyPrefix('build/')
    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment if you use Sass/SCSS files
    .enableSassLoader()
    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
    // show OS notifications when builds finish/fail
    .enableBuildNotifications()
    // the following line enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    .enablePostCssLoader((options) => {
        options.config = {
            path: 'config/postcss.config.js'
        };
    })
    // uncomment to define the assets of the project
    .addEntry('frontend/js/main', './assets/js/main.js')
    .addStyleEntry('frontend/css/main', './assets/dev/sass/main.scss')
;

module.exports = Encore.getWebpackConfig();
