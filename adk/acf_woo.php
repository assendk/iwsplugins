<?php

/*
Plugin Name: ACF Fields for Woo Products
Description: A shortcode to display ACF fields for WooCommerce products. [acf_for_woo]
Version: 1.0
Author: Your Name
*/

// Add the shortcode
//add_shortcode( 'acf_for_woo', 'print_acf_for_woo' );
//
//function print_acf_for_woo() {
//	// Make sure WooCommerce and ACF are active
//	if ( ! class_exists( 'WooCommerce' ) || ! function_exists( 'get_field_objects' ) ) {
//		return '<p>WooCommerce and/or Advanced Custom Fields are not active.</p>';
//	}
//
//	$args = array(
//		'post_type'      => 'product',
//		'posts_per_page' => - 1
//	);
//	$loop = new WP_Query( $args );
//
//	$output = '';
//
//	if ( $loop->have_posts() ) {
//		while ( $loop->have_posts() ): $loop->the_post();
//			global $post;
//
//			$field_objects = get_field_objects();
//
//			if ( $field_objects ) {
//				foreach ( $field_objects as $field_name => $field ) {
//					$output .= '<h1>***' . $field['label'] . '</h1>';
//					$output .= '<p>' . $field['value'] . '</p>';
//				}
//			}
//		endwhile;
//	}
//
//	wp_reset_postdata();
//
//	return $output;
//}

//// Add the shortcode
//add_shortcode('acf_for_woo', 'print_acf_for_woo');
//
//function print_acf_for_woo() {
//	// Make sure WooCommerce and ACF are active
//	if ( ! class_exists('WooCommerce') || ! function_exists('get_field_objects')) {
//		return '<p>WooCommerce and/or Advanced Custom Fields are not active.</p>';
//	}
//
//	$args = array(
//		'post_type' => 'product',
//		'posts_per_page' => -1,
//		'product_cat' => 'Wines'
//	);
//	$loop = new WP_Query($args);
//
//	$output = '';
//
//	if ($loop->have_posts()) {
//		while ($loop->have_posts()): $loop->the_post();
//			global $post;
//
//			// Get 'Awards' terms for this product
//			$terms = get_the_terms($post->ID, 'Awards');
//
//			if ($terms) {
//				foreach ($terms as $term) {
//					// Get the ACF fields for this term
//					$fields = get_fields($term);
//
//					if ($fields) {
//						foreach ($fields as $field_name => $value) {
//							$output .= '<h1>' . $field_name . '</h1>';
//							$output .= '<p>' . $value . '</p>';
//						}
//					}
//				}
//			}
//		endwhile;
//	}
//
//	wp_reset_postdata();
//
//	return $output;
//}
// Add the shortcode
add_shortcode('acf_for_woo', 'print_acf_for_woo');

function print_acf_for_woo() {
	// Make sure WooCommerce and ACF are active
	if ( ! class_exists('WooCommerce') || ! function_exists('get_field_objects')) {
		return '<p>WooCommerce and/or Advanced Custom Fields are not active.</p>';
	}

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'product_cat' => 'Wines'
	);
	$loop = new WP_Query($args);

	$output = '';

	if ($loop->have_posts()) {
		while ($loop->have_posts()): $loop->the_post();
			global $post;

			// Get 'Awards' terms for this product
			$terms = get_the_terms($post->ID, 'Awards');

			if ($terms) {
				foreach ($terms as $term) {
					// Get the ACF fields for this term
					$fields = get_fields($term);

					if ($fields) {
						foreach ($fields as $field_name => $value) {
							$output .= '<h1>' . $field_name . '</h1>';
							$output .= '<p>' . json_encode($value) . '</p>';
						}
					}
				}
			}
		endwhile;
	}

	wp_reset_postdata();

	return $output;
}
