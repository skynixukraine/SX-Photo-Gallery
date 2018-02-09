<?php
/*
Plugin Name: SX Photo Gallery
Description: SX Photo Gallery is FREE inline photo gallery. Allows easily run a photogallery on any wordpress site in minutes.
Version: 1.0.0
Vendor: Skynix
Author: Skynix Team
Author URI: https://skynix.company/
License: GPL
*/

/*  
    Copyright 2018 Skynix ( email: apps@skynix.co )
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

/**
 * Add admin menu item
 */
function sxpg_add_menu_page()
{
    add_menu_page(
        "SX Photo Gallery",
        "SX Photo Gallery",
        "manage_options",
        "skynix_photo_gallery",
        'sxpg_menu_page_content',
        plugins_url( 'sx_photo_gallery/assets/images/sx_photo_gallery.ico' ),
        10
    );
}
add_action('admin_menu', 'sxpg_add_menu_page');

/**
 * Admin menu page
 */
function sxpg_menu_page_content(){
    echo "<hr><p>";
    esc_html_e( 'Hello! Thank You for using our plugin and complying with license requirements.', 'sx_photo_gallery' );
    echo "</p><hr>";
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
add_action( 'init', 'sxpg_create_post_type', 0 );
