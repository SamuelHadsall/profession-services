<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://steadyrain.com/
 * @since      1.0.0
 *
 * @package    Professional_Services
 * @subpackage Professional_Services/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
$args = array(
    'public'   => true,
    '_builtin' => false
 );

 $output = 'objects'; // 'names' or 'objects' (default: 'names')
 $operator = 'and'; // 'and' or 'or' (default: 'and')

 $post_types = get_post_types( $args, $output, $operator );

 if ( $post_types ) : // If there are any custom public post types.
 ?>
 <h1 class="ui header">Professional Services Admin</h1>
 <div class="ui grid dashboard-card-row">
 <?php foreach ( $post_types as $post_type ) : ?>
    <?php //print_r($post_type); ?>
    <div class="four wide column">
        <a href="/wp-admin/edit.php?post_type=<?php echo $post_type->name; ?>">
            <div class="dashboard-cards">
                <div class="dashboard-card-icon">
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                </div>
                <h2><?php echo $post_type->labels->singular_name; ?></h2>
            </div>
        </a>
    </div>
<?php endforeach; ?>
</div>
<?php endif; ?>
