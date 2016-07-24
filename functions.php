<?php
/**
 * novelty.
 *
 * @package      Novelty
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 09/22/2015
 * @license      GPL-2.0+
 */

//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent. 

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );
 //* Add Color Selection to novelty Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Loads Responsive Menu, Google Fonts, and Dashicons
add_action( 'wp_enqueue_scripts', 'novelty_enqueue_scripts' );
function novelty_enqueue_scripts() {

	wp_enqueue_script( 'global-script', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic,700|Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic', array() );
	wp_enqueue_style( 'dashicons' );

}

add_filter( 'the_content_more_link', 'modify_read_more_link' );
function modify_read_more_link() {
return '<a class="more-link" href="' . get_permalink() . '">Leer más</a>';
}
//* Enqueue scripts on static Pages that have Featured images.
add_action( 'wp_enqueue_scripts', 'novelty_static_page_enqueue_scripts' );
function novelty_static_page_enqueue_scripts() {
	if ( is_singular( array( 'post', 'page' ) ) && has_post_thumbnail() ) {

		wp_enqueue_script( 'novelty-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery.backstretch.min.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_script( 'novelty-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'novelty-backstretch' ), '1.0.0' );
		wp_localize_script( 'novelty-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', genesis_get_image( array('format' => 'url') ) ) ) );
	}
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add new featured image size
add_image_size( 'square-entry-image', 360, 360, TRUE );
add_image_size( 'vertical-entry-image', 360, 570, TRUE );
add_image_size( 'small-vertical-entry-image', 150, 238, TRUE );
add_image_size( 'blog-entry-image', 750, 450, TRUE );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 900,
	'height'          => 420,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav', 7 );

//* Add search form to navigation
add_filter( 'wp_nav_menu_items', 'prefix_primary_nav_extras', 10, 2 );
function prefix_primary_nav_extras( $menu, $args ) {
	//* Change 'primary' to 'secondary' to add extras to the secondary navigation menu
	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu .= '<li class="right search">' . $search . '</li>';

	return $menu;
}
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'Buscar' );
}

//* Add widget to primary navigation
add_filter( 'genesis_nav_items', 'novelty_social_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'novelty_social_icons', 10, 2 );

function novelty_social_icons($menu, $args) {
	$args = (array)$args;
	if ( 'primary' !== $args['theme_location'] )
		return $menu;
	ob_start();
	genesis_widget_area('nav-social-menu');
	$social = ob_get_clean();
	return $menu . $social;
}

//* Add support for footer menu
add_theme_support ( 'genesis-menus' , array ( 
	'primary'   => 'Primary Navigation Menu', 
	'secondary' => 'Secondary Navigation Menu', 
	'footer'    => 'Footer Navigation Menu' 
) );

//* Hook menu in footer
add_action( 'genesis_before_footer', 'novelty_footer_menu', 7 );
function novelty_footer_menu() {

	printf( '<nav %s>', genesis_attr( 'nav-footer' ) );

	wp_nav_menu( array(
		'theme_location' => 'footer',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',		
		
	) );
	
	echo '</nav>';

}

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'novelty_secondary_menu_args' );
function novelty_secondary_menu_args( $args ){

	if( 'footer' != $args['theme_location'] ){
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

//* Edit width of tiled gallery
if ( ! isset( $content_width ) )
    $content_width = 1200;
    
//* Reposition Featured Images
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

//* Position post info above post title
remove_action( 'genesis_entry_header', 'genesis_post_info', 12);
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

//* Customize the Post Info Function
add_filter( 'genesis_post_info', 'novelty_post_info_filter' );
function novelty_post_info_filter( $post_info ) {

	$post_info = '[post_date format="m/d/y"]';
    return $post_info;

}

//* Customize the Post Meta function
add_filter( 'genesis_post_meta', 'novelty_post_meta_filter' );
function novelty_post_meta_filter( $post_meta ) {

    $post_meta = '[post_comments]<br>[post_categories before="" sep=" // "]';
    return $post_meta;

}

//* Setup widget counts
function novelty_count_widgets( $id ) {
	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

function novelty_widget_area_class( $id ) {
	$count = novelty_count_widgets( $id );

	$class = '';

	if( $count == 1 || $count < 9 ) {

		$classes = array(
			'zero',
			'one',
			'two',
			'three',
			'four',
			'five',
			'six',
			'seven',
			'eight',
		);

		$class = $classes[ $count ] . '-widget';
		$class = $count == 1 ? $class : $class . 's';

		return $class;

	} else {

		$class = 'widget-thirds';
		
		return $class;

	}

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'novelty_comments_gravatar' );
function novelty_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'novelty_author_box_gravatar' );
function novelty_author_box_gravatar( $size ) {

	return 125;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'novelty_remove_comment_form_allowed_tags' );
function novelty_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add Home Slider Overlay below Header
add_action( 'genesis_after_header', 'novelty_home_slider' );
function novelty_home_slider() {
	if( ! ( is_home() || is_front_page() ) ) {
		return;
	}
	if( function_exists( 'soliloquy' ) ) {
		echo '<div class="home-slider-container"><div class="home-slider">';
			soliloquy( 'home-slider', 'slug' );
		echo '</div>';

		genesis_widget_area( 'home-slider-overlay', array(
			'before'	=> '<div class="home-slider-overlay widget-area"><div class="wrap">',
			'after'		=> '</div></div></div>',
		) );
	}
}





//* Add Featured Image below Primary Navigation on Single Pages & Posts
add_action( 'genesis_after_header','novelty_relocate_entry_title_pages' );
function novelty_relocate_entry_title_pages() {
	if ( is_singular( 'page' ) && has_post_thumbnail() ) {

		echo '<div class="entry-header-wrap"><div class="entry-header-wrapper"><div class="wrap">';
			genesis_do_post_title();
		echo '</div></div></div>';

		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	}

}

//* Hooks Widget Area Above Content
add_action( 'genesis_after_header', 'novelty_widget_above_content'  ); 
function novelty_widget_above_content() {

    genesis_widget_area( 'widget-above-content', array(
		'before' => '<div class="widget-above-content widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

}

//* Load Entry Navigation
add_action( 'genesis_after_entry', 'genesis_prev_next_post_nav', 7 );

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'novelty_footer_creds_text' );
function novelty_footer_creds_text() {

    echo '<div class="creds"><p>';
    echo 'Copyright &copy; ';
    echo date('Y');
    echo ' &middot; <a target="_blank" href="#">Made</a> by <a target="_blank" #">Erika Leal</a>';
    echo '</p></div>';

}

//* Add Theme Support for WooCommerce
add_theme_support( 'genesis-connect-woocommerce' );

//* Cambia el texto del botón Añadir al carrito en WooCommerce en la categorías de productos: 2.1 o superior
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
 
function woo_archive_custom_cart_button_text() {
 
        return __( 'Comprar', 'woocommerce' );
 
}



//* Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'            => 'home-slider-overlay',
	'name'          => __( 'Home Slider Overlay', 'novelty' ),
	'description'   => __( 'This widget area appears on top of the slider on homepage', 'novelty' ),
) );
genesis_register_sidebar( array(
	'id'            => 'widget-above-content',
	'name'          => __( 'Widget Above Content', 'novelty' ),
	'description'   => __( 'This widget area appears on top of the slider on homepage', 'novelty' ),
) );
genesis_register_sidebar( array(
	'id'            => 'home-flexible',
	'name'          => __( 'Home Flexible', 'novelty' ),
	'description'   => __( 'This widget area appears on top of the slider on homepage', 'novelty' ),
) );
genesis_register_sidebar( array(
	'id'            => 'category-index',
	'name'          => __( 'Category Index', 'novelty' ),
	'description'   => __( 'This widget area that appears on the Category Index page', 'novelty' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'above-blog-slider',
	'name'        	=> __( 'Above Blog Slider', 'novelty' ),
	'description' 	=> __( 'This is the above blog slider section of the home or blog page.', 'novelty' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'fancybox-popup',
	'name'        	=> __( 'Fancybox Popup on Home Page', 'novelty' ),
	'description' 	=> __( 'This is the section for the fancybox popup on the home page.', 'novelty' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'nav-social-menu',
	'name'        	=> __( 'Nav Social Menu', 'novelty' ),
	'description' 	=> __( 'This is the nav social menu section.', 'novelty' ),
) );
