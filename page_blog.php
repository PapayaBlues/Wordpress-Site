<?php
/**
 * Novelty.
 *
 * @package      Novelty
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 09/22/2015
 * @license      GPL-2.0+
 */

//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent.

/*
Template Name: Blog Page
*/

//* Add archive body class to the head
add_filter( 'body_class', 'novelty_add_archive_body_class' );
function novelty_add_archive_body_class( $classes ) {
   $classes[] = 'novelty-archive';
   return $classes;
}

//* Remove featured image from the blog page template
remove_action( 'genesis_after_header','novelty_relocate_entry_title_pages' );

//* Hooks Slider Above Blog Content
add_action( 'genesis_before_loop', 'novelty_above_blog_slider'  ); 
function novelty_above_blog_slider() {
    
    genesis_widget_area( 'above-blog-slider', array(
		'before' => '<div class="above-blog-slider widget-area">',
		'after'  => '</div>',
    ) );

}

//* Remove Featured image (if set in Theme Settings)
add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'novelty_no_post_image' );
function novelty_no_post_image() {
	return '0';
}

//* Show Excerpts regardless of Theme Settings
add_filter( 'genesis_pre_get_option_content_archive', 'novelty_show_excerpts' );
function novelty_show_excerpts() {
	return 'excerpts';
}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'novelty_excerpt_length' );
function novelty_excerpt_length( $length ) {
	return 60; // pull first 50 words
}

//* Modify the Excerpt read more link
add_filter('excerpt_more', 'novelty_new_excerpt_more');
function novelty_new_excerpt_more($more) {
	return '... <a class="more-link" href="' . get_permalink() . '">Leer más</a>';
}

//* Make sure content limit (if set in Theme Settings) doesn't apply
add_filter( 'genesis_pre_get_option_content_archive_limit', 'novelty_no_content_limit' );
function novelty_no_content_limit() {
	return '0';
}

//* Display centered wide featured image for First Post and left aligned thumbnail for the next five
add_action( 'genesis_entry_header', 'novelty_show_featured_image', 8 );
function novelty_show_featured_image() {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	global $wp_query;

	if( ( $wp_query->current_post <= 0 ) ) {
		$image_args = array(
			'size' => 'blog-entry-image',
			'attr' => array(
				'class' => 'aligncenter',
			),
		);
	
	} else {
		$image_args = array(
			'size' => 'square-entry-image',
			'attr' => array(
				'class' => 'alignleft',
			),
		);
	}

	$image = genesis_get_image( $image_args );

	echo '<div class="home-featured-image"><a href="' . get_permalink() . '">' . $image .'</a></div>';
}

//* Remove entry meta
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


genesis();