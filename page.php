<?php get_header(); ?>
<main id="content">
<?php if ( is_front_page() ) : ?>
<?php include 'homepage/posts.php';?>
		<!-- Two -->
			<section id="three" class="wrapper style2">
				<div class="inner">
<?php endif; ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="header">
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>
<div class="entry-content">
<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
<?php the_content(); ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
</article>

<?php if ( comments_open() && ! post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>
<?php if ( is_front_page() ) : ?>
				</div>
			</section>
<?php endif; ?>
</main> 
<?php if ( !is_front_page() ) : ?>
<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>