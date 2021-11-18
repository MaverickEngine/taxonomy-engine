const path = require('path');
const { VueLoaderPlugin } = require("vue-loader");
const MiniCssExtractPlugin = require("mini-css-extract-plugin")
const WebpackBundleAnalyzer = require("webpack-bundle-analyzer").BundleAnalyzerPlugin;

module.exports = {
    mode: 'development',
    entry: './src/index.js',
    output: {
        filename: 'taxonomyengine.js',
        path: path.resolve(__dirname, 'dist'),
    },
    module: {
        rules: [
            // {
            //     test: /\.(js|ts)$/,
            //     loader: 'babel-loader',
            //     exclude: /(node_modules|bower_components)/,
            //     options: {
            //         presets: ["@babel/env"]
            //     }
            // },
            {
                test: /\.less$/,
                use: [ 
                    'style-loader',
                    // MiniCssExtractPlugin.loader,
                    'css-loader', 
                    'less-loader'
                ],
            },
            {
                test: /\.scss$/,
                use: [
                  "style-loader",
                //   MiniCssExtractPlugin.loader,
                  "css-loader",
                  "sass-loader"
                ]
            },
            {
                test: /\.css$/,
                use: [
                    // process.env.NODE_ENV !== 'production' ? 'vue-style-loader' : MiniCssExtractPlugin.loader,
                    'css-loader'
                ]
            },
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
        new VueLoaderPlugin(),
        new MiniCssExtractPlugin({
            filename: 'taxonomyengine.css',
        }),
        new WebpackBundleAnalyzer()
    ],
    // resolve: {
    //     alias: {
    //         'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
    //     }
    // }
};