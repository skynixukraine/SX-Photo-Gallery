<?php
/**
 * SX Photo Gallery itself
 */

class SXPG_gallery {

    public $taxonomy   = 'sx_gallery_names';
    public $post_type  = 'sx_photo_galleries';
    
    public function __construct() {

    }

    public function init(){
        // Register new post type
        add_action( 'init', array( $this, 'sxpg_create_post_type' ) );
        // Register custom taxonomy that will serve as gallery
        add_action( 'init', array( $this, 'sxpg_create_gallery_taxonomies' ), 0);
        // Add columns to gallery posts
        add_action('manage_posts_custom_column', array( $this, 'sxpg_custom_columns' ) );

        // Add thumbnail images to preview column
        if ( !empty( $_REQUEST['post_type'] ) && $_REQUEST['post_type'] == $this->post_type ) {
            add_filter('manage_posts_columns', array( $this, 'sxpg_add_post_thumbnail_column' ), 5);
            add_filter('manage_pages_columns', array( $this, 'sxpg_add_post_thumbnail_column' ), 5);
            add_filter('manage_custom_post_columns', array( $this, 'sxpg_add_post_thumbnail_column' ), 5);
        }
        // Add filter by gallery names in posts display
        add_action( 'restrict_manage_posts', array( $this, 'sxpg_filter_by_galleries' ), 10, 2 );

        add_shortcode( 'SXPhotoGallery', array( $this, 'sxpg_output_gallery' ) );
    }

    /**
     * Create new post type
     */
    function sxpg_create_post_type() {

        // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'SX Photo Galleries', 'Post Type General Name', 'sx_photo_gallery' ),
            'singular_name'       => _x( 'SX Photo Gallery', 'Post Type Singular Name', 'sx_photo_gallery' ),
            'menu_name'           => __( 'SX Photo Galleries', 'sx_photo_gallery' ),
            'parent_item_colon'   => __( 'Parent SX Photo Gallery', 'sx_photo_gallery' ),
            'all_items'           => __( 'All Photos', 'sx_photo_gallery' ),
            'view_item'           => __( 'View Photo', 'sx_photo_gallery' ),
            'add_new_item'        => __( 'Add New Photo', 'sx_photo_gallery' ),
            'add_new'             => __( 'Add New Photo', 'sx_photo_gallery' ),
            'edit_item'           => __( 'Edit Photo', 'sx_photo_gallery' ),
            'update_item'         => __( 'Update Photo', 'sx_photo_gallery' ),
            'search_items'        => __( 'Search Photos', 'sx_photo_gallery' ),
            'not_found'           => __( 'Not Found', 'sx_photo_gallery' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'sx_photo_gallery' ),
        );

        // Set other options for Custom Post Type
        $args = array(
            'description'         => __( 'Inline photo gallery', 'sx_photo_gallery' ),
            'labels'              => $labels,
            'supports'            => array(
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
            ),
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
        register_post_type( $this->post_type, $args );

    }

    /**
     * Allow different different galleries to be created
     */
    function sxpg_create_gallery_taxonomies(){

        $labels = array(
            'name'                       => _x( 'SX Photo Galleries', 'taxonomy general name', 'textdomain' ),
            'singular_name'              => _x( 'SX Photo Gallery', 'taxonomy singular name', 'textdomain' ),
            'search_items'               => __( 'Search galleries', 'textdomain' ),
            'popular_items'              => __( 'Popular galleries', 'textdomain' ),
            'all_items'                  => __( 'All galleries', 'textdomain' ),
            'parent_item'                => __( 'Parrent gallery', 'textdomain' ),
            'parent_item_colon'          => __( 'Parrent gallery:', 'textdomain' ),
            'edit_item'                  => __( 'Edit gallery', 'textdomain' ),
            'update_item'                => __( 'Update gallery', 'textdomain' ),
            'add_new_item'               => __( 'Add New gallery', 'textdomain' ),
            'new_item_name'              => __( 'New gallery Name', 'textdomain' ),
            'menu_name'                  => __( 'All SX Photo Galleries', 'textdomain' ),
        );

        $args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
        );

        register_taxonomy( $this->taxonomy, $this->post_type, $args );
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
            'sxpg_post_thumb' => __('Photo preview')
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
        if ( $this->post_type !== $post_type )
            return;

        // Retrieve taxonomy data
        $taxonomy_obj = get_taxonomy( $this->taxonomy );

        // Retrieve taxonomy terms
        $terms = get_terms( $this->taxonomy );

        // Display filter HTML
        echo "<select name='{$this->taxonomy}' id='{$this->taxonomy}' class='postform'>";
        echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_obj->labels->name ) . '</option>';
        foreach ( $terms as $term ) {
            printf(
                '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                $term->slug,
                ( ( isset( $_GET[$this->taxonomy] ) && ( $_GET[$this->taxonomy] == $term->slug ) ) ? ' selected="selected"' : '' ),
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
        $response = '<div class="sxpg-gallery ' . $gallery_name[0] . '" >';
        $args = array(
            'post_type' => $this->post_type,
            'tax_query' => array(
                array(
                    'taxonomy' => $this->taxonomy,
                    'field'    => 'slug',
                    'terms'    => $gallery_name,
                ),
            ),
        );

        $gallery = new WP_Query( $args );
        if ( $gallery->have_posts() ) {
            while ( $gallery->have_posts() ) {
                $gallery->the_post();
                $attachment_id = get_post_thumbnail_id( $gallery->post->ID );
                $response .= '<img src="' . wp_get_attachment_image_src( $attachment_id, 'full' )[0] . '" alt="' . $gallery->post->post_title . '" />';
            }
        }

        return $response . '</div>';
    }

}
