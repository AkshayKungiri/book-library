var wpbl_ajax_url = wpbl_ajax_object.ajaxurl;
function generateSliderAndRating() {
	jQuery( ".js-range-slider" ).ionRangeSlider(
		{
			type: "double",
			grid: true,
			min: 1,
			max: 1000,
			from: 1,
			to: 1000,
			step: 1,
		}
	);
	jQuery( ".my-rating" ).starRating(
		{
			initialRating: 4,
			strokeColor: '#894A00',
			strokeWidth: 10,
			starSize: 15,
			readOnly: true,
		}
	);
}
jQuery( document ).ready(
	function ($) {
		generateSliderAndRating();
		$( document ).on(
			"submit",
			"#wpbl_book_filter_form",
			function(e){
				e.preventDefault();
				$.ajax(
					{
						url: wpbl_ajax_url,
						data: $( this ).serialize(),
						method: 'POST',
						success: function(response) {
							$( "#wpbl-book-table-container" ).html( response );
							generateSliderAndRating();
						}
					}
				);
			}
		);
		$( document ).on(
			"click",
			".page-link:not('.active')",
			function(e){
				let cur_page = $( this ).attr( "data-page" );
				$( "#wp_bl_current_page" ).val( cur_page );
				$( "#wpbl_book_filter_form" ).submit();
			}
		);
	}
);
