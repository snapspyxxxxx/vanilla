const path = require("path");
const CleanWebpackPlugin = require("clean-webpack-plugin");
const webpack = require("webpack");

const config = {
    mode: "production",

    entry: [
        'react',
        'react-dom',
        'react-dom/server',
        "classnames",
        "lodash",
        "moment",
        "validator",
    ],

    output: {
        filename: "dll.min.js",
        path: path.resolve("./v8js/dist/"),
        library: "dll",
    },

    // devtool: "source-map",

    plugins: [
        new CleanWebpackPlugin([path.resolve("./v8js/dist")], { root: path.resolve("./"), verbose: false }),

        new webpack.EnvironmentPlugin({ "process.env.NODE_ENV": JSON.stringify("production") }),

        new webpack.DllPlugin({
            path: "v8js/dist/dll.manifest.json",
            name: "dll",
        }),
    ],

    // some libs import node modules but don't use them in the browser, this provides empty mocks for them
    node: {
        dgram: "empty",
        dns: "empty",
        fs: "empty",
        net: "empty",
        tls: "empty",
        child_process: "empty",
    },
};

module.exports = config;
