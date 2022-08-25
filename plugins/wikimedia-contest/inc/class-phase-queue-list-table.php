<?php
/**
 * List table for rendering queues for each contest status.
 *
 * @extends WP_PostsList_Table
 *
 * phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols
 */

namespace Wikimedia_Contest;

use WP_Posts_List_Table;

/**
 * Generic list table for displaying submissions on all statuses.
 */
class Phase_Queue_List_Table extends WP_Posts_List_Table {

	/**
	 * This property stores the phase of submissions to be displayed.
	 * @var string
	 */
	public $scoring_phase;

	/**
	 * Override some base controls from the parent class.
	 *
	 * @param string $scoring_phase The phase of scoring to display.
	 */
	public function __construct( $scoring_phase ) {
		$this->scoring_phase = $scoring_phase;
		parent::__construct( [
			'singular' => 'Sound Logo Entry',
			'plural'   => 'Sound Logo Entries',
			'screen' => 'edit-submission-phase-queue',
			'ajax'     => false,
		] );
	}

	/**
	 * Prepare the current query for display.
	 */
	function prepare_items() {
		global $wp_query, $per_page;

		// phpcs:disable HM.Security.NonceVerification.Recommended
		// phpcs:disable HM.Security.ValidatedSanitizedInput.MissingUnslash
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		// phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$per_page = $this->get_items_per_page( 'edit_submissions_per_page', 20 );
		$paged = absint( $_REQUEST['paged'] ?? 1 );

		// Set up global WP_Query vars.
		query_posts( [
			'post_type' => 'submission',
			'post_status' => $this->scoring_phase,
			'per_page' => $per_page ?? 20,
			'orderby' => $_REQUEST['orderby'] ?? 'date',
			'order' => $_REQUEST['order'] ?? 'desc',
			'paged' => $_REQUEST['paged'] ?? 1,
			'cache_results' => false,
		] );

		// phpcs:enable HM.Security.NonceVerification.Recommended
		// phpcs:enable HM.Security.ValidatedSanitizedInput.MissingUnslash
		// phpcs:enable WordPress.Security.NonceVerification.Recommended
		// phpcs:enable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		$this->set_pagination_args( [
			'total_items' => $wp_query->found_posts,
			'total_pages' => $wp_query->max_num_pages,
			'per_page' => $per_page,
		] );

		$this->items = $wp_query->posts;
	}

	/**
	 * Get a list of columns.
	 *
	 * @return [] Array of column slugs to titles.
	 */
	function get_columns() {
		$custom_post_statuses = get_post_stati( [
			'_builtin' => false,
			'internal' => false,
		], 'objects' );

		$columns = [
			'col_submission_id'   => 'Submission ID',
			'col_submission_date' => 'Submission Date',
			'col_user_score'      => 'Score Given by You',
		];

		if ( \Wikimedia_Contest\Scoring\user_has_scoring_leader_capability() ) {
			$columns["col_phase_score"] = '"' . $custom_post_statuses[ $this->scoring_phase ]->label . "\" Phase Score";
		}

		return $columns;
	}

	/**
	 * Define the columns which should be sortable.
	 *
	 * @return [] Array of column slugs to query arg.
	 */
	function get_sortable_columns() {

		$columns = [
			'col_submission_id'   => 'title',
			'col_submission_date' => [ 'date', true ],
		];

		if ( \Wikimedia_Contest\Scoring\user_has_scoring_leader_capability() ) {
			$columns['col_phase_score'] = [ 'phase_score', true ];
		}

		return $columns;
	}

	/**
	 * Render the "row actions" available to a user.
	 *
	 * @param WP_Post $item Post being output.
	 * @param string $column_name Column being output.
	 * @param string $primary Primary column in table.
	 */
	function handle_row_actions( $item, $column_name, $primary ) {
		if ( $primary !== $column_name ) {
			return;
		}

		$submission_link = Scoring\get_scoring_link( $item->ID );
		$link_label = 'Scoring Submission';

		$actions = [
			'screen' => '<a href="' . esc_url( $submission_link ) . '">' . esc_html( $link_label ) . '</a>',
		];

		return $this->row_actions( $actions );
	}

	/**
	 * Remove bulk actions.
	 *
	 * @return [] Empty array - no bulk actions available in this view.
	 */
	function get_bulk_actions() {
		return [];
	}

	/**
	 * Render the submission ID column.
	 */
	function column_col_submission_id() {
		the_title();
	}

	/**
	 * Render the submission date column.
	 */
	function column_col_submission_date( $item ) {
		// Use core's date format strings for proper localization.
		// phpcs:disable HM.Security.EscapeOutput.OutputNotEscaped
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo sprintf(
			__( '%1$s at %2$s' ),
			get_the_time( __( 'Y/m/d' ), $item ),
			get_the_time( __( 'g:i a' ), $item )
		);
		// phpcs:enable HM.Security.EscapeOutput.OutputNotEscaped
		// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render the phase score column.
	 */
	function column_col_phase_score( $item ) {
		$score = get_post_meta( $item->ID, "score_{$this->scoring_phase}", true );
		echo is_numeric( $score ) ? round( $score, 2) : '-';
	}

	/**
	 * Render the score given by user column on the phase.
	 */
	function column_col_user_score( $item ) {
		$score = Scoring\get_submission_score( $item->ID, get_current_user_id(), $this->scoring_phase )['overall'];
		echo is_numeric( $score ) ? round( $score, 2) : '-';
	}
}
