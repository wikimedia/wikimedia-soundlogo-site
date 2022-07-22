const { helpers, externals, presets } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

module.exports = [
	presets.production( {
		externals,
		name: 'Wikimedia Contest Plugin',
		entry: {
			editor: filePath( 'plugins/wikimedia-contest/src/editor.js' ),
			submissionForm: filePath( 'plugins/wikimedia-contest/src/submission-form.js' ),
		},
		output: {
			path: filePath( 'plugins/wikimedia-contest/build/' ),
		},
	} ),
	presets.production( {
		externals,
		name: 'Sound Logo Child Theme',
		entry: {
			theme: filePath( 'themes/soundlogo/src/sass/index.scss' ),
		},
		output: {
			path: filePath( 'themes/soundlogo/build/' ),
		},
	} ),
];
