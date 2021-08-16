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
        <label for="ps-business-sector-image">Image</label>
        <?php $image = get_post_meta( get_the_ID(), 'ps-business-sector-image', true ); ?>
        <div class="file-uploaded list-image-uploaded <?php echo $image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($image); ?>" class="img-fluid ps-image" />
            <input type="hidden" name="ps-business-sector-img" value="<?php echo esc_attr($image); ?>" class="icon-img" />
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
        <label for="ps-business-sector-description">Page Description</label>
        <?php
            $detail_content   = esc_attr( get_post_meta( get_the_ID(), 'ps-business-sector-description', true ) );
            $detail_id = 'ps-business-sector-description';
            $detail_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $detail_content, $detail_id, $detail_settings );
        ?>
    </div>
</div>