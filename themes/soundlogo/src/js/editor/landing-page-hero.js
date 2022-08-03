const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { SelectControl, Panel, PanelBody, } = wp.components;
const { __ } = wp.i18n;

const landingPageHeroCustomAttributes = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {

		if ( props.name !== 'shiro/landing-page-hero' ) {
			return <BlockEdit { ...props } />;
		}

		// const ctaButtonStyle = {
		// 	type: 'string',
		// 	default: 'no-icon-blue-background',
		// };

		// const headingDescription = {
		// 	type: 'string',
		// 	source: 'html',
		// 	selector: '.hero__description',
		// 	multiline: 'p',
		// };

		const ctaButtonStyle = 'no-icon-blue-background';
		const headingDescription = __( 'People all over the world ask their voice-activated devices all sorts of questions, and search engines query Wikipedia knowledge to provide them with answers. That is why we are looking to co-create a sound logo that will be played each time a person is served an answer to a question that was responded with Wikimedia projects.', 'shiro-admin' );

		const { attributes } = props;

		props.attributes = {
			...attributes,
			ctaButtonStyle,
			headingDescription,
		};

		console.log(props);

		const ctaButtonStyleOptions = [
			{ label: __( 'No icon / Blue background', 'shiro-admin' ), value: 'no-icon-blue-background' },
			{ label: __( 'Info icon / Gray background', 'shiro-admin' ), value: 'info-icon-gray-background' },
			{ label: __( 'Info icon / No background', 'shiro-admin' ), value: 'info-icon-no-background' },
			{ label: __( 'Expand icon / Gray background', 'shiro-admin' ), value: 'expand-icon-gray-background' },
		];

		const ctaButtonStyleControl = (
			<Panel>
				<PanelBody
					title={ __( 'Call-to-action button', 'shiro-admin' ) }
					initialOpen={ true }
				>
					<SelectControl
						label={ __( 'Button style', 'shiro-admin' ) }
						value={ ctaButtonStyle }
						options={ ctaButtonStyleOptions }
						onChange={ ( value ) => setAttributes( { ctaButtonStyle: value } ) }
					/>
				</PanelBody>
			</Panel>
		);


        return (
            <Fragment>
                <BlockEdit { ...props } />
				<InspectorControls key="setting">
					{ ctaButtonStyleControl }
				</InspectorControls>
            </Fragment>
        );
    };
}, 'descriptionField' );


wp.hooks.addFilter(
    'editor.BlockEdit',
    'soundlogo/landing-page-hero',
    landingPageHeroCustomAttributes
);
