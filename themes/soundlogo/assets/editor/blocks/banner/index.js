/**
 * Custom settings for banner custom block.
 */

import { useBlockProps, RichText } from '@wordpress/block-editor';
import { useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const { addFilter } = wp.hooks;

function filterBannerAlignSupport(settings, name) {
	if (name === 'shiro/banner') {

		console.log(settings);

		settings.supports.align = ['full', 'wide', 'center'];

		settings.attributes = {
			align: {
				type: 'string',
				default: 'wide',
			},
		};

		settings.edit = (props) => {

			const { attributes, setAttributes } = props;

			const {
				heading,
				text,
				buttonText,
				url,
				imageID,
				imageSrc,
				imageFilter,
				align,
			} = attributes;

			const blockProps = useBlockProps( {
				className: 'banner',
			} );

			const onImageChange = useCallback( ( { id, src, alt } ) => {
				setAttributes( {
					imageID: id,
					imageSrc: src,
					imageAlt: alt,
				} );
			}, [ setAttributes ] );

			const onChangeLink = useCallback( url => {
				setAttributes( {
					url,
				} );
			}, [ setAttributes ] );

			const onChangeText = useCallback( text => {
				setAttributes( {
					buttonText: text,
				} );
			}, [ setAttributes ] );

			const onChangeAlign = useCallback( align => {
				setAttributes( {
					align: align,
				} );
			}, [ setAttributes ] );

			return (
				<div { ...applyDefaultStyle( blockProps ) } >

					<div className="banner__content {align}">
						<RichText
							allowedFormats={ [ 'core/bold', 'core/italic' ] }
							className="banner__heading is-style-h4"
							keepPlaceholderOnFocus
							placeholder={ __( 'Heading for banner', 'shiro-admin' ) }
							tagName="h2"
							value={ heading }
							onChange={ heading => setAttributes( { heading } ) }
						/>
						<RichText
							allowedFormats={ [ 'core/bold', 'core/italic' ] }
							className="banner__text"
							placeholder={ __( 'Enter the message for this banner.', 'shiro-admin' ) }
							tagName="p"
							value={ text }
							onChange={ text => setAttributes( { text } ) }
						/>
						<Cta
							className="banner__cta"
							text={ buttonText }
							url={ url }
							onChangeLink={ onChangeLink }
							onChangeText={ onChangeText }
						/>
					</div>

					<ImageFilter
						className="banner__image-wrapper"
						value={ imageFilter }
						onChange={ imageFilter => setAttributes( { imageFilter } ) }>
						<ImagePicker
							className="banner__image"
							id={ imageID }
							imageSize={ 'medium_large' }
							src={ imageSrc }
							onChange={ onImageChange }
						/>
					</ImageFilter>

					<div className="banner__controls">
						<ButtonGroup align={align} onChange={onChangeAlign}>
							<Button icon="align-full" label={__('Full', 'shiro-admin')} value="full" />
							<Button icon="align-wide" label={__('Wide', 'shiro-admin')} value="wide" />
							<Button icon="align-center" label={__('Center', 'shiro-admin')} value="center" />
						</ButtonGroup>
					</div>

				</div>
			);
		};

		settings.save = function BannerSave( { attributes } ) {
			const {
				heading,
				text,
				buttonText,
				url,
				imageSrc,
				imageAlt,
				imageID,
				imageFilter,
			} = attributes;

			const blockProps = useBlockProps.save( {
				className: 'banner',
			} );

			return (
				<div { ...applyDefaultStyle( blockProps ) } >
					<div className="banner__content">
						<RichText.Content
							className="banner__heading"
							tagName="h4"
							value={ heading }
						/>
						<RichText.Content
							className="banner__text"
							tagName="p"
							value={ text }
						/>
						<Cta.Content
							className="banner__cta"
							text={ buttonText }
							url={ url }
						/>
					</div>
					<ImageFilter.Content
						className="banner__image-wrapper"
						value={ imageFilter }>
						<ImagePicker.Content
							alt={ imageAlt }
							className="banner__image"
							id={ imageID }
							imageSize={ 'medium_large' }
							src={ imageSrc }
						/>
					</ImageFilter.Content>
				</div>
			);
		};
	}
	return settings;
}

addFilter(
	'blocks.registerBlockType',
	'shiro/banner',
	filterBannerAlignSupport,
);

