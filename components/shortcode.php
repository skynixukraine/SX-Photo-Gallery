<script type="text/javascript">
    $(document).on( 'click', '#sxpg_insert_shortcode', function ( e ) {

        var gallery_slug = $('#sxpg_gallery_name').val();

        if ( typeof gallery_slug === 'undefined' || gallery_slug.length < 1 ) {
            alert( "Selected gallery is invalid" );
            e.preventDefault();
            return false;
        }

        var shortcode = '[SXPhotoGallery ' + gallery_slug + ']';

        window.send_to_editor( shortcode );

        e.preventDefault();
    } );
</script>

<style type="text/css">
    #sxpg_insert_shortcode {
        margin-left: 20px;
    }
</style>

<div id="sxpg_shortcode_form" style="display: none;">
    <div class="wrap sxpg-shortcode">
        <div>
            <div class="sxpg-header">
                <h3 class="popup-header"><?php _e( 'SX Photo Gallery', SXPG_gallery::$textdomain ); ?></h3>
            </div>

            <form id="sxpg_shortcode_form_element">
                <div class="sxpg-select">
                    <label for="sxpg_gallery_name"><?php _e( 'Please choose a SX Photo Gallery to insert:', SXPG_gallery::$textdomain ); ?></label>

                    <select id="sxpg_gallery_name" name="sxpg_gallery_name">
                        <option value="" selected>Please select a gallery</option>
                        <?php echo SXPG_gallery::sxpg_output_galleries_names(); ?>
                    </select>

                    <a class="button-primary" id="sxpg_insert_shortcode" href="#sxpg-insert-shortcode"><?php _e( 'Insert', SXPG_gallery::$textdomain ); ?></a>

                </div>

            </form>
        </div>
    </div>
</div>
