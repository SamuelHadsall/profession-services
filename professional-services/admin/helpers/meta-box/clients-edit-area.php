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
        <label for="ps-client-business-sector">Business Sector(s)</label>
        <?php $business_sectors = get_post_meta( get_the_ID(), 'ps-client-business-sector', true ); ?>
        <select id="ps-client-business-sector" name="ps-client-business-sector" class="js-select">
            <option value="" <?php echo $business_sectors ? 'selected' : ''; ?>>Select Business Sector</option>
            <?php foreach($data as $business_sector) : if ($business_sector->post_type === 'business_sectors') :?>                  
            <option value="<?php echo $business_sector->ID; ?>" <?php echo $business_sectors ? 'selected' : ''; ?>><?php echo $business_sector->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-client-industry">Industries</label>
        <?php $industries = get_post_meta( get_the_ID(), 'ps-client-industry', true ); ?>
        <select id="ps-client-industry" name="ps-client-industry" class="js-select">
            <option value="" <?php echo $industries ? 'selected' : ''; ?>>Select Industry</option>
            <?php foreach($data as $industry) : if ($industry->post_type === 'industries') :?>                  
            <option value="<?php echo $industry->ID; ?>" <?php echo $industries ? 'selected' : ''; ?>><?php echo $industry->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>    
    <div class="meta-options ps-meta-box-field">
        <label for="ps-client-icon">List View Image</label>
        <?php $image = get_post_meta( get_the_ID(), 'ps-client-icon', true ); ?>
        <div class="file-uploaded list-image-uploaded <?php echo $image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr(image); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
            <input type="hidden" name="ps-client-icon" value="<?php echo esc_attr($image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-list-image">
                <label for="ps-client-icon" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-client-description">Description</label>
        <?php
            $content   = get_post_meta( get_the_ID(), 'ps-client-description', true );
            $editor_id = 'ps-client-description';
            $editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $content, $editor_id, $editor_settings );
        ?>
    </div>
</div>