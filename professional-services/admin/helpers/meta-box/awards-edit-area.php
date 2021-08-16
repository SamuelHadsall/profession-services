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
        <label for="ps-awards-date">Date</label>
        <div class="ui action input">
            <input id="ps-awards-date" class="js-awards-date-input"  type="text" name="ps-awards-date" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-awards-date', true ) ); ?>" />
            <button class="ui icon button js-awards-date">
                <i class="calendar alternate icon"></i>
            </button>
        </div>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-awards-description">Description</label>
        <?php
            $content   = esc_attr( get_post_meta( get_the_ID(), 'ps-awards-description', true ) );
            $editor_id = 'ps-awards-description';
            $editor_settings  = array(
                'media_buttons' => false,
                'default_editor' => 'Quicktags'
            );

            wp_editor( $content, $editor_id, $editor_settings );
        ?>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-awards-services">Services</label>
        <?php $services = get_post_meta( get_the_ID(), 'ps-awards-services', true ); ?>
        <select id="ps-awards-services" name="ps-awards-services" class="js-select">
            <option value="0" <?php echo $services ? 'selected' : ''; ?>>Select Service</option>
            <?php foreach($data as $service) : if ($service->post_type === 'service') :?>                  
            <option value="<?php echo $service->ID; ?>" <?php echo $services ? 'selected' : ''; ?>><?php echo $service->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-awards-platform">platform</label>
        <?php $platform = get_post_meta( get_the_ID(), 'ps-awards-platform', true ); ?>        
        <select id="ps-awards-platform" name="ps-awards-platform" class="js-select">
            <option value="0" <?php echo $platform ? 'selected' : ''; ?>>Select a Platform</option>
            <?php foreach($data as $platform) : if ($platform->post_type === 'platform') :?>                  
            <option value="<?php echo $platform->ID; ?>" <?php echo $platform ? 'selected' : ''; ?>><?php echo $platform->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-awards-case-studies">Case Studies</label>
        <?php $case_studies = get_post_meta( get_the_ID(), 'ps-awards-case-studies', true ); ?>
        <select id="ps-awards-case-studies" name="ps-awards-case-studies" class="js-select">     
            <option value="0" <?php echo $case_studies ? 'selected' : ''; ?>>Select a Case Study</option>           
            <?php foreach($data as $case_study) : if ($case_study->post_type === 'case_studies') :?>                  
            <option value="<?php echo $case_study->ID; ?>" <?php echo $case_studies ? 'selected' : ''; ?>><?php echo $case_study->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <?php $articles = get_post_meta( get_the_ID(), 'ps-awards-articles', true ); ?>
        <label for="ps-awards-articles">Article(s)</label>            
        <select id="ps-awards-articles" name="ps-awards-articles[]" class="js-select" multiple="multiple">
            <option value="0" <?php echo $articles ? 'selected' : ''; ?>>Select Article(s)</option>                      
            <?php foreach($data as $article) : if ($article->post_type === 'articles') :?>                  
            <option value="<?php echo $article->ID; ?>" <?php echo $articles ? 'selected' : ''; ?>><?php echo $article->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-article-people">People</label>
        <?php $people = get_post_meta( get_the_ID(), 'ps-awards-people', true ); ?>
        <select id="ps-awards-people" name="ps-awards-people" class="js-select">
            <option value="0" <?php echo $people ? 'selected' : ''; ?>>Select People</option>                
            <?php foreach($data as $person) : if ($person->post_type === 'people') :?>                  
            <option value="<?php echo $person->ID; ?>" <?php echo $people ? 'selected' : ''; ?>><?php echo $person->post_title; ?></option>
            <?php endif; endforeach; ?>
        </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-awards-icon">Image</label>
        <?php $awards_icon = get_post_meta( get_the_ID(), 'ps-awards-icon', true ); ?>
        <div class="file-uploaded nav-icn-uploaded <?php echo $awards_icon != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($awards_icon); ?>" class="img-fluid ps-image" />
            <input type="hidden" name="ps-awards-icon" class="icon-img" value="<?php echo esc_attr($awards_icon); ?>" />
        </div>
        <div class="file-upload <?php echo $awards_icon ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-nav-icn">
                <label for="ps-awards-icon" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>
</div>