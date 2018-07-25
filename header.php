<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		/**
		 * Hook: suki/frontend/before_canvas
		 *
		 * @hooked suki_skip_to_content_link - 1
		 * @hooked suki_top_popups - 10
		 */
		do_action( 'suki/frontend/before_canvas' );
		?>

		<div id="canvas" class="suki-canvas">
			<div id="page" class="site">

				<?php
				/**
				 * Hook: suki/frontend/before_header
				 */
				do_action( 'suki/frontend/before_header' );

				/**
				 * Header
				 */
				suki_header();

				/**
				 * Hook: suki/frontend/after_header
				 *
				 * @hooked suki_page_title - 10
				 */
				do_action( 'suki/frontend/after_header' );
				
				if ( apply_filters( 'suki/frontend/is_using_content_wrapper', true ) ) : ?>
					<div id="content" class="site-content suki-section <?php echo esc_attr( implode( ' ', apply_filters( 'suki/frontend/content_classes', array() ) ) ); ?>">
						<div class="suki-section-inner">
							<div class="suki-wrapper">
								<div class="suki-content-row">
				<?php endif;