<?php
/**
 * Template to display products in andrijamicic cart
 * @package andrijamicic
 * @since 1.0.0
 */

global $woocommerce;
$carts = array_reverse( $woocommerce->cart->get_cart() );

foreach ( $carts as $cart_item_key => $values ) :
	// Add support for MNM plugin
	if( isset( $values['mnm_container'] ) ) continue;

	$_product = $values['data'];

	if ( $_product->exists() && $values['quantity'] > 0 ): ?>

		<div class="product">

			<a href="<?php echo esc_url( version_compare( WOOCOMMERCE_VERSION, '3.3.0', '>=' )
					? wc_get_cart_remove_url( $cart_item_key ) : $woocommerce->cart->get_remove_url( $cart_item_key ) ); ?>" data-product-key="<?php echo $cart_item_key; ?>" class="remove-item remove-item-js">
				<i class="icon-flatshop-close"></i>
			</a>

			<figure class="product-image">
				<a href="<?php echo esc_url( get_permalink(apply_filters('woocommerce_in_cart_product_id', $values['product_id'])) ); ?>">
					<?php
						$product_thumbnail = $_product->get_image('cart_thumbnail');
						if ( ! empty( $product_thumbnail ) ) {
							echo $product_thumbnail;
						}
					?>
				</a>
			</figure>

			<div class="product-details">
				<h3 class="product-title">
					<a href="<?php echo esc_url( get_permalink(apply_filters('woocommerce_in_cart_product_id', $values['product_id'])) );?>">
						<?php echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ); ?>
					</a>
				</h3>
				<p class="quantity-count"><?php echo sprintf(__('x %d', 'andrijamicic'), $values['quantity']); ?></p>
			</div>

		</div>
		<!--/product -->

	<?php endif; ?>

<?php endforeach; ?>
