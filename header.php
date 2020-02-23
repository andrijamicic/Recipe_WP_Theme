<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
<header id="header" class="alt">
<div class="logo">
<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; } ?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; } ?>
<span><?php bloginfo( 'description' ); ?></span>
</div>
<a href="#menu">LINKOVI</a>
</header>
<nav id="menu">
<div id="search"><?php get_search_form(); ?></div>
<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 
 //'after'    => '<span class="child-arrow"></span>', 
 ) ); ?>
<?php if (true) : global $woocommerce; ?>
<?php $class = ( is_object( $woocommerce->cart ) ? $woocommerce->cart->get_cart_contents_count() : '0' > 0) ? "cart-icon" : "cart-icon empty-cart"; ?>
	<div class="<?php echo $class; ?>">
		<span class="check-cart"></span>
		<div class="cart-wrap">
			<a id="cart-icon" href="#slide-cart">
				<i class="fa fa-shopping-cart"></i>
				<span>
					<?php echo $woocommerce->cart->get_cart_contents_count(); ?>
				</span>
			</a>
			<!-- /.cart-wrap -->
		</div>
	</div>	
<?php endif; ?>										
</nav>

<div id="container">
					<div id="slide-cart" class="sidemenu sidemenu-off">
						<a id="cart-icon-close"></a>
						<?php include 'includes/shopdock.php';?>
					</div>
