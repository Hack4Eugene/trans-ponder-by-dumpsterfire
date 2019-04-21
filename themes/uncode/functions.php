<?php
define("ITEM_ID", "13373220");
define("ENVATO_KEY", "5OAZOzhz4IGXSkE7BLmT5UQ7kjALip11");

/**
 * uncode functions and definitions
 *
 * @package uncode
 */

$ok_php = true;
if ( function_exists( 'phpversion' ) ) {
	$php_version = phpversion();
	if (version_compare($php_version,'5.3.0') < 0) $ok_php = false;
}
if (!$ok_php && !is_admin()) {
	$title = esc_html__( 'PHP version obsolete','uncode' );
	$html = '<h2>' . esc_html__( 'Ooops, obsolete PHP version' ,'uncode' ) . '</h2>';
	$html .= '<p>' . sprintf( wp_kses( 'We have coded the Uncode theme to run with modern technology and we have decided not to support the PHP version 5.2.x just because we want to challenge our customer to adopt what\'s best for their interests.%sBy running obsolete version of PHP like 5.2 your server will be vulnerable to attacks since it\'s not longer supported and the last update was done the 06 January 2011.%sSo please ask your host to update to a newer PHP version for FREE.%sYou can also check for reference this post of WordPress.org <a href="https://wordpress.org/about/requirements/">https://wordpress.org/about/requirements/</a>' ,'uncode', array('a' => 'href') ), '</p><p>', '</p><p>', '</p><p>') . '</p>';

	wp_die( $html, $title, array('response' => 403) );
}


/**
 * Load the main functions.
 */
require_once get_template_directory() . '/core/inc/main.php';

/**
 * Load envato-toolkit
 */
//require_once get_template_directory() . '/core/inc/envato-toolkit/init.php';

/**
 * Load the admin functions.
 */
require_once get_template_directory() . '/core/inc/admin.php';

/**
 * Load the uncode export file.
 */
require_once get_template_directory() . '/core/inc/export/uncode_export.php';

/**
 * Font system.
 */
require_once get_template_directory() . '/core/font-system/font-system.php';

/**
* Update helpers.
*/
require_once get_template_directory() . '/core/inc/update-helpers.php';

/**
* Ajax system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/ajax.php';

/**
* Notification system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/notifications.php';

/**
* Communication system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/communication.php';

/**
* Patch system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/patches.php';

/**
 * Load the color system.
 */
require_once get_template_directory() . '/core/inc/colors.php';

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
require_once get_template_directory() . '/core/theme-options/assets/theme-mode/functions.php';

/**
 * Required: include OptionTree.
 */
load_template( get_template_directory() . '/core/theme-options/ot-loader.php' );

/**
 * Load the theme options.
 */
require_once get_template_directory() . '/core/theme-options/assets/theme-mode/theme-options.php';

/**
 * Load the main functions.
 */
require_once get_template_directory() . '/core/inc/performance.php';

/**

 * Load the theme meta boxes.
 */
require_once get_template_directory() . '/core/theme-options/assets/theme-mode/meta-boxes.php';

/**
 * Load TGM plugins activation.
 */
require_once get_template_directory() . '/core/plugins_activation/init.php';

/**
 * Load the media enhanced function.
 */
require_once( ABSPATH . WPINC . '/class-oembed.php' );
require_once get_template_directory() . '/core/inc/media-enhanced.php';

/**
 * Load the bootstrap navwalker.
 */
require_once get_template_directory() . '/core/inc/wp-bootstrap-navwalker.php';

/**
 * Load the bootstrap navwalker.
 */
require_once get_template_directory() . '/core/inc/uncode-comment-walker.php';

/**
 * Load menu builder.
 */
if ($ok_php) require_once get_template_directory() . '/partials/menus.php';

/**
 * Load header builder.
 */
if ($ok_php) require_once get_template_directory() . '/partials/headers.php';

/**
 * Load elements partial.
 */
if ($ok_php) require_once get_template_directory() . '/partials/elements.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/core/inc/template-tags.php';

/**
 * Helpers functions.
 */
require_once get_template_directory() . '/core/inc/helpers.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/core/inc/customizer.php';

/**
 * Customizer WooCommerce additions.
 */
if (class_exists( 'WooCommerce' )) {
	require_once get_template_directory() . '/core/inc/customizer-woocommerce.php';
}

/**
 * Load one click demo
 */
require_once get_template_directory() . '/core/one-click-demo/init.php';

/**
 * Load Jetpack compatibility file.
 */
require_once get_template_directory() . '/core/inc/jetpack.php';

/**
 * Load gallery functions
 */
require_once get_template_directory() . '/core/inc/galleries.php';

add_action( 'after_setup_theme', 'uncode_related_post_call' );

if ( ! function_exists( 'uncode_related_post_call' ) ) :
/**
 * @since Uncode 1.5.0
 * Additional post type for related posts plugin
 */
function uncode_related_post_call() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'related-posts-for-wp/related-posts-for-wp.php' ) ) {
		require_once get_template_directory() . '/core/inc/related-posts.php';
	}
}
endif;

// https://stackoverflow.com/questions/22787341/get-all-tags-based-on-specific-category-including-all-tags-from-child-categorie/22787970
function get_category_tags($args) {
    global $wpdb;
    $tags = $wpdb->get_results
    ("
        SELECT DISTINCT terms2.term_id as tag_id, terms2.name as tag_name, null as tag_link, terms2.slug as tag_slug
        FROM " . $wpdb->prefix . "posts as p1
            LEFT JOIN " . $wpdb->prefix . "term_relationships as r1 ON p1.ID = r1.object_ID
            LEFT JOIN " . $wpdb->prefix . "term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
            LEFT JOIN " . $wpdb->prefix . "terms as terms1 ON t1.term_id = terms1.term_id,

            " . $wpdb->prefix . "posts as p2
            LEFT JOIN " . $wpdb->prefix . "term_relationships as r2 ON p2.ID = r2.object_ID
            LEFT JOIN " . $wpdb->prefix . "term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
            LEFT JOIN " . $wpdb->prefix . "terms as terms2 ON t2.term_id = terms2.term_id
        WHERE
            t1.taxonomy = 'category' AND p1.post_status = 'publish' AND terms1.term_id IN (".$args['categories'].") AND
            t2.taxonomy = 'post_tag' AND p2.post_status = 'publish'
            AND p1.ID = p2.ID
        ORDER by tag_name
    ");
    $count = 0;
    foreach ($tags as $tag) {
        $tags[$count]->tag_link = get_tag_link($tag->tag_id);
        $count++;
	}
    return $tags;
}

add_action( 'pre_get_posts', 'search_by_cat' );

function search_by_cat()
{
    if ( is_search() )
    {
        $cat = empty( $_GET['cat'] ) ? '' : (int) $_GET['cat'];
        add_query_arg( ['cat' => $cat] );
    }
}
