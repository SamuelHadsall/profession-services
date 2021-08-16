<?php
if( function_exists('acf_register_block_type') ) {
    // Register a testimonial block.
    acf_register_block_type(array(
        'name'              => 'platform_list',
        'title'             => __('Platform Post List'),
        'description'       => __('Platform Post List block.'),
        'post_types' 		=> array( 'post', 'page', 'lc_gt_block' ),
        'render_template'   => plugin_dir_path( __FILE__ ) . '/platform-list/platform-list.php',
        'category'          => 'theme',
        'example'           => array(
            'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    'show_list_image'   => 0,
                    'show_list_description'        => 0,
                    'layout'          => "list",
                    'is_preview'    => true
                )
            )
        )
    ));
}

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_610a15a5b8dee',
        'title' => 'Block Platform List',
        'fields' => array(
            array(
                'key' => 'field_610a15a5c1fe6',
                'label' => 'Show List Image',
                'name' => 'show_list_image',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_610a15a5c5ab1',
                'label' => 'Show List Description',
                'name' => 'show_list_description',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_610a15a5c9569',
                'label' => 'Layout',
                'name' => 'layout',
                'type' => 'checkbox',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'grid' => '<img src="/wp-content/plugins/professional-services/includes/assets/imgs/th-solid.svg" />',
                    'list' => '<img src="/wp-content/plugins/professional-services/includes/assets/imgs/bars-solid.svg" />',
                ),
                'allow_custom' => 0,
                'default_value' => array(
                    0 => 'list',
                ),
                'layout' => 'horizontal',
                'toggle' => 0,
                'return_format' => 'value',
                'save_custom' => 0,
            ),
            array(
                'key' => 'field_610a15a5ccfb4',
                'label' => 'Columns',
                'name' => 'columns',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_610a15a5c9569',
                            'operator' => '==',
                            'value' => 'grid',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    '1' => 'One',
                    '2' => 'Two',
                    '3' => 'Three',
                    '4' => 'Four',
                    '5' => 'Five',
                    '6' => 'Six',
                    '7' => 'Seven',
                ),
                'default_value' => false,
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/platform-list',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    endif;