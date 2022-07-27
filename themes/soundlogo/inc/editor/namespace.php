<?php
/**
 * Editor-related functionality for the Sound Logo Child Theme.
 *
 * @package wikimedia-contest
 */

namespace Wikimedia_Contest\Theme\Editor;

/**
 * Bootstrap hooks relevant to the block editor.
 *
 * @return void
 */
function bootstrap() : void {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\unregister_shiro_block_styles' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_banner_custom_block_scripts' );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\register_block_styles' );
}

/**
 * Enqueue client-side script to unregister the undesired shiro block styles.
 *
 * @return void
 */
function unregister_shiro_block_styles() : void{
	wp_enqueue_script(
		'unregister-shiro-block-styles',
		get_stylesheet_directory_uri() . '/assets/js/unregister-shiro-block-styles.js',
		array( 'jquery' )
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
		// 'strong-red' =>
		// [
		// 	'background-color' => '#970302',
		// 	'text-color'       => '#FFFFFF',
		// 	'name'             => 'Strong Red'
		// ],
		'black' =>
		[
			'background-color' => '#000000',
			'text-color'       => '#FFFFFF',
			'name'             => 'Black'
		],
		'white' =>
		[
			'background-color' => '#FFFFFF',
			'text-color'       => '#000000',
			'name'             => 'White'
		],
		'strong-pink' =>
		[
			'background-color' => '#E679A6',
			'text-color'       => '#000000',
			'name'             => 'Pink'
		],
		// 'strong-orange' =>
		// [
		// 	'background-color' => '#EE8019',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Strong Orange'
		// ],
		// 'strong-yellow' =>
		// [
		// 	'background-color' => '#F0BC00',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Strong Yellow'
		// ],
		// 'strong-purple' =>
		// [
		// 	'background-color' => '#5748B5',
		// 	'text-color'       => '#FFFFFF',
		// 	'name'             => 'Strong Purple'
		// ],
		// 'strong-darkgreen' =>
		// [
		// 	'background-color' => '#305D70',
		// 	'text-color'       => '#FFFFFF',
		// 	'name'             => 'Strong Dark Green'
		// ],
		// 'strong-blue' =>
		// [
		// 	'background-color' => '#0E65C0',
		// 	'text-color'       => '#FFFFFF',
		// 	'name'             => 'Strong Blue'
		// ],
		// 'strong-brightblue' =>
		// [
		// 	'background-color' => '#049DFF',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Strong Bright Blue'
		// ],
		// 'strong-brightyellow' =>
		// [
		// 	'background-color' => '#E9E7C4',
		// 	'text-color'       => '#FFFFFF',
		// 	'name'             => 'Strong Bright Yellow'
		// ],
		// 'strong-green' =>
		// [
		// 	'background-color' => '#308557',
		// 	'text-color'       => '#FFFFFF',
		// 	'name'             => 'Strong Green'
		// ],
		'strong-brightgreen' =>
		[
			'background-color' => '#71D1B3',
			'text-color'       => '#000000',
			'name'             => 'Strong Bright Green'
		],
		// 'light-red' =>
		// [
		// 	'background-color' => '#E5C0C0',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Red'
		// ],
		// 'light-pink' =>
		// [
		// 	'background-color' => '#F9DDE9',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Pink'
		// ],
		// 'light-orange' =>
		// [
		// 	'background-color' => '#FBDFC5',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Orange'
		// ],
		// 'light-yellow' =>
		// [
		// 	'background-color' => '#FBEEBF',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Yellow'
		// ],
		// 'light-purple' =>
		// [
		// 	'background-color' => '#D5D1EC',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Purple'
		// ],
		// 'light-darkgreen' =>
		// [
		// 	'background-color' => '#CBD6DB',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Dark Green'
		// ],
		// 'light-blue' =>
		// [
		// 	'background-color' => '#C3D8EF',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Blue'
		// ],
		// 'light-brightblue' =>
		// [
		// 	'background-color' => '#C0E6FF',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Bright Blue'
		// ],
		// 'light-brightyellow' =>
		// [
		// 	'background-color' => '#F9F9F0',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Bright Yellow'
		// ],
		// 'light-green' =>
		// [
		// 	'background-color' => '#CBE0D5',
		// 	'text-color'       => '#000000',
		// 	'name'             => 'Light Green'
		// ],
		'light-brightgreen' =>
		[
			'background-color' => '#DBF3EC',
			'text-color'       => '#000000',
			'name'             => 'Light Bright Green'
		],
   ];

	foreach ( $blocks as $block ) {
		foreach ( $block_styles as $style_name => $style_data ) {
			register_block_style(
				$block,
				[
					'name'         => $style_name,
					'label'        => __( $style_data['name'], 'soundlogo-theme-admin' ),
					'inline_style' => ".is-style-{$style_name} {
					    --background-color: {$style_data['background-color']};
					    --text-color: {$style_data['text-color']};
					}",
				]
			);
		}
	}
}
