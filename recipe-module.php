<?php
/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Recipes', 'Post Type General Name', 'andrijamicic' ),
        'singular_name'       => _x( 'Recipe', 'Post Type Singular Name', 'andrijamicic' ),
        'menu_name'           => __( 'Recipes', 'andrijamicic' ),
        'parent_item_colon'   => __( 'Parent Recipe', 'andrijamicic' ),
        'all_items'           => __( 'All Recipes', 'andrijamicic' ),
        'view_item'           => __( 'View Recipe', 'andrijamicic' ),
        'add_new_item'        => __( 'Add New Recipe', 'andrijamicic' ),
        'add_new'             => __( 'Add New', 'andrijamicic' ),
        'edit_item'           => __( 'Edit Recipe', 'andrijamicic' ),
        'update_item'         => __( 'Update Recipe', 'andrijamicic' ),
        'search_items'        => __( 'Search Recipe', 'andrijamicic' ),
        'not_found'           => __( 'Not Found', 'andrijamicic' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'andrijamicic' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Recipes', 'andrijamicic' ),
        'description'         => __( 'Recipe news and reviews', 'andrijamicic' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'show_in_admin_status_list' => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'Recipes', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );				
?>
<?php
/*
* Displaying Custom Post Types on The Front Page
*/

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
 
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'Recipes' ) );
    return $query;
}

?>
<?php
/*
Add Custom Post Types to Your Main WordPress RSS Feed
*/
function myfeed_request($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('post', 'Recipes');
    return $qv;
}
add_filter('request', 'myfeed_request');
?>
<?php

/*
Add Custom Post Types shortcode
*/
    add_shortcode( 'shortcoderecipe', 'display_custom_post_type' );
    function display_custom_post_type(){
        $args = array(
            'post_type' => 'Recipes',
            'post_status' => 'pending'
        );

        $string = '';
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            $string .= '<table><tbody>  <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Image</th>
            <th>Aprove Recipe</th>
          </tr>';
          $i = 0;
            while( $query->have_posts() ){
                $query->the_post();
                $i = $i+1;
                $imax = $i;
                $string .= '<tr>' . '<td>' . get_the_title() . '</td>' . '<td>' . get_the_content() . '</td>' . '<td>' . get_the_post_thumbnail() . '</td>' . '<td>' . '<form method="POST" enctype="multipart/form-data"> <button class="btn btn-primary">Aprove Recipe</button><input type="hidden" name="aprove' . $i . '" value="publish" /></form>' . '</td>' . '<td>' . '</td>' .'</tr>';
                $my_post = array(
                    'ID'           => get_the_ID(),
                    'post_status'   => 'publish',
                );
                if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['aprove' . $i] ) && $_POST['aprove' . $i] == "publish") {
                    wp_update_post( $my_post );
                  //  echo "<script type='text/javascript'>alert('$i');</script>";
                  echo "<meta http-equiv='refresh' content='0'>";
                }
            }
            $string .= '</tbody></table>';
        }
        wp_reset_postdata();
        return $string;
    }

?>
    <?php
if (current_user_can( 'manage_options' )) {    
class MyNewWidget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'My New Widget Title' );
	}

	function widget( $args, $instance ) {
        echo do_shortcode( '[shortcoderecipe]' );
		// Widget output
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// Output admin widget options form
	}
}

function myplugin_register_widgets() {
	register_widget( 'MyNewWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );
} 
    ?>