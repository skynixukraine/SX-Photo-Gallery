<?php
/**
 * SX Photo Gallery settings
 */

class SXPG_settings {

    public $skin = "sxpg-skin";
    public $template_path;
    public $default_template = "Skynix Dark";
    public $plugin_url;

    public function __construct() {
        $this->template_path = plugin_dir_path( __DIR__ ) . 'templates/';
        $this->plugin_url    = plugin_dir_url( __DIR__ ) . 'templates/';
    }

    /**
     * Register new settings
     */
    public function sxpg_settings_fields(){
        register_setting( 'sxpg-settings', $this->skin );
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
     * Add options to settings page
     */
    public function sxpg_settings_page_content() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $option = get_option( $this->skin );
        $skins  = $this->sxpg_get_available_skins();

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <label for="<?php echo $this->skin; ?>" >SX Photo Gallery Skin</label><br/>
                <select class="sxpg-select" id="<?php echo $this->skin; ?>" name="<?php echo $this->skin; ?>">
                    <?php
                        foreach ( $skins as $skin ){
                            $selected = ( ( $option == $skin ) ) ? "selected" : "";
                            echo '<option ' . $selected . ' value="' . $skin . '">' . $skin . '</option>';
                        }
                    ?>
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

    /**
     * Get all available skins
     *
     * @return array
     */
    public function sxpg_get_available_skins(){
        $skins = [];
        $names = scandir( $this->template_path );
        foreach ( $names as $name ) {
            if ( ( $name != '.' && $name != '..' ) && is_dir( $this->template_path . $name ) ) {
                $skins[] = $name;
            }
        }

        return $skins;
    }

    /**
     * Enqueue the selected skin template
     */
    public function sxpg_load_template(){
        $skin = get_option( $this->skin );
        if ( empty( $skin ) ) {
            $skin = $this->default_template;
        }
        wp_enqueue_style( "sxpg_template", $this->plugin_url . $skin . '/template.css' );
    }

}
