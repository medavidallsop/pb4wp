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
Primarily included to ensure JS translations work as JSON translation files need this as the source,
minified version enqueued in wp_enqueue_script with wp_set_script_translations which links everything together.
Not possible to extract strings from /client source files then enqueued from the equivalent in /assets,
the non-minified version is used as wp i18n make-pot ignores .min.js files.
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
