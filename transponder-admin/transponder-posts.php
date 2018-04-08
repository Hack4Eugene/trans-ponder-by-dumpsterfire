<?php
function create_resources_post_type() {
	$labels = array(
		'name' => 'Resource Suggestions',
		'singular_name' => 'Resource Suggestion'
	);
	$args = array (
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'heirarchical' => false,
		'menu_icon' => 'dashicons-location-alt',
		'suppports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revisions',
	),
	'taxonomies' => array('category','post_tag'),
	'menu_position' => 1
	);
	register_post_type('resourcesuggestions',$args);
}
add_action('init','create_resources_post_type');
?>