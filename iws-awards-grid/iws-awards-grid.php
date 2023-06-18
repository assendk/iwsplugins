<?php
/*
Plugin Name: IWS Awards Grid on Page
Plugin URI: https://assen.xyz/
Description: Displays a list of subcategory logos with customizable image size.
Version: 1.0
Author: Assen Kovachev
Author URI: https://assen.xyz/
License: GPLv2 or later
Text Domain: subcategory-list
*/

function award_list_shortcode($atts) {
	// Extract attributes
	extract(shortcode_atts(array(
		'layout' => 'columns', // default to 'columns' if no 'layout' attribute is provided
	), $atts));

	$output = '';

	$term_query = new WP_Term_Query( array(
		'taxonomy' => 'awards',
		'parent' => 0,
		'hide_empty' => false,
	) );

	if ( ! empty( $term_query->terms ) ) {
		$output .= '<ul class="award-logos ' . ($layout === 'rows' ? 'rows' : 'columns') . '">'; // add the 'rows' or 'columns' class

		foreach ( $term_query->terms as $term ) {
			$slug = $term->slug;
			$url = get_site_url() . '/awards/' . $slug;

			$logo = get_field('logo', $term);
			$visibility =get_field('visible_in_lists', $term);

			$output .= '<li class="award-logo-item " '. $visibility .'>';
			if ($logo) {
				$output .= '<div class="award-logo-item-container">';
				$output .= '<div class="award-logo-container"><a href="' . $url . '"><img src="' . esc_url($logo) . '" alt="' . esc_attr($term->name) . '"/></a></div>';
				$output .= '<div class="award-name">' . $term->name . '</div>';
				$output .= '</div>';
			} else {
				$output .= 'No logo found';
			}
			$output .= '</li>';
		}

		$output .= '</ul>';
	} else {
		$output .= 'No terms found.';
	}

	return $output;
}
add_shortcode('award_list', 'award_list_shortcode');