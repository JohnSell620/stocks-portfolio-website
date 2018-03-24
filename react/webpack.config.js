var webpack = require('webpack');
var path = require('path');

var BUILD_DIR = path.resolve(__dirname, 'src');
var APP_DIR = path.resolve(__dirname, 'src');
var DATA_DIR = path.resolve(__dirname, 'data');

var config = {
  entry: {
    app_create: APP_DIR + '/index.js'
  },
  output: {
    path: BUILD_DIR,
    filename: "[name].bundle.js"
  },
  module : {
    loaders : [
      {
        test : /\.jsx?$/,
        exclude : /node_modules(?!\/react-redux-toastr)/,
        include : APP_DIR,
        loader : 'babel'
      },
      {
        test : /\.json$/,
        include : DATA_DIR,
        loader : 'json-loader'
      },
      {
        test: /\.css$/,
        loader: "style-loader!css-loader"
      },
      {
        test: /\.(ttf|eot|svg|woff(2)?)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        loader: "url-loader?limit=80000"
      }
    ]
  },
  plugins: [
    new webpack.optimize.UglifyJsPlugin({minimize: true})
  ],
  resolve: {
    modulesDirectories: [__dirname + '/node_modules'],
    root: __dirname + '/app'
  },

  resolveLoader: {
    root: __dirname + '/node_modules'
  }
};


module.exports = config;
