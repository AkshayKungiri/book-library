<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpbl_publisher_terms = get_terms( 'wpbl_publisher' );
?>

<div class="booksearch-box">
	<h4 class="title"><?php echo $search_title; ?></h4>
	<form action="" id="wpbl_book_filter_form">
		<div class="form-row">
			<div class="form-group col-md-6">
				<div class="d-flex">
					<label for="text1"><?php _e( 'Book Name', 'wpbl' ); ?>:</label>
					<input name="wpbl_filter_book_name" type="text" class="form-control" id="text1" value="<?php echo $wpbl_filter_book_name; ?>" placeholder="<?php _e( 'Enter Book Name', 'wpbl' ); ?>" />
				</div>
			</div>
			<div class="form-group col-md-6">
				<div class="d-flex">
					<label for="text2"><?php _e( 'Author', 'wpbl' ); ?>:</label>
					<input name="wpbl_filter_book_author" type="text" class="form-control" id="wpbl_filter_book_author" value="<?php echo $wpbl_filter_book_author; ?>" placeholder="<?php _e( 'Enter Author Name', 'wpbl' ); ?>" />
				</div>
			</div>
			<div class="form-group col col-md-6">
				<div class="d-flex">
					<label for="inputpublisher"><?php _e( 'Publisher', 'wpbl' ); ?>:</label>
					<select name="wpbl_filter_book_publisher" id="inputpublisher" class="form-control">
						<option selected value=""><?php _e( 'Select Publisher', 'wpbl' ); ?></option>
						<?php
						foreach ( $wpbl_publisher_terms as $wpbl_publisher_term ) {
							$selected = '';
							?>
							<option <?php selected( $wpbl_filter_book_publisher, $wpbl_publisher_term->term_id ); ?> value="<?php echo $wpbl_publisher_term->term_id; ?>"><?php echo $wpbl_publisher_term->name; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group col col-md-6">
				<div class="d-flex">
					<label for="inputrating"><?php _e( 'Rating', 'wpbl' ); ?>:</label>
					<select name="wpbl_filter_book_rating" id="inputrating" class="form-control">
						<option selected value=""><?php _e( 'Select Rating', 'wpbl' ); ?></option>
						<option <?php selected( $wpbl_filter_book_rating, '1' ); ?> value="1">1</option>
						<option <?php selected( $wpbl_filter_book_rating, '2' ); ?> value="2">2</option>
						<option <?php selected( $wpbl_filter_book_rating, '3' ); ?> value="3">3</option>
						<option <?php selected( $wpbl_filter_book_rating, '4' ); ?> value="4">4</option>
						<option <?php selected( $wpbl_filter_book_rating, '5' ); ?> value="5">5</option>
					</select>
				</div>
			</div>

			<div class="form-group col col-md-6">
				<div class="d-flex">
					<label for="inputrating"><?php _e( 'Price', 'wpbl' ); ?>:</label>
					<input name="wpbl_filter_book_price" type="text" class="js-range-slider" data-from="<?php echo $wpbl_filter_book_price[0]; ?>" data-to="<?php echo $wpbl_filter_book_price[1]; ?>" />
				</div>
			</div>
		</div>
		<input type="hidden" name="action" value="wp_bl_filter_book" />
		<input type="hidden" name="current_page" id="wp_bl_current_page" value="<?php echo $current_page; ?>" />
		<input type="hidden" name="post_per_page" id="wp_bl_post_per_page" value="<?php echo $posts_per_page; ?>" />
		<input type="hidden" name="search_title" id="wp_bl_search_title" value="<?php echo $search_title; ?>" />
		<button class="search-btn" type="submit"><?php _e( 'Search', 'wpbl' ); ?></button>
	</form>
</div>

<?php
if ( $query->have_posts() ) {
	?>
	<div class="table-box table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th><?php _e( 'No', 'wpbl' ); ?></th>
					<th><?php _e( 'Book Name', 'wpbl' ); ?></th>
					<th><?php _e( 'Price', 'wpbl' ); ?></th>
					<th><?php _e( 'Author', 'wpbl' ); ?></th>
					<th><?php _e( 'Publisher', 'wpbl' ); ?></th>
					<th><?php _e( 'Rating', 'wpbl' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 0;
				while ( $query->have_posts() ) :
					$query->the_post();
					$i++;
					// foreach ($book_post as $key => $book_item) {
					$wpbl_author    = wp_get_post_terms( $query->post->ID, array( 'wpbl_author' ) );
					$wpbl_publisher = wp_get_post_terms( $query->post->ID, array( 'wpbl_publisher' ) );
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><a href="<?php echo get_permalink( $query->post->ID ); ?>"><?php the_title(); ?></a></td>
						<td>$<?php echo get_post_meta( $query->post->ID, 'wp_bl_cstm_book_price', true ); ?></td>
						<td>
							<?php
							$author_list_array = array();
							foreach ( $wpbl_author as $author ) {
								$author_list_array[] = "<a href='" . get_term_link( $author->term_id ) . "'>" . $author->name . '</a>';
							}
							echo implode( ' , ', $author_list_array );
							?>
						</td>
						<td>
							<?php
							$publisher_list_array = array();
							foreach ( $wpbl_publisher as $publisher ) {
								$publisher_list_array[] = "<a href='" . get_term_link( $publisher->term_id ) . "'>" . $publisher->name . '</a>';
							}
							echo implode( ' , ', $publisher_list_array );
							?>
						</td>
						<td>
							<span class="my-rating" data-rating="<?php echo get_post_meta( $query->post->ID, 'wp_bl_cstm_book_rating', true ); ?>"></span>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
	<?php if ( $total_no_page > 1 ) { ?>
	<ul class="pagination">
		<?php if ( $current_page > 1 ) { ?>
			<li class="page-item"><a class="page-link" data-page="<?php echo $current_page - 1; ?>" href="javascript:void(0);">Previous</a></li>
		<?php } ?>
		<?php
		for ( $i = 1; $i <= $total_no_page; $i++ ) {
			?>
			<li class="page-item"><a class="page-link <?php echo ( $i === $current_page ) ? 'active' : ''; ?>" data-page="<?php echo $i; ?>" href="javascript:void(0);"><?php echo $i; ?></a></li>
			<?php
		}
		?>
		<?php if ( $current_page < $total_no_page ) { ?>
			<li class="page-item"><a class="page-link" data-page="<?php echo $current_page + 1; ?>" href="javascript:void(0);">Next</a></li>
		<?php } ?>
	</ul>
	<?php } ?>
	</ul>
	<?php
} else {
	?>
	<p><?php _e( 'No matching record(s) found.', 'wpbl' ); ?></p>
	<?php
}
