<?php
/**
 * Block Name: Service Post List
 *
 * This is the template that displays the Category Grid loop block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'service-area-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'service-area-list';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$columns;
$get_layout = get_field('layout');
$show_image = get_field('show_list_image');
$show_description = get_field('show_list_description');
$get_columns = get_field('columns');

switch ($get_columns) {    
    case 2:
        $columns = 'col-span-two';
    break;
    case 3:
        $columns = 'col-span-three';
    break;
    case 4:
        $columns = 'col-span-four';
    break;
    case 5:
        $columns = 'col-span-five';
    break;
    case 6:
        $columns = 'col-span-six';
    break;
    case 7:
        $columns = 'col-span-seven';
    break;
}

$page_id = get_queried_object_id();

$service_args = array(
	'post_type' => 'area',
	'posts_per_page' => -1,
);

$services = new WP_Query( $service_args );

//print_r($related);

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <h3>Service Area Post List</h3>
    <div class="service-area-list <?php echo $get_layout; ?>">
        <?php while( $services->have_posts() ): $services->the_post(); 
            $list_image = esc_attr( get_post_meta( get_the_ID(), 'ps-list-img', true ) );  
            $list_description = wpautop( get_post_meta( get_the_ID(), 'ps-detail-page-description', true ) );      
            if ($page_id != get_the_ID() ) :
        ?>
            <div class="service-list-item <?php echo $columns; ?>">
                <?php if ($show_image) : ?>
                    <?php echo wp_get_attachment_image( $list_image, "full", "", array( "class" => "img-fluid ps-image" ) ); ?>
                <?php endif; ?>
                <h3><?php the_title(); ?></h3>
                <?php if ($show_description) : ?>
                    <?php echo $list_description; ?>
                <?php endif; ?>
            </div>           
            <?php endif; 
        endwhile; 
        wp_reset_postdata();
        ?>
    </div>
</div>