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
                    <h1 class="display-4 fw-bold"><?php echo esc_html( get_post_meta( $page_id, 'ps-platform-detail-header', true ) ); ?></h1>
                    <?php echo wpautop( get_post_meta( get_the_ID(), 'ps-platform-detail-page-description', true ) ); ?>
                </div><!-- /col -->
                <div class="col-lg-5 mt-5 mt-lg-0">
                    <?php echo wp_get_attachment_image( get_post_meta( $page_id, 'ps-platform-detail-banner-image', true ), 'full', "", array( "class" => "img-fluid ps-image" ) ); ?>
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
get_footer();