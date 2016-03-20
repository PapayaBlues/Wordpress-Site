<?php

/**
 * This file adds the Theme Defaults to the Novelty Theme.
 *
 * @package      Novelty
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 09/22/2015
 * @license      GPL-2.0+
 */
 
//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent. 

//* Novelty Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'novelty_theme_defaults' );
function novelty_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 300;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'blog-entry-image';
	$defaults['image_alignment']           = 'alignnone';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Novelty Theme Setup
add_action( 'after_switch_theme', 'novelty_theme_setting_defaults' );
function novelty_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 300,
			'content_archive_thumbnail' => 1,
			'image_size'                => 'blog-entry-image',
			'image_alignment'           => 'alignnone',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
	
	} 

	update_option( 'posts_per_page', 6 );

}

//* Novelty Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'novelty_social_default_styles' );
function novelty_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#FFFFFF',
		'background_color_hover' => '#FFFFFF',
		'border_radius'          => 0,
		'border_color'           => '#FFFFFF',
		'border_color_hover'     => '#FFFFFF',
		'border_width'           => 0,
		'icon_color'             => '#333333',
		'icon_color_hover'       => '#c5d8de',
		'size'                   => 22,
		'new_window'             => 1,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}

//* Novelty Genesis Responsive Slider defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'novelty_responsive_slider_defaults' );
function novelty_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'right',
		'location_vertical'               => 'bottom',
		'posts_num'                       => '5',
		'slideshow_arrows'                => 1,
		'slideshow_excerpt_show'          => 0,
		'slideshow_height'                => '450',
		'slideshow_pager'                 => 0,
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '750',
	);

	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}
