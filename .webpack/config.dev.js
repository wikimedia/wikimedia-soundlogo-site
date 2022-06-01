const { helpers, externals, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, filePath } = helpers;

module.exports = choosePort( 8080 ).then( port => [
	presets.development( {
		name: 'Wikimedia Contest Plugin',
		devServer: {
			port,
		},
		externals,
		entry: {
			editor: filePath( 'plugins/wikimedia-contest/src/editor.js' ),
		},
		output: {
			path: filePath( 'plugins/wikimedia-contest/build/' ),
			publicPath: `http://localhost:${ port }/plugins/wikimedia-contest/build/`,
		},
	} ),
] );

