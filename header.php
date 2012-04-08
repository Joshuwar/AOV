<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );
	
		// Add the blog name.
		bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
	
		?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/reset.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/grid.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/j-base2.css" media="screen" /> 
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/stickyfooter.css" media="screen" /> 
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/j-base-testpage.css" media="screen" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<script type="text/javascript">
		document.documentElement.className = "js";
	</script>
	
	<?php
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<a name="top" id="top"></a>
	<div><a class="trigger" href="javascript:func()">Grid</a></div>
	<div id="wrap" class="png_bg">
		<div class="jbasewrap">
			<div class="grid12col png_bg">
				<div id="header">
					<div class="leftcol textalignright">
						<a id="logo" href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a>
					</div>
					<div class="rightcol">
						<?php wp_nav_menu( array(
							'container'		 => 'false',
							'theme_location' => 'top_menu',
							'menu_id' => 'nav',
							'menu_class' => ''
							)
						); ?>
					</div>
				</div>
			</div>
		</div>












