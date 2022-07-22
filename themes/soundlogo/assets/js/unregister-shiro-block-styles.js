/**
 * Unregister the undesired shiro block styles.
 */
wp.domReady( function () {

	const blockStyles = [
		'shiro/banner',
		'shiro/landing-page-hero',
		'shiro/spotlight',
	];

	const styles = [
		'base70',
		'base0',
		'blue90',
		'blue50',
		'red90',
		'red50',
		'yellow90',
		'yellow50',
		'donate-red90',
	];

	blockStyles.forEach( ( block ) => {
		styles.forEach( ( style ) => {
			wp.blocks.unregisterBlockStyle( block, style );
		} );
	} );
} );
