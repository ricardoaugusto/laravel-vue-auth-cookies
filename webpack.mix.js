const webpack = require("webpack");
require("dotenv").config();

let dotenvplugin = new webpack.DefinePlugin({
    "process.env": {
        APP_NAME: JSON.stringify(process.env.APP_NAME),
        APP_ENV: JSON.stringify(process.env.APP_ENV),
        APP_DEBUG: JSON.stringify(process.env.APP_DEBUG),
        APP_URL: JSON.stringify(process.env.APP_URL),
        APP_API: JSON.stringify(process.env.APP_API),
        DB_HOST: JSON.stringify(process.env.DB_HOST)
    }
});

const mix = require("laravel-mix");

mix.webpackConfig({
    plugins: [dotenvplugin]
});

mix.js("resources/js/app.js", "public/js").sass(
    "resources/sass/app.scss",
    "public/css"
);
