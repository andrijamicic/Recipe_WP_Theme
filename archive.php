<?php get_header();  ?>
<main id="content">
<header class="header">
<h1 class="entry-title"><?php single_term_title(); ?></h1>
<div class="archive-meta"><?php if ( '' != the_archive_description() ) { echo esc_html( the_archive_description() ); } ?></div>
</header>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php endwhile; endif; ?>
<footer class="footer">
<?php get_template_part( 'nav', 'below' ); ?>
</footer>
<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php next_posts_link(__('Older', 'andrijamicic')); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer', 'andrijamicic')); ?></li>
    </ul>
  </nav>
<?php endif; ?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>