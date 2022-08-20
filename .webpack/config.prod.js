const { helpers, externals, presets, plugins } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

module.exports = [
	presets.production( {
		externals,
		name: 'Wikimedia Contest Plugin',
		entry: {
			admin: filePath( 'plugins/wikimedia-contest/src/js/admin.js' ),
			adminStyles: filePath( 'plugins/wikimedia-contest/src/sass/admin.scss' ),
			editor: filePath( 'plugins/wikimedia-contest/src/js/editor.js' ),
			submissionForm: filePath( 'plugins/wikimedia-contest/src/js/submission-form.js' ),
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
			themeScripts: filePath( 'themes/soundlogo/src/js/frontend.js' ),
			frontend: filePath( 'themes/soundlogo/src/sass/frontend.scss' ),
			editor_soundlogo_styles: filePath( 'themes/soundlogo/src/sass/editor.scss' ),
		},
		output: {
			path: filePath( 'themes/soundlogo/build/' ),
		},
		plugins: [
			plugins.clean(),
		],
	} ),
];
