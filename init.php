<?php
/*
Plugin Name: SX Photo Gallery
Description: SX Photo Gallery is FREE inline photo gallery. Allows easily run a photogallery on any wordpress site in minutes.
Version: 1.0.0
Vendor: Skynix
Author: Skynix Team
Author URI: https://skynix.company/
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
