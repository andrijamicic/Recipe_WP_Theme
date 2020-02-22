<?php 
// the query
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$recipe_query = new WP_Query(
	array('post_type'=>'Recipes', 
	'post_status'=>'publish',
	'nopaging'=> false,
//	'posts_per_page'=>3, 
	'order'=>'DESC',
	'orderby'=>'ID',
        'paged' => $paged)); 
?>
<?php function get_excerpt($contents){
$excerpt = $contents;
$excerpt = preg_replace(" ([.*?])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 20);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
$excerpt = $excerpt.'... <a href="'.get_the_permalink().'">more</a>';
return $excerpt;
}?>
<!-- limit excpert (default is 50) -->
<?php
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}?>
<!-- limit content (default is max) --> 
<?php
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]>', $content);
  return $content;
}?>
<?php if ( $recipe_query->have_posts() ) : ?>
    <!-- the loop -->
			<section >
				<div class="inner">
					<div class="grid-style">
                     <?php while ( $recipe_query->have_posts())  : $recipe_query->the_post(); ?>
					    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?> 
						<div>
							<div class="box">
								<div class="image fit">
									<img src="<?php echo $image[0]; ?>" alt="">
								</div>
								<div class="content">
									<header class="align-center">
										<p> <?php 
										$i = 0; 
										$value = get_the_category();
										$len = count($value); 
										foreach($value as $category){
											if ($i == $len - 1) {
										echo $category->name."";
        }	
		else{
										echo $category->name." | ";
        } ++$i;}	?> </p> 
										<h2><?php the_title(); ?></h2>
									</header>
									<?php echo content(50); ?>
									<footer class="align-center">
									    <a class="button alt" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</footer>
								</div>
							</div>
						</div>
                     <?php endwhile; ?>
					</div>
				</div>
			</section>
	<!-- end of the loop -->
	<div class="pagination">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $recipe_query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Recipes', 'andrijamicic' ) ),
            'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Recipes', 'andrijamicic' ) ),
            'add_args'     => false,
            'add_fragment' => '',
        ) );
    ?>
</div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

