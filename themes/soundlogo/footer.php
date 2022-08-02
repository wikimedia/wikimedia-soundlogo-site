<?php
/**
 * Wikimedia Sound Logo Footer Template
 *
 * @package wikimedia-contest
 */

// Get the Footer Reusable Block ID from the settings page.
$footer_reusable_block_id = (int) get_option( 'footer_reusable_block_id' );
if ( isset( $footer_reusable_block_id ) ) {
	$get_block = get_post( $footer_reusable_block_id );

	if ( is_a( $get_block, 'WP_Post' ) && $get_block->post_type === 'wp_block' ) {
		$block_content = $get_block->post_content;
		$footer_content = do_blocks( $block_content ) ?? '';
	}
}

?>

<?php if ( isset( $footer_content ) ) : ?>
<footer class="footer__container">
	<div class="footer__reusable-block">
		<?php
			// This content comes from a reusable block, and it needs to be displayed as it is.
			echo $footer_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
</footer>
<?php endif; ?>
