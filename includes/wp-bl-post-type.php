<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wp_bl_register_post_types() {

	// Create Custom Post Type For Book
	$labels = array(
		'name'               => __( 'Books', 'wpbl' ),
		'singular_name'      => __( 'Book', 'wpbl' ),
		'add_new'            => __( 'Add New', 'wpbl' ),
		'add_new_item'       => __( 'Add New Book', 'wpbl' ),
		'edit_item'          => __( 'Edit Book', 'wpbl' ),
		'new_item'           => __( 'New Book', 'wpbl' ),
		'all_items'          => __( 'Books', 'wpbl' ),
		'view_item'          => __( 'View Book', 'wpbl' ),
		'search_items'       => __( 'Search Book', 'wpbl' ),
		'not_found'          => __( 'No Books found', 'wpbl' ),
		'not_found_in_trash' => __( 'No Books found in Trash', 'wpbl' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( 'Books', 'wpbl' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => WP_BL_POST_TYPE_BOOK ),
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	);

	register_post_type( WP_BL_POST_TYPE_BOOK, $args );

	// Create Custom Taxonomy for Author
	$labels = array(
		'name'              => __( 'Authors', 'wpbl' ),
		'singular_name'     => __( 'Author', 'wpbl' ),
		'search_items'      => __( 'Search Authors', 'wpbl' ),
		'all_items'         => __( 'All Authors', 'wpbl' ),
		'parent_item'       => __( 'Parent Author', 'wpbl' ),
		'parent_item_colon' => __( 'Parent Author:', 'wpbl' ),
		'edit_item'         => __( 'Edit Author', 'wpbl' ),
		'update_item'       => __( 'Update Author', 'wpbl' ),
		'add_new_item'      => __( 'Add New Author', 'wpbl' ),
		'new_item_name'     => __( 'New Author Name', 'wpbl' ),
		'menu_name'         => __( 'Author', 'wpbl' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'wpbl-author' ),
	);

	register_taxonomy(
		'wpbl_author',
		array(
			WP_BL_POST_TYPE_BOOK,
		),
		$args
	);

	// Create Custom Taxonomy for Publisher
	$labels = array(
		'name'              => __( 'Publishers', 'wpbl' ),
		'singular_name'     => __( 'Publisher', 'wpbl' ),
		'search_items'      => __( 'Search Publishers', 'wpbl' ),
		'all_items'         => __( 'All Publishers', 'wpbl' ),
		'parent_item'       => __( 'Parent Publisher', 'wpbl' ),
		'parent_item_colon' => __( 'Parent Publisher:', 'wpbl' ),
		'edit_item'         => __( 'Edit Publisher', 'wpbl' ),
		'update_item'       => __( 'Update Publisher', 'wpbl' ),
		'add_new_item'      => __( 'Add New Publisher', 'wpbl' ),
		'new_item_name'     => __( 'New Publisher Name', 'wpbl' ),
		'menu_name'         => __( 'Publisher', 'wpbl' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'wpbl-publisher' ),
	);

	register_taxonomy(
		'wpbl_publisher',
		array(
			WP_BL_POST_TYPE_BOOK,
		),
		$args
	);
}
add_action( 'init', 'wp_bl_register_post_types' );
