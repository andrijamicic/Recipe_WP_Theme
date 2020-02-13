<?php

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) {

			 // Woocommerc PHOTOSWIPE deregister, register new location
			 add_action( 'wp_enqueue_scripts', 'load_photoswipe_scripts' );			
			} 
			 
			 else { return false; }
	}
}
 
function load_photoswipe_scripts() {
	global $wp_scripts; 
	$wp_scripts->registered[ 'photoswipe' ]->src = get_template_directory_uri() . '/photoswipe/lib/photoswipe.js';
	$wp_scripts->registered[ 'photoswipe-ui-default' ]->src = get_template_directory_uri() . '/photoswipe/lib/photoswipe-ui-default.js';
	}
	
add_filter( 'woocommerce_add_to_cart_fragments', 'cart_count_fragments', 10, 1 );
 
function cart_count_fragments( $fragments ) {

	// cart list
	ob_start();
	get_template_part( 'includes/shopdock' );
	$shopdock = ob_get_clean();

	global $woocommerce;

	$fragments['#shopdock-ultra'] = $shopdock;
	$fragments['.check-cart'] = sprintf( '<span class="%s"></span>', WC()->cart->get_cart_contents_count() > 0 ? 'check-cart show-count' : 'check-cart' );    
    $fragments['#cart-icon span'] = sprintf( '<span>%s</span>', WC()->cart->get_cart_contents_count() );
    
    return $fragments;
    
} 
/**
 * Single product lightbox
 **/
function andrijamicic_redirect_product_ajax_content() {
	global $post, $wp_query;
	// locate template single page in lightbox
	if (is_single() && isset($_GET['ajax']) && $_GET['ajax']) {
		// remove admin bar inside iframe
		add_filter( 'show_admin_bar', '__return_false' );
		if (have_posts()) {
			woocommerce_single_product_content_ajax();
			die();
		} else {
			$wp_query->is_404 = true;
		}
	}
}
 
// Add specific CSS class by filter.
function andrijamicic_slide_cart_body_class( $classes ) {
	
		$classes[] = 'slide-cart';
	

	return $classes;
}
add_filter( 'body_class', 'andrijamicic_slide_cart_body_class' );
?>

