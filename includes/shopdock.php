<?php
/**
 * Template for cart
 * @package andrijamicic
 * @since 1.0.0
 */
?>
<div id="shopdock-ultra">



	<?php
	// check whether cart is not empty
	if ( sizeof( WC()->cart->get_cart() ) > 0 ):
	?>
		<div id="cart-wrap">

			<div id="cart-list">
				<div class="jspContainer">
					<div class="jspPane">
						<?php get_template_part( 'includes/loop-product', 'cart' ); ?>
					</div>
					<!-- /.jspPane -->
				</div>
				<!-- /.jspContainer -->
			</div>
			<!-- /cart-list -->

			<p class="cart-total">
				<?php echo WC()->cart->get_cart_subtotal(); ?>
				<a id="view-cart" href="<?php echo esc_url( wc_get_cart_url() ) ?>">
					<?php _e('Vidi korpu', 'andrijamicic') ?>
				</a>
			</p>


			<p class="checkout-button">
				<button type="submit" class="button checkout white flat" onClick="document.location.href='<?php echo esc_url( wc_get_checkout_url() ); ?>'; return false;"><?php _e('Završi kupovinu', 'andrijamicic')?></button>
			</p>
			<!-- /checkout-botton -->

		</div>
		<!-- /#cart-wrap -->
	<?php else: ?>
		<?php printf( __( 'Niste još ništa naručili. Pogledajte <a href="%s">cene</a>.', 'andrijamicic' )
			, get_permalink( version_compare( WOOCOMMERCE_VERSION, '3.0.0', '>=' )
				? wc_get_page_id( 'shop' )
				: woocommerce_get_page_id( 'shop' ) ) ); ?>
	<?php endif; // cart whether is not empty?>

</div>
<!-- /#shopdock -->
