<?php
/**
 * Include post type product in WordPress' search
 * @param array
 * @return array
 * @since 1.0.0 
 */
function woocommerceframework_add_search_fragment ( $settings ) {
	$settings['add_fragment'] = '?post_type=product';
	return $settings;
}

/** gets the url to remove an item from dock cart */
function get_remove_url( $cart_item_key ) {
	global $woocommerce;

	$cart_page_id = version_compare( WOOCOMMERCE_VERSION, '3.0.0', '>=' )
		? wc_get_page_id( 'cart' )
		: woocommerce_get_page_id( 'cart' );
		
	if ($cart_page_id)
		return apply_filters('woocommerce_get_remove_url', $woocommerce->nonce_url( 'cart', add_query_arg('update_cart', $cart_item_key, get_permalink($cart_page_id))));
}
/**
 * Remove from cart/update
 **/
function update_cart_action() {
	global $woocommerce;
	
	// Update Cart
	if (isset($_GET['update_cart']) && $_GET['update_cart']  && $woocommerce->verify_nonce('cart')) :
		
		$cart_totals = $_GET['update_cart'];
		
		if (sizeof($woocommerce->cart->get_cart())>0) : 
			foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) :
				
        $update = $values['quantity'] - 1;
        
				if ($cart_totals == $cart_item_key) 
          $woocommerce->cart->set_quantity( $cart_item_key, $update);
				
			endforeach;
		endif;
		
		echo json_encode(array('deleted' => 'deleted'));
    die();
		
	endif;
}

/**
 * Add product variation value to callback lightbox
 **/
function product_variation_vars(){
  global $available_variations, $woocommerce, $product, $post;
  echo '<div class="hide" id="andrijamicic_product_vars">'.json_encode($available_variations).'</div>';
}

/**
 * Add cart total and shopdock cart to the WC Fragments
 * @param array $fragments 
 * @return array
 */
function theme_add_to_cart_fragments( $fragments ) {
	// cart list
	ob_start();
	get_template_part( 'includes/shopdock' );
	$shopdock = ob_get_clean();

	global $woocommerce;

	$fragments['#shopdock-ultra'] = $shopdock;
	$fragments['.check-cart'] = sprintf( '<span class="%s"></span>'
			, WC()->cart->get_cart_contents_count() > 0 ? 'check-cart show-count' : 'check-cart' );
	$fragments['#cart-icon span'] = sprintf( '<span>%s</span>', WC()->cart->get_cart_contents_count() );
	return $fragments;
}

/**
 * Delete cart
 * @return json
 */
function theme_woocommerce_delete_cart() {
	global $woocommerce;
	if ( isset($_POST['remove_item']) && $_POST['remove_item'] ) {
		$woocommerce->cart->set_quantity( $_POST['remove_item'], 0 );
		WC_AJAX::get_refreshed_fragments();
		die();
	}
}

/**
 * Add to cart ajax on single product page
 * @return json
 */
function theme_woocommerce_add_to_cart() {
	ob_start();
	WC_AJAX::get_refreshed_fragments();
	die();	
}





?>