<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wp-bl-form-group">
	<div class="wp-bl-form-label">
		<label><?php _e( 'Price', 'wpbl' ); ?></label>
	</div>
	<div class="wp-bl-form-input">
		<input type="number" name="wp_bl_cstm_book_price" value="<?php echo $wp_bl_cstm_book_price; ?>" min="0" />
	</div>
</div>
<div class="wp-bl-form-group">
	<div class="wp-bl-form-label">
		<label><?php _e( 'Rating', 'wpbl' ); ?></label>
	</div>
	<div class="wp-bl-form-input">
		<select name="wp_bl_cstm_book_rating" id="wp_bl_cstm_book_rating" class="postbox">
			<option value="">Select something...</option>
			<option <?php selected( $wp_bl_cstm_book_rating, '1' ); ?> value="1">1</option>
			<option <?php selected( $wp_bl_cstm_book_rating, '2' ); ?> value="2">2</option>
			<option <?php selected( $wp_bl_cstm_book_rating, '3' ); ?> value="3">3</option>
			<option <?php selected( $wp_bl_cstm_book_rating, '4' ); ?> value="4">4</option>
			<option <?php selected( $wp_bl_cstm_book_rating, '5' ); ?> value="5">5</option>
		</select>
	</div>
</div>
