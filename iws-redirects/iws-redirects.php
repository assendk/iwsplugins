<?php
/*
Plugin Name: IWS Custom Redirects
Description: A simple plugin that redirects specific pages to other URLs.
Version: 1.0
Author: Assen Kovachev
*/

function iws_custom_redirects() {
	$current_url = trim( parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
	$site_url    = get_site_url(); // Get the current site URL

	$redirects = array(
		'category/wines' => "$site_url/brands/wines/",
		'old-slug-2' => "$site_url/new-slug-2",
		// Add more redirects here
	);

	if ( array_key_exists( $current_url, $redirects ) ) {
		wp_redirect( $redirects[ $current_url ], 301 );
		exit();
	}
}

add_action( 'template_redirect', 'iws_custom_redirects' );