<?php get_header(); ?>

	<h2 href="#" class="fixed">404 - missing page</h2>
		<hr class="grid12col" />
		<h1>404 - Whoops!</h1>
		<div class="grid8col">
			<p>Sorry! The page you were looking for does not exist. We've been notified about this. Please go back to the <a href="/">home page</a> and continue looking around.</p>
		</div>
	<br class="clearboth marginbottom" />
	<?php $adminemail = get_option('admin_email');
		$websitename = get_bloginfo('name');
		echo $website;
		$message = "A user tried to go to ".$_SERVER['REQUEST_URI']
			." and received a 404 (page not found) error. "
	        ."They came from ".$_SERVER['HTTP_REFERER'];
		wp_mail($adminemail, "Bad Link To ".$_SERVER['REQUEST_URI'],
	        $message, "From: BPSF no-reply <noreply@bellpottinger-sansfrontieres.com>");
	?>
<?php get_footer(); ?>