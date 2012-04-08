<?php get_header(); ?>
		<div class="jbasewrap contents">
			
			<!--<?php /* Pagination System
			
			$previous_posts = get_previous_posts_page_link();
			$next_posts = get_next_posts_page_link();
			global $paged, $wp_query;
			$max_page = $wp_query->max_num_pages;
			if(!$paged) {
				$paged = 1;
			}
			if($paged<$max_page) { ?>
				<a href="<?php echo $next_posts; ?>" class="right fixed">next page</a>			
			<?php }
			if($paged>1) { ?>
			<a href="<?php echo $previous_posts; ?>" class="prev right fixed">previous page</a>
			<?php } */
			?>-->
			
			<h1 class="fixed"><?php if(is_search()) {
			?>Searching for: <?php
				echo get_search_query();
 			} else if ( is_category() ) { 
	 			 ?>
	 			This is the  
 			<?php single_cat_title(); ?> Section . <a href="<?php bloginfo( 'url' );  ?>/contents">View Contents Ordered by date</a><?php
 			} else {
			?>Contents Ordered by Date
			<?php } ?>
			</h1>
			<span class="sections">View Section: </span>
			<ul class="noBullets sections">
				<?php wp_list_categories('hierarchical=false&title_li='); ?>
			</ul>
			<?php // single_cat_title();
			 ?>
			<?php 
			
			if ( have_posts() ) : ?>
			<ul class="contentlist noBullets">
			<?php while ( have_posts() ) : the_post();
				$title = get_the_title();
			?>
				<li class="grid12col left">
					<div class="grid10col left">
						<h2 class="small"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>
					</div>
					<div class="grid1col left marginleft">
						<span class="date push1"><?php echo get_the_date('d/m'); ?></span>
						<span class="date year"><?php echo get_the_date('Y'); ?></span>
					</div>
					<div class="grid1col left push1 marginleft textalignright">
						<span class="expand">></span>
					</div>
					<div class="grid6col left">
						<p><?php echo get_the_excerpt(); ?></p>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php endif; ?>
			<br class="clearboth"/>
			
		</div>


<?php get_footer(); ?>