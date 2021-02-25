const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
	resolve: {
        alias: {
			vue: "vue/dist/vue.esm-bundler.js"
		}
    },
	plugins: [
		new VueLoaderPlugin()
	],
	output: {
		filename: 'bundle.js',
	},
	module: {
		rules: [
			{
				test: /\.vue$/,
				loader: "vue-loader"
			},
			{
				test: /\.(js|jsx)$/,
				exclude: /(node_modules)/,
				loader: 'babel-loader',
				query: {
					presets: [
						[
							'@babel/preset-env'
						],
					],
				}
			}
		],
	}
};
