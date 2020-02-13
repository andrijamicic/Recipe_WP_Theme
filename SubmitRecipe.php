<?php /* Template Name: SubmitRecipe */ ?>
<?php get_header(); ?>
<main id="content">
<form method="POST" enctype="multipart/form-data">
<label>Recipe name</label>
        <input type="text" value="" class="input-xlarge" name='title'>
        <label>Recipe description</label>
        <textarea rows="3" class="input-xlarge" name='post_content'>
        </textarea>
        <label>Select image to upload:</label>
        <input type="file" name="file[]" multiple="multiple" id="fileToUpload" class="input-xlarge" placeholder="Image"/>
        <div><br>
            <button class="btn btn-primary">Add Recipe</button>
        </div>
        <input type="hidden" name="action" value="recipe" />
 </form>
 <footer class="footer">
   <?php get_template_part( 'nav', 'below' ); ?>
</footer>
 </main> 
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/*
Fronted submit post
*/
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == "recipe") {

    $title     = $_POST['title'];
    $post_content     = $_POST['post_content'];
    $post_type = 'Recipes';
    //the array of arguements to be inserted with wp_insert_post
    $front_post = array(
    'post_title'    => $title,
    'post_status'   =>  'pending', 
    'post_content'   => $post_content,       
    'post_type'     => $post_type 
    );

    //insert the the post into database by passing $new_post to wp_insert_post
    //store our post ID in a variable $pid
    $post_id = wp_insert_post($front_post);

    if ( $_FILES ) { 
        $files = $_FILES["file"];  
        foreach ($files['name'] as $key => $value) {            
                if ($files['name'][$key]) { 
                    $file = array( 
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key], 
                        'tmp_name' => $files['tmp_name'][$key], 
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    ); 
                    $_FILES = array ("file" => $file); 
                    foreach ($_FILES as $file => $array) {              
                        $newupload = frontend_handle_attachment( $file, $post_id ); 
                    }
                } 
            } 
        }
    //we now use $pid (post id) to help add out post meta data
   // update_post_meta($post_id, "description", @$_POST["description"]);
}


function frontend_handle_attachment($file_handler,$post_id) {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    
    $attach_id = media_handle_upload( $file_handler, $post_id );
    
    // Set featured image 
    set_post_thumbnail($post_id, $attach_id);
    return $attach_id;
    }
?>