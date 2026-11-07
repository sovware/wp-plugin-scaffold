const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const devHost = 'wpmvc.test';

module.exports = {
	...defaultConfig,
	entry: {
		app: './assets/src/js/app.js',
	},
	output: {
		path: path.resolve( __dirname, './assets/build/' ),
		filename: '[name].js',
		clean: true,
	},
	resolve: {
		...defaultConfig.resolve,
		alias: {
			...defaultConfig.resolve.alias,
			'@': path.resolve(__dirname, 'assets/src/js/'),
		},
	},
	devServer: {
		devMiddleware: {
			writeToDisk: true,
		},
		allowedHosts: 'auto',
		port: 8887,
		host: devHost,
		proxy: {
			'/assets/build': {
				pathRewrite: {
					'^/assets/build': '',
				},
			},
		},
		headers: { 'Access-Control-Allow-Origin': '*' },
	},
};
