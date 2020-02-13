<?php $args = array(
'prev_text' => sprintf( esc_html__( '%s older', 'andrijamicic' ), '<span class="meta-nav">&larr;</span>' ),
'next_text' => sprintf( esc_html__( 'newer %s', 'andrijamicic' ), '<span class="meta-nav">&rarr;</span>' )
);
the_posts_navigation( $args ); ?>