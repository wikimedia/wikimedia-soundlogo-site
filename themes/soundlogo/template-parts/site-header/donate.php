<?php
/**
 * Adds the "Learn more" link.
 *
 * Replaces the donate button from Shiro theme.
 *
 * @package wikimedia-contest
 */

$page_id = get_queried_object_id();
$uri     = get_theme_mod( 'wmf_donate_now_uri',
'https://donate.wikimedia.org/?utm_medium=wmfSite&utm_campaign=comms' );
$copy    = get_theme_mod( 'wmf_donate_now_copy', __( 'Submit', 'wikimedia-contest' ) );
?>

<div class="nav-donate">
	<a href="<?php echo esc_url( $uri ); ?>" class="nav-donate__link">
		<?php wmf_show_icon( 'musical-note', 'nav-donate__icon nav-donate__icon--musical-note' ); ?>
		<span class="nav-donate__copy">
			<?php echo esc_html( $copy ); ?>
		</span>
	</a>
</div>
