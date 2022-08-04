const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { SelectControl, Panel, PanelBody, } = wp.components;
const { __ } = wp.i18n;

const assignNewAttributes = ( settings, name ) => {
	if ( name !== 'shiro/landing-page-hero' ) {
		return settings;
	}

	const ctaButtonStyle = {
		type: 'string',
		default: 'no-icon-blue-background',
	};

	const headingDescription = {
		type: 'string',
		source: 'html',
		selector: '.hero__description',
		multiline: 'p',
	};

	const currentSettings =  Object.assign( {}, settings, {
		attributes: Object.assign( {}, settings.attributes, {
			ctaButtonStyle: ctaButtonStyle,
			headingDescription: headingDescription,
		} ),
	} );

	return currentSettings;
};

wp.hooks.addFilter(
    'blocks.registerBlockType',
    'soundlogo/landing-page-hero/attributes',
    assignNewAttributes,
);


const customControls = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {

		if ( props.name !== 'shiro/landing-page-hero' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;
		const { ctaButtonStyle, headingDescription } = attributes;

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
    'soundlogo/landing-page-hero/custom-controls',
    customControls,
);
