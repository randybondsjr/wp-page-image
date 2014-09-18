#WordPress Page Image Custom Post Type

Add Custom Images to any part of your site.

##Installation Instructions
1. Copy page-image folder to /wp-content/plugins/
2. Add the code below to any page you want to show the latest page image.
3. Enjoy!

If you have any questions or suggestions, please use the Issue Tracker in github.


	<?php
	  $mypost = array( 'post_type' => 'page-image','posts_per_page'=>1, );
	  $image = new WP_Query( $mypost );
		while ($image->have_posts()) :
			$image->the_post();  	
			$image_url = wp_get_attachment_url( get_post_thumbnail_id($loop->ID) );
	?>
	
	<div class="pagemast">
		<img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>">
	</div>
	
	<?php 
		endwhile;
		wp_reset_query(); 
	?>