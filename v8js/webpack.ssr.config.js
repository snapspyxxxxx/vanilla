const path = require('path');
const webpack = require('webpack');

const config = {
  mode: 'production',

  entry: {
    reactBundle: './v8js/react-bundle.js',
    HelloWorld: './applications/dashboard/js/src/HelloWorld.jsx',
  },

  output: {
    filename: '[name].js',
    path: path.resolve('./v8js/dist/'),
  },

  // devtool: 'source-map',

  optimization: {
    concatenateModules: true,
    namedModules: true,
    namedChunks: true,
    runtimeChunk: false,
  },

  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: ['babel-loader'],
      },
    ],
  },


  plugins: [
    new webpack.EnvironmentPlugin({ 'process.env.NODE_ENV': JSON.stringify('production') }),

    new webpack.DllReferencePlugin({
      context: '.',
      manifest: 'v8js/dist/dll.manifest.json',
    }),
  ],

  // some libs import node modules but don't use them in the browser, this provides empty mocks for them
  node: {
    dgram: 'empty',
    dns: 'empty',
    fs: 'empty',
    net: 'empty',
    tls: 'empty',
    child_process: 'empty',
  },
};

module.exports = config;
