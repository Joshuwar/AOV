<?php 

// Template Name Posts: One Column Template

get_header(); ?>
		
			<?php 
			if ( have_posts() ) : while ( have_posts() ) : the_post();
			$slug = basename(get_permalink());
		 ?>
		<div id="<?php // the_title(); To do: make this echo the slug?> " class="jbasewrap oneColTemplate post <?php echo $slug; ?>">
				
			<h1><?php the_title(); ?></h1>
		
			<?php the_content(); ?>

			<?php if( !is_page()) { ?> 
				<hr>
				<div class="tags">
					<?php the_tags(); ?>
				</div>
			<?php } ?>
			
			<br class="clearboth" />
		</div>
		<?php 
			endwhile; 
			endif;
		?>
		
	
<?php get_footer(); ?>