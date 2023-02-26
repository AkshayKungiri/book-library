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

class Wp_Bl_Scripts {

	//class constructor
	function __construct() {
	}

	/**
	 * Enqueue Scripts on Admin Side
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	public function wp_bl_admin_scripts() {

		wp_enqueue_script( 'jquery' );
	}

	public function wp_bl_public_scripts() {
		wp_enqueue_style( 'book-style', WP_BL_INC_URL . '/css/style.css', array(), false );
		wp_enqueue_style( 'book-starRating-style', 'https://cdn.jsdelivr.net/npm/star-rating-svg@3.5.0/src/css/star-rating-svg.min.css', array(), false );
		wp_enqueue_style( 'book-rangeSlider-style', 'https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css', array(), false );

		wp_enqueue_script( 'book-starRating-script', 'https://cdn.jsdelivr.net/npm/star-rating-svg@3.5.0/dist/jquery.star-rating-svg.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'book-rangeSlider-script', 'https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'book-custom-script', WP_BL_INC_URL . '/js/custom.js', array( 'jquery' ), false, true );

		wp_localize_script(
			'book-custom-script',
			'wpbl_ajax_object',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the styles and scripts.
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	function add_hooks() {

		//add admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'wp_bl_admin_scripts' ) );

		//add frontent scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_bl_public_scripts' ) );

	}
}

