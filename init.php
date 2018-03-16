<?php
/*
Plugin Name: SX Photo Gallery
Description: SX Photo Gallery is FREE inline photo gallery. Allows easily run a photogallery on any wordpress site in minutes.
Version: 1.0.0
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

// load classes
spl_autoload_register( function ( $class_name ) {
    $classes_dir = plugin_dir_path( __FILE__ ) . '/classes/class-';
    $file = $classes_dir . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
    if( file_exists( $file ) ) require_once( $file );
} );

$sxpg = new SXPG_init();
$sxpg->init();
