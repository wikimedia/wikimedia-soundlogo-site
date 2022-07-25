/**
 * Custom settings for banner custom block.
 */

 const { addFilter } = wp.hooks;

function filterBannerAlignSupport(settings, name) {
	console.log(settings); if (name === 'shiro/banner') {

		settings.supports.align = ['full', 'wide', 'center'];

		settings.attributes = {
			align: {
				type: 'string',
				default: 'wide',
			},
		};


	}
	return settings;
}

addFilter(
	'blocks.registerBlockType',
	'shiro/banner',
	filterBannerAlignSupport,
);

