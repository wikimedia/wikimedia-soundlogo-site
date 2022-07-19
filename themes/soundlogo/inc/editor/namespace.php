<?php
/**
 * Editor-related functionality for the Sound Logo Child Theme.
 *
 * @package wikimedia-contest
 */

namespace Wikimedia_Contest\Theme\Editor;

/**
 * Bootstrap hooks relevant to the block editor.
 */
function bootstrap() {
	//add_action( 'after_setup_theme', __NAMESPACE__ . '\\add_theme_supports', 30 );
}

function add_theme_supports() {
	// From https://meta.wikimedia.org/wiki/Brand/colours#The_Creative_Palette
	add_theme_support( 'editor-color-palette', [
		// Strong colors.
		[ 'name' => __( 'Strong Red', 'wikimedia-contest-admin' ), 'slug' => 'strong-red', 'color' => '#970302' ],
		[ 'name' => __( 'Strong Pink', 'wikimedia-contest-admin' ), 'slug' => 'strong-pink', 'color' => '#E679A6' ],
		[ 'name' => __( 'Strong Orange', 'wikimedia-contest-admin' ), 'slug' => 'strong-orange', 'color' => '#EE8019' ],
		[ 'name' => __( 'Strong Yellow', 'wikimedia-contest-admin' ), 'slug' => 'strong-yellow', 'color' => '#F0BC00' ],
		[ 'name' => __( 'Strong Purple', 'wikimedia-contest-admin' ), 'slug' => 'strong-purple', 'color' => '#5748B5' ],
		[ 'name' => __( 'Strong Dark Green', 'wikimedia-contest-admin' ), 'slug' => 'strong-dark-green', 'color' => '#305D70' ],
		[ 'name' => __( 'Strong Blue', 'wikimedia-contest-admin' ), 'slug' => 'strong-blue', 'color' => '#0E65C0' ],
		[ 'name' => __( 'Strong Bright Blue', 'wikimedia-contest-admin' ), 'slug' => 'strong-bright-blue', 'color' => '#049DFF' ],
		[ 'name' => __( 'Strong Bright Yellow', 'wikimedia-contest-admin' ), 'slug' => 'strong-bright-yellow', 'color' => '#E9E7C4' ],
		[ 'name' => __( 'Strong Green', 'wikimedia-contest-admin' ), 'slug' => 'strong-green', 'color' => '#308557' ],
		[ 'name' => __( 'Strong Bright Green', 'wikimedia-contest-admin' ), 'slug' => 'strong-bright-green', 'color' => '#71D1B3' ],
		// Light colors.
		[ 'name' => __( 'Light Red', 'wikimedia-contest-admin' ), 'slug' => 'light-red', 'color' => '#E5C0C0' ],
		[ 'name' => __( 'Light Pink', 'wikimedia-contest-admin' ), 'slug' => 'light-pink', 'color' => '#F9DDE9' ],
		[ 'name' => __( 'Light Orange', 'wikimedia-contest-admin' ), 'slug' => 'light-orange', 'color' => '#FBDFC5' ],
		[ 'name' => __( 'Light Yellow', 'wikimedia-contest-admin' ), 'slug' => 'light-yellow', 'color' => '#FBEEBF' ],
		[ 'name' => __( 'Light Purple', 'wikimedia-contest-admin' ), 'slug' => 'light-purple', 'color' => '#D5D1EC' ],
		[ 'name' => __( 'Light Dark Green', 'wikimedia-contest-admin' ), 'slug' => 'light-dark-green', 'color' => '#CBD6DB' ],
		[ 'name' => __( 'Light Blue', 'wikimedia-contest-admin' ), 'slug' => 'light-blue', 'color' => '#C3D8EF' ],
		[ 'name' => __( 'Light Bright Blue', 'wikimedia-contest-admin' ), 'slug' => 'light-brightblue', 'color' => '#C0E6FF' ],
		[ 'name' => __( 'Light Bright Yellow', 'wikimedia-contest-admin' ), 'slug' => 'light-bright-yellow', 'color' => '#F9F9F0' ],
		[ 'name' => __( 'Light Green', 'wikimedia-contest-admin' ), 'slug' => 'light-green', 'color' => '#CBE0D5' ],
		[ 'name' => __( 'Light Bright Green', 'wikimedia-contest-admin' ), 'slug' => 'light-bright-green', 'color' => '#DBF3EC' ],
	] );
}
