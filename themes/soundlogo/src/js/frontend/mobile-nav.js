/**
 * Mobile nav markup for language switcher.
 *
 * @package
 */

const _languagePicker = document.querySelector(
	'[data-dropdown="language-switcher"]'
);

/**
 * Handle document focus and scroll trapping when toggling the language picker.
 *
 * @param {Event} Click event on the language-switcher button.
 */
const controlContentInteraction = ( { target } ) => {
	if ( target.getAttribute( 'aria-expanded' ) === 'true' ) {
		disableContentInteraction();
	} else if ( target.getAttribute( 'aria-expanded' ) === 'false' ) {
		enableContentInteraction();
	}
};

/**
 * Handle the escape key when the language switcher menu is open.
 *
 * @param {Event} Keydown event
 */
const handleKeyPress = ( { keyCode } ) => {
	if ( keyCode === 27 ) { // esc
		enableContentInteraction();
	}
};

/**
 * Disable scrolling when the language switcher is open.
 */
const disableContentInteraction = () => {
	window.scrollTo( 0, 0 );
	document.body.classList.toggle( 'disable-body-scrolling', true );
	document.addEventListener( 'keydown', handleKeyPress );
};

/**
 * Re-enable scrolling when the language switcher is closed.
 */
const enableContentInteraction = () => {
	document.body.classList.toggle( 'disable-body-scrolling', false );
	document.removeEventListener( 'keydown', handleKeyPress );
};

/**
 * Attach event listener to dropdown toggle button.
 */
const init = () => {
	if ( ! _languagePicker ) {
		return;
	}
	_languagePicker.addEventListener( 'click', controlContentInteraction );
};

document.addEventListener( 'DOMContentLoaded', init );
