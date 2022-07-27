const { helpers, externals, presets, plugins } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

module.exports = [
	presets.production( {
		externals,
		name: 'Wikimedia Contest Plugin',
		entry: {
			editor: filePath( 'plugins/wikimedia-contest/src/editor.js' ),
		},
		output: {
			path: filePath( 'plugins/wikimedia-contest/build/' ),
		},
		plugins: [
			plugins.clean(),
		],
	} ),
	presets.production( {
		externals,
		name: 'Sound Logo Child Theme',
		entry: {
			frontend: filePath( 'themes/soundlogo/src/sass/frontend.scss' ),
			editor: filePath( 'themes/soundlogo/src/sass/editor.scss' ),
		},
		output: {
			path: filePath( 'themes/soundlogo/build/' ),
		},
		plugins: [
			plugins.clean(),
		],
	} ),
];
