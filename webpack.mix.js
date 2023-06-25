const mix = require('laravel-mix');
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .vue()
    .sourceMaps()
    .version();
/*mix.js('resources/js/app.js', 'public/js')
    .vue({
        extractStyles: true,
        globalStyles: false
    })
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);*/

/*
const { VueLoaderPlugin } = require('vue-loader');

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ]
});
*/
