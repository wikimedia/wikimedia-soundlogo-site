const { helpers, externals, presets, plugins } = require( '@humanmade/webpack-helpers' );
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
			landing_page_hero: filePath( 'themes/soundlogo/src/js/editor/landing-page-hero.js' ),
		},
		output: {
			path: filePath( 'themes/soundlogo/build/' ),
		},
		plugins: [
			plugins.clean(),
		],
	} ),
];
