<?php
add_action('init','create_posttype');
function create_posttype() {
	register_post_type( 'Resource Suggestions',
		array(
			'labels' => array(
				'name' => __('Resource Suggestions'),
				'singular_name' => __('Resource Suggestion')
			),
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'show_in_menu' => true,
			'menu_position' => 1,
			'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'resource-suggestions'),
			'show_ui' => true,
			'menu_icon' => 'dashicons-location-alt'
		)
	);
}


?>