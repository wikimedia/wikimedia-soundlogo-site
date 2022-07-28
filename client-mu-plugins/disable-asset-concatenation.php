<?php
/**
 * Plugin Name: Disable Asset Concatenation
 * Description: Disables VIP's default asset concatenation behavior.
 * Author: Human Made
 * Version: 0.1
 */

/**
 * Disable VIP's file concatenation and minification for CSS and JS assets.
 *
 * @see https://docs.wpvip.com/technical-references/vip-platform/file-concatenation-and-minification/
 *
 * We're managing versioning ourselves via filename-based version hash strings,
 * and this method doesn't work well with VIP's page caching strategy (even if
 * all aseets are versioned properly, there will still be broken assets after
 * every deploy because the file names change, and the page cache still has
 * references to the old hashes.
 */
add_filter( 'js_do_concat', '__return_false' );
add_filter( 'css_do_concat', '__return_false' );
