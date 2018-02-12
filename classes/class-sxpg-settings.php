<?php
/**
 * SX Photo Gallery settings
 */

class SXPG_settings {

    public function __construct() {

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
        // Add settigns subpage to SX Photo Gallery
        add_submenu_page(
            "skynix_photo_gallery",
            "SX Photo Gallery Settings",
            "Settings",
            "manage_options",
            "sxpg-settings.php",
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
                    <option <?php echo ( ( $option == "Skynix Dark" ) ) ? "selected" : ''; ?> value="Skynix Dark">Skynix Dark</option>
                </select>

                <?php
                // output security fields for the registered setting "sxpg"
                settings_fields( 'sxpg-settings' );

                // output save settings button
                submit_button( 'Save' );
                ?>
            </form>
        </div>
        <?php
    }

}
