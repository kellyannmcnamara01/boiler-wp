<section class="posts" style="padding: 30px; background: lightblue;">
	<h2>Posts</h2>
	<?php
		if( have_posts() ){
			while( have_posts() ){
				the_post();
				get_template_part( 'partials/posts/content-excerpt' );
			}
		}
	?>

</section>