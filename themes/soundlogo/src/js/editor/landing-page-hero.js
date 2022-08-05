const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls, RichText, useBlockProps } = wp.blockEditor;
const { SelectControl, Panel, PanelBody, } = wp.components;
const { __ } = wp.i18n;

const addNewAttributes = ( settings, name ) => {
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
    addNewAttributes,
);


const customCtaButtonStyleControl = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {

		if ( props.name !== 'shiro/landing-page-hero' ) {
			return <BlockEdit { ...props } />;
		}

		const blockProps = useBlockProps( { className: 'hero' } );
		console.log(blockProps);

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
    customCtaButtonStyleControl,
);


const addCtaButtonStyleClass = createHigherOrderComponent( ( BlockListBlock ) => {
    return ( props ) => {
		if ( props.name !== 'shiro/landing-page-hero' ) {
			return <BlockEdit { ...props } />;
		}

		console.log(props.wrapperProps);

		const { attributes } = props;
		const { ctaButtonStyle } = attributes;

		if ( ctaButtonStyle ) {
			return <BlockListBlock { ...props } className={ `hero__cta__button--${ ctaButtonStyle }` } />
		} else {
			return <BlockListBlock { ...props } />
		}
    };
}, 'addCtaButtonStyleClass' );

wp.hooks.addFilter(
    'editor.BlockListBlock',
    'soundlogo/landing-page-hero/custom-cta-class',
    addCtaButtonStyleClass
);


// const saveCtaClassAttribute = ( extraProps, blockType, attributes ) => {
// 	//console.log(extraProps, blockType, attributes);
// 	// if ( props.name === 'shiro/landing-page-hero' ) {
//     //     const { ctaButtonStyle } = attributes;
//     //     if ( ctaButtonStyle ) {
//     //         extraProps.className = classnames( extraProps.className, 'hero__cta-button--' + ctaButtonStyle )
//     //     }
//     // }

//     return extraProps;

// };
// wp.hooks.addFilter(
//     'blocks.getSaveContent.extraProps',
//     'soundlogo/landing-page-hero/save-cta-class-attribute',
//     saveCtaClassAttribute,
// );
