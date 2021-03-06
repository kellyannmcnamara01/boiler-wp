<?php 


	/* How to set up filters
	 *
	 * 1. Set up $adminAjax var to the wp-admin/admin-ajax.php file
	 * 2. Set up the different query arrays as vars
	 * 3. Create a form tag with an id and action set to the $adminAjax location
	 * 4. Within the form add your fields that use the query array vars from step 1
	 * 5. At the bottom of the form add a hidden field that connects to the functions.php -> add_action();
	 * ** IMPORTANT: the hidden field in step 5, it's value should match the add_action()s in functions.php 
	 *    hidden field's value: FIELD_VALUE
	 *    add_action( 'wp_ajax_FIELD_VALUE', 'SITENAME_POST_FILTER_FUNCTION_NAME' );
	 *    add_action( 'wp_ajax_nopriv_FIELD_VALUE', 'SITENAME_POST_FILTER_FUNCTION_NAME' );
	 * 6. Create a div that will replace it's current contents with the filtered contents
	 * 7. Edit corresponding js file found: assets/src/scripts/partials.ajax-filters.js
	 * 8. Edit corresponsing php file found: includes/front/post-filters.php 
	============================================= */



	
	/* Setting up vars
	============================================= */
	$adminAjax 			=	site_url() . '/wp-admin/admin-ajax.php';
	
	$termsArray			=	array(
		'taxonomy'		=>	'category',
		'orderby' 		=>	'name',
		'parent' 		=> 	0
	);
	
	$termsColourArray	=	array(
		'taxonomy'		=>	'category',
		'orderby' 		=>	'name',
		'parent' 		=> 	19
	);
	
	$termsPlacesArray	=	array(
		'taxonomy'		=>	'category',
		'orderby' 		=>	'name',
		'parent' 		=> 	14
	);

	$tags				=	get_tags(array(
  		'hide_empty' 	=> 	false
	));

?>



<!-- Dropdown category filter example
============================================= -->
<form action="<?php echo $adminAjax; ?>" method="POST" id="filter">





	<!-- Dropdown categories
	============================================= -->
	<?php

		if( $terms = get_terms( $termsArray ) ) {
 
			echo '<label>Select General Category <select id="categoryfilterdropdown" name="categoryfilterdropdown">';
			echo '<option value="">Select a Category</option>';
			foreach ( $terms as $term ) {
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
			}
			echo '</select></label><br><br>';
		}

	?>




	<!-- Multi-checkmark categories
	============================================= -->
	<?php

		if( $terms = get_terms( $termsColourArray ) ){

			echo '<fieldset><legend>Select Colours</legend>';
			foreach ( $terms as $term ) {
				echo '<label><input type="checkbox" name="categoryfiltercheckboxes[]" value="' . $term->term_id . '" />' . $term->name . '</label>';
			}
			echo '</fieldset><br><br>';

		}

	?>




	<!-- Multi-radio categories
	============================================= -->
	<?php

		if( $terms = get_terms( $termsPlacesArray ) ){

			echo '<fieldset><legend>Select a Location</legend>';
			foreach ( $terms as $term ) {
				echo '<label><input type="radio" name="categoryfilterradios[]" value="' . $term->term_id . '" />' . $term->name . '</label>';
			}
			echo '</fieldset><br><br>';

		}

	?>




	<!-- Multi-checkmark tags
	============================================= -->
	<?php

		if( $tags ){

			echo '<fieldset><legend>Select Tags</legend>';
			foreach ( $tags as $tag ) {
				echo '<label><input type="checkbox" name="tagcheckboxes[]" value="' . $tag->ID . '" />' . $tag->name . '</label>';
			}
			echo '</fieldset><br><br>';

		}

	?>





	<!-- Date Selection
	============================================= -->
	<label>Start Date: <input type="date" name="startDateSelection"></label><br>
	<label>End Date: <input type="date" name="endDateSelection"></label><br><br>




	<!-- Date order dropdown
	============================================= -->
	<label> Order By:
		<select name="orderby">
			<option value="DESC">Newest</option>
			<option value="ASC">Oldest</option>
			<option value="popular">Popularity</option>
		</select>
	</label><br><br>




	<!-- Layout style radios
	============================================= -->
	<fieldset>
		<legend>>Select a Location</legend>
		<label><input type="radio" name="layoutStyle" value="rows" />Rows</label>
		<label><input type="radio" name="layoutStyle" value="blocks" />Blocks</label>
	</fieldset><br><br>




	<span></span>




	<!-- Hidden input to connect to functions.php -> add_action()
	============================================= -->
	<input type="hidden" name="action" value="post_filter">




</form>




<div id="response" style="padding: 50px; background: coral;">
	<?php
		if( have_posts() ){
			echo '<ul>';
				while( have_posts() ){
					the_post();
					get_template_part( 'partials/posts/content-excerpt' );
				}
			echo '</ul>';
		}
	?>
</div>



<?php wp_reset_postdata(); ?>