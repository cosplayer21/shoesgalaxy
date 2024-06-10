<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Disable sidebar using metabox.
$sidebar_display = get_post_meta( $post->ID, '_gmr_sidebar_key', true );

// Sidebar layout options via customizer.
$sidebar_layout = get_theme_mod( 'gmr_page_sidebar', 'sidebar' );

if ( 'fullwidth' === $sidebar_layout ) :
	$class = ' col-md-12';
elseif ( $sidebar_display ) :
	$class = ' col-md-12';
else :
	$class = ' col-md-8';
endif;

?>

<div id="primary" class="content-area<?php echo esc_attr( $class ); ?>">

	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				if ( galepro_is_amp() ) {
					/* Add Non AMP Version using <div id="site-version-switcher"> and id="version-switch-link" */
					$nonamp_link = amp_remove_endpoint( amp_get_current_url() );
					echo '<div class="site-main gmr-box-content text-center"><div id="site-version-switcher"><a id="version-switch-link" class="button" href="' . esc_url( $nonamp_link ) . '#comments" class="amp-wp-canonical-link" title="' . __( 'Add Comment', 'galepro' ) . '" rel="noamphtml nofollow">' . __( 'Add Comment', 'galepro' ) . '</a></div></div>';
				} else {	
					comments_template();
				}
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php
if ( $sidebar_display || 'fullwidth' === $sidebar_layout ) :
else :
	get_sidebar();
endif;

get_footer();
