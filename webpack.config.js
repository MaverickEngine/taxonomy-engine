const path = require('path');
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
    mode: 'development',
    entry: './src/index.js',
    output: {
    filename: 'main.js',
        path: path.resolve(__dirname, 'includes/js'),
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: "vue-loader",
            },
            {
                test: /\.pug$/,
                loader: 'pug-plain-loader'
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ],
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
        }
    }
};