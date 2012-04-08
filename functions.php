<?php 

add_theme_support( 'post-thumbnails' );
add_image_size( 'case-study-index', 460, 240, true ); // Case Study index
add_image_size( 'case-study-page', 380, 250, true ); // Case Study page
add_image_size( 'video-thumb', 300, 222, true); // Video thumbnail on home page
add_image_size( 'category-thumb', 60, 60, true ); // Category index
add_image_size( 'consultant-peoplegrid', 220, 144, true ); // Consultant portrait on Our People page
add_image_size( 'consultant-homepage', 114, 78, true ); // Consultant portrait on homepage
add_image_size( 'consultant-profile', 129, 99, true ); // Consultant portait on profile

add_post_type_support('page', 'excerpt');

// Menus
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'top_menu', 'Top Menu' );
	register_nav_menu( 'footer_menu', 'Footer Menu' );
}

// ************************************ create post type: Case Study

if ( ! function_exists( 'post_type_case_study' ) ) :

function post_type_case_study() {

	register_post_type( 
		'case_study',
		array( 
			'label' => __('Case Studies'),
			'labels' => array(
				'singular_name'=>'Case Study'
			),
			'description' => __('Create a Case Study page'), 
			'public' => true, 
			'show_ui' => true,
			//'register_meta_box_cb' => 'init_metaboxes_case_study',
			'supports' => array (
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'author',
				'tags',
				'page-attributes'
			),
			'hierarchical' => true,
			'taxonomies' => array (
				'category', 
				'post_tag'
			) 
		)
	);

}

endif;

add_action('init', 'post_type_case_study');


// ************************************ create post type: Our People

if ( ! function_exists( 'post_type_our_people' ) ) :

function post_type_our_people() {

	register_post_type( 
		'person',
		array( 
			'label' => __('Our People'), 
			'description' => __('Create a Person page'), 
			'public' => true, 
			'show_ui' => true,
			//'register_meta_box_cb' => 'init_metaboxes_case_study',
			'supports' => array (
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'page-attributes'
			),
			'taxonomies' => array (
				'category'
			)
		)
	);

}

endif;

add_action('init', 'post_type_our_people');


// ************************************ create post type: Video

if ( ! function_exists( 'post_type_video' ) ) :

function post_type_video() {

	register_post_type( 
		'video',
		array( 
			'label' => __('Videos'), 
			'description' => __('Add a Video'), 
			'public' => true, 
			'show_ui' => true,
			'supports' => array (
				'title',
				'editor',
				'thumbnail',
				'excerpt',
			),
			'taxonomies' => array (
				'post_tag'
			) 
		)
	);

}

endif;

add_action('init', 'post_type_video');





function people_init() {
	// create people taxonomy
	
	$labels = array(
		'singular_name' => _x( 'Person', 'taxonomy singular name' ),
		'name' => _x( 'People', 'taxonomy general name' ),
	    'search_items' =>  __( 'Search People' ),
	    'all_items' => __( 'All People' ),
	    'edit_item' => __( 'Edit Person' ), 
	    'update_item' => __( 'Update Person' ),
	    'add_new_item' => __( 'Add New Person' ),
	    'new_item_name' => __( 'New Person Name' ),
	    'parent_item' => __( 'Parent Person' ),
	    'parent_item_colon' => __( 'Parent Person:' ),
	    'menu_name' => __( 'People' )
	);
	
	register_taxonomy(
		'people',
		'post',
		array(
			'labels' => $labels,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' )
			//'rewrite' => array( 'slug' => 'people' )
			//'hierarchical' => true
		)
	);
}
add_action( 'init', 'people_init' );


function add_theme_box() {
	add_meta_box('theme_box_ID', __('People'), 'your_styling_function', 'post', 'side', 'default');
	add_meta_box('theme_box_ID', __('People'), 'your_styling_function', 'video', 'side', 'default');
}	
 
function add_theme_menus() {
 
	if ( ! is_admin() )
		return;
 
	add_action('admin_menu', 'add_theme_box');
 
	/* Use the save_post action to save new post data */
	add_action('save_post', 'save_taxonomy_data');
	add_action('save_video', 'save_taxonomy_data');
}
 
add_theme_menus();


// This function gets called in edit-form-advanced.php
function your_styling_function($post) {
	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_people' ) . '" />';
 
 
	// Get all theme taxonomy terms
	$people = get_terms('people', 'hide_empty=0'); 
	$names = wp_get_object_terms($post->ID, 'people');
	?> <p>Tick the people associated with this post: </p><div style=""><?php
	foreach ($people as $person) { ?>
		<input style="margin-bottom:10px;" type="checkbox" id="<?php echo $person->slug; ?>" value="<?php echo $person->slug; ?>" name="post_people[]"
		<?php if (!is_wp_error($names) && !empty($names)) {
			foreach($names as $name) {
				if(!strcmp($person->slug, $name->slug)) {
					echo "checked='checked'";	
				}
			}
		}  ?> /> 
		<label for="<?php echo $person->slug; ?>"><?php echo $person->name; ?></label><br />
		<?php
	}
	?></div> <?php 
}



function remove_post_people_tags_ui() {
	remove_meta_box('tagsdiv-people','post','core');
}
add_action( 'admin_menu' , 'remove_post_people_tags_ui' );


function save_taxonomy_data($post_id) {
 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_people' )) {
    	return $post_id;
  	}
  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    	return $post_id;
  	if ( 'page' == $_POST['post_type'] ) {
    	if ( !current_user_can( 'edit_page', $post_id ) )
      		return $post_id;
  	} else {
    	if ( !current_user_can( 'edit_post', $post_id ) )
      	return $post_id;
  	}
	$post = get_post($post_id);
	if (($post->post_type == 'post') || ($post->post_type == 'page') || ($post->post_type == 'video')) { 
           $people = $_POST['post_people'];
           wp_set_object_terms( $post_id, NULL, 'people');
           wp_set_object_terms( $post_id, $people, 'people', true);
        }
	return $person;
}


function get_people() {
	global $post;
	$people = array();
	$people_query = new WP_Query('post_type=person&posts_per_page=-1&orderby=menu_order&order=ASC');
	while ( $people_query->have_posts() ) : $people_query->the_post();
		$people[] = $post;
	endwhile;
	return $people;
	
}


function get_post_by_title($page_title, $output = OBJECT) {
    global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s", $page_title )); // NB: there seems to be a bug where this will return an autosave ID rather than the post itself - perhaps something to do with it returning the first match it finds? Can we change to not find autosaves?
        if ( $post )
            return get_post($post, $output);
    return null;
}


function get_post_by_slug( $slug, $post_type ) {
    global $post;
    $query = new WP_Query(
        array(
            'name' => $slug,
            'post_type' => $post_type
        )
    );
    while ( $query->have_posts() ) : $query->the_post();
		$the_post = $post;
	endwhile;
	wp_reset_query();
	return $the_post;
}





// Function to output an author link

function post_author_link($class, $after, $linkToProfile) {
	global $post;
	$temps = $post;
	$people = wp_get_object_terms( $post->ID, 'people' );
	foreach($people as $author) :
		$name = $author->name;
	    if ($author) {
	    	if($linkToProfile) {
				$post = get_post_by_title($name);
				$person_link = get_permalink();
		   	} else { // link to archive page
		    	$person_link = get_term_link( $name, 'people' );
		   	}
			echo "<a href='$person_link' class='$class' title='$name'>$name</a>$after";
		}
	endforeach;
	$post = $temps;
}




/* save new person taxonomies when we create new people */
add_action('publish_person', 'save_new_person_taxonomy');
function save_new_person_taxonomy($id) {
	$post = get_post($id);
	wp_insert_term( $post->post_title, 'people');
}


/*function addThis() { ?>
<div class="addthis_toolbox addthis_default_style">
	<div class="custom_images">
		<!--<a class="addthis_button_facebook"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook.png" width="64" height="64" border="0" alt="Share to Facebook" /></a>
		<a class="addthis_button_twitter"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter.png" width="64" height="64" border="0" alt="Share to Twitter" /></a>
		<a class="addthis_button_email"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/email.png" width="64" height="64" border="0" alt="Email this" /></a>
		<a class="addthis_button_print"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/print.png" width="64" height="64" border="0" alt="Print" /></a>-->
		<a class="addthis_button_facebook"></a>
		<a class="addthis_button_twitter"></a>
		<a class="addthis_button_email"></a>
		<a class="addthis_button_print"></a>
		<a class="addthis_button_google_plusone"></a>
	</div>
</div>	
<?php }

add_action('wp_footer', 'addThisScript');

function AddThisScript() { ?>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
<?php } */

// adding setting for number of homepage blog posts
add_action('admin_init', 'bpsf_admin_init');
function bpsf_admin_init() {
	register_setting(
		'general', // settings page
		'bpsf_options' // option name
	);
	add_settings_field(
		'bpsf_homepage_blog_count', // id
		'Number of posts to show on home page', // setting title
		'bpsf_homepage_blog_count_input', // display callback
		'general', // settings page
		'default' // settings section
	);
	add_settings_field(
		'bpsf_homepage_news_count', // id
		'Number of news articles to show on home page', // setting title
		'bpsf_homepage_news_count_input', // display callback
		'general', // settings page
		'default' // settings section
	);
}
function bpsf_homepage_blog_count_input() {
	$options = get_option( 'bpsf_options' );
	$value = $options['homepage_blog_count'];
	?>
	<input id="bpsf_homepage_blog_count" name="bpsf_options[homepage_blog_count]" value="<?php echo esc_attr( $value ); ?>" />
	<?php
}
function bpsf_homepage_news_count_input() {
	$options = get_option( 'bpsf_options' );
	$value = $options['homepage_news_count'];
	?>
	<input id="bpsf_homepage_news_count" name="bpsf_options[homepage_news_count]" value="<?php echo esc_attr( $value ); ?>" />
	<?php
}

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function bpsf_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}



/*
 * Extending Editor role for admin capabilities 
 */
 
$role = get_role( 'editor' );
 
$role->add_cap( 'manage_options' );
$role->add_cap( 'edit_theme_options' );

/* Add custom menu walker for footer menu, to allow for non-links */
/**
 * Create nested UL's for top-level items.
 *
 * with help from Description_Walker by toscho, http://toscho.de
 */
$menu_count=0;
class Non_Link_Walker extends Walker_Nav_Menu
{
    /*
	 Based on start_el in Walker_Nav_Menu in nav-menu-template.php
	 */
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )      ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		if($item->url!="#") {
			$item_output .= '<a'. $attributes .'>';
		}
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}





?>