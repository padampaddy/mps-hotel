<?php
function mps_amenities_init()
{
    $labels = array(
        'name'                  => _x('Amenities', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Amenity', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Amenities', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Amenities', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add new amenity', 'textdomain'),
        'new_item'              => __('New amenity', 'textdomain'),
        'edit_item'             => __('Edit amenities', 'textdomain'),
        'view_item'             => __('View amenities', 'textdomain'),
        'all_items'             => __('All amenities', 'textdomain'),
        'search_items'          => __('Search amenities', 'textdomain'),
        'parent_item_colon'     => __('Parent amenities:', 'textdomain'),
        'not_found'             => __('No amenities found.', 'textdomain'),
        'not_found_in_trash'    => __('No amenities found in Trash.', 'textdomain'),
        'featured_image'        => _x('Amenities Icon', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Set Icon', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Remove Icon', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Use as Icon', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Amenities archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Insert into amenities', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this amenities', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filter amenities list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Amenities list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Amenities list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'amenities'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 105,
        'supports'           => array('title', 'author', 'thumbnail'),
    );

    register_post_type('amenities', $args);

}

add_action('init', 'mps_amenities_init');
