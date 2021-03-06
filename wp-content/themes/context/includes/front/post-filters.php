<?php

function context_post_filters_function(){



	/* Order By Queries
	============================================= */
	if ( $_POST['orderby'] == 'popular' ) {

		$args = array(
			'meta_key' => 'post_views_count',
			'orderby' => 'meta_value_num', 
			'order' => 'DESC'
		);

	} else {

		$args = array(
			'orderby' => 'date', // sort by date
			'order'	=> $_POST['orderby'] // ASC or DESC
		);

	}




	/* Date Range Query
	============================================= */
	$startDate = '';
	if ( isset( $_POST['startDateSelection'] ) ) {
		$startDate = $_POST['startDateSelection'];
	}

	$endDate = '';
	if ( isset( $_POST['endDateSelection'] ) ) {
		$endDate = $_POST['endDateSelection'];
	}

	$args['date_query'] = array(
        'after' => $startDate,
        'before' => $endDate,
	);




	/* Layout Style
	============================================= */
	$layout = 'row';
	if ( isset( $_POST['layoutStyle'] ) ) {
		if ( $_POST['layoutStyle'] == 'blocks' ) {
			$layout = 'blocks';
		}
	}



	/* Check isset and fill arrays
	============================================= */
	$categoryfilterdropdown = [];
 	if( isset( $_POST['categoryfilterdropdown'] ) ) {
 		array_push( $categoryfilterdropdown , $_POST['categoryfilterdropdown'] );
 	}

 	$categoryfiltercheckboxes = [];
 	if( isset( $_POST['categoryfiltercheckboxes'] ) ) {
 		$categoryfiltercheckboxes = $_POST['categoryfiltercheckboxes'];
 	}

 	$categoryfilterradios = [];
 	if( isset( $_POST['categoryfilterradios'] ) ) {
 		$categoryfilterradios = $_POST['categoryfilterradios'];
 	}

 	$tagcheckboxes = [];
 	if( isset( $_POST['tagcheckboxes'] ) ) {
 		$tagcheckboxes = $_POST['tagcheckboxes'];
 	}




 	/* Comparative Query
	============================================= */
	$args['tax_query'] = array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => $categoryfilterdropdown,
			'operator' => 'AND'
		),
		array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => $categoryfiltercheckboxes,
			'operator' => 'AND'
		),
		array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => $categoryfilterradios,
			'operator' => 'AND'
		),
		array(
			'taxonomy' => 'post_tag',
			'field' => 'id',
			'terms' => $tagcheckboxes,
			'operator' => 'AND'
		),
	);




 	/* The below examples are if categories were not in several fields
	============================================= */




	/* Dropdown category filter example
	============================================= */
	// if( isset( $_POST['categoryfilterdropdown'] ) ) {
	// 	$args['tax_query'] = array(
	// 		array(
	// 			'taxonomy' => 'category',
	// 			'field' => 'id',
	// 			'terms' => $_POST['categoryfilterdropdown']
	// 		)
	// 	);
	// }




	/* Multi-Checkboxes category filter example
	============================================= */
	// if( isset( $_POST['categoryfiltercheckboxes'] ) ) {

	// 	$checkedArray = $_POST['categoryfiltercheckboxes'];

	// 	$args['tax_query'] = array(
	// 		array(
	// 			'taxonomy' => 'category',
	// 			'field' => 'id',
	// 			'terms' => $checkedArray
	// 		)
	// 	);
	// }
 


 
 	/* Final query and return
	============================================= */
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) {

		if ( $layout == 'blocks' ) {
			echo '<ul class="post-cards blocks">';
		} else {
			echo '<ul class="post-cards">';
		}

		while( $query->have_posts() ): $query->the_post();
			get_template_part( 'partials/posts/content-excerpt' );
		endwhile;


		echo '</ul>';

		wp_reset_postdata();

	} else {

		echo 'No posts found';

	}
 
	die();
}

?>