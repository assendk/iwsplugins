<?php
/*
Plugin Name: IWS Spirits Filter Grid
Plugin URI: https://assen.xyz/
Description: Displays a list of subcategory logos with customizable image size. [spirits_filter_grid]
Version: 1.0
Author: Assen Kovachev
Author URI: https://assen.xyz/
License: GPLv2 or later
Text Domain: subcategory-list
*/

// Styles and Scripts Enqueue
function my_iwsspirits_filter_enqueue_styles() {
	wp_enqueue_style( 'my-spirits-filter-css-2', plugin_dir_url( __FILE__ ) . 'css/custom-spirits-filter.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'my_iwsspirits_filter_enqueue_styles' );

function spirits_plugin_enqueue_filter_scripts() {
	wp_enqueue_script( 'my-spirits-filter-js-1', plugin_dir_url( __FILE__ ) . 'js/customjs-spirits-filter.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'spirits_plugin_enqueue_filter_scripts' );

function iws_spirits_filter($atts) {
	// Extract the shortcode attributes
	$atts = shortcode_atts(array(
		'category' => 'spirits',
		'use_acf_logo' => 'true',
		'acf_field' => 'brand_logo',
		'logo_color' => 'default', // New attribute
		'grid' => '6',
		'rows' => 'auto',
		'columns' => '4',
		'carrows' => 'true',
		'cid' => '1',
		'height' => '480px',
	), $atts);

	$cid = $atts['cid'];

	// Get the category object
	$category = get_term_by('slug', $atts['category'], 'product_cat');

	// Convert 'use_acf_logo' attribute to boolean
	$use_acf_logo = filter_var($atts['use_acf_logo'], FILTER_VALIDATE_BOOLEAN);

	// Get the ACF field to use
	$acf_field = sanitize_text_field($atts['acf_field']);

	// Use the 'brand_logo_white' field if 'logo_color' attribute is 'white'
	if ($atts['logo_color'] == 'white') {
		$acf_field = 'brand_logo_white';
	}

	// Initialize the output variable
	$output = '<div class="filter-container">
				    <button class="filter active" data-group="all">All</button>
				    <button class="filter" data-group="wine">Wine</button>
				    <button class="filter" data-group="vodka">Vodka</button>
				</div>';

  $output = '<div>';

	// Check if the specified category exists
	if ($category && !is_wp_error($category)) {
		// Get the products of the specified category
		$products = get_posts(array(
			'post_type' => 'product',
			'numberposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => $category->slug,
				),
			),
		));

		// Loop through the products
		if (!empty($products)) {
			foreach ($products as $product) {
				// Get the product brand logo
				$brand_logo = '';
				if ($use_acf_logo) {
					$brand_logo_id = get_field($acf_field, $product->ID);
					$brand_logo = wp_get_attachment_image_src($brand_logo_id, 'full');
				}

				// Generate the URL based on the product
				$product_url = get_permalink($product->ID);

				// Get the product tags and convert them to class names
				$tags = wp_get_post_terms($product->ID, 'product_tag');
				$tag_classes = array_map(function($tag) {
					return sanitize_html_class($tag->slug, $tag->term_id);
				}, $tags);
				$tag_classes = implode(' ', $tag_classes);

				// Display the product brand logo
				if ($brand_logo && $brand_logo[0]) {
					$output .= '<div class="swiper-slide ' . $tag_classes . '">';
					$output .= '<a href="' . $product_url . '">';
					$output .= '<img src="' . $brand_logo[0] . '" alt="' . $product->post_title . '">';
					$output .= '</a>';
					$output .= '</div>';
				}
			}
		} else {
			$output = 'No products found.';
		}
	} else {
		$output = 'The specified category does not exist.';
	}

	$output .= "</div>";


	return $output;
}
add_shortcode('spirits_filter_grid', 'iws_spirits_filter');
