<?php

/**
 * This file adds the Customizer ability to the Novelty Theme.
 *
 * @package      Novelty
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 09/22/2015
 * @license      GPL-2.0+
 */
 
//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent. 
 
/**
 * Get default primary color for Customizer.
 *
 * @return string Hex color code for primary color.
 */
function novelty_customizer_get_default_primary_color() {
	return '#c5d8de';
}

add_action( 'customize_register', 'novelty_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function novelty_customizer(){

	global $wp_customize;
	
	$wp_customize->add_setting(
		'novelty_primary_color',
		array(
			'default' => novelty_customizer_get_default_primary_color(),
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'novelty_primary_color',
			array(
				'description' => __( 'Change the default primary color for the newsletter capture areas.', 'novelty' ),
			    'label'       => __( 'Primary Color', 'novelty' ),
			    'section'     => 'colors',
			    'settings'    => 'novelty_primary_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'novelty_css' );
/**
* Checks the settings for the images and background colors for each image
* If any of these value are set the appropriate CSS is output
*
* @since 1.0
*/
function novelty_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	
	$color_primary = get_theme_mod( 'novelty_primary_color', novelty_customizer_get_default_primary_color() );

	$css = '';
	
	$css .= ( novelty_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '
		
		button, input[type="button"], 
		input[type="reset"], 
		input[type="submit"], 
		.button {
			background-color: %1$s;
		}
		
		.site-header,
		button, 
		input[type="button"], 
		input[type="reset"], 
		input[type="submit"], 
		.button {
			border-color: %1$s;
		}
		
		.woocommerce #respond input#submit, 
		.woocommerce a.button, 
		.woocommerce button.button, 
		.woocommerce input.button,
		.woocommerce span.onsale,
		#sb_instagram .sbi_follow_btn a {
			background-color: %1$s !important;
		}
		
		a,
		.genesis-nav-menu a:hover, 
		.genesis-nav-menu .current-menu-item > a, 
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.entry-title a:hover,
		.sidebar li::before {
			color: %1$s;
		}
		
		.woocommerce .woocommerce-message,
		.woocommerce .woocommerce-info,
		.woocommerce #respond input#submit, 
		.woocommerce a.button, 
		.woocommerce button.button, 
		.woocommerce input.button,
		.woocommerce span.onsale {
			border-color: %1$s !important;
		}
		
		.woocommerce .woocommerce-message::before,
		.woocommerce .woocommerce-info::before,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce ul.products li.product .price,
		.woocommerce form .form-row .required {
			color: %1$s !important;
		}

		', $color_primary ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}

