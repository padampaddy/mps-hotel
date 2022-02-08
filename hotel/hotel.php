<?php
function mps_hotel_init()
{
    $labels = array(
        'name'                  => _x('Hotels', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Hotel', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Hotels', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Hotel', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Hotel', 'textdomain'),
        'new_item'              => __('New Hotel', 'textdomain'),
        'edit_item'             => __('Edit Hotel', 'textdomain'),
        'view_item'             => __('View Hotel', 'textdomain'),
        'all_items'             => __('All Hotels', 'textdomain'),
        'search_items'          => __('Search Hotels', 'textdomain'),
        'parent_item_colon'     => __('Parent Hotel:', 'textdomain'),
        'not_found'             => __('No hotels found.', 'textdomain'),
        'not_found_in_trash'    => __('No hotels found in Trash.', 'textdomain'),
        'featured_image'        => _x('Hotel Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Hotel archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Insert into hotel', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this hotel', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filter hotels list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Hotels list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Hotels list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'hotel'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 104,
        'supports'           => array('title', 'editor', 'author', 'thumbnail'),
    );

    register_post_type('hotel', $args);
    include 'address.php';
    include 'tagline.php';
    include 'short_description.php';
    include 'amenities.php';
    include 'images.php';
    include 'qrcode.php';
    include 'specials.php';
}

add_action('init', 'mps_hotel_init');
function mps_enqueue($hook_suffix)
{
    $cpt = 'hotel';

    if (in_array($hook_suffix, array('post.php', 'post-new.php'))) {
        $screen = get_current_screen();

        if (is_object($screen) && $cpt == $screen->post_type) {
            wp_enqueue_script('mps-qrcode-script', MPS_HOTEL_PLUGIN__URL__ . 'qrcode/qrcode.js');
        }
    }
}

add_action('admin_enqueue_scripts', 'mps_enqueue');

function load_hotel_template( $template ) {
    global $post;

    if ( 'hotel' === $post->post_type && locate_template( array( 'single-hotel.php' ) ) !== $template ) {
        return plugin_dir_path( __FILE__ ) . 'single-hotel.php';
    }

    return $template;
}

add_filter( 'single_template', 'load_hotel_template' );