<?php
/**
 * SX Photo Gallery itself
 */

class SXPG_gallery {

    public static $taxonomy   = 'sx_gallery_names';
    public static $post_type  = 'sx_photo_galleries';
    public static $textdomain = 'sx_photo_gallery';
    
    public function __construct() {

    }

    public function init(){
        // Register new post type
        add_action( 'init', array( $this, 'sxpg_create_post_type' ) );
        // Register custom taxonomy that will serve as gallery
        add_action( 'init', array( $this, 'sxpg_create_gallery_taxonomies' ), 0);
        // Add columns to gallery posts
        add_action( 'manage_posts_custom_column', array( $this, 'sxpg_custom_columns' ) );

        // Add thumbnail images to preview column
        if ( !empty( $_REQUEST['post_type'] ) && $_REQUEST['post_type'] == self::$post_type ) {
            add_filter('manage_posts_columns', array( $this, 'sxpg_add_post_thumbnail_column' ), 5);
            add_filter('manage_pages_columns', array( $this, 'sxpg_add_post_thumbnail_column' ), 5);
            add_filter('manage_custom_post_columns', array( $this, 'sxpg_add_post_thumbnail_column' ), 5);
        }
        // Add filter by gallery names in posts display
        add_action( 'restrict_manage_posts', array( $this, 'sxpg_filter_by_galleries' ), 10, 2 );

        add_shortcode( 'SXPhotoGallery', array( $this, 'sxpg_output_gallery' ) );

        // Add Media Bar button for Shortcode
        add_action( 'media_buttons', array( $this, 'media_button' ), 12 );

    }

    /**
     * Output media button for SX Photo Gallery shortcode
     *
     */
    public function media_button () {

        add_action( 'admin_footer', array( $this, 'mce_popup' ) );

        echo '<a href="#TB_inline?width=640&inlineId=sxpg_shortcode_form" class="thickbox button" id="add_sxpg_button" title="Insert SX Photo Gallery"><img style="padding: 0px 6px 0px 0px; margin: -3px 0px 0px;" src="' . plugin_dir_url( __DIR__ ) . 'assets/images/sx_photo_gallery.ico" alt="' . __( 'Insert SX Photo Gallery' , self::$textdomain ) . '" />' . __( 'Insert SX Photo Gallery' , self::$textdomain ) . '</a>';
    }

    /**
     * Output SX Photo Gallery shortcode popup window
     */
    public function mce_popup () {
        require_once(  plugin_dir_path( __DIR__ ) . 'components/shortcode.php' );
    }

    /**
     * Create new post type
     */
    function sxpg_create_post_type() {

        // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'SX Photo Gallery', 'Post Type General Name', self::$textdomain ),
            'singular_name'       => _x( 'SX Photo Gallery', 'Post Type Singular Name', self::$textdomain ),
            'menu_name'           => __( 'SX Photo Gallery', self::$textdomain ),
            'parent_item_colon'   => __( 'Parent SX Photo Gallery', self::$textdomain ),
            'all_items'           => __( 'All Photos', self::$textdomain ),
            'view_item'           => __( 'View Photo', self::$textdomain ),
            'add_new_item'        => __( 'Add New Photo', self::$textdomain ),
            'add_new'             => __( 'Add New Photo', self::$textdomain ),
            'edit_item'           => __( 'Edit Photo', self::$textdomain ),
            'update_item'         => __( 'Update Photo', self::$textdomain ),
            'search_items'        => __( 'Search Photos', self::$textdomain ),
            'not_found'           => __( 'Not Found', self::$textdomain ),
            'not_found_in_trash'  => __( 'Not found in Trash', self::$textdomain ),
        );

        $supports = array(
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
        );

        // Set other options for Custom Post Type
        $args = array(
            'description'         => __( 'Inline photo gallery', self::$textdomain ),
            'menu_icon'           => plugins_url( 'sx_photo_gallery/assets/images/sx_photo_gallery.png' ),
            'labels'              => $labels,
            'supports'            => $supports,
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
        register_post_type( self::$post_type, $args );

    }

    /**
     * Allow different different galleries to be created
     */
    function sxpg_create_gallery_taxonomies(){

        $labels = array(
            'name'                       => _x( 'SX Photo Galleries', 'taxonomy general name', self::$textdomain ),
            'singular_name'              => _x( 'SX Photo Gallery', 'taxonomy singular name', self::$textdomain ),
            'search_items'               => __( 'Search galleries', self::$textdomain ),
            'popular_items'              => __( 'Popular galleries', self::$textdomain ),
            'all_items'                  => __( 'All galleries', self::$textdomain ),
            'parent_item'                => __( 'Parrent gallery', self::$textdomain ),
            'parent_item_colon'          => __( 'Parrent gallery:', self::$textdomain ),
            'edit_item'                  => __( 'Edit gallery', self::$textdomain ),
            'update_item'                => __( 'Update gallery', self::$textdomain ),
            'add_new_item'               => __( 'Add New gallery', self::$textdomain ),
            'new_item_name'              => __( 'New gallery Name', self::$textdomain ),
            'menu_name'                  => __( 'Manage SX Photo Galleries', self::$textdomain ),
        );

        $args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
        );

        register_taxonomy( self::$taxonomy, self::$post_type, $args );

    }

    /**
     * Echo the thumbnail in posts table
     *
     * @param $column
     */
    public function sxpg_custom_columns( $column ){
        global $post;

        if ( $column == 'sxpg_post_thumb' ) {
            echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</a>';
        }
    }

    /**
     * Add photo preview column
     *
     * @param $cols
     * @return array
     */
    public function sxpg_add_post_thumbnail_column( $cols ){
        $add_cols = array(
            'sxpg_post_thumb' => __('Photo preview', self::$textdomain )
        );
        // Insert new column right after checkbox ( kind of array_splice for assoc arrays )
        $cols = array_slice( $cols, 0, 1, true ) + $add_cols + array_slice( $cols, 1, NULL, true );

        return $cols;
    }

    /**
     * Allow to filter photos by galleries
     *
     * @param $post_type
     */
    public function sxpg_filter_by_galleries( $post_type ) {

        // Apply this only on a specific post type
        if ( self::$post_type !== $post_type )
            return;

        // Retrieve taxonomy data
        $taxonomy_obj = get_taxonomy( self::$taxonomy );

        // Retrieve taxonomy terms
        $terms = get_terms( self::$taxonomy );

        // Display filter HTML
        echo "<select name='{" . self::$taxonomy . "}' id='{" . self::$taxonomy . "}' class='postform'>";
        echo '<option value="">' . sprintf( esc_html__( 'Show All %s', self::$textdomain ), $taxonomy_obj->labels->name ) . '</option>';
        foreach ( $terms as $term ) {
            printf(
                '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                $term->slug,
                ( ( isset( $_GET[self::$taxonomy] ) && ( $_GET[self::$taxonomy] == $term->slug ) ) ? ' selected="selected"' : '' ),
                $term->name,
                $term->count
            );
        }
        echo '</select>';

    }

    /**
     * Return html string with images from specified gallery
     *
     * @param string $gallery_name
     * @return string
     */
    public function sxpg_output_gallery( $gallery_name ){
        $response = '';
        $args = array(
            'post_type' => self::$post_type,
            'tax_query' => array(
                array(
                    'taxonomy' => self::$taxonomy,
                    'field'    => 'slug',
                    'terms'    => $gallery_name,
                ),
            ),
        );

        $category = get_term_by( 'slug', $gallery_name[0], self::$taxonomy );
        $skin     = get_option( SXPG_settings::$skin );
        if ( empty( $skin ) ) {
            $skin = SXPG_settings::$default_template;
        }
        $skin = sanitize_title( $skin );

        $gallery = new WP_Query( $args );

        if ( $gallery->have_posts() ) {
            $response .= '<section class="sx-photo-gallery sx-photo-gallery--' . $skin . ' sx-photo-gallery--' . $gallery_name[0] . '">';
            $response .= '<h1 class="sx-photo-gallery__title">' . $category->name . '</h1>';
            $response .= '<ul class="sx-photo-gallery-photos sx-photo-gallery--' . $skin . ' sx-photo-gallery-photos--' . $gallery_name[0] . '">';

            while ( $gallery->have_posts() ) {
                $gallery->the_post();

                $attachment_id = get_post_thumbnail_id( $gallery->post->ID );
                $image_src     = wp_get_attachment_image_src( $attachment_id, 'full' )[0];

                if ( !empty( $image_src ) ) {
                    $response .= '<li class="sx-photo-gallery-photos__photo-container">';
                    $response .= '<a href="' . get_permalink($gallery->post->ID) . '">';
                    $response .= '<img class="sx-photo-gallery-photos__photo" src="' . $image_src . '" alt="' . $gallery->post->post_title . '" title="' . $gallery->post->post_title . '" />';
                    $response .= '</a>';
                    $response .= '</li>';
                }
            }

            $response .= '</ul>';
            $response .= '<div class="sx-photo-gallery__controlls">';
            $response .= '<div class="sx-photo-gallery__controlls-arrow sx-photo-gallery__controlls-arrow--left" data-param="left"></div>';
            $response .= '<a class="sx-photo-gallery__share">';
            $response .= '<div class="sx-photo-gallery__share-facebook"></div>';
            $response .= '<a class="sx-photo-gallery__share">';
            $response .= '<div class="sx-photo-gallery__share-twitter"></div>';
            $response .= '</a>';
            $response .= '<a class="sx-photo-gallery__share">';
            $response .= '<div class="sx-photo-gallery__share-linkedin"></div>';
            $response .= '</a>';
            $response .= '<div class="sx-photo-gallery__controlls-arrow sx-photo-gallery__controlls-arrow--right" data-param="right"></div>';
            $response .= '</div>';
            $response .= '</section>';
        } else {
            $response = '<section class="sx-photo-gallery sx-photo-gallery--' . $skin . ' sx-photo-gallery--' . $gallery_name[0] . ' sx-photo-gallery--not-found"><h1>' . $category->name .'</h1> is empty or does not exist</section>';
        }

        return $response;
    }

    /**
     * Output the SX Photo Galleries as options for select tag
     *
     * @return string
     */
    public static function sxpg_output_galleries_names(){
        $options      = '';
        $sx_galleries = get_terms(
            array(
                'taxonomy'   => self::$taxonomy,
                'hide_empty' => false,
            )
        );

        foreach ( $sx_galleries as $gallery ) {
            $options .= '<option value="'. $gallery->slug .'">' . $gallery->name . '</option>';
        }

        return $options;
    }
}
