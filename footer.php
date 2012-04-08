		<div class="push"></div>
	</div> <!-- end #wrap -->
	<div id="footer" class="footer">
		<div class="jbasewrap overflow">
			<div class="grid12col margintop push4">
				<div class="column1 left">
					<h3 class="fixed">Links</h3>
					<ul class="noBullets">
						<?php wp_list_bookmarks( 'categorize=0&title_before=&title_after=&title_li=0&category_name=links' ); ?>
					</ul>
				</div>
				<div class="column2 left">
					<?php  
					$the_query = new WP_Query('pagename=biog');
					while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					
					<h3 class="fixed"><?php the_title(); ?></h3>

					<p><?php the_content(); ?></p>
					<?php
					endwhile;
					wp_reset_postdata();
					?>
					
				</div>
				<div class="column3 left">
					<h3 class="fixed">Sections</h3>
					<ul class="noBullets">
						<?php wp_list_categories('hierarchical=false&title_li='); ?>
					</ul>
				</div>
				<div class="column4 left">
					<h3 class="fixed">Archival</h3>
					<ul class="noBullets">
						<?php wp_list_bookmarks( 'categorize=0&title_before=&title_after=&title_li=0&category_name=archive' ); ?>
					</ul>
				</div>
			</div>
			<?php wp_nav_menu( array(
				'container'		 => 'false',
				'theme_location' => 'footer_menu',
				'menu_class' => 'links',
				'walker' => new Non_Link_Walker
				)
			); ?>
		</div>
	</div>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.6.1.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.ie6MultipleClass.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/togglegrid.js"></script>
	<?php wp_footer(); ?>
	<script type="text/javascript">
		window.baseURL = "<?php bloginfo('url'); ?>";
		window.wpURL = "<?php bloginfo('wpurl'); ?>";
	</script>
	<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.scrollTo-min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.localscroll-1.2.7-min.js"></script>
	<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/app.js"></script>
	<!--[if (gte IE 6)&(lte IE 8)]>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/selectivizr-min.js"></script>
	<![endif]-->
	<!--[if lt IE 7 ]>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/dd_belatedpng.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.ie6MultipleClass.min.js"></script>
		<script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
	<![endif]-->
</body>
</html>
