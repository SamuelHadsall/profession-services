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

        .ps-meta-video-box, .ps-meta-documents-box {
            display: flex;
            flex-wrap: wrap;
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
    <div class="ui top attached tabular menu">
        <a class="active item" data-tab="case-study">Case Study Info</a>
        <a class="item" data-tab="related-content">Related Content</a>
        <a class="item" data-tab="images">Images</a>
        <a class="item" data-tab="documents">Documents</a>
        <a class="item" data-tab="videos">Videos</a>
    </div>
    <div class="ui bottom attached tab segment active" data-tab="case-study">
    <div class="ps-meta-box">
        <div class="meta-options ps-meta-box-field">
            <label for="ps-detail-header">Detail Header Title</label>
            <input id="ps-detail-header" type="text" name="ps-detail-header" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-detail-header', true ) ); ?>" />
        </div>
        <div class="meta-options ps-meta-box-field">
            <?php $clients = get_post_meta( get_the_ID(), 'ps-clients', true ); ?>
            <label for="ps-clients">Clients</label>
            <select id="ps-clients" name="ps-clients" class="js-select">                
                <?php foreach($data as $client) : if ($client->post_type === 'clients') :?>                  
                <option value="<?php echo $client->ID; ?>" <?php echo $clients ? 'selected' : ''; ?>><?php echo $client->post_title; ?></option>
                <?php endif; endforeach; ?>
            </select>
        </div>
        <div class="meta-options ps-meta-box-field">
            <?php $locations = get_post_meta( get_the_ID(), 'ps-locations', true ); ?>
            <label for="ps-locations">Locations</label>
            <select id="ps-locations" name="ps-locations" class="js-select">                
                <?php foreach($data as $location) : if ($location->post_type === 'locations') :?>                  
                <option value="<?php echo $location->ID; ?>" <?php echo $locations ? 'selected' : ''; ?>><?php echo $location->post_title; ?></option>
                <?php endif; endforeach; ?>
            </select>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-people">People</label>
            <?php $people = get_post_meta( get_the_ID(), 'ps-people', true ); ?>
            <select id="ps-people" name="ps-people" class="js-select">                
                <?php foreach($data as $person) : if ($person->post_type === 'people') :?>                  
                <option value="<?php echo $person->ID; ?>" <?php echo $locations ? 'selected' : ''; ?>><?php echo $person->post_title; ?></option>
                <?php endif; endforeach; ?>
            </select>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-challenge-description">Challenge</label>
            <?php
                $challenge_editor_content   =  esc_attr( get_post_meta( get_the_ID(), 'ps-challenge-description', true ) );
                $challenge_editor_id = 'ps-challenge-description';
                $challenge_editor_settings  = array(
                    'media_buttons' => false,
                    'default_editor' => 'Quicktags'
                );

                wp_editor( $challenge_editor_content, $challenge_editor_id, $challenge_editor_settings );
            ?>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-solution-description">Solution</label>
            <?php
                $solution_editor_content   = esc_attr( get_post_meta( get_the_ID(), 'ps-solution-description', true ) );
                $solution_editor_id = 'ps-solution-description';
                $solution_editor_settings  = array(
                    'media_buttons' => false,
                    'default_editor' => 'Quicktags'
                );

                wp_editor( $solution_editor_content, $solution_editor_id, $solution_editor_settings );
            ?>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-results-description">Results</label>
            <?php
                $results_editor_content   = esc_attr( get_post_meta( get_the_ID(), 'ps-results-description', true ) );
                $results_editor_id = 'ps-results-description';
                $results_editor_settings  = array(
                    'media_buttons' => false,
                    'default_editor' => 'Quicktags'
                );

                wp_editor( $results_editor_content, $results_editor_id, $results_editor_settings );
            ?>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-list-description">List Description</label>
            <?php
                $list_editor_content   = esc_attr( get_post_meta( get_the_ID(), 'ps-list-description', true ) );
                $list_editor_id = 'ps-list-description';
                $list_editor_settings  = array(
                    'media_buttons' => false,
                    'default_editor' => 'Quicktags'
                );

                wp_editor( $list_editor_content, $list_editor_id, $list_editor_settings );
            ?>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-detail-description">Detail Description</label>
            <?php
                $detail_editor_content   = esc_attr( get_post_meta( get_the_ID(), 'ps-detail-description', true ) );
                $detail_editor_id = 'ps-detail-description';
                $detail_editor_settings  = array(
                    'media_buttons' => false,
                    'default_editor' => 'Quicktags'
                );

                wp_editor( $detail_editor_content, $detail_editor_id, $detail_editor_settings );
            ?>
        </div>
        </div>
    </div>
    <div class="ui bottom attached tab segment" data-tab="related-content">
        <div class="ps-meta-box">
            <div class="meta-options ps-meta-box-field">
                <label for="ps-channels">Channel(s)</label>
                <?php $related_channels = explode(',', get_post_meta( get_the_ID(), 'ps-channels', true ) ); ?>
                <select id="ps-channels" name="ps-channels[]" class="js-select" multiple="multiple">                
                    <?php foreach($data as $channel) : if ($channel->post_type === 'channels') :?>  
                        <?php  $selected = in_array( $channel->ID, $related_channels ) ? ' selected="selected" ' : ''; ?>
                        <option value="<?php echo $channel->ID; ?>" <?php echo $selected; ?>><?php echo $channel->post_title; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="meta-options ps-meta-box-field">
                <label for="ps-services">Service(s)</label>
                <?php $related_services = explode(',', get_post_meta( get_the_ID(), 'ps-services', true ) ); ?>
                <select id="ps-services" name="ps-services[]" class="js-select" multiple="multiple">                
                    <?php foreach($data as $service) : if ($service->post_type === 'service') :?> 
                        <?php $selected = in_array($service->ID, $related_services ) ? ' selected="selected" ' : ''; ?>                 
                    <option value="<?php echo $service->ID; ?>" <?php echo $selected; ?>><?php echo $service->post_title; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="meta-options ps-meta-box-field">
                <label for="ps-platform">Platform(s)</label>
                <?php $related_platforms = explode(',', get_post_meta( get_the_ID(), 'ps-platform', true ) ); ?>
                <select id="ps-platform" name="ps-platform[]" class="js-select" multiple="multiple">                
                    <?php foreach($data as $platform) : if ($platform->post_type === 'platform') :?>  
                        <?php $selected = in_array($platform->ID, $related_platforms ) ? ' selected="selected" ' : ''; ?>                
                    <option value="<?php echo $platform->ID; ?>" <?php echo $selected; ?>><?php echo $platform->post_title; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="meta-options ps-meta-box-field">
                <label for="ps-platform-groups">Platform Group(s)</label>
                <?php $related_platform_groups = explode(',', get_post_meta( get_the_ID(), 'ps-platform-groups', true ) ); ?>
                <select id="ps-platform-groups" name="ps-platform-groups[]" class="js-select" multiple="multiple">  
                    <?php foreach($data as $platform_group) : if ($platform_group->post_type === 'platform_groups') :?>    
                        <?php $selected = in_array($platform_group->ID, $related_platform_groups ) ? ' selected="selected" ' : ''; ?>              
                    <option value="<?php echo $platform_group->ID; ?>" <?php echo $selected; ?>><?php echo $platform_group->post_title; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="meta-options ps-meta-box-field">
                <label for="ps-challenges">Challenge(s)</label>
                <?php $related_challenges = explode(',', get_post_meta( get_the_ID(), 'ps-challenges', true ) ); ?>
                <select id="ps-challenges" name="ps-challenges[]" class="js-select" multiple="multiple">                
                    <?php foreach($data as $challenge) : if ($challenge->post_type === 'challenges') :?>   
                        <?php $selected = in_array($challenge->ID, $related_challenges ) ? ' selected="selected" ' : ''; ?>               
                    <option value="<?php echo $challenge->ID; ?>" <?php echo $selected; ?>><?php echo $challenge->post_title; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="meta-options ps-meta-box-field">
                <?php $related_articles = explode(',',  get_post_meta( get_the_ID(), 'ps-articles', true ) ); ?>
                <label for="ps-articles">Article(s)</label>            
                <select id="ps-articles" name="ps-articles[]" class="js-select" multiple="multiple">                
                    <?php foreach($data as $article) : if ($article->post_type === 'articles') :?>
                        <?php $selected = in_array($article->ID, $related_articles ) ? ' selected="selected" ' : ''; ?>                   
                    <option value="<?php echo $article->ID; ?>" <?php echo $selected; ?>><?php echo $article->post_title; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="ui bottom attached tab segment" data-tab="images">
    <div class="ps-meta-box">
        <div class="meta-options ps-meta-box-field">
            <label for="ps-images-list-image">List View Image</label>
            <?php $list_image = esc_attr( get_post_meta( get_the_ID(), 'ps-images-list-img', true ) ); ?>
            <div class="file-uploaded list-image-uploaded <?php echo get_post_meta( get_the_ID(), 'ps-images-list-img', true ) != null ? '' : 'hidden'; ?>">
                <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
                <img src="<?php echo $list_image; ?>" class="img-fluid ps-image" />
                <?php echo wp_get_attachment_image( $list_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
                <input type="hidden" name="ps-images-list-img" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-images-list-img', true ) ); ?>" class="icon-img" />
            </div>
            <div class="file-upload <?php echo get_post_meta( get_the_ID(), 'ps-images-list-img', true ) ? 'hidden' : ''; ?>">
                <div class="file-upload-add-file add-file add-list-image">
                    <label for="ps-images-list-image" data-tooltip="Click To Add File">
                            <i class="fal fa-plus-circle fa-3x"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-images-detail-banner-image">Detail Banner Image</label>
            <?php $banner_image = esc_attr( get_post_meta( get_the_ID(), 'ps-images-detail-banner-image', true ) ); ?>
            <div class="file-uploaded banner-image-uploaded <?php echo get_post_meta( get_the_ID(), 'ps-images-detail-banner-image', true ) != null ? '' : 'hidden'; ?>">
                <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
                <img src="<?php echo $banner_image; ?>" class="img-fluid ps-image" />
                <?php echo wp_get_attachment_image( $banner_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
                <input type="hidden" name="ps-images-detail-banner-image" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-images-list-img', true ) ); ?>" class="icon-img" />
            </div>
            <div class="file-upload <?php echo get_post_meta( get_the_ID(), 'ps-images-detail-banner-image', true ) ? 'hidden' : ''; ?>">
                <div class="file-upload-add-file add-file add-banner-image">
                    <label for="ps-images-detail-banner-image" data-tooltip="Click To Add File">
                            <i class="fal fa-plus-circle fa-3x"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-images-challenge-image">Challenge Image</label>
            <?php $challenge_image = esc_attr( get_post_meta( get_the_ID(), 'ps-images-challenge-image', true ) ); ?>
            <div class="file-uploaded challenge-image-uploaded <?php echo get_post_meta( get_the_ID(), 'ps-images-challenge-image', true ) != null ? '' : 'hidden'; ?>">
                <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
                <img src="<?php echo $challenge_image; ?>" class="img-fluid ps-image" />
                <?php echo wp_get_attachment_image( $challenge_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
                <input type="hidden" name="ps-images-challenge-image" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-images-challenge-image', true ) ); ?>" class="icon-img" />
            </div>
            <div class="file-upload <?php echo get_post_meta( get_the_ID(), 'ps-images-challenge-image', true ) ? 'hidden' : ''; ?>">
                <div class="file-upload-add-file add-file add-challenge-image">
                    <label for="ps-images-challenge-image" data-tooltip="Click To Add File">
                            <i class="fal fa-plus-circle fa-3x"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-images-solutions-image">Solution Image</label>
            <?php $solutions_image = esc_attr( get_post_meta( get_the_ID(), 'ps-images-solutions-image', true ) ); ?>
            <div class="file-uploaded solutions-image-uploaded <?php echo get_post_meta( get_the_ID(), 'ps-images-solutions-image', true ) != null ? '' : 'hidden'; ?>">
                <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
                <img src="<?php echo $solutions_image; ?>" class="img-fluid ps-image" />
                <?php echo wp_get_attachment_image( $solutions_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
                <input type="hidden" name="ps-images-solutions-image" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-images-solutions-image', true ) ); ?>" class="icon-img" />
            </div>
            <div class="file-upload <?php echo get_post_meta( get_the_ID(), 'ps-images-solutions-image', true ) ? 'hidden' : ''; ?>">
                <div class="file-upload-add-file add-file add-solutions-image">
                    <label for="ps-images-solutions-image" data-tooltip="Click To Add File">
                            <i class="fal fa-plus-circle fa-3x"></i>
                    </label>
                </div>
            </div>
        </div>
        <div class="meta-options ps-meta-box-field">
            <label for="ps-images-results-image">Results Image</label>
            <?php $results_image = esc_attr( get_post_meta( get_the_ID(), 'ps-images-results-image', true ) ); ?>
            <div class="file-uploaded results-image-uploaded <?php echo get_post_meta( get_the_ID(), 'ps-images-results-image', true ) != null ? '' : 'hidden'; ?>">
                <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
                <img src="<?php echo $results_image; ?>" class="img-fluid ps-image" />
                <?php echo wp_get_attachment_image( $results_image, array('156', '156'), "", array( "class" => "img-fluid wp-image ps-image" ) ); ?>
                <input type="hidden" name="ps-images-results-image" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-images-results-image', true ) ); ?>" class="icon-img" />
            </div>
            <div class="file-upload <?php echo get_post_meta( get_the_ID(), 'ps-images-results-image', true ) ? 'hidden' : ''; ?>">
                <div class="file-upload-add-file add-file add-results-image">
                    <label for="ps-images-results-image" data-tooltip="Click To Add File">
                            <i class="fal fa-plus-circle fa-3x"></i>
                    </label>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="ui bottom attached tab segment" data-tab="documents">
        <?php $documents = explode(',', get_post_meta( get_the_ID(), 'ps-document', true) ); ?>
        <div class="ui placeholder segment file-upload">
            <div class="ui icon header">
                <i class="pdf file outline icon"></i>
                <span class="segment-text">
                <?php if (!empty($documents)) : ?>
                    You have <span class="doc-count"><?php echo count($documents); ?></span> documents uploaded to this Case Study.
                <?php else: ?>
                    No documents are uploaded to this Case Study.
                <?php endif; ?>
                </span>
            </div>
            <div class="ui primary button add-documents">Add Document</div>
        </div>
        <div class="ps-meta-documents-box ps-meta-slides document-slides">
        <?php if (!empty($documents)) {
            $output = '';
            foreach ($documents as $key=>$val) {
                $ext = pathinfo($val, PATHINFO_EXTENSION);
                $output .= '<div class="file-upload document-uploaded document-' . $key . '">';
                    $output .= '<a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>';
                    if ($ext === 'png' || $ext === 'jpg' || $ext === 'jpeg') {
                        $output .= '<img src="' . plugins_url( $this->plugin_name . '/includes/assets/imgs/file-image-solid.svg') . '" class="img-fluid ps-image icon" />';
                    }
                    elseif ($ext === 'pdf') {
                        $output .= '<img src="' . plugins_url( $this->plugin_name . '/includes/assets/imgs/file-pdf-solid.svg') . '" class="img-fluid ps-image icon" />';
                    }
                    elseif ($ext === 'doc' || $ext === 'docx') {
                        $output .= '<img src="' . plugins_url( $this->plugin_name . '/includes/assets/imgs/file-word-solid.svg') . '" class="img-fluid ps-image icon" />';
                    } else {
                        $output .= '<img src="' .plugins_url( $this->plugin_name . '/includes/assets/imgs/file-alt-solid.svg') . '" class="img-fluid ps-image icon" />';
                    }
                    $output .= '<input type="hidden" class="js-video-embed-upload" id="ps-document-control-' . $key . '" name="ps-document[]" value="'.esc_attr($val).'">';
                $output .= '</div>';
            }
            echo $output;
        } ?>
            <div class="file-upload document-uploaded-clone hidden">
                <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            </div>
        </div>
    </div>
    <div class="ui bottom attached tab segment" data-tab="videos">
    <?php $videos = explode(',', get_post_meta( get_the_ID(), 'ps-videos', true) ); ?>
    <?php print_r($videos); ?>
    <div class="ui placeholder segment">
        <div class="ui icon header">
            <i class="film icon"></i>
            <span class="segment-text">
            <?php if (!empty($videos)) : ?>
                You have <span class="doc-count"><?php echo count($videos); ?></span> videos uploaded to this Case Study.
            <?php else: ?>
                No videos are uploaded to this Case Study.
            <?php endif; ?>
            </span>
        </div>
        <div class="ui primary button js-videos">Add Video</div>
    </div>
    <div class="ps-meta-video-box ps-meta-slides video-slides">
        <?php if (!empty($videos)) {
            $output = '';
            foreach ($videos as $key=>$val) {
                $vid_id = basename($val);
                $output .= '<div class="video-uploaded video-' . $key . '">';
                    $output .= '<a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>';
                    $output .= '<div class="ui embed" data-url="https://www.youtube.com/embed/'.esc_attr($val).'" data-placeholder="http://i3.ytimg.com/vi/' . $vid_id . '/hqdefault.jpg"></div>';
                    $output .= '<input type="hidden" class="js-video-embed-upload" id="ps-videos-control-' . $key . '" name="ps-videos[]" value="'.esc_attr($val).'">';
                $output .= '</div>';
            }
            echo $output;
            } ?>
        <div class="video-uploaded-clone hidden">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <div class="ui embed" data-url="" data-placeholder=""></div>
        </div>
    </div>
    <div class="ui modal embed-modal">
        <i class="close icon"></i>
        <div class="header">
            Add New Video
        </div>
        <div class="content">
            <div class="ps-meta-box">
                <div class="meta-options ps-meta-box-field">
                    <label for="ps-detail-header">YouTube Video ID</label>
                    <div class="ui labeled input">
                        <div class="ui label">
                            https://www.youtube.com/embed/
                        </div>
                        <input class="js-video-embed-upload" id="ps-video-upload" name="ps-video-upload" placeholder="1uB2ZRjbtbY" />
                    </div>                    
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