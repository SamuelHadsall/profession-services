<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @link       https://www.steadyrain.com
 * @since      1.0.0
 *
 * @package    Professional_Services
 * @subpackage Professional_Services/public/page-templates
 */
$page_id = get_queried_object_id();
get_header();
?>
<section id="slider" class="slider-element" style="background-image: -webkit-linear-gradient(to bottom, #315653, #182927 ); background-image: linear-gradient(to bottom, #315653, #182927);">
    <div class="dotted-bg"></div>
    <div class="vertical-middle min-vh-lg-100">
        <div class="container py-5 py-lg-0">
            <div class="row align-items-center">
                <div class="col-lg-7 dark py-5">
                    <h6 class="text-uppercase ls4 fw-normal op-05"><?php echo get_post_type(); ?></h6>
                    <h1 class="display-4 fw-bold"><?php echo esc_html( get_post_meta( $page_id, 'ps-detail-header', true ) ); ?></h1>
                    <?php echo wpautop( get_post_meta( get_the_ID(), 'ps-detail-page-description', true ) ); ?>
                </div><!-- /col -->
                <div class="col-lg-5 mt-5 mt-lg-0">
                    <?php echo wp_get_attachment_image( get_post_meta( $page_id, 'ps-banner-img', true ), 'full', "", array( "class" => "img-fluid ps-image" ) ); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
while ( have_posts() ) {
    the_post();
    the_content();
}	

$related_args = array(
	'post_type' => 'service',
	'posts_per_page' => -1,
);

$related = new WP_Query( $related_args );

//print_r($related);

?>
<h3>Related posts</h3>
	<ul>
        <?php while( $related->have_posts() ): $related->the_post(); 
            $list_image = esc_attr( get_post_meta( get_the_ID(), 'ps-list-img', true ) );           
            if ($page_id != get_the_ID() ) :
        ?>
            <li><?php echo wp_get_attachment_image( $list_image, "full", "", array( "class" => "img-fluid ps-image" ) ); ?></li>
			<li data-id="<?php echo get_the_ID(); ?>"><?php the_title(); ?></li>
            <?php endif; 
        endwhile; 
        wp_reset_postdata();
        ?>
	</ul>
<?php

$related_casestudy_args = array(
	'post_type' => 'case_studies',
	'posts_per_page' => -1,
);

$related_casestudies = new WP_Query( $related_casestudy_args );

//print_r($related);

?>
<h3>View Our Work</h3>
	<ul>
        <?php while( $related_casestudies->have_posts() ): $related_casestudies->the_post(); 
            $list_image = esc_attr( get_post_meta( get_the_ID(), 'ps-images-list-img', true ) );
            $related_services = explode(',', get_post_meta( get_the_ID(), 'ps-services', true ) );
            if (in_array($page_id, $related_services ) ) :
        ?>
            <li><?php echo wp_get_attachment_image( $list_image, 'full', "", array( "class" => "img-fluid ps-image" ) ); ?></li>
			<li data-id="<?php echo get_the_ID(); ?>"><?php the_title(); ?></li>
            <?php endif; 
        endwhile; 
        wp_reset_postdata();
        ?>
	</ul>
<?php

get_footer();