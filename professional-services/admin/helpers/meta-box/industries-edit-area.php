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
        <label for="ps-detail-header">Detail Header Title</label>
        <input id="ps-detail-header" type="text" name="ps-detail-header" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-detail-header', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-service">Service(s)</label>
        <?php $service = explode(',', get_post_meta( get_the_ID(), 'ps-service', true ) ); ?>
        <?php print_r($service); ?>
        <select id="ps-service" name="ps-service[]" class="js-select" multiple="multiple">
            <option value="">Select Service</option>
            <?php foreach($data as $service_name) : if ($service_name->post_type === 'service') :?>   
                <?php $selected = in_array( $service_name->ID,  $service ) ? ' selected="selected" ' : ''; ?>               
                <option value="<?php echo $service_name->ID; ?>" <?php echo $selected; ?>><?php echo $service_name->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
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
            $list_editor_content   = esc_attr(get_post_meta( get_the_ID(), 'ps-list-description', true ));
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
            <img src="<?php echo esc_attr($banner_image); ?>" class="img-fluid ps-image" />
            <?php echo wp_get_attachment_image( $banner_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
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
            $detail_editor_content   = esc_attr( get_post_meta( get_the_ID(), 'ps-detail-page-description', true ) );
            $detail_editor_id = 'ps-detail-page-description';
            $detail_editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $detail_editor_content, $detail_editor_id,$detail_editor_settings );
        ?>
    </div>
</div>