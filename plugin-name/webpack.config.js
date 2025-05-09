const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = {
	entry: './client/bundle/example-bundle.js',
	stats: 'minimal',
	cache: {
		type: 'filesystem', // Use filesystem cache
	},
	output: {
		filename: 'example-bundle.min.js',
		path: path.resolve(__dirname, 'assets/bundle'),
	},
	module: {
		rules: [
			{
				test: /\.css$/,
				use: [MiniCssExtractPlugin.loader, 'css-loader'],
			},
		],
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'example-bundle.min.css',
		}),
	],
	optimization: {
		minimizer: ['...', new CssMinimizerPlugin()],
	},
	mode: 'production',
};
