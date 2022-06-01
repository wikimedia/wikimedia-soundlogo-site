const { helpers, externals, presets } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

module.exports = presets.production( {
	externals,
	name: 'Wikimedia Contest Plugin',
	entry: {
		editor: filePath( 'plugins/wikimedia-contest/src/editor/index.js' ),
	},
	output: {
		path: filePath( 'plugins/wikimedia-contest/build/' ),
	},
} );
