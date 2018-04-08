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
			'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'tags'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'resource-suggestions'),
			'show_ui' => true,
			'menu_icon' => 'dashicons-location-alt',
			'taxonomies' => array('category', 'post_tag')
		)
	);
}
add_action( 'init', 'create_client_tax' );
function create_client_tax() {
    register_taxonomy( 
            'client_tag', //your tags taxonomy
            'Resource Suggestions',  // Your post type
            array( 
                'hierarchical'  => false, 
                'label'         => __( 'Tags', CURRENT_THEME ), 
                'singular_name' => __( 'Tag', CURRENT_THEME ), 
                'rewrite'       => true, 
                'query_var'     => true 
            )  
        );
}
?>