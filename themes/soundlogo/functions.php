<?php
/**
 * Wikimedia Sound Logo Contest theme
 *
 * Child theme of Shiro
 *
 * @package wikimedia-contest
 */

namespace Wikimedia_Contest\Theme;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_parent_stylesheet' );
add_action( 'wp_head', __NAMESPACE__ . '\\embed_fonts' );

/**
 * Enqueue the stylesheet from this theme, as well as the shiro stylesheet.
 */
function enqueue_parent_stylesheet() {
	wp_enqueue_style(
		'wikimedia-contest',
		get_stylesheet_uri(),
		[ 'shiro-style' ],
		md5_file( get_theme_file_path( 'style.css' ) )
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
