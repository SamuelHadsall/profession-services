<?php
$service_args = array(
	'post_type' => 'service',
	'posts_per_page' => -1,
);

$services = new \WP_Query( $service_args );

//print_r($related);

?>
<h3>Related posts</h3>
<ul>
    <?php while( $services->have_posts() ): $services->the_post();
    
    if (true == $instance['image']) :
        $list_image = esc_attr( get_post_meta( get_the_ID(), 'ps-list-img', true ) );           
        
    ?>
        <li><?php echo wp_get_attachment_image( $list_image, "full", "", array( "class" => "img-fluid ps-image" ) ); ?></li>
    <?php 
    endif;
    ?>
    <li data-id="<?php echo get_the_ID(); ?>"><?php the_title(); ?></li>
    <?php
    if (true == $instance['description']) :
        $list_desc = wp_kses_post( get_post_meta( get_the_ID(), 'ps-list-description', true ) );
    ?>
        <li><?php echo $list_desc; ?></li>
    <?php
    endif;
    ?>			
        <?php 
    endwhile; 
    wp_reset_postdata();
    ?>
</ul>