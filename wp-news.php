<?php
/*
Plugin Name: wp custompost
Plugin URI: http://www.bcn-cluster.com/
Description: Custom Post in WordPress
Version: 0.1
Author: A. Fontana
*/


//Add Image Size
//add_image_size( 'new-thumb', 96, 96, true ); // Hard Crop Mode

//Register Custom Post Types

add_action( 'init', 'register_fi_new' );

function register_fi_new() {

    $labels = array( 
        'name' => _x( 'News', 'new' ),
        'singular_name' => _x( 'new', 'new' ),
        'add_new' => _x( 'Add New', 'new' ),
        'add_new_item' => _x( 'Add New new', 'new' ),
        'edit_item' => _x( 'Edit new', 'new' ),
        'new_item' => _x( 'New new', 'new' ),
        'view_item' => _x( 'View new', 'new' ),
        'search_items' => _x( 'Search News', 'new' ),
        'not_found' => _x( 'No news found', 'new' ),
        'not_found_in_trash' => _x( 'No news found in Trash', 'new' ),
        'parent_item_colon' => _x( 'Parent new:', 'new' ),
        'menu_name' => _x( 'News', 'new' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        //'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'revisions' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'new', $args );
}

//Custom Meta Box


$key = "new";
$meta_boxes = array(
"campodemas" => array(
"name" => "campodemas",
"title" => "Link",
"description" => "Enter the link url.")
);
 
function create_meta_box() {
global $key;
 
if( function_exists( 'add_meta_box' ) ) {
add_meta_box( 'new-meta-boxes', ucfirst( $key ) . ' Info adicional', 'display_meta_box', 'new', 'normal', 'high' );
}
}
 
function display_meta_box() {
global $post, $meta_boxes, $key;
?>
 
<div class="form-wrap">
 
<?php
wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
 
foreach($meta_boxes as $meta_box) {
$data = get_post_meta($post->ID, $key, true);
?>
 
<div class="form-field form-required">
<label for="<?php echo $meta_box[ 'name' ]; ?>"><?php echo $meta_box[ 'title' ]; ?></label>
<input type="text" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo htmlspecialchars( $data[ $meta_box[ 'name' ] ] ); ?>" />
<p><?php echo $meta_box[ 'description' ]; ?></p>
</div>
 
<?php } ?>
 
</div>
<?php
}
 
function save_meta_box( $post_id ) {
global $post, $meta_boxes, $key;
 
foreach( $meta_boxes as $meta_box ) {
$data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
}
 
if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce' ], plugin_basename(__FILE__) ) )
return $post_id;
 
if ( !current_user_can( 'edit_post', $post_id ))
return $post_id;
 
update_post_meta( $post_id, $key, $data );
}
 
add_action( 'admin_menu', 'create_meta_box' );
add_action( 'save_post', 'save_meta_box' );

// force the tenplate
add_filter( 'template_include', 'include_reviews_template', 1 );
function include_reviews_template($template_path){
    if ( get_post_type() == 'new' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array( 'single-movie-reviews.php' ) ) ) {
                    $template_path = $theme_file;
                } else {
                    $template_path = plugin_dir_path( __FILE__ ) . '/news-loop.php';
            }
        }
    }
    return $template_path;
}

