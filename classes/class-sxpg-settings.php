<?php
/**
 * SX Photo Gallery settings
 */

class SXPG_settings {

    public $skin = "sxpg-skin";
    public $template_path;
    public $default_template = "Skynix Dark";
    public $plugin_url;

    public function __construct( $gallery ) {
        $this->gallery       = $gallery;
        $this->template_path = plugin_dir_path( __DIR__ ) . 'templates/';
        $this->plugin_url    = plugin_dir_url( __DIR__ ) . 'templates/';
    }

    public function init() {
        // Register settings options
        add_action( 'admin_init', array( $this, 'sxpg_settings_fields' ) );
        // Create settings subpage
        add_action( 'admin_menu', array( $this, 'sxpg_add_settings_page' ) );
        // Load SX Photo Gallery selected skin template
        add_action( 'wp_enqueue_scripts', array( $this, 'sxpg_load_template' ) );
        // Show notice when settings are saved
        add_action( 'admin_notices', array( $this, 'sxpg_options_saved__success' ) );
    }

    /**
     * Register new settings
     */
    public function sxpg_settings_fields(){
        register_setting( 'sxpg-settings', $this->skin );
    }

    /**
     * Add admin menu item
     */
    public function sxpg_add_settings_page(){
        add_submenu_page(
            "edit.php?post_type=" . $this->gallery->post_type,
            __( "SX Photo Gallery Settings", $this->gallery->textdomain ),
            __( "Settings", $this->gallery->textdomain ),
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
            <h1><?php echo esc_html( get_admin_page_title(), $this->gallery->textdomain ); ?></h1>
            <hr>
            <p><?php echo __( 'Feel free to', $this->gallery->textdomain ); ?> <a href="https://skynix.company/wordpress-plugin-development"><?php echo __( 'contact us', $this->gallery->textdomain ); ?></a> <?php echo __( 'if you need any kind of support', $this->gallery->textdomain ); ?></p>
            <hr>
            <form action="options.php" method="post">
                <table>
                    <tr>
                        <td><label for="<?php echo $this->skin; ?>" ><?php _e( 'Choose a Skin', $this->gallery->textdomain ); ?>: </label></td>
                        <td><select class="sxpg-select" id="<?php echo $this->skin; ?>" name="<?php echo $this->skin; ?>">
                            <?php
                                foreach ( $skins as $skin ){
                                    $selected = ( ( $option == $skin ) ) ? "selected" : "";
                                    echo '<option ' . $selected . ' value="' . $skin . '">' . $skin . '</option>';
                                }
                            ?>
                        </select></td>
                    </tr>
                </table>
                <?php
                // output security fields for the registered setting "sxpg"
                settings_fields( 'sxpg-settings' );

                // output save settings button
                submit_button( __( 'Save', $this->gallery->textdomain ) );
                ?>
            </form>
        </div>
        <?php
    }

    public function sxpg_options_saved__success() {
        $notice = '';

        if ( !empty( $_REQUEST["settings-updated"] ) && $_REQUEST["settings-updated"] ) {
            $notice .= '<div class="notice notice-success is-dismissible">';
            $notice .= '<p>' . __( 'Settigns Saved', $this->gallery->textdomain ) . '</p>';
            $notice .= '</div>';
        }

        echo $notice;
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
        wp_enqueue_style( "sxpg_template_css", $this->plugin_url . $skin . '/sx-photo-gallery.css' );
        wp_enqueue_script( "sxpg_template_js", $this->plugin_url . $skin . '/sx-photo-gallery.js', array('jquery'), '1.0', true );
    }

}
