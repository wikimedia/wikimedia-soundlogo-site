/**
 * Handle in-page anchor links.
 *
 * Updates the "current menu item" selection when nevigating via in-page links,
 * as well as adjusts the scroll offset to compensate for the header height.
 *
 * @package wikimedia-contest
 */

const currentMenuItems = [ ...document.querySelectorAll( '.current-menu-item' ) ];

/**
 * If there are multiple menu items pointing to the current page, choose the
 * correct one by matching the document hash.
 *
 * @returns {HTMLElement[]}
 */
const updateCurrentMenuItem = () => {
	currentMenuItems.forEach( menuItem => {
		const { hash } = new URL(  menuItem.querySelector( 'a' ) );
		menuItem.classList.toggle( 'current-menu-item', window.location.hash === hash );
	} );
};

/**
 * Scroll to the element identified by the hash link, if it's present.
 *
 * @param {Event} event Click event on menu link.
 */
const handleAnchorLinkClick = event => {
	event.preventDefault();

	const { hash } = new URL( event.currentTarget );
	window.location.hash = hash;
	smoothScrollTo( hash );
	updateCurrentMenuItem();

	// Close the mobile dropdown, if it's open.
	if ( document.body.classList.contains( 'disable-body-scrolling' ) ) {
		document.querySelector( '.primary-nav-toggle' ).dispatchEvent( new Event( 'click' ) );
	}
};

/**
 * Scroll to the element identified by the hash link, if it's present.
 *
 * @param {string} hash Window location hash, with leading `#`.
 */
const smoothScrollTo = hash => {
	const target = document.getElementById( hash.substring( 1 ) );
	const headerHeight = document.querySelector( '.header-default' ).clientHeight;

	if ( target ) {
		window.scrollTo( {
			left: 0,
			top: target.offsetTop - headerHeight - 16,
			behavior: 'smooth',
		} );
	} else {
		window.scrollTo( {
			left: 0,
			top: 0,
			behavior: 'smooth',
		} );
	}
};

/**
 * Set current menu item on page load, and attach event listeners to other
 * anchor links.
 */
const init = () => {
	if ( currentMenuItems.length < 2 ) {
		return;
	}

	updateCurrentMenuItem();
	smoothScrollTo( document.location.hash );

	const links = currentMenuItems.map( listItem => listItem.querySelector( 'a' ) );

	links.forEach(
		link => link.addEventListener( 'click', handleAnchorLinkClick )
	);
};

document.addEventListener( 'DOMContentLoaded', init );
