import { createElement } from "@wordpress/element";

/**
 * WordPress dependencies
 */
import { PanelRow } from '@wordpress/components';
import { PostSlug as PostSlugForm, PostSlugCheck } from '@wordpress/editor';
export function PostSlug() {
  return createElement(PostSlugCheck, null, createElement(PanelRow, null, createElement(PostSlugForm, null)));
}
export default PostSlug;
//# sourceMappingURL=index.js.map