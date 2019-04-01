const path = require('path');
const webpack = require('webpack');
const AssetsPlugin = require('assets-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  // Here the application starts executing and webpack starts bundling
  entry: {
    app: path.resolve('./resources/src/app'),
    vendor: path.resolve('./resources/src/vendor'),
  },

  // Options related to how webpack emits results
  output: {
    // The target directory for all output files must be an absolute path
    path: path.resolve(__dirname, 'public/dist'),
    // The filename template for entry chunks
    filename: 'js/[name].[hash].js',
  },

  optimization: {
    // Tell webpack to minimize the bundle using the UglifyjsWebpackPlugin.
    minimize: true,
    // npm packages are added to the vendor code separately in splitChunks below
    splitChunks: {
      cacheGroups: {
        common: {
          chunks: 'all',
          filename: 'js/[name].[hash].js',
          name: 'common',
          test: /[\\/]node_modules[\\/]/,
        },
      },
    },
  },

  module: {
    rules: [
      {
        // Allows transpiling JavaScript files using Babel and webpack.
        test: /\.(js|jsx)$/,
        include: path.resolve('./resources'),
        // Exclude these folders from testing
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              ['@babel/preset-env', {
                targets: {
                  browsers: ['last 3 versions'],
                },
              }],
              // Transforms JSX
              '@babel/preset-react',
            ],
          },
        },
      },

      {
        test: /\.s(a|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'resolve-url-loader',
          'sass-loader?sourceMap=true',
        ],
      },

      {
        test: /\.(eot|woff2?|ttf)$/,
        loader: 'file-loader',
        options: {
          name: '[name].[hash].[ext]',
          outputPath: 'fonts/',
          publicPath: path.resolve('./dist/fonts'),
        },
      },

      {
        test: /\.(png|gif|jpe?g|svg)$/,
        loader: 'file-loader',
        options: {
          name: '[name].[ext]',
          outputPath: 'img/',
          publicPath: path.resolve('./dist/img'),
        },
      },
    ],
  },

  plugins: [
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: 'css/[name].[chunkhash].css',
    }),
    new AssetsPlugin({
      filename: 'manifest.json',
      useCompilerPath: true,
      includeManifest: 'manifest',
      prettyPrint: true,

    }),

    // Makes it easier to see which dependencies are being patched
    new webpack.NamedModulesPlugin(),

    // Allows modules to be updated at runtime without the need for a full refresh
    new webpack.HotModuleReplacementPlugin(),
  ],

  // Options for resolving module requests
  // (does not apply to resolving to loaders)
  resolve: {
    extensions: ['.js', '.json', '.jsx', '.css'],
  },
};
