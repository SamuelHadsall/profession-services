<?php
if( function_exists('acf_register_block_type') ) {
    // Register a testimonial block.
    acf_register_block_type(array(
        'name'              => 'service_list',
        'title'             => __('Service Post List'),
        'description'       => __('Service Post List block.'),
        'post_types' 		=> array( 'post', 'page', 'lc_gt_block' ),
        'render_template'   => plugin_dir_path( __FILE__ ) . '/service-list/service-list.php',
        'enqueue_assets' => function(){
            wp_enqueue_style( $this->plugin_name . '-service-post-list', plugins_url() . '/' . $this->plugin_name . '/includes/blocks/service-list/service-list.css' );
            wp_enqueue_script( $this->plugin_name . '-service-post-list', plugins_url() . '/' . $this->plugin_name . '/includes/blocks/service-list/service-list.js', array('jquery'), '', true );
          },
        'category'          => 'theme',
        'example'           => array(
            'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    'show_list_image'        => 0,
                    'show_list_description'  => 0,
                    'layout'                 => "list",
                    'is_preview'             => true
                )
            )
        )
    ));
}

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6104b67f7e56b',
        'title' => 'Block Service List',
        'fields' => array(
            array(
                'key' => 'field_6104b69d69a2c',
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
                'key' => 'field_6104b6dc69a2d',
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
                'key' => 'field_6104b70469a2e',
                'label' => 'Layout',
                'name' => 'layout',
                'type' => 'radio',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'grid' => '<img src="'. plugins_url() . '/' . $this->plugin_name . '/includes/assets/imgs/th-solid.svg" />',
                    'list' => '<img src="'. plugins_url() . '/' . $this->plugin_name . '/includes/assets/imgs/bars-solid.svg" />',
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
                'key' => 'field_6104b99669a2f',
                'label' => 'Columns',
                'name' => 'columns',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_6104b70469a2e',
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
                    '2' => 'Two',
                    '3' => 'Three',
                    '4' => 'Four',
                    '5' => 'Five',
                    '6' => 'Six',
                    '7' => 'Seven',
                    '8' => 'Eight',
                    '9' => 'Nine',
                    '10' => 'Ten',
                    '11' => 'Eleven',
                    '12' => 'Twelve',
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
                    'value' => 'acf/service-list',
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