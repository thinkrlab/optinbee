const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const NODE_ENV = process.env.NODE_ENV || 'development';
const isProduction = NODE_ENV === 'production';

module.exports = {
	...defaultConfig,
	entry: {
		'js/optinbee': path.resolve(process.cwd(), 'src/index.js'),
		'css/optinbee': path.resolve(process.cwd(), 'src/style.scss'),
	},
	output: {
		path: path.resolve(process.cwd(), 'assets'),
		filename: isProduction ? '[name].min.js' : '[name].js',
	},
	mode: NODE_ENV,
};
