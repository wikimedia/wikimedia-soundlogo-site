<?php
/**
 * Control scoring pages for each contest status.
 *
 * @package wikimedia-contest;
 */

namespace Wikimedia_Contest\Phase_Status_Pages;
use Wikimedia_Contest\Phase_Queue_List_Table;

/**
 * Bootstrap scoring results related functionality.
 *
 * @return void
 */
function bootstrap() : void {
	add_action( 'admin_menu', __NAMESPACE__ . '\\register_custom_status_pages' );
	add_filter( 'manage_phase-queue-pages_sortable_columns', __NAMESPACE__ . '\\register_sortable_columns' );
	add_action( 'pre_get_posts', __NAMESPACE__ . '\\register_meta_orderby' );
}

/**
 * Register custom status pages.
 *
 * @return void
 */
function register_custom_status_pages() : void {

	$current_contest_phase_option = get_site_option( 'contest_status' );
	$custom_post_statuses = get_post_stati( [
		'_builtin' => false,
		'internal' => false,
	], 'objects' );

	if ( ! in_array( wp_get_current_user()->roles[0], \Wikimedia_Contest\Scoring\ALLOWED_SCORING_ROLES, true ) ) {
		return;
	}

	// Add a custom page named "Seeder" if is admin.
	if ( is_admin() && current_user_can( 'administrator' ) ) {
		add_menu_page(
			'Seeder',
			'Seeder',
			'edit_posts',
			'seeder',
			__NAMESPACE__ . '\\render_seeder_page',
			'dashicons-warning',
			3
		);
	}

	add_menu_page(
		sprintf( '<b>%s</b> Queue', $custom_post_statuses[ $current_contest_phase_option ]->label ),
		sprintf( '<b>%s</b> Queue', $custom_post_statuses[ $current_contest_phase_option ]->label ),
		'edit_posts',
		'phase-queue-pages',
		__NAMESPACE__ . '\\render_phase_status_page',
		'dashicons-feedback',
		2
	);

	if ( current_user_can( 'administrator' ) || current_user_can( 'scoring_panel_lead' ) ) {
		// Include a page for each custom status.
		foreach ( $custom_post_statuses as $custom_post_status ) {
			$custom_post_status_name = $custom_post_status->name;
			$custom_post_status_label = $custom_post_status->label;

			add_submenu_page(
				'phase-queue-pages',
				"{$custom_post_status_label} status",
				"{$custom_post_status_label} status",
				'edit_posts',
				"submissions-{$custom_post_status_name}",
				function() use ( $custom_post_status_name ) {
					call_user_func( __NAMESPACE__ . '\\render_phase_status_page', $custom_post_status_name );
				},
			);
		}
	}
}

/**
 * Render the proper page for each contest status.
 *
 * @param string $status_name The contest phase name.
 *
 * @return void
 */
function render_phase_status_page( $status_name = null ) : void {
	$status_name = $status_name ?: get_site_option( 'contest_status' );
	$custom_post_statuses = get_post_stati( [
		'_builtin' => false,
		'internal' => false,
	], 'objects' );

	require_once __DIR__ . '/class-phase-queue-list-table.php';
	$list_table = new Phase_Queue_List_Table( $status_name );
	$list_table->prepare_items();

	echo '<div id="scoring-queue" class="wrap">';
	echo '<h1 class="wp-heading-inline">Submissions on <b>' . esc_html( $custom_post_statuses[ $status_name ]->label ) . '</b> status</h1>';
	echo '<hr class="wp-header-end">';

	$list_table->display();

	echo '</div>';
}

/**
 * Returns the submission link for a given submission ID
 *
 * @param int $post_id Submission ID
 *
 * @return string Submission link
 */
function get_submission_link( $submission_id ) : string {
	return add_query_arg(
		[
			'page' => 'score-submission',
			'post' => $submission_id,
		],
		admin_url( 'admin.php' )
	);
}

/**
 * Register sortable columns for the phase queue list table.
 *
 * @param array $columns The sortable columns.
 *
 * @return array The sortable columns.
 */
function register_sortable_columns( $columns ) : array {
    $columns['col_overall_score'] = 'col_overall_score';

	$custom_post_statuses = get_post_stati( [
		'_builtin' => false,
		'internal' => false,
	], 'objects' );

	foreach ( $custom_post_statuses as $custom_post_status ) {
		$columns["col_{$custom_post_status->name}_score"] = "col_{$custom_post_status->name}_score";
	}

	return $columns;
}

/*
 * Register meta_orderby for the phase queue list table.
 *
 * @param WP_Query $wp_query The WP_Query object.
 *
 * @return void
 */
function register_meta_orderby( $query ) : void {
	$orderby = $query->get( 'orderby');

	if ( 'col_overall_score' == $orderby ) {
		$query->set('meta_key','score_overall');
		$query->set('orderby','meta_value_num');
	}

	$custom_post_statuses = get_post_stati( [
		'_builtin' => false,
		'internal' => false,
	], 'objects' );

	foreach ( $custom_post_statuses as $custom_post_status ) {
		if ( "col_{$custom_post_status->name}_score" == $orderby ) {
			$query->set('meta_key','score_' . $custom_post_status->name);
			$query->set('orderby','meta_value_num');
		}
	}
}

/**
 * Populate the database with Seeders, to use for testing.
 * It creates submissions, screening comments and scoring comments.
 * Use it changing the values and uncommenting code.
 * TODO: remove it before pushing to production.
 *
 * @return void
 */
function render_seeder_page() : void {

	// set error reporting to display all but no notice
	// ini_set( 'display_errors', 1 );
	// error_reporting( E_ALL & ~E_NOTICE );

	echo '<div id="scoring-queue" class="wrap">';
	echo '<h1 class="wp-heading-inline">Submissions seeder</h1>';
	echo '<hr class="wp-header-end">';

	$custom_post_statuses = get_post_stati( [
		'_builtin' => false,
		'internal' => false,
	], 'objects' );

	// create 10 random screeners.
	// $users = [];
	// for ( $i = 0; $i < 10; $i++ ) {
	// 	$random_number = rand(0,99999);
	// 	$user_id = wp_create_user( "Screener {$random_number}", "Screener {$random_number}", "miguel+screener-{$random_number}@humanmade.com" );
	// 	$users[] = $user_id;
	// 	$user = get_user_by( 'id', $user_id );
	// 	$user->set_role( 'screener' );
	// }
	// echo "<p>Created 10 screener users with the following IDs: " . implode( ', ', $users ) . "</p>";

	// create 10 random panelists.
	// $users = [];
	// for ( $i = 0; $i < 10; $i++ ) {
	// 	$random_number = rand(0,99999);
	// 	$user_id = wp_create_user( "Panelist {$random_number}", "Panelist {$random_number}", "miguel+panelist-{$random_number}@humanmade.com" );
	// 	$users[] = $user_id;
	// 	$user = get_user_by( 'id', $user_id );
	// 	$user->set_role( 'panelist' );
	// }
	// echo "<p>Created 10 panelist users with the following IDs: " . implode( ', ', $users ) . "</p>";

	// create 20 submissions on each of the custom statuses.
	for ( $i = 0; $i < 20; $i++ ) {
		$status = array_rand( $custom_post_statuses );
		$random_number = rand(0,99999);

		$post_id = wp_insert_post( [
			'post_title' => 'Seeder Submission ' . $random_number,
			'post_status' => $status,
			'post_type' => 'submission',
		] );
		echo "<p><b>Created submission with ID {$post_id}</b></p>";

		// Insert 3 screening comments from random screeners.
		$screeners = get_users( [
			'role' => 'screener',
		] );
		for ( $j = 0; $j < 3; $j++ ) {
			$screener = $screeners[ array_rand( $screeners ) ];
			$screening_case = array_rand( ['ineligible', 'eligible'] );
			$results = [
				'status' => $screening_case,
				'flags' => [],
				'message' => "Screening comment {$j}",
			];

			\Wikimedia_Contest\Screening_Results\add_screening_comment( $post_id, $results, $screener->ID );
			echo "<p>Added screening comment from screener {$screener->ID} to submission with ID: {$post_id}</p>";
		}

		// Insert 5 scoring comments for each phase from random panelists.
		$panelists = get_users( [
			'role' => 'panelist',
		] );

		foreach ( $custom_post_statuses as $custom_post_status ) {
			for ( $k = 0; $k < 5; $k++ ) {
				$panelist = $panelists[ array_rand( $panelists ) ];

				foreach ( \Wikimedia_Contest\Scoring\SCORING_CRITERIA as $category_id => $value ) {
					foreach ( $value['criteria'] as $criteria_id => $text ) {
						$score_criteria['scoring']["scoring_criteria_{$category_id}_{$criteria_id}"] = rand( 0, 10 );
					}
				}
				$score_criteria['additional_comment'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc euismod, nisi eget consectetur porta, nisl nisi consectetur nisi.";

				// here is the trick for inserting the scoring comments on different contest status.
				update_site_option( 'contest_status', $custom_post_status->name );

				\Wikimedia_Contest\Scoring\add_scoring_comment( $post_id, $score_criteria, $panelist->ID );
				echo "<p>Added scoring comment for panelist {$panelist->ID} to submission with ID: {$post_id} and phase {$custom_post_status->name}</p>";
			}
		}
	}
}
