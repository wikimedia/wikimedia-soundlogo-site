<?php
/**
 * Control pages for each custom status.
 *
 * @package wikimedia-contest;
 */

namespace Wikimedia_Contest\Custom_Stati_Pages;

/**
 * Bootstrap scoring results related functionality.
 *
 * @return void
 */
function bootstrap() : void {
	add_action( 'admin_menu', __NAMESPACE__ . '\\register_custom_stati_pages' );
}

function register_custom_stati_pages() : void {

	$current_contest_phase_option = get_site_option( 'contest_status' );

	$custom_post_statuses = get_post_stati( [
		'_builtin' => false,
		'internal' => false,
	], 'objects' );

	add_menu_page(
		sprintf( 'Current Phase: %s', $custom_post_statuses[ $current_contest_phase_option ]->label ),
		sprintf( 'Current Phase: %s', $custom_post_statuses[ $current_contest_phase_option ]->label ),
		'edit_posts',
		'custom-stati-pages',
		__NAMESPACE__ . '\\render_current_phase_page',
		'dashicons-feedback',
		3
	);

	foreach ( $custom_post_statuses as $custom_post_status ) {
		$custom_post_status_name = $custom_post_status->name;
		$custom_post_status_label = $custom_post_status->label;

		add_submenu_page(
			'custom-stati-pages',
			$custom_post_status_label,
			$custom_post_status_label,
			'edit_posts',
			$custom_post_status_name,
			__NAMESPACE__ . '\\render_custom_page',
			( $current_contest_phase_option === $custom_post_status->name ) ? 'dashicons-star-filled' : 'dashicons-marker',
		);
	}
}

function render_current_phase_page() : void {
	require_once __DIR__ . '/class-custom-queue-list-table.php';
	$list_table = new Custom_Queue_List_Table( get_site_option( 'contest_status' ) );
	$list_table->prepare_items();

	echo '<div id="scoring-queue" class="wrap">';
	echo '<h1 class="wp-heading-inline">' . esc_html__( 'Scoring Queue', 'wikimedia-contest-admin' ) . '</h1>';
	echo '<hr class="wp-header-end">';

	$list_table->display();

	echo '</div>';
}
