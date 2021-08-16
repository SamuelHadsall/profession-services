<input type="hidden" name="post_title" id="title" class="js-post-title" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-first-name', true ) ); ?> <?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-last-name', true ) ); ?>" />
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
        <label for="ps-first-name">First Name</label>
        <input id="ps-first-name" class="js-first-name"  type="text" name="ps-first-name" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-first-name', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-last-name">Last Name</label>
        <input id="ps-last-name" class="js-last-name"  type="text" name="ps-last-name" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-last-name', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-title">Title</label>
        <input id="ps-people-title" class="js-title"  type="text" name="ps-people-title" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-people-title', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-phone-number">Phone Number</label>
        <input id="ps-people-phone-number" class="js-phone-number"  type="text" name="ps-people-phone-number" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-people-phone-number', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-email">Email</label>
        <input id="ps-people-email" class="js-email"  type="text" name="ps-people-email" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-people-email', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-description">Description</label>
        <?php
            $content   = esc_attr( get_post_meta( get_the_ID(), 'ps-people-description', true ) );
            $editor_id = 'ps-people-description';
            $editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $content, $editor_id, $editor_settings );
        ?>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-services">Services</label>
        <?php $services = get_post_meta( get_the_ID(), 'ps-people-services', true ); ?>
        <select id="ps-people-services" name="ps-people-services" class="js-select">
            <?php foreach($data as $service) : if ($service->post_type === 'service') :?>                  
            <option value="<?php echo $service->ID; ?>" <?php echo $services ? 'selected' : ''; ?>><?php echo $service->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-platform">platform</label>
        <?php $platform = get_post_meta( get_the_ID(), 'ps-people-platform', true ); ?>
        <select id="ps-people-platform" name="ps-people-platform" class="js-select">
            <?php foreach($data as $platform) : if ($platform->post_type === 'platform') :?>                  
            <option value="<?php echo $platform->ID; ?>" <?php echo $platform ? 'selected' : ''; ?>><?php echo $platform->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-locations">Locations</label>
        <?php $locations = get_post_meta( get_the_ID(), 'ps-people-locations', true ); ?>
        <select id="ps-people-locations" name="ps-people-locations" class="js-select">                
                <?php foreach($data as $location) : if ($location->post_type === 'locations') :?>                  
                <option value="<?php echo $location->ID; ?>" <?php echo $locations ? 'selected' : ''; ?>><?php echo $location->post_title; ?></option>
                <?php endif; endforeach; ?>
            </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-people-image">Image</label>
        <div class="file-uploaded people-image-uploaded <?php echo get_post_meta( get_the_ID(), 'ps-people-image', true ) != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-people-image', true ) ); ?>" class="img-fluid ps-image" />
            <input type="hidden" name="ps-people-image" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-images-list-img', true ) ); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo get_post_meta( get_the_ID(), 'ps-people-image', true ) ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-people-image">
                <label for="ps-people-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field gravitar use-gravitar">
        <label for="useing-gravitar"></label>
        <div class="ui form">
            <p class="is-gravitar hidden">
                <?php
                    echo get_avatar( get_current_user_id(), $size = '100', $default = plugins_url( $this->plugin_name . '/includes/assets/imgs/user-solid.svg') );
                ?>
            </p>
            <div class="inline field">
                <div class="ui toggle checkbox">
                    <input type="checkbox" name="useing-gravitar" class="hidden">
                    <label for="useing-gravitar" class="useing-gravitar">Turn on Use of Gravitar.</label>
                </div>
            </div>           
            <p class="description">
                <a href="https://en.gravatar.com/" class="">You can change your picture on Gravatar</a>.
            </p>
        </div>
    </div>
</div>