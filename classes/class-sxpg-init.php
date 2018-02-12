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
        // Create plugin menu item
        add_action( 'admin_menu', array( $this, 'sxpg_add_menu_page' ) );
        // Create settings subpage
        add_action( 'admin_menu', array( $this->settings, 'sxpg_options_page' ) );

    }

    /**
     * Add admin menu item
     */
    public function sxpg_add_menu_page()
    {
        add_menu_page(
            "SX Photo Gallery",
            "SX Photo Gallery",
            "manage_options",
            "skynix_photo_gallery",
            array( $this, 'sxpg_menu_page_content' ),
            plugins_url( 'sx_photo_gallery/assets/images/sx_photo_gallery.ico' ),
            10
        );
    }

    /**
     * Admin menu page
     */
    public function sxpg_menu_page_content(){
        echo "<hr><p>";
        esc_html_e( 'Hello! Thank You for using our plugin and complying with license requirements.', 'sx_photo_gallery' );
        echo "</p><hr>";
    }

}
