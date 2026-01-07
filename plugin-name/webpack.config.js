const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

// Base configuration shared between minified and non-minified.
const baseConfig = {
	entry: {
		'example-bundle': './client/bundle/example-bundle.js', // Add more entries as needed.
	},
	stats: 'minimal',
	cache: {
		type: 'filesystem', // Use filesystem cache.
	},
	module: {
		rules: [
			{
				test: /\.css$/,
				use: [MiniCssExtractPlugin.loader, 'css-loader'],
			},
			{
				test: /\.scss$/,
				use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
			},
		],
	},
};

// Minified configuration.
const minifiedConfig = {
	...baseConfig,
	output: {
		filename: '[name].min.js',
		path: path.resolve(__dirname, 'assets/bundle'),
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: '[name].min.css',
		}),
	],
	optimization: {
		minimizer: ['...', new CssMinimizerPlugin()],
	},
	mode: 'production',
};

/*
Non-minified configuration.

This configuration is primarily needed for JavaScript translations to work correctly:
- The `wp i18n make-pot` command ignores .min.js files, so it cannot extract translatable
  strings from minified bundles.
- While the minified version is what gets enqueued via `wp_enqueue_script()`,
  WordPress uses the non-minified version as the source.
- It's not possible to extract strings from /client source files and then enqueue
  the equivalent minified files from /assets, as the translation system needs to match
  the exact file structure.
*/
const nonMinifiedConfig = {
	...baseConfig,
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'assets/bundle'),
		clean: false, // Don't clean the output directory to preserve minified files.
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: '[name].css',
		}),
	],
	optimization: {
		minimize: false,
		runtimeChunk: false, // Disable runtime chunk to minimize webpack bootstrap.
		splitChunks: false, // Disable code splitting.
	},
	mode: 'production',
};

module.exports = [minifiedConfig, nonMinifiedConfig];
