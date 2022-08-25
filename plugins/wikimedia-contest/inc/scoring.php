<?php
/**
 * Scoring results for submissions.
 *
 * Scoring results will be stored in the comments table using the 'workflow'
 * comment type. We use the 'comment_agent' field in that table to mark these comments as scoring
 *
 * @package wikimedia-contest;
 */

namespace Wikimedia_Contest\Scoring;

use Wikimedia_Contest\Post_Type;
use Wikimedia_Contest\Scoring_Queue_List_Table;

/**
 * User role for scorers.
 *
 * @var string
 */
const PANELIST_USER_ROLE = 'scoring_panel';

/**
 * User role for scoring panel leads.
 *
 * @var string
 */
const PANEL_LEAD_USER_ROLE = 'scoring_panel_lead';

/**
 * User roles allowed to score.
 *
 * @var string
 */
const ALLOWED_SCORING_ROLES = [
	'administrator',
	'scoring_panel',
	'scoring_panel_lead',
];

/**
 * Comment type used to store editorial comments.
 *
 * @var string
 */
const COMMENT_TYPE = 'workflow';

/**
 * Name used in the comment agent to identify these comments.
 *
 * @var string
 */
const COMMENT_AGENT = 'scoring_comment';

/**
 * Statuses used in the scoring process.
 *
 * @var array
 */
const SCORING_STATUSES = [
	'scoring_phase_1',
	'scoring_phase_2',
	'scoring_phase_3',
];

/**
 * Abstracts the score categories, weights and criteria.
 *
 * @var array
 */
const SCORING_CRITERIA = [
	'conceptual' => [
		'weight'   => 0.5,
		'label'    => 'Conceptual Match (%d%% weighting)',
		'criteria' => [
			'represent_spirit' => 'To what extent does the sound represent the spirit of the Wikimedia movement?',
			'closely_communicate' => 'How closely does the sound communicate one of the creative prompts?',
			'feel_human' => 'To what extent does it feel human, inspired, smart and warm?',
		]
	],
	'originality' => [
		'weight'   => 0.25,
		'label'    => 'Originality (%s%% weighting)',
		'criteria' => [
			'original_unique' => 'To what extent does the sound feel original and unique?',
			'stand_out' => 'How much does it stand out compared to other sound logos?',
		]
	],
	'recallability' => [
		'weight'   => 0.25,
		'label'    => 'Recallability (%s%% weighting)',
		'criteria' => [
			'feel_recall' => 'How easily do you feel you could recall the sound logo?',
			'easy_replicate' => 'How easily do you feel you would be able to replicate (sing / hum / tap) the sound logo?',
		]
	],
];

/**
 * Bootstrap scoring results related functionality.
 *
 * @return void
 */
function bootstrap() : void {
	add_action( 'init', __NAMESPACE__ . '\\register_scorer_roles' );
	add_action( 'init', __NAMESPACE__ . '\\support_editorial_comments' );
	add_action( 'admin_menu', __NAMESPACE__ . '\\register_scoring_menu_pages' );
	add_action( 'bulk_actions-edit-submission', __NAMESPACE__ . '\\add_bulk_assignment_controls' );
	add_action( 'bulk_actions-edit-submission-scoring-queue', __NAMESPACE__ . '\\add_bulk_assignment_controls' );
	add_action( 'handle_bulk_actions-edit-submission', __NAMESPACE__ . '\\handle_bulk_assignment_controls', 10, 3 );
	add_action( 'handle_bulk_actions-edit-submission-scoring-queue', __NAMESPACE__ . '\\handle_bulk_assignment_controls', 10, 3 );
	add_filter( 'wp_list_table_show_post_checkbox', __NAMESPACE__ . '\\show_bulk_actions_cb_for_panelist_leads', 10, 2 );
}

/**
 * Register scoring panelist and panelist lead roles.
 *
 * @return void
 */
function register_scorer_roles() : void {
	$roles = get_option( 'wikimedia_contest_roles' ) ?: [];

	if ( ! isset( $roles[ PANELIST_USER_ROLE ] ) ) {
		wpcom_vip_add_role(
			PANELIST_USER_ROLE,
			__( 'Scoring Panel', 'wikimedia-contest-admin' ),
			array_merge(
				get_role( 'contributor' )->capabilities,
				[
					'score_submissions' => true,
					'view_scored_submissions' => false,
				]
			)
		);
		$roles[ PANELIST_USER_ROLE ] = 1;
		update_option( 'wikimedia_contest_roles', $roles );
	}

	if ( ! isset( $roles[ PANEL_LEAD_USER_ROLE ] ) ) {
		wpcom_vip_add_role(
			PANEL_LEAD_USER_ROLE,
			__( 'Scoring Panelist Lead', 'wikimedia-contest-admin' ),
			array_merge(
				get_role( 'editor' )->capabilities,
				[
					'score_submissions' => true,
					'assign_scorers' => true,
					'promote_submissions' => true,
				]
			)
		);

		$roles[ PANEL_LEAD_USER_ROLE ] = 1;
		update_option( 'wikimedia_contest_roles', $roles );
	}
}

/**
 * Render the Scoring interface.
 *
 * @return void
 */
function render_scoring_interface() : void {
	$post_id = sanitize_text_field( $_REQUEST['post'] ?? null );
	if ( ! $post_id ) {
		wp_safe_redirect( admin_url( 'admin.php?page=phase-queue-pages' ) );
		exit;
	}

	if ( ! empty( sanitize_text_field( $_POST['_score_submission_nonce'] ) ) ) {
		handle_scoring_results();
	}

	require_once dirname( __DIR__ ) . '/templates/scoring-interface.php';
}

/**
 * Get a link to edit a submission post.
 *
 * @param int $submission_id Submission ID.
 * @return string Scoring interface URL for this post.
 */
function get_scoring_link( $submission_id ) {
	return add_query_arg(
		[
			'page' => 'score-submission',
			'post' => $submission_id,
		],
		admin_url( 'admin.php' )
	);
}

/**
 * Handle user-submitted scoring results.
 *
 * @return void
 */
function handle_scoring_results() : void {
	check_admin_referer( 'score-submission', '_score_submission_nonce' );

	$post_id = sanitize_text_field( $_REQUEST['post'] ?? null );

	if ( ! current_user_can( 'score-submissions' ) ) {
		return;
	}

	// Iterate over $_POST and save fields that starts with 'scoring_criteria_' string.
	$scoring_criteria = [];
	foreach ( $_POST as $key => $value ) {
		if ( strpos( $key, 'scoring_criteria_' ) === 0 ) {
			$scoring_criteria[ $key ] = $value;
		}
	}
	$additional_comment = sanitize_text_field( $_POST['additional_scoring_comment'] ?? '' );

	$results = [
		'scoring' => $scoring_criteria,
		'additional_comment' => $additional_comment,
	];

	add_scoring_comment( $post_id, $results, get_current_user_id() );
	wp_safe_redirect( admin_url( 'admin.php?page=phase-queue-pages' ) );
	exit;
}

/**
 * Ensure that the post type registers support for editorial comments.
 *
 * In order to allow for easier access to an edit trail for scoring and
 * scoring on these posts, we'll reuse the 'workflow' comment_type, which
 * enables the Editorial Comments metabox.
 *
 * @return void
 */
function support_editorial_comments() : void {
	add_post_type_support( Post_Type\SLUG, 'editorial-comments' );
}

/**
 * Insert a new scoring comment.
 *
 * @param int   $submission_id Post ID of submission being scoreed.
 * @param array $results Scoring result fields.
 *   @var array  'scoring'            All scores given by user to each scoring fields
 *   @var string 'additional_comment' Free-text message field for additional comments.
 * @param int   $user_id User ID for the user who is scoring.
 *
 * @return void
 */
function add_scoring_comment( int $submission_id, array $results, $user_id ) : void {

	// Inactivate any existing scoring comments from this user.
	inactivate_user_scoring_comments( $submission_id, $user_id );

	// Invalid values should not come through, but it's better to be safe than sorry.
	$results['scoring'] = array_map( 'absint', $results['scoring'] );

	$given_score = wp_json_encode( $results['scoring'] );

	wp_insert_comment( [
		'comment_post_ID' => $submission_id,
		'comment_type' => COMMENT_TYPE,
		'comment_agent' => COMMENT_AGENT,
		'comment_author' => get_userdata( $user_id )->user_nicename ?? get_bloginfo( 'name' ),
		'comment_content' => null,
		'comment_meta' => [
			'given_score' => $given_score,
			'additional_comment' => $results['additional_comment'] ?? null,
			'scoring_phase' => get_site_option( 'contest_status' ),
		],
		'comment_status' => 'approve',
		'user_id' => $user_id,
	] );

	// Update the submission overall weighted score.
	$submission_overall_score = get_submission_score( $submission_id );
	update_post_meta( $submission_id, 'score_overall', $submission_overall_score['overall'] );

	// Update the submission overall weighted score for current contest phase.
	$current_contest_phase = get_site_option( 'contest_status' );
	$submission_current_phase_score = get_submission_score( $submission_id, null, $current_contest_phase );
	update_post_meta( $submission_id, 'score_' . $current_contest_phase, $submission_current_phase_score['overall'] );
}

/**
 * Get user assigned score on the specified post.
 *
 * @param int $submission_id Post ID of the submission to retrieve results for.
 * @param int $user_id_id User ID which inserted scoring comments.
 *
 * @return array Scoring results given by user
 *  @var array  'criteria'           All scores given by user to each scoring fields.
 *  @var string 'additional_comment' Free-text message field for additional comments.
  */
function get_submission_score_given_by_user( $submission_id, $user_id ) : ?array {
	$comments = get_comments( [
		'post_id' => $submission_id,
		'type' => COMMENT_TYPE,
		'agent' => COMMENT_AGENT,
		'status' => 'approve',
		'user_id' => $user_id,
	] );

	$comment = end( $comments );
	if ( ! $comment ) {
		return null;
	}

	$given_score = [];

	$given_score['criteria'] = json_decode( get_comment_meta( $comment->comment_ID, 'given_score', true ), true );

	// not natural values should not be here, but we never know.
	$given_score['criteria'] = array_map( 'absint', $given_score['criteria'] );

	$given_score['additional_comment'] = get_comment_meta( $comment->comment_ID, 'additional_comment', true );

	return $given_score;
}

/**
 * Get the overall (phase-specific) score for the provided post.
 *
 * @param int $submission_id Post ID of the submission to retrieve results for.
 * @param int $user_id User ID which inserted scoring comments.
 *
 * @return array|null Scoring results, or null if no results found.
 */
function get_submission_score( $submission_id, $user_id = null, $phase = null ) {

	$comment_search_args = [
		'post_id' => $submission_id,
		'type' => COMMENT_TYPE,
		'agent' => COMMENT_AGENT,
		'status' => 'approve',
	];

	if ( $user_id !== null ) {
		$comment_search_args['user_id'] = $user_id;
	}

	if ( $phase !== null ) {
		$comment_search_args['meta_query'] = [
			'key' => 'scoring_phase',
			'value' => $phase,
			'compare' => '=',
		];
	}

	$comments = get_comments( $comment_search_args );
	if ( empty( $comments ) ) {
		return null;
	}

	$category_sum = [];
	foreach ( $comments as $comment ) {
		$comment_score_content = json_decode( get_comment_meta( $comment->comment_ID, 'given_score', true ), true );
		foreach ( SCORING_CRITERIA as $category_id => $value ) {
			foreach ( $value['criteria'] as $criteria_id => $_ ) {
				$category_sum[ $category_id ]['sum'] += $comment_score_content["scoring_criteria_{$category_id}_{$criteria_id}"];
				$category_sum[ $category_id ]['item_count']++;
			}
		}
	}

	$weighted_score = [];
	foreach ( SCORING_CRITERIA as $category_id => $value ) {
		$weighted_score['overall'] += ( $category_sum[ $category_id ]['sum'] / $category_sum[ $category_id ]['item_count'] ) * $value['weight'];
		$weighted_score['by_category'][ $category_id ] = $category_sum[ $category_id ]['sum'] / $category_sum[ $category_id ]['item_count'];
	}

	if ( array_sum( $weighted_score['by_category'] ) === 0 || $weighted_score['overall'] === 0 ) {
		return null;
	}

	return $weighted_score;
}

/**
 * Inactivate all past comments from the user, so we don't calculate them but keep the record.
 *
 * @param int $submission_id Post ID of the submission to retrieve results for.
 * @param int $user_id User ID which inserted scoring comments.
 *
 * @return void
  */
function inactivate_user_scoring_comments( $submission_id, $user_id ) : void {
	$comments = get_comments( [
		'post_id' => $submission_id,
		'type' => COMMENT_TYPE,
		'agent' => COMMENT_AGENT,
		'status' => 'approve',
		'user_id' => $user_id,
	] );

	foreach ( $comments as $comment ) {
		wp_set_comment_status( $comment->comment_ID, 'hold' );
	}
}

/**
 * Update bulk actions available for scorers in the submissions list table.
 *
 * @param [] $bulk_actions Items available in the bulk actions dropdown.
 * @return [] Updated bulk actions array.
 */
function add_bulk_assignment_controls( $bulk_actions ) {

	if ( current_user_can( 'assign_scorers' ) && in_array( get_post_status(), SCORING_STATUSES, true ) ) {
		$scoring_panel =
		$assignment_dropdown = [];

		foreach ( get_scoring_panel_members() as $user ) {
			$assignment_dropdown[ "assign-{$user->ID}" ] = sprintf(
				__( 'Assign %s', 'wikimedia-contest-admin' ),
				$user->display_name
			);
		}

		$bulk_actions[ __( 'Assign to', 'wikimedia-contest-admin' ) ] = $assignment_dropdown;

		$bulk_actions['remove-assignees'] = __( 'Remove assignees', 'wikimedia-contest-admin' );
	}

	if ( ! current_user_can( 'edit_submissions' ) ) {
		unset( $bulk_actions['edit'] );
		unset( $bulk_actions['trash'] );
	}

	return $bulk_actions;
}

/**
 * Allow panelist leads to see the bulk action checkboxes.
 *
 * The bulk actions functionality is normally only exposed to users with the
 * edit-posts cap. This ensures that even users who can't edit posts, but can
 * assign scorers, can use these controls.
 *
 * @param bool $show Whether to show the bulk actions checkbox.
 * @param WP_Post $post Post being rendered.
 * @return bool Whether to show the bulk checkbox.
 */
function show_bulk_actions_cb_for_panelist_leads( $show, $post ) {
	if ( in_array( $post->post_status, SCORING_STATUSES, true ) && current_user_can( 'assign_scorers' ) ) {
		$show = true;
	}

	return $show;
}

/**
 * Handle user-initiated bustom bulk actions.
 *
 * @param string $return_url URL of the page to return to after completion.
 * @param string $action Name of action being performed.
 * @param int[] $post_ids Array of IDs of posts checked.
 */
function handle_bulk_assignment_controls( $return_url, $action, $post_ids ) {

	if ( strpos( $action, 'assign-' ) === 0 ) {
		$user_id = intval( substr( $action, 7 ) );

		if ( in_array( $user_id, wp_list_pluck( get_scoring_panel_members(), 'ID' ), true ) ) {
			foreach ( $post_ids as $post_id ) {
				$assignees = get_post_meta( $post_id, 'assignees' ) ?: [];
				$assignees[] = $user_id;

				delete_post_meta( $post_id, 'assignees' );
				foreach ( array_unique( array_filter( $assignees ) ) as $assignee ) {
					add_post_meta( $post_id, 'assignees', $assignee );
				}
			}
		}
	}

	if ( $action === 'remove-assignees' ) {
		foreach ( $post_ids as $post_id ) {
			delete_post_meta( $post_id, 'assignees' );
		}
	}

	wp_safe_redirect( $return_url );
}

/**
 * Get all members of the scoring panel.
 *
 * @return WP_User[] All users with the scoring panel or panelist lead roles.
 */
function get_scoring_panel_members() {
	return get_users( [ 'role__in' => [ PANELIST_USER_ROLE, PANEL_LEAD_USER_ROLE ] ] );
}
