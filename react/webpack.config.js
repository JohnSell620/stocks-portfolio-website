var webpack = require('webpack');
var path = require('path');

var BUILD_DIR = path.resolve(__dirname, '../view');
var APP_DIR = path.resolve(__dirname, 'src');
var DATA_DIR = path.resolve(__dirname, 'data');

var config = {
    entry: {
        app_create: APP_DIR + '/App.js'
    },
    output: {
        path: BUILD_DIR,
        filename: "[name].bundle.js"
    },
    module : {
        loaders : [
          {
              test : /\.jsx?$/,
              // exclud : /node_modules/,
              include : APP_DIR,
              loader : 'babel',
              // query :
              // {
              //   presets : ['es2015','react']
              // }
          },
          {
            test : /\.json$/,
            include : DATA_DIR,
            loader : 'json-loader'
          }
        ]
    },
    plugins: [
      new webpack.optimize.UglifyJsPlugin({minimize: true})
    ]
};


module.exports = config;
