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
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
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
