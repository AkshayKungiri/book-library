<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scripts Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package Book library
 * @since 1.0.0
 */

class Wp_Bl_Admin {


	//class constructor
	function __construct() {
	}

	/**
	 * Adding Metabox
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	public function wp_bl_add_book_metabox() {

		add_meta_box(
			'wp_bl_book_metabox_id',                 // Unique ID
			'Addional book fields ',      // Box title
			array( $this, 'wp_bl_meta_box_html' ),  // Content callback, must be of type callable
			WP_BL_POST_TYPE_BOOK              // Post type
		);
	}

	/**
	 * Adding form html for metabox
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	public function wp_bl_meta_box_html( $post ) {
		$wp_bl_cstm_book_price  = get_post_meta( $post->ID, 'wp_bl_cstm_book_price', true );
		$wp_bl_cstm_book_rating = get_post_meta( $post->ID, 'wp_bl_cstm_book_rating', true );

		require WP_BL_INC_DIR . '/template/wpbl-admin-metabox-html.php';
	}

	/**
	 * Save custom field for books
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	public function wp_bl_save_postdata( $post_id ) {
		if ( array_key_exists( 'wp_bl_cstm_book_price', $_POST ) ) {
			update_post_meta(
				$post_id,
				'wp_bl_cstm_book_price',
				sanitize_text_field( $_POST['wp_bl_cstm_book_price'] )
			);
		}
		if ( array_key_exists( 'wp_bl_cstm_book_rating', $_POST ) ) {
			update_post_meta(
				$post_id,
				'wp_bl_cstm_book_rating',
				sanitize_text_field( $_POST['wp_bl_cstm_book_rating'] )
			);
		}
	}

	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the backend.
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	function add_hooks() {
		add_action( 'add_meta_boxes', array( $this, 'wp_bl_add_book_metabox' ) );
		add_action( 'save_post', array( $this, 'wp_bl_save_postdata' ) );
	}
}
