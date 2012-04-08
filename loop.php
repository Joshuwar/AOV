		<?php 
			if ( have_posts() ) : while ( have_posts() ) : the_post();
			$slug = basename(get_permalink());
		 ?>
		<div id="<?php // the_title(); To do: make this echo the slug?>" class="jbasewrap post pull1 <?php echo $slug; ?>">
			<div class="leftcol textalignright">
				
				<h1><?php the_title(); ?></h1>
				
				<?php if( !is_page()) { ?> 
				<div class="meta push1">
					<p>Posted in <?php
					$cat = get_the_category();
					$catname = $cat[0]->name;
					$catlink = get_category_link( $cat[0]->term_id );					
					?>
					<a class="fixed" href="<?php echo $catlink; ?>" title="view other <?php echo $catname; ?> posts"><?php echo $catname; ?></a> // <?php echo get_the_date('d F Y'); ?>
					
					</p>
					<?php // to do - check the encoding of the "<" & ">" characters 
					$next_post = get_next_post();
					$previous_post = get_previous_post();
					if($next_post) { ?>
					<a href="<?php echo get_permalink($next_post->ID); ?>" rel="next" id="next" >></a>
					<?php }
					if($previous_post) { ?>
					<a href="<?php echo get_permalink($previous_post->ID); ?>" rel="prev" id="prev"><</a>
					<?php } ?>
				
				</div>
				<?php } ?>
	
			</div>
			<div class="rightcol push3">
					<?php the_content(); ?>
			</div>
			<br class="clearboth" />
		</div>
		<?php 
			endwhile; 
			endif;
		?>
		