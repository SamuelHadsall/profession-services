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
    <?php $args = array(
            'public'   => true,
            '_builtin' => false
            );
            
            $output = 'names'; // 'names' or 'objects' (default: 'names')
            $operator = 'and'; // 'and' or 'or' (default: 'and')
            
            $post_types = get_post_types( $args, $output, $operator );            

            $data = get_posts( array(
                'post_type' => $post_types,
                'post_status' => 'publish',
                'numberposts' => -1,
              ) );
              //print_r($data);
    ?>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-platform-detail-header">Detail Header Title</label>
        <?php $detail_header = get_post_meta( get_the_ID(), 'ps-platform-detail-header', true ); ?>
        <input id="ps-platform-detail-header" type="text" name="ps-platform-detail-header" value="<?php echo esc_attr($detail_header); ?>" />
    </div>    
    <div class="meta-options ps-meta-box-field">
        <label for="ps-platform-services">Services</label>
        <?php $services = get_post_meta( get_the_ID(), 'ps-platform-services', true ); ?>
        <select id="ps-platform-services" name="ps-platform-services" class="js-select">
            <option value="" <?php echo $services ? 'selected' : ''; ?>>Select Service</option>
            <?php foreach($data as $service) : if ($service->post_type === 'service') :?>                  
            <option value="<?php echo $service->ID; ?>" <?php echo $services ? 'selected' : ''; ?>><?php echo $service->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-platform-detail-banner-image">Detail Banner Image</label>
        <?php $banner_image = get_post_meta( get_the_ID(), 'ps-platform-detail-banner-image', true ); ?>
        <div class="file-uploaded banner-image-uploaded <?php echo $banner_image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($banner_image); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $banner_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
            <input type="hidden" name="ps-platform-detail-banner-image" value="<?php echo esc_attr($banner_image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $banner_image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-banner-image">
                <label for="ps-platform-detail-banner-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-platform-list-image">List View Image</label>
        <?php $list_image = get_post_meta( get_the_ID(), 'ps-platform-list-image', true ); ?>
        <div class="file-uploaded list-image-uploaded <?php echo $list_image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($list_image); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $list_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
            <input type="hidden" name="ps-platform-list-image" value="<?php echo esc_attr($list_image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $list_image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-list-image">
                <label for="ps-platform-list-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-platform-list-description">List Description</label>
        <?php $list_desc = get_post_meta( get_the_ID(), 'ps-platform-list-description', true ); ?>
        <?php
            $list_editor_content   = $list_desc;
            $list_editor_id = 'ps-platform-list-description';
            $list_editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $list_editor_content, $list_editor_id, $list_editor_settings );
        ?>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-platform-detail-page-description">Detail Page Description</label>
        <?php $detail_desc = get_post_meta( get_the_ID(), 'ps-platform-detail-page-description', true ); ?>
        <?php
            $detail_editor_content   = $detail_desc;
            $detail_editor_id = 'ps-platform-detail-page-description';
            $detail_editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $detail_editor_content, $detail_editor_id, $detail_editor_settings );
        ?>
    </div>


</div>