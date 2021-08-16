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
$slug = get_post_field( 'post_name', $page_id );
get_header();
?>
<section id="slider" class="slider-element" style="background-image: -webkit-linear-gradient(to bottom, #315653, #182927 ); background-image: linear-gradient(to bottom, #315653, #182927);">
    <div class="dotted-bg"></div>
    <div class="vertical-middle min-vh-lg-100">
        <div class="container py-5 py-lg-0">
            <div class="row align-items-center">
                <div class="col-lg-7 dark py-5">
                    <h6 class="text-uppercase ls4 fw-normal op-05">Platform</h6>
                    <h1 class="display-4 fw-bold"><?php the_title(); ?></h1>
                    <?php echo wpautop( get_post_meta( get_the_ID(), 'ps-detail-page-description', true ) ); ?>
                </div><!-- /col -->
                <div class="col-lg-5 mt-5 mt-lg-0">
                    <?php echo wp_get_attachment_image( get_post_meta( $page_id, 'ps-image', true ), 'full', "", array( "class" => "img-fluid ps-image" ) ); ?>
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

$platform_args = array(
	'post_type' => 'platform',
	'posts_per_page' => -1,
);

$platforms = new WP_Query( $platform_args );

//print_r($related);

?>
<h3>Our <?php echo strtoupper($slug); ?> Services</h3>
	<ul>
        <?php while( $platforms->have_posts() ): $platforms->the_post(); 
            $list_image = esc_attr( get_post_meta( get_the_ID(), 'ps-platform-list-image', true ) );
        ?>
            <li><?php echo wp_get_attachment_image( $list_image, "full", "", array( "class" => "img-fluid ps-image" ) ); ?></li>
			<li data-id="<?php echo get_the_ID(); ?>"><?php the_title(); ?></li>
            <?php
        endwhile; 
        wp_reset_postdata();
        ?>
    </ul>
<?php
get_footer();