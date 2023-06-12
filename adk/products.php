<?php
/*
Plugin Name: ACF Fields for Specific Woo Product
Description: A shortcode to display all linked taxonomies and their fields for a specific WooCommerce product.
Version: 1.0
Author: Your Name
*/

// Add the shortcode
//add_shortcode('acf_for_specific_woo_product', 'print_acf_for_specific_woo_product');
//
//function print_acf_for_specific_woo_product() {
//	// Make sure WooCommerce and ACF are active
//	if ( ! class_exists('WooCommerce') || ! function_exists('get_field_objects')) {
//		return '<p>WooCommerce and/or Advanced Custom Fields are not active.</p>';
//	}
//
//	$product_id = 3497; // Replace this with the ID of your product
//
//	// Get all taxonomies linked to the product
//	$taxonomies = get_object_taxonomies('product');
//
//	$output = '';
//
//	// Go through each taxonomy
//	foreach ($taxonomies as $taxonomy) {
//		// Get the terms of this taxonomy that are linked to the product
//		$terms = get_the_terms($product_id, $taxonomy);
//
//		if ($terms && ! is_wp_error($terms)) {
//			// Go through each term
//			foreach ($terms as $term) {
//				// Get the ACF fields for this term
//				$fields = get_fields($term);
//
//				if ($fields) {
//					$output .= '<h1>Taxonomy: ' . $taxonomy . ', Term: ' . $term->name . '</h1>';
//
//					// Go through each field
//					foreach ($fields as $field_name => $value) {
//						$output .= '<p>' . $field_name . ': ' . $value . '</p>';
//					}
//				}
//			}
//		}
//	}
//
//	return $output;
//}

// Add the shortcode
add_shortcode('acf_for_specific_woo_product', 'print_acf_for_specific_woo_product');

function print_acf_for_specific_woo_product() {
	// Make sure WooCommerce and ACF are active
	if ( ! class_exists('WooCommerce') || ! function_exists('get_field_objects')) {
		return '<p>WooCommerce and/or Advanced Custom Fields are not active.</p>';
	}

	$product_id = 3497; // Replace this with the ID of your product
	$taxonomy = 'awards'; // Replace this with the slug of your taxonomy
	$field_name = 'year'; // Replace this with the name of your field

	// Get the 'Awards' terms that are linked to the product
	$terms = get_the_terms($product_id, $taxonomy);

	$output = '';

	if ($terms && ! is_wp_error($terms)) {
		// Go through each term
		foreach ($terms as $term) {
			// Get the 'year' field for this term
			$field_value = get_field($field_name, $term);

			// If the 'year' field is not empty
			if (! empty($field_value)) {
				$output .= '<h1>Term: ' . $term->name . '</h1>';
				$output .= '<p>' . $field_name . ': ' . $field_value . '</p>';
			}
		}
	}

	return $output;
}