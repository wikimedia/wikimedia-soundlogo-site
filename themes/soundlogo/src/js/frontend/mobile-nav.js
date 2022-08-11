/**
 * Mobile nav markup for language switcher.
 *
 * @package
 */

const _languagePicker = document.querySelector(
	'[data-dropdown="language-switcher"]'
);

/**
 * Ensures that the language switcher prevents document scrolling.
 *
 * The admin bar can be sticky at some viewport sizes, which throws off the
 * positioning of the site header and language dropdown. This fixes that issue
 * by scrolling up to the top of the page and locking body scrolling while the
 * language dropdown is open.
 *
 * @param {Event} Click event on the toggle button.
 */
const toggleLanguagePicker = ( { target } ) => {

	// Set a timeout to allow other listeners to complete first.
	setTimeout( () => {
		window.scrollTo( 0, 0 );
		document.body.classList.toggle(
			'disable-body-scrolling',
			target.getAttribute( 'aria-expanded' ) === 'true'
		);
	} );
};

/**
 * Attach event listener to dropdown toggle button.
 */
const init = () => {
	if ( ! _languagePicker ) {
		return;
	}

	_languagePicker.addEventListener( 'click', toggleLanguagePicker );
};

document.addEventListener( 'DOMContentLoaded', init );
