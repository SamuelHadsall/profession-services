<div class="ps-meta-box">
    <style scoped>
        .ps-meta-box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .ps-meta-box-field{
            display: contents;
        }
    </style>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-image">Image</label>
        <?php $image = get_post_meta( get_the_ID(), 'ps-image', true ); ?>
        <div class="file-uploaded list-image-uploaded <?php echo $image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($image); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
            <input type="hidden" name="ps-image" value="<?php echo esc_attr($image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-list-image">
                <label for="ps-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-detail-page-description">Description</label>
        <?php $desc = wpautop( get_post_meta( get_the_ID(), 'ps-detail-page-description', true ) ); ?>
        <?php
            $content   = $desc;
            $editor_id = 'ps-detail-page-description';
            $editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $content, $editor_id, $editor_settings );
        ?>
    </div>


</div>