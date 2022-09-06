"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.PostSlug = PostSlug;
exports.default = void 0;

var _element = require("@wordpress/element");

var _components = require("@wordpress/components");

var _editor = require("@wordpress/editor");

/**
 * WordPress dependencies
 */
function PostSlug() {
  return (0, _element.createElement)(_editor.PostSlugCheck, null, (0, _element.createElement)(_components.PanelRow, null, (0, _element.createElement)(_editor.PostSlug, null)));
}

var _default = PostSlug;
exports.default = _default;
//# sourceMappingURL=index.js.map