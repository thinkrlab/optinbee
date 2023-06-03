const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const NODE_ENV = process.env.NODE_ENV || 'development';

module.exports = {
	...defaultConfig,
	entry: {
		optinbee: path.resolve(process.cwd(), 'src/index.js'),
	},
	output: {
		path: path.resolve(process.cwd(), 'assets/frontend'),
		filename: '[name].js',
	},
	mode: NODE_ENV,
};
