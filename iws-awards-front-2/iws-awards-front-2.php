<?php
/*
Plugin Name: IWS Awards Front Carousel 2
Plugin URI: https://assen.xyz/
Description: Displays a list of subcategory logos with customizable image size. [award_frontpage_crl]
Version: 2.1
Author: Assen Kovachev
Author URI: https://assen.xyz/
License: GPLv2 or later
Text Domain: subcategory-list
*/

// Styles and Scripts Enqueue
function my_iwsaf2_enqueue_styles() {
	if ( ! wp_style_is( 'my-bundle-style', 'enqueued' ) ) {
		// CSS file from bundle is not loaded, enqueue it
		wp_enqueue_style( 'my-iwsaf2-css-1', plugin_dir_url( __FILE__ ) . 'css/swiper-bundle.min.css', array(), '1.0' );
	}
	wp_enqueue_style( 'my-iwsaf2-css-2', plugin_dir_url( __FILE__ ) . 'css/custom-iwsaf2.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'my_iwsaf2_enqueue_styles' );

function my_plugin_enqueue_scripts() {
	if ( ! wp_script_is( 'swiper-bundle', 'enqueued' ) ) {
		// Swiper script is not loaded, enqueue it
		wp_enqueue_script( 'swiper-bundle', plugin_dir_url( __FILE__ ) . 'js/swiper-bundle.min.js', array(), '1.0.0', true );
	}
	wp_enqueue_script( 'my-iwsaf2-js-1', plugin_dir_url( __FILE__ ) . 'js/customjs-iwsaf2.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_scripts' );

function add_defer_attribute($tag, $handle) {
	if ('my-script' === $handle) {
		return str_replace(' src', ' defer src', $tag);
	}
	return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);

function award_carousel_4($atts) {

	$atts = shortcode_atts(array(
		'height' => '280px',
	), $atts);

	$term_query = new WP_Term_Query( array(
		'taxonomy' => 'awards',
		'parent' => 0,
		'hide_empty' => false,
	) );
	$output = '';

	$output .= '<div class="swiper-container swiper4" style="height: '. $atts['height'] .'">';
	$output .= '<div class="swiper mySwiper4 swiper-grid swiper-grid-column swiper-backface-hidden">';
	$output .= '<div class="swiper-wrapper">';
	if ( ! empty( $term_query->terms ) ) {

		foreach ( $term_query->terms as $term ) {
			$slug = $term->slug;
			$url = get_site_url() . '/awards/' . $slug;

			$logo = get_field('logo', $term);
			$output .= '<div class="swiper-slide">';

				if ($logo) {
					$output .= '<div class="award-logo-item4">'; // start award-logo-item div
					$output .= '<div class="award-logo-wrapper4">'; // start award-logo-wrapper div
						$output .= '<div class="award-logo-container4"><a href="' . $url . '"><img src="' . esc_url($logo) . '" alt="' . esc_attr($term->name) . '"/></a></div>';
						$output .= '<div class="award-name4">' . $term->name . '</div>';
					$output .= '</div>'; // end award-logo-wrapper div
					$output .= '</div>'; // end award-logo-item div
				} else {
					$output .= 'No logo found';
				}

			$output .= '</div>';

		}

	$output .= '</div>';
      $output .= '<div class="swiper-pagination"></div>';
    $output .= '</div>';
    $output .= '</div>';

	} else {
		$output .= 'No terms found.';
	}
	return $output;
}
add_shortcode('award_frontpage_crl', 'award_carousel_4');