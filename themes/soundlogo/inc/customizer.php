<?php
/**
 * Customizer controls available for Sound Logo theme.
 *
 * @package wikimedia-contest
 */

namespace Wikimedia_Contest\Theme\Customizer;

/**
 * Init functionality.
 */
function bootstrap() {
	add_action( 'customize_register', __NAMESPACE__ . '\customize_register', 11 ); // After shiro theme registers controls.
}

/**
 * Setup the customizer and store the customizer instance.
 *
 * @param object $wp_customize Full WP_Customizer object.
 */
function customize_register( $wp_customize ) {
	$sections = $wp_customize->sections();

	// Remove all Shiro theme footer controls.
	$removed_controls = [
		'wmf_footer_logo',
		'wmf_footer_text',
		'wmf_projects_menu_label',
		'wmf_movement_affiliates_menu_label',
		'wmf_other_links_menu_label',
		'wmf_footer_copyright',
	];

	foreach ( $removed_controls as $control_id ) {
		$wp_customize->remove_setting( $control_id );
		$wp_customize->remove_control( $control_id );
	}

	// Add customizer control for footer block.
	$available_blocks = get_posts( [
		'post_type' => 'wp_block',
		'numberposts' => -1,
	] );

	$wp_customize->add_setting( 'footer_reusable_block_id', [ 'type' => 'option' ] );

	$wp_customize->add_control(
		'footer_reusable_block_id',
		[
			'label' => __( 'Reusable Block to use for footer', 'wikimedia-contest-admin' ),
			'description' => __( 'Choose a block to hold footer content.', 'wikimedia-contest-admin' ),
			'section' => 'wmf_footer',
			'type' => 'select',
			'choices' => wp_list_pluck( $available_blocks, 'post_title', 'ID' ),
		]
	);

	return $wp_customize;
}


