<?php
/**
 * SX Photo Gallery itself
 */

class SXPG_gallery {

    public function __construct() {

    }

    /**
     * Create new post type
     */
    function sxpg_create_post_type() {

        // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'SX Photo Galleries', 'Post Type General Name', 'sx_photo_gallery' ),
            'singular_name'       => _x( 'SX Photo Gallery', 'Post Type Singular Name', 'sx_photo_gallery' ),
            'menu_name'           => __( 'SX Photo Galleries', 'sx_photo_gallery' ),
            'parent_item_colon'   => __( 'Parent SX Photo Gallery', 'sx_photo_gallery' ),
            'all_items'           => __( 'All SX Photo Galleries', 'sx_photo_gallery' ),
            'view_item'           => __( 'View SX Photo Gallery', 'sx_photo_gallery' ),
            'add_new_item'        => __( 'Add New SX Photo Gallery', 'sx_photo_gallery' ),
            'add_new'             => __( 'Add New', 'sx_photo_gallery' ),
            'edit_item'           => __( 'Edit SX Photo Gallery', 'sx_photo_gallery' ),
            'update_item'         => __( 'Update SX Photo Gallery', 'sx_photo_gallery' ),
            'search_items'        => __( 'Search SX Photo Gallery', 'sx_photo_gallery' ),
            'not_found'           => __( 'Not Found', 'sx_photo_gallery' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'sx_photo_gallery' ),
        );

        // Set other options for Custom Post Type
        $args = array(
            'label'               => __( 'SX Photo Galleries', 'sx_photo_gallery' ),
            'description'         => __( 'Inline photo gallery', 'sx_photo_gallery' ),
            'labels'              => $labels,
            'supports'            => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'comments',
                'revisions',
                'page-attributes',
                'post-formats',
            ),
            'taxonomies'          => array(),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 11,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );

        // Registering your Custom Post Type
        register_post_type( 'sx_photo_galleries', $args );

    }

}
