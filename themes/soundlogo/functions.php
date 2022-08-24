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

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );
add_action( 'wp_head', __NAMESPACE__ . '\\embed_fonts' );
add_action( 'admin_init', __NAMESPACE__ . '\\add_footer_reusable_block_setting' );

require_once __DIR__ . '/inc/editor/namespace.php';
\Wikimedia_Contest\Theme\Editor\bootstrap();

require_once __DIR__ . '/inc/customizer.php';
\Wikimedia_Contest\Theme\Customizer\bootstrap();

/**
 * Enqueue the stylesheet from this theme, as well as the shiro stylesheet.
 */
function enqueue_assets() {

	$manifest = Manifest\get_active_manifest( [
		__DIR__ . '/build/development-asset-manifest.json',
		__DIR__ . '/build/production-asset-manifest.json',
	] );

	if ( is_rtl() ) {
		wp_register_style(
			'shiro-style-rtl',
			get_template_directory_uri() . '/rtl.css',
			[ 'shiro-style' ],
			md5_file( get_template_directory() . '/rtl.css' )
		);
	}

	Asset_Loader\enqueue_asset(
		$manifest,
		'frontend.css',
		[
			'dependencies' => [ is_rtl() ? 'shiro-style-rtl' : 'shiro-style' ],
			'handle' => 'soundlogo-style',
		]
	);


	Asset_Loader\enqueue_asset(
		$manifest,
		'themeScripts.js',
		[
			'handle' => 'soundlogo-script',
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

/**
 * Add on Settings > General a parameter for Footer Reusable Block ID
 *
 * @return void
 */
function add_footer_reusable_block_setting() : void {
	add_settings_section(
		'soundlogo_theme_settings_section',
		'Sound Logo Theme',
		__NAMESPACE__ . '\\soundlogo_theme_message',
		'general'
	);

	add_settings_field(
		'footer_reusable_block_id',
		'Footer Reusable Block ID',
		__NAMESPACE__ . '\\footer_reusable_block_id_field',
		'general',
		'soundlogo_theme_settings_section',
		[
			'footer_reusable_block_id',
		]
	);

	$args = [
		'type' => 'integer',
		'sanitize_callback' => 'absint',
		'default' => null,
	];

	register_setting( 'general', 'footer_reusable_block_id', $args );
}

/**
 * Prints a message for the Sound Logo Theme settings section
 *
 * @return void
 */
function soundlogo_theme_message() : void {
	// Following HTML needs to be displayed as it is, so we can't use esc_html.
	echo '<p>' . __( 'Custom settings for Wikimedia Sound Logo Contest Theme', 'soundlogo-theme-admin' ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints a text input for the Footer Reusable Block ID setting
 *
 * @param array $args The arguments for the field.
 * @return void
 */
function footer_reusable_block_id_field( $args ) : void {
	$option = get_option( $args[0] );

	// Following HTML needs to be displayed as it is, so we can't use esc_html.
	echo '<input type="text" id="' . esc_attr( $args[0] ) . '" name="' . esc_attr( $args[0] ) . '" value="' . esc_attr( $option ) . '" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	echo '<p>' . sprintf(
		__( 'The ID of the Reusable Block which will be displayed on the site footer. You can find it here: %s', 'soundlogo-theme-admin' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'<a href="' . esc_url( admin_url() ) . 'edit.php?post_type=wp_block" target="_blank">' . esc_url( admin_url() ) . 'edit.php?post_type=wp_block</a>'
	) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
