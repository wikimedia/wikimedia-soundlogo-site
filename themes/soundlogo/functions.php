<?php
/**
 * Wikimedia Sound Logo Contest theme
 *
 * Child theme of Shiro
 *
 * @package wikimedia-contest
 */

namespace Wikimedia_Contest\Theme;

use Asset_Loader;
use Asset_Loader\Manifest;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_stylesheets' );
add_action( 'wp_head', __NAMESPACE__ . '\\embed_fonts' );

/**
 * Enqueue the stylesheet from this theme, as well as the shiro stylesheet.
 */
function enqueue_stylesheets() {

	$manifest = Manifest\get_active_manifest( [
		__DIR__ . '/build/development-asset-manifest.json',
		__DIR__ . '/build/production-asset-manifest.json',
	] );

	Asset_Loader\enqueue_asset(
		$manifest,
		'theme.css',
		[
			'dependencies' => [ 'shiro-style' ],
			'handle' => 'soundlogo-style',
		]
	);
}

/**
 * Add link to Google Fonts in the header.
 */
function embed_fonts() {
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
	<?php
}
