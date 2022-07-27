/* global jQuery: false */

/*
 * Select all of the inputs inside GF field containers.
 *
 * @var {(DOMNodeList|[])}
 */
let inputs = [];

/**
 * Form IDs which appear on the current page.
 *
 * @var {number[]}
 */
let initializedForms = [];

/**
 * Find the Gravity Forms field container that an event took place in.
 *
 * @param {DOMEvent} event Event in a child node of the .gfield element.
 * @returns {*}
 */
const getGfieldContainer = event => {
	let { target } = event;

	for ( ; target && target !== document; target = target.parentElement ) {
		if ( target.classList.contains( 'gfield' ) ) {
			return target;
		}
	}
};

/**
 * Add a class to a form field container when focused.
 *
 * @param {DOMEvent} DOM focus event.
 */
const setFocusClass = event => getGfieldContainer( event ).classList.add( 'has-focus' );

/**
 * Remove the "has-focus" class from a form field container when it loses focus.
 *
 * @param DOMEvent DOM blur event.
 */
const removeFocusClass = event => getGfieldContainer( event ).classList.remove( 'has-focus' );

/**
 * Validate that a field has required value and update its class names appropriately.
 *
 * @param {DOMEvent} DOM input event.
 */
const validateFieldContent = event => {
	const inputField = event.target;
	const container = getGfieldContainer( event );

	const inputValue = inputField.value;

	if ( inputValue ) {
		container.classList.add( 'has-value' );
	} else {
		container.classList.remove( 'has-value' );
	}
};

/**
 * Auto Expand textarea as content is added.
 *
 * Method taken from:
 * https://gomakethings.com/automatically-expand-a-textarea-as-the-user-types-using-vanilla-javascript/
 */
const autoExpandTextarea = event => {
	const field = event.target;

	if ( field.tagName.toLowerCase() !== 'textarea' ) {
		return;
	}
	// Reset field height so that we can calculate how tall the content is/should be.
	field.style.height = 'inherit';

	// Get the computed styles for the element
	const computed = window.getComputedStyle( field );

	// Calculate the height including the bottom border.
	const height = field.scrollHeight
	             + parseInt( computed.getPropertyValue( 'border-bottom-width' ), 10 );

	field.style.height = `${height}px`;
}

/**
 * Scroll so that the form is centered on the page after submitting or
 * validating.
 *
 * @param {jQuery.Event} Custom 'gform_post_render_event'
 * @param {string} formID Current form ID.
 * @param {number} currentPage Page of form being displayed. Undefined for confirmation message.
 */
const scrollToBlockOnSubmit = ( event, formID, currentPage ) => {
	const form = document.querySelector( `#gf_${formID}` );

	// Since this is being fired every time a form is rendered (including on
	// page load) we want to be sure to exclude the initial page load.
	if ( ! ( form && initializedForms.includes( formID ) ) ) {
		initializedForms.push( formID );
		return;
	}

	// Operate on the form's parent, because the form element itself is removed and re-added.
	const formParent = form.parentElement.parentElement;
	formParent.focus( { preventScroll: true } );

	setTimeout( () => {
		formParent.scrollIntoView( {
			behavior: 'smooth',
			block: 'center',
		} );
	}, 200 );
};

/**
 * Attach event listeners to all form inputs on the page.
 */
const addInputListeners = () => {
	inputs = document.querySelectorAll( '.gfield input, .gfield select, .gfield textarea' );

	[ ...inputs ].forEach( input => {

		// If this is a second page of a form, recheck field content.
		validateFieldContent( { target: input } );

		input.addEventListener( 'focus', setFocusClass );
		input.addEventListener( 'blur', removeFocusClass );
		input.addEventListener( 'input', validateFieldContent );
		input.addEventListener( 'input', autoExpandTextarea );
	} );
};

/**
 * Remove event listeners from all form inputs on the page.
 */
const removeInputListeners = () => {
	[ ...inputs ].forEach( input => {
		input.removeEventListener( 'focus', setFocusClass );
		input.removeEventListener( 'blur', removeFocusClass );
		input.removeEventListener( 'input', validateFieldContent );
		input.removeEventListener( 'input', autoExpandTextarea );
	} );
};

/**
 * Mark up field containers in order to add CSS selectors to target.
 */
const markupFieldContainers = () => {

	// Mark up field containers which contain textareas or other full-width
	// form fields so that they don't get stacked on desktop views.
	const fullWidthContainers = [
		...document.querySelectorAll(
			[
				'.ginput_container_textarea',
				'.ginput_container_fileupload',
				'ginput_container_hcaptcha',
			].join( ',' )
		)
	];

	fullWidthContainers.forEach(
		container => container.closest( '.gfield' ).classList.add( 'gfield--fullwidth' )
	);
};

/**
 * Attach all event listeners to inputs.
 */
const init = () => {
	markupFieldContainers();
	addInputListeners();
};

/**
 * Refresh event listeners when a new form page is presented.
 */
const refreshListeners = () => {
	removeInputListeners();
	addInputListeners();
};

// Kick it all off!
document.addEventListener( 'DOMContentLoaded', init );

// Gravity Forms fires a jQuery event when rendering a new page. Update event
// listeners when that happens, because new input fields may be visible.
jQuery( document ).on( 'gform_post_render.reinitialize', refreshListeners );

// Whenever a new form page is rendered, scroll it into position in the viewport.
jQuery( document ).on( 'gform_post_render.scrollPosition', scrollToBlockOnSubmit );

// Handle HMR updates.
if ( module.hot ) {
	init();

	module.hot.dispose( () => {
		removeInputListeners();
		jQuery( document ).off( 'gform_post_render.scrollPosition' );
		jQuery( document ).off( 'gform_post_render.reinitialize' );
	} );

	module.hot.accept( init );
}
