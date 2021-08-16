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
        <label for="ps-channel-image">Image</label>
        <?php $image = get_post_meta( get_the_ID(), 'ps-channel-image', true ); ?>
        <div class="file-uploaded list-image-uploaded <?php echo $image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($image); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
            <input type="hidden" name="ps-channel-image" value="<?php echo esc_attr($image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-list-image">
                <label for="ps-channel-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-channel-description">Page Description</label>
        <?php
            $detail_content = get_post_meta( get_the_ID(), 'ps-channel-description', true );
            $detail_id = 'ps-channel-description';
            $detail_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $detail_content, $detail_id, $detail_settings );
        ?>
    </div>
</div>