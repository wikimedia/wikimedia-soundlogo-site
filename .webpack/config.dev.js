const { helpers, externals, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, filePath } = helpers;

module.exports = choosePort( 8080 ).then( port => [
	presets.development( {
		name: 'Wikimedia Contest Plugin',
		devServer: {
			client: {
				webSocketURL: `ws://localhost:${ port }/ws`,
			},
			allowedHosts: 'all',
			port,
		},
		externals,
		entry: {
			admin: filePath( 'plugins/wikimedia-contest/src/js/admin.js' ),
			adminStyles: filePath( 'plugins/wikimedia-contest/src/sass/admin.scss' ),
			editor: filePath( 'plugins/wikimedia-contest/src/js/editor.js' ),
			submissionForm: filePath( 'plugins/wikimedia-contest/src/js/submission-form.js' ),
		},
		output: {
			path: filePath( 'plugins/wikimedia-contest/build/' ),
			publicPath: `http://localhost:${ port }/plugins/wikimedia-contest/build/`,
		},
	} ),
	presets.development( {
		name: 'Sound Logo Child Theme',
		devServer: {
			client: {
				webSocketURL: `ws://localhost:${ port + 1 }/ws`,
			},
			allowedHosts: 'all',
			port: port + 1,
		},
		externals,
		entry: {
			themeScripts: filePath( 'themes/soundlogo/src/js/frontend.js' ),
			frontend: filePath( 'themes/soundlogo/src/sass/frontend.scss' ),
			editor_soundlogo_styles: filePath( 'themes/soundlogo/src/sass/editor.scss' ),
			fonts: filePath( 'themes/soundlogo/src/fonts/fonts.scss' ),
		},
		output: {
			path: filePath( 'themes/soundlogo/build/' ),
			publicPath: `http://localhost:${ port + 1 }/themes/soundlogo/build/`,
		},
	} ),
] );

