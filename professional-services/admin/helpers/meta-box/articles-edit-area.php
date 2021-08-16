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
        <label for="ps-article-subtitle">SubTitle</label>
        <input id="ps-article-subtitle" class="js-article-subtitle"  type="text" name="ps-article-subtitle" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-article-subtitle', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-article-author">Author</label>
        <input id="ps-article-author" class="js-article-author"  type="text" name="ps-article-author" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-article-author', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-article-date">Date</label>
        <input id="ps-article-date" class="js-article-date"  type="text" name="ps-article-date" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-article-date', true ) ); ?>" />
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-article-people">People</label>
        <?php $people = get_post_meta( get_the_ID(), 'ps-article-people', true ); ?>
            <select id="ps-article-people" name="ps-article-people" class="js-select">                
                <?php foreach($data as $person) : if ($person->post_type === 'people') :?>                  
                <option value="<?php echo $person->ID; ?>" <?php echo $locations ? 'selected' : ''; ?>><?php echo $person->post_title; ?></option>
                <?php endif; endforeach; ?>
            </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-article-case-studies">Case Studies</label>
        <?php $case_studies = get_post_meta( get_the_ID(), 'ps-article-case-studies', true ); ?>
            <select id="ps-article-case-studies" name="ps-article-case-studies" class="js-select">                
                <?php foreach($data as $case_study) : if ($case_study->post_type === 'case_studies') :?>                  
                <option value="<?php echo $case_study->ID; ?>" <?php echo $case_studies ? 'selected' : ''; ?>><?php echo $case_study->post_title; ?></option>
                <?php endif; endforeach; ?>
            </select>
    </div>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-article-content">Content</label>
        <?php
            $content   = wpautop( get_post_meta( get_the_ID(), 'ps-article-content', true ) );
            $editor_id = 'ps-article-content';
            $editor_settings  = array(
                'default_editor' => 'Quicktags'
            );

            wp_editor( $content, $editor_id, $editor_settings );
        ?>
    </div>


</div>