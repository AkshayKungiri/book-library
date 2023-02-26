<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scripts Class
 *
 * Handles adding front end pages
 * as well as the front pages.
 *
 * @package Book library
 * @since 1.0.0
 */

class Wp_Bl_Public {


	//class constructor
	function __construct() {
	}

	/**
	 * Adding shortcode for the frontend.
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	public function wp_bl_book_library_callback( $atts = array() ) {

		$posts_per_page             = ( isset( $atts['pagination'] ) && ! empty( $atts['pagination'] ) ) ? sanitize_text_field( $atts['pagination'] ) : WP_BL_POST_PER_PAGE;
		$search_title               = ( isset( $atts['search_title'] ) && ! empty( $atts['search_title'] ) ) ? sanitize_text_field( $atts['search_title'] ) : WP_BL_SEARCH_TITLE;
		$posts_per_page             = ( isset( $_REQUEST['post_per_page'] ) && ! empty( $_REQUEST['post_per_page'] ) ) ? sanitize_text_field( $_REQUEST['post_per_page'] ) : $posts_per_page;
		$search_title               = ( isset( $_REQUEST['search_title'] ) && ! empty( $_REQUEST['search_title'] ) ) ? sanitize_text_field( $_REQUEST['search_title'] ) : $search_title;
		$current_page               = ( isset( $_REQUEST['current_page'] ) && ! empty( $_REQUEST['current_page'] ) ) ? (int) sanitize_text_field( $_REQUEST['current_page'] ) : 1;
		$args                       = array(
			'post_type'      => WP_BL_POST_TYPE_BOOK,
			'post_status'    => 'publish',
			'posts_per_page' => $posts_per_page,
			'paged'          => $current_page,
		);
		$wpbl_filter_book_name      = '';
		$wpbl_filter_book_author    = '';
		$wpbl_filter_book_publisher = '';
		$wpbl_filter_book_rating    = '';
		$wpbl_filter_book_price     = array( 0, 1000 );
		if ( isset( $_REQUEST['wpbl_filter_book_name'] ) && ! empty( $_REQUEST['wpbl_filter_book_name'] ) ) {
			$wpbl_filter_book_name = sanitize_text_field( $_REQUEST['wpbl_filter_book_name'] );
			$args['s']             = $wpbl_filter_book_name;
		}
		if ( isset( $_REQUEST['wpbl_filter_book_author'] ) && ! empty( $_REQUEST['wpbl_filter_book_author'] ) ) {
			$wpbl_filter_book_author = sanitize_text_field( $_REQUEST['wpbl_filter_book_author'] );
			$args['tax_query'][]     = array(
				'taxonomy' => 'wpbl_author',
				'field'    => 'name',
				'terms'    => $wpbl_filter_book_author,
			);
		}
		if ( isset( $_REQUEST['wpbl_filter_book_publisher'] ) && ! empty( $_REQUEST['wpbl_filter_book_publisher'] ) ) {
			$wpbl_filter_book_publisher = sanitize_text_field( $_REQUEST['wpbl_filter_book_publisher'] );
			$args['tax_query'][]        = array(
				'taxonomy' => 'wpbl_publisher',
				'field'    => 'id',
				'terms'    => $wpbl_filter_book_publisher,
			);
		}
		if ( isset( $_REQUEST['wpbl_filter_book_rating'] ) && ! empty( $_REQUEST['wpbl_filter_book_rating'] ) ) {
			$wpbl_filter_book_rating = sanitize_text_field( $_REQUEST['wpbl_filter_book_rating'] );
			$args['meta_query'][]    = array(
				'key'   => 'wp_bl_cstm_book_rating',
				'value' => $wpbl_filter_book_rating,
			);
		}
		if ( isset( $_REQUEST['wpbl_filter_book_price'] ) && ! empty( $_REQUEST['wpbl_filter_book_price'] ) ) {
			$wpbl_filter_book_price = explode( ';', sanitize_text_field( $_REQUEST['wpbl_filter_book_price'] ) );
			$args['meta_query'][]   = array(
				'key'     => 'wp_bl_cstm_book_price',
				'value'   => $wpbl_filter_book_price,
				'type'    => 'numeric',
				'compare' => 'between',
			);
		}

		$query         = new WP_Query( $args );
		$total_no_page = $query->max_num_pages;
		// echo "<pre>";
		// print_r($query);
		// echo "</pre>";
		ob_start();
		echo '<div id="wpbl-book-table-container" class="container">';
		require WP_BL_INC_DIR . '/template/wpbl-table.php';
		echo '</div>';
		return ob_get_clean();
	}

	/**
	 * Ajax filter call for book list.
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	public function wp_bl_filter_book_callback() {
		echo $this->wp_bl_book_library_callback();
		exit();
	}

	/**
	 * Add custom fields in the detail page of book post type.
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	function wp_bl_add_cstm_field_in_detail( $content ) {

		global $post;
		if ( is_singular( WP_BL_POST_TYPE_BOOK ) ) {
			$wpbl_author    = wp_get_post_terms( $post->ID, array( 'wpbl_author' ) );
			$wpbl_publisher = wp_get_post_terms( $post->ID, array( 'wpbl_publisher' ) );
			ob_start();
			?>
			<p>
				<b><?php _e( 'Author', 'wpbl' ); ?></b>: 
				<?php
				$author_list_array = array();
				foreach ( $wpbl_author as $author ) {
					$author_list_array[] = "<a href='" . get_term_link( $author->term_id ) . "'>" . $author->name . '</a>';
				}
				echo implode( ' , ', $author_list_array );
				?>
			</p>
			<p>
				<b><?php _e( 'Publisher', 'wpbl' ); ?></b>: 
				<?php
				$publisher_list_array = array();
				foreach ( $wpbl_publisher as $publisher ) {
					$publisher_list_array[] = "<a href='" . get_term_link( $publisher->term_id ) . "'>" . $publisher->name . '</a>';
				}
				echo implode( ' , ', $publisher_list_array );
				?>
			</p>
			<p>
				<b><?php _e( 'Rating', 'wpbl' ); ?></b>: 
				<span class="my-rating" data-rating="<?php echo get_post_meta( $post->ID, 'wp_bl_cstm_book_rating', true ); ?>"></span>
			</p>
			<p>
				<b><?php _e( 'Price', 'wpbl' ); ?></b>: 
				$<?php echo get_post_meta( $post->ID, 'wp_bl_cstm_book_price', true ); ?>
			</p>
			<?php
			$data = ob_get_clean();
			return $content . $data;
		}

		return $content;
	}

	/**
	 * Adding hooks for the frontend.
	 *
	 * @package Book library
	 * @since 1.0.0
	 */
	public function add_hooks() {
		// shortcodes
		add_shortcode( 'wp_bl_book_library', array( $this, 'wp_bl_book_library_callback' ) );

		// action hooks
		add_action( 'wp_ajax_wp_bl_filter_book', array( $this, 'wp_bl_filter_book_callback' ) );
		add_action( 'wp_ajax_nopriv_wp_bl_filter_book', array( $this, 'wp_bl_filter_book_callback' ) );

		// filter hooks
		add_filter( 'the_content', array( $this, 'wp_bl_add_cstm_field_in_detail' ), 10, 2 );
	}
}
