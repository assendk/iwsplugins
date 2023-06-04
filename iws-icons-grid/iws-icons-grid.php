<?php
/*
Plugin Name: IWS Icons Grid
Plugin URI: https://assen.xyz/
Description: Displays a list of subcategory logos with customizable image size. [subcategory_grid_1 category="wines"], params 'use_acf_logo' => 'true','image_size' => '150px'
Version: 1.4
Author: Assen Kovachev
Author URI: https://assen.xyz/
License: GPLv2 or later
Text Domain: subcategory-list
*/

// Register the shortcode
function iws_spirits_subcategory_list_shortcode_3($atts) {
	// Extract the shortcode attributes
	$atts = shortcode_atts(array(
		'category' => 'wines',
		'use_acf_logo' => 'true',
		'image_size' => '120px', // Default image size
	), $atts);

	// Get the category object
	$category = get_term_by('slug', $atts['category'], 'product_cat');

	// Convert 'use_acf_logo' attribute to boolean
	$use_acf_logo = filter_var($atts['use_acf_logo'], FILTER_VALIDATE_BOOLEAN);

	// Start the output with a style block for our image size
	$output = '
		<style>
			.list-container-1 {
	list-style-type: none;
	padding: 0;
	display: flex;        /* This */
	flex-wrap: wrap;       /* This */
	justify-content: center; /* And this */
}

.list-container-1 li {
	text-align: center;
	margin-bottom: 8px;
	padding: 15px;
	/* display: inline-block; Remove this */
	flex: 0 1 auto;        /* Add this */
}

.list-container-1 img {
	width: ' . esc_attr($atts['image_size']) . ';
	height: auto;
}

		</style>
	';

	// Start the list container
	$output .= '<ul class="list-container-1">';

	// Check if the specified category exists
	if ($category && !is_wp_error($category)) {
		// Get the subcategories of the specified category
		$subcategories = get_terms([
			'taxonomy' => 'product_cat',
			'parent' => $category->term_id,
			'hide_empty' => false, // Set to true if you only want to retrieve non-empty categories
		]);

		// Loop through the subcategories
		if (!empty($subcategories)) {
			foreach ($subcategories as $subcategory) {
				// Get the subcategory logo
				$subcategory_logo = '';
				if ($use_acf_logo) {
					$subcategory_logo_id = get_field('home_page_logo', 'product_cat_' . $subcategory->term_id);
					$subcategory_logo = wp_get_attachment_image_src($subcategory_logo_id, 'full');
				} else {
					$subcategory_logo = get_term_meta($subcategory->term_id, 'thumbnail_id', true);
					$subcategory_logo = wp_get_attachment_image_src($subcategory_logo, 'full');
				}

				// Generate the URL based on the subcategory's slug
				$subcategory_url = get_term_link($subcategory, 'product_cat');

				// Display the subcategory logo
				if ($subcategory_logo && $subcategory_logo[0]) {
					$output .= '<li class="list-item">';
					$output .= '<a href="' . esc_url($subcategory_url) . '">';
					$output .= '<img src="' . esc_url($subcategory_logo[0]) . '" alt="' . esc_attr($subcategory->name) . '">';
					$output .= '</a>';
					$output .= '</li>';

				} else {
					$output .= '<li class="list-item">';
					$output .= '<a href="' . esc_url($subcategory_url) . '">';
					$output .= '<img src="' . esc_url(plugins_url('assets/placeholder.png', __FILE__)) . '" alt="' . esc_attr($subcategory->name) . '">';
					$output .= '</a>';
					$output .= '</li>';
				}
			}
		} else {
			$output = 'No subcategories found.';
		}
	} else {
		$output = 'The specified category does not exist.';
	}

	$output .= '</ul>'; // End the list container

	return $output;
}
add_shortcode('subcategory_grid_1', 'iws_spirits_subcategory_list_shortcode_3');
