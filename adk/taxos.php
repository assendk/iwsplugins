<?php
/*
Plugin Name: adk Taxonomies for Woo Products
Description: A shortcode to display taxonomies and their terms that are associated with at least one product. [tax_for_woo]
Version: 1.0
Author: Your Name
*/

// Add the shortcode
add_shortcode('tax_for_woo', 'print_tax_for_woo');

function print_tax_for_woo() {
	// Make sure WooCommerce is active
	if (!class_exists('WooCommerce')) {
		return '<p>WooCommerce is not active.</p>';
	}

	// Get all taxonomies for products
	$taxonomies = get_object_taxonomies('product', 'objects');

	$output = '';

	// Go through each taxonomy
	foreach ($taxonomies as $taxonomy_slug => $taxonomy) {
		// Get all terms in this taxonomy
		$terms = get_terms(array('taxonomy' => $taxonomy_slug, 'hide_empty' => false));

		// Go through each term
		foreach ($terms as $term) {
			// Check if there are any products associated with this term
			$posts = get_posts(array(
				'post_type' => 'product',
				'numberposts' => 1, // We only need to know if there's at least one
				'tax_query' => array(
					array(
//						'taxonomy' => $taxonomy_slug,
						'taxonomy' => 'awards',
						'terms' => $term->term_id
					)
				)
			));

			// If there's at least one product associated with this term
			if ($posts) {
				$output .= '<h1>' . $taxonomy->label . ': ' . $term->name . '::' .  $term->slug . '</h1>';
//				$output .= '<h1>' . $taxonomy->label . ': ' . $term->name . json_encode($term) . '</h1>';
			}
		}
	}

	return $output;
}
