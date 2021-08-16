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
    ?>   
    
    <div class="meta-options ps-meta-box-field">
        <label for="ps-service-location">Locations</label>
        <?php $service_location = get_post_meta( get_the_ID(), 'ps-service-location', true ); ?>
        <select id="ps-service-location" name="ps-service-location" class="js-select">
            <option value="" <?php echo $service_location ? 'selected' : ''; ?>>Select Service Location(s)</option>
            <?php foreach($data as $location) : if ($location->post_type === 'locations') :?>                  
            <option value="<?php echo $location->ID; ?>" <?php echo $service_location ? 'selected' : ''; ?>><?php echo $location->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-service-industries">Industries</label>
        <?php $service_industry = explode(',', get_post_meta( get_the_ID(), 'ps-service-industry', true ) ); ?>      
        <?php //print_r($service_industry); ?>
        <select id="ps-service-industry" name="ps-service-industry[]" class="js-select" multiple="multiple">
            <option value="">Select Service Industry(s)</option>
            <?php foreach($data as $industry) : if ($industry->post_type === 'industries') :?>  
                    <?php $selected = in_array( $industry->ID, $service_industry ) ? ' selected="selected" ' : ''; ?>
                    <option value="<?php echo $industry->ID; ?>" <?php echo $selected; ?>><?php echo $industry->post_title; ?></option>
                <?php endif; 
            endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-service-platform">platform</label>
        <?php $service_platform = explode(',', get_post_meta( get_the_ID(), 'ps-service-platform', true ) ); ?>
        <select id="ps-service-platform" name="ps-service-platform[]" multiple="multiple" class="js-select">
            <option value="">Select Service Platform(s)</option>
            <?php foreach($data as $platform) : if ($platform->post_type === 'platform') :?> 
                <?php $selected = in_array( $platform->ID, $service_platform ) ? ' selected="selected" ' : ''; ?>
                <option value="<?php echo $platform->ID; ?>" <?php echo $selected; ?>><?php echo $platform->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-detail-header">Detail Header Title</label>
        <input id="ps-detail-header" type="text" name="ps-detail-header" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-detail-header', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-nav-icon">Navigation Icon</label>
        <?php $nav_icon = get_post_meta( get_the_ID(), 'ps-nav-img', true ); ?>

        <div class="file-uploaded nav-icn-uploaded <?php echo $nav_icon != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($nav_icon); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $nav_icon, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
            <input type="hidden" name="ps-nav-img" class="icon-img" value="<?php echo esc_attr($nav_icon); ?>" />
        </div>
        <div class="file-upload <?php echo $nav_icon ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-nav-icn">
                <label for="ps-nav-icon" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-list-image">List View Image</label>
        <?php $list_image = get_post_meta( get_the_ID(), 'ps-list-img', true ); ?>
        <div class="file-uploaded list-image-uploaded <?php echo $list_image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($list_image); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $list_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
            <input type="hidden" name="ps-list-img" value="<?php echo esc_attr($list_image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $list_image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-list-image">
                <label for="ps-list-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-list-description">List View Description</label>
        <?php
            $list_editor_content   =  get_post_meta( get_the_ID(), 'ps-list-description', true );
            $list_editor_id = 'ps-list-description';
            $list_editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $list_editor_content, $list_editor_id, $list_editor_settings );
        ?>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-list-bullet-points">Key List Bullet Point</label>
        <?php $bullitList = get_post_meta( get_the_ID(), 'ps-list-bullet-points', true ); ?>
        <div class="column">
            <a href="#" class="js-add-bullet-point ui button">Add Bullet Point</a>
            <div class="ps-meta-bulletpoint-box ps-meta-slides bulletpoint-slide">
                <div class="ui middle aligned divided list">
                    <?php if (!empty($bullitList)) {
                        $output = '';
                        foreach ($bullitList as $key=>$val) {
                            $output .= '<div class="item bulletpoint-added bulletpoint-' . $key . '">';
                                $output .= '<div class="right floated content"><div class="ui button js-remove">remove</div></div>';
                                $output .= '<i class="caret right icon"></i>';
                                $output .= '<div class="content">'. esc_attr( $val ) . '</div>';
                                $output .= '<input type="hidden" class="js-bulletpoint" id="ps-list-bullet-point-' . $key . '" name="ps-list-bullet-points[]" value="'.esc_attr($val).'">';
                                $output .= '</div>';
                        }
                        echo $output;
                    } ?>
                    <div class="item-clone hidden">
                        <div class="right floated content">
                            <div class="ui button js-remove disabled">remove</div>
                        </div>
                        <i class="caret right icon"></i>
                        <div class="content">
                        </div>
                    </div>
                </div>
                <div class="ui modal bullet-point-modal">
                    <i class="close icon"></i>
                    <div class="header">
                        Add New Bullet Point
                    </div>
                    <div class="content">
                        <div class="ps-meta-box">
                            <div class="meta-options ps-meta-box-field">
                                <label for="ps-list-bullet-point-temp">New Bullet Point</label>
                                <input type="text" id="ps-list-bullet-point-temp" class="bullet-temp" />
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="ui positive button">
                            Save
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-detail-banner-image">Detail Banner Image</label>
        <?php $banner_image = get_post_meta( get_the_ID(), 'ps-banner-img', true ); ?>
        <div class="file-uploaded banner-image-uploaded <?php echo $banner_image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo wp_get_attachment_image_src($banner_image, 'full'); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $banner_image, array('156', '156'), "", array( "class" => "img-fluid ps-image" ) ); ?>
            <input type="hidden" name="ps-banner-img" value="<?php echo esc_attr($banner_image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $banner_image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-banner-image">
                <label for="ps-detail-banner-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-detail-page-description">Detail Page Description</label>
        <?php
            $detail_editor_content   = wpautop( get_post_meta( get_the_ID(), 'ps-detail-page-description', true ) );
            $detail_editor_id = 'ps-detail-page-description';
            $detail_editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $detail_editor_content, $detail_editor_id,$detail_editor_settings );
        ?>
    </div>
</div>