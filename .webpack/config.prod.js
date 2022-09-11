const { helpers, externals, presets, plugins } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;
const { clean, manifest, miniCssExtract } = plugins;

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
			filename: '[name].js',
		},
		plugins: [
			clean(),
			manifest( {
				fileName: 'production-asset-manifest.json',
				seed: { buildTime: new Date().toISOString() },
			} ),
			miniCssExtract( { filename: '[name].css' } ),
		],
	} ),
	presets.production( {
		externals,
		name: 'Sound Logo Child Theme',
		entry: {
			themeScripts: filePath( 'themes/soundlogo/src/js/frontend.js' ),
			frontend: filePath( 'themes/soundlogo/src/sass/frontend.scss' ),
			editor_soundlogo_styles: filePath( 'themes/soundlogo/src/sass/editor.scss' ),
			fonts: filePath( 'themes/soundlogo/src/fonts/fonts.scss' ),
		},
		output: {
			path: filePath( 'themes/soundlogo/build/' ),
			filename: '[name].js',
		},
		plugins: [
			clean(),
			manifest( {
				fileName: 'production-asset-manifest.json',
				seed: { buildTime: new Date().toISOString() },
			} ),
			miniCssExtract( { filename: '[name].css' } ),
		],
	} ),
];
