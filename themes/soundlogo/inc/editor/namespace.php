<?php
/**
 * Editor-related functionality for the Sound Logo Child Theme.
 *
 * @package wikimedia-contest
 */

namespace Wikimedia_Contest\Theme\Editor;

use Asset_Loader;
use Asset_Loader\Manifest;

/**
 * Bootstrap hooks relevant to the block editor.
 *
 * @return void
 */
function bootstrap() : void {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\unregister_shiro_block_styles' );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\register_block_styles' );
	add_action( 'admin_init', __NAMESPACE__ . '\\add_editor_assets' );
}

/**
 * Enqueue client-side script to unregister the undesired shiro block styles.
 *
 * @return void
 */
function unregister_shiro_block_styles() : void {
	wp_enqueue_script(
		'unregister-shiro-block-styles',
		get_stylesheet_directory_uri() . '/assets/js/unregister-shiro-block-styles.js',
		[ 'jquery' ]
	);
}

/**
 * Register Wikimedia Sound Logo specific the block styles.
 *
 * @return void
 */
function register_block_styles() : void {

	$blocks = [
		'shiro/banner',
		'shiro/landing-page-hero',
		'shiro/spotlight',
	];

	$block_styles = [
		'black' =>
		[
			'background-color' => '#000000',
			'text-color'       => '#FFFFFF',
			'name'             => __( 'Black', 'wikimedia-contest-admin' ),
		],
		'white' =>
		[
			'background-color' => '#FFFFFF',
			'text-color'       => '#000000',
			'name'             => __( 'White', 'wikimedia-contest-admin' ),
		],
		'strong-pink' =>
		[
			'background-color' => '#E679A6',
			'text-color'       => '#000000',
			'name'             => __( 'Pink', 'wikimedia-contest-admin' ),
		],
		'strong-brightgreen' =>
		[
			'background-color' => '#71D1B3',
			'text-color'       => '#000000',
			'name'             => __( 'Strong Bright Green', 'wikimedia-contest-admin' ),
		],
		'light-brightgreen' =>
		[
			'background-color' => '#DBF3EC',
			'text-color'       => '#000000',
			'name'             => __( 'Light Bright Green', 'wikimedia-contest-admin' ),
		],
	];

	foreach ( $blocks as $block ) {
		foreach ( $block_styles as $style_name => $style_data ) {
			register_block_style(
				$block,
				[
					'name'         => $style_name,
					'label'        => $style_data['name'],
					'inline_style' => ".is-style-{$style_name} {
					    --background-color: {$style_data['background-color']};
					    --text-color: {$style_data['text-color']};
					}",
				]
			);
		}
	}
}

/**
 * Add needed fonts and stylesheet to the editor
 */
function add_editor_assets() {
	$manifest = Manifest\get_active_manifest( [
		__DIR__ . '/../../build/development-asset-manifest.json',
		__DIR__ . '/../../build/production-asset-manifest.json',
	] );

	Asset_Loader\enqueue_asset(
		$manifest,
		'fonts.css',
	);

	$json = file_get_contents( $manifest ); //phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
	$json_data = json_decode( $json, true );

	if ( isset( $json_data['editor_soundlogo_styles.css'] ) ) {
		add_editor_style( "build/{$json_data['editor_soundlogo_styles.css']}" );
	}
}
