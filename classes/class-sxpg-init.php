<?php
/**
 * SX Photo Gallery initial class
 */

class SXPG_init {

    public function __construct() {
        $this->gallery  = new SXPG_gallery();
        $this->settings = new SXPG_settings();
    }

    public function init() {
        $this->gallery->init();
        // Register settings options
        add_action( 'admin_init', array( $this->settings, 'sxpg_settings_fields' ) );
        // Create settings subpage
        add_action( 'admin_menu', array( $this->settings, 'sxpg_add_settings_page' ) );
        // Load SX Photo Gallery selected skin template
        add_action( 'wp_enqueue_scripts', array( $this->settings, 'sxpg_load_template' ) );
    }

}
