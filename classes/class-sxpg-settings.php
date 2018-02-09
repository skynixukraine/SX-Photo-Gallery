<?php
/**
 * REST API: Skynix_REST_Posts_Controller class
 */

class SXPG_settings {

    public $dir; // plugin url for styles

    public function __construct() {
        $this->dir = plugin_dir_url( __DIR__ );
    }

    public function init() {
        add_action( 'admin_init', array( $this, 'sxpg_settings_fields' ) );
        add_action( 'admin_menu', array( $this, 'sxpg_options_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'sxpg_enqueue_admin_style' ) );
    }

    public function sxpg_enqueue_admin_style() {
        wp_enqueue_style( 'settings_css', $this->dir . '/assets/css/settings.css', false, '1.0.0' );
    }

    /**
     * Register new settings
     */
    public function sxpg_settings_fields(){
        register_setting( 'sxpg-settings', 'sxpg-settings' );
    }

    /**
     * Add new pages to admin menu
     */
    public function sxpg_options_page() {
        // Add option to Settings
        add_options_page(
            'SX Photo Gallery Settings',
            'SX Photo Gallery Settings',
            'manage_options',
            'sxpg-settings.php',
            array( $this, 'sxpg_settings_page_content' )
        );
    }

    /**
     * top level menu:
     * callback functions
     */
    public function sxpg_settings_page_content() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $option = get_option( 'sxpg-settings' );

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <label for="allowed_settings_textarea" >SX Photo Gallery Skin</label><br/>
                <select class="sxpg-select" id="sxpg-settings" name="sxpg-settings">
                    <option <?php echo ( ( $option == "S2" ) ) ? "selected" : ''; ?> value="Skynix Dark">S2</option>
                    <option <?php echo ( ( $option == "Skynix Dark" ) ) ? "selected" : ''; ?> value="Skynix Dark">Skynix Dark</option>
                    <option <?php echo ( ( $option == "Sk" ) ) ? "selected" : ''; ?> value="Skynix Dark">Sk</option>
                </select>

                <?php
                // output security fields for the registered setting "skynix"
                settings_fields( 'sxpg-settings' );

                // output save settings button
                submit_button( 'Save' );
                ?>
            </form>
        </div>
        <?php
    }

}