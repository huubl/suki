<?php
/**
 * Customizer settings: WooCommerce > Product Catalog
 *
 * @package Suki
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$defaults = Suki_Customizer::instance()->get_setting_defaults();

$section = 'woocommerce_product_catalog';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Products Grid
$wp_customize->add_control( new Suki_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_index_grid', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'suki' ),
	'priority'    => 20,
) ) );

// Loop posts per page
$id = 'woocommerce_index_posts_per_page';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( $id, array(
	'type'        => 'number',
	'section'     => $section,
	'label'       => esc_html__( 'Max products per page', 'suki' ),
	'description' => esc_html__( 'Empty / 0 = disabled; -1 = Show all.', 'suki' ),
	'input_attrs' => array(
		'min'  => -1,
		'step' => 1,
	),
	'priority'    => 20,
) );

// Loop columns
$id = 'woocommerce_index_grid_columns';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Grid columns', 'suki' ),
	'units'       => array(
		'' => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1,
			'label' => 'col',
		),
	),
	'priority'    => 20,
) ) );

// Gap between columns
$id = 'woocommerce_index_grid_columns_gap';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'slider' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Slider( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap between columns', 'suki' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// ------
$wp_customize->add_control( new Suki_Customize_Control_HR( $wp_customize, 'hr_woocommerce_index_elements', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Breadcrumb
$id = 'woocommerce_index_page_title';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show page title', 'suki' ),
	'priority'    => 20,
) ) );

// Breadcrumb
$id = 'woocommerce_index_breadcrumb';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show breadcrumb', 'suki' ),
	'priority'    => 20,
) ) );

// Products filter
$id = 'woocommerce_index_filter';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show products filter', 'suki' ),
	'priority'    => 20,
) ) );

// Product Add to cart
$id = 'woocommerce_index_item_add_to_cart';
$wp_customize->add_setting( $id, array(
	'default'     => suki_array_value( $defaults, $id ),
	'sanitize_callback' => array( 'Suki_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Suki_Customize_Control_Toggle( $wp_customize, $id, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show "add to cart" on each product', 'suki' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Suki Pro Teaser
 * ====================================================
 */

if ( suki_show_pro_teaser() ) {
	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_woocommerce_index_product_typography', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'Product Typography', 'Suki Pro teaser', 'suki' ),
		'url'         => 'https://sukiwp.com/pro/modules/advanced-typography/',
		'priority'    => 90,
	) ) );

	$wp_customize->add_control( new Suki_Customize_Control_Pro( $wp_customize, 'pro_teaser_woocommerce_index_product_styles', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'Products Grid Styles', 'Suki Pro teaser', 'suki' ),
		'url'         => 'https://sukiwp.com/pro/modules/advanced-woocommerce/',
		'priority'    => 90,
	) ) );
}