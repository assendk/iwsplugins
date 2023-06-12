<?php
///*
//Plugin Name: Update Taxonomy Terms
//Description: A simple plugin that updates all terms in a specific taxonomy with a default value for a new custom field.
//Version: 1.0
//Author: Your Name
//*/
//
//function update_taxonomy_terms() {
//	$taxonomy      = 'awards'; // replace with your taxonomy
//	$meta_key      = 'visible_in_lists'; // replace with your meta key
//	$default_value = 'yes'; // replace with your default value
//
//	$terms = get_terms( array(
//		'taxonomy'   => $taxonomy,
//		'hide_empty' => false,
//	) );
//
//	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
//		foreach ( $terms as $term ) {
//			if ( ! get_term_meta( $term->term_id, $meta_key, true ) ) {
//				update_term_meta( $term->term_id, $meta_key, $default_value );
//			}
//		}
//	}
//}
//
//// Run the function when the plugin is activated
//register_activation_hook( __FILE__, 'update_taxonomy_terms' );
