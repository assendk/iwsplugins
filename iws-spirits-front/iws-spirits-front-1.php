<?php
/*
Plugin Name: IWS Spirits Home Carousel
Plugin URI: https://assen.xyz/
Description: Displays a list of subcategory logos with customizable image size. [award_frontpage_crl]
Version: 1.0
Author: Assen Kovachev
Author URI: https://assen.xyz/
License: GPLv2 or later
Text Domain: subcategory-list
*/

// Styles and Scripts Enqueue
function my_iwsspirits_enqueue_styles() {
	if ( ! wp_style_is( 'my-bundle-style', 'enqueued' ) ) {
		// CSS file from bundle is not loaded, enqueue it
		wp_enqueue_style( 'my-iwsaf2-css-1', plugin_dir_url( __FILE__ ) . 'css/swiper-bundle.min.css', array(), '1.0' );
	}
	wp_enqueue_style( 'my-iwsaf2-css-2', plugin_dir_url( __FILE__ ) . 'css/custom-spirits-home.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'my_iwsspirits_enqueue_styles' );

function spirits_plugin_enqueue_scripts() {
	if ( ! wp_script_is( 'swiper-bundle', 'enqueued' ) ) {
		// Swiper script is not loaded, enqueue it
		wp_enqueue_script( 'swiper-bundle', plugin_dir_url( __FILE__ ) . 'js/swiper-bundle.min.js', array(), '1.0.0', true );
	}
	wp_enqueue_script( 'my-spirits-js-1', plugin_dir_url( __FILE__ ) . 'js/customjs-spirits-home.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'spirits_plugin_enqueue_scripts' );

//function add_defer_attribute($tag, $handle) {
//	if ('my-script' === $handle) {
//		return str_replace(' src', ' defer src', $tag);
//	}
//	return $tag;
//}
//add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);

function iws_spirits_carousel_2($atts) {
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
	$output = '';
	$output .= '<div class="swiper-container-'.$cid.'" style="height: '. $atts['height'] .'">';
	$output .= '<div class="swiper mySwiper'.$cid.' swiper-grid swiper-grid-column swiper-backface-hidden">';
	$output .= '<div class="swiper-wrapper">';

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

				// Display the product brand logo
				if ($brand_logo && $brand_logo[0]) {
					$output .= '<div class="swiper-slide">';
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
	$output .= '<div class="swiper-pagination"></div>';
	if (filter_var($atts['carrows'], FILTER_VALIDATE_BOOLEAN)) {
		$output .= '<div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>';
	}
	$output .= "</div>";
	$output .= "</div>";

	return $output;
}
add_shortcode('spirits_home_carousel', 'iws_spirits_carousel_2');
