!-- mini-cart -->
<div class="mini-cart">
	<div class="mini-cart-inner">
		<?php
            global $woocommerce;
            $items = $woocommerce->cart->get_cart();
            $currency = get_woocommerce_currency_symbol();
            if (!$items) {
            	echo '<span class="no-items-mini">No items added</span>';
            }
                foreach($items as $item => $values) { 
                    $_product = $values['data']->post; 
                    $link = get_permalink($_product);
                    echo "<span>";
                    	echo $values['quantity']." x <a href='".$link."'>".$_product->post_title;
                    echo "<a/></span>";
                    $price = get_post_meta($values['product_id'] , '_price', true);
                    echo "  Price: ".$currency.$price."<br>";
                }
            $total = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
            echo "<span class='mini-total'><b>Total: </b>".$currency.$total."</span>";
        ?>
	</div>
	<p><span><a href="<?php echo get_home_url(); ?>/cart">View cart</span></a></p>
</div>
<!-- cart counter -->
<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></a>