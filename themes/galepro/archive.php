<?php
/**
 * The template for displaying archive pages.
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

// Blog layout options via customizer.
$blog_layout = get_theme_mod( 'gmr_blog_layout', 'gmr-smallthumb' );

// Sidebar layout options via customizer.
$sidebar_layout = get_theme_mod( 'gmr_blog_sidebar', 'sidebar' );

if ( 'fullwidth' === $sidebar_layout ) {
	$class_sidebar = ' col-md-12';
} else {
	$class_sidebar = ' col-md-8';
}
?>

<div id="primary" class="content-area<?php echo esc_attr( $class_sidebar ); ?> <?php echo esc_attr( $blog_layout ); ?>">

	<?php
	echo '<h1 class="page-title" ' . galepro_itemprop_schema( 'headline' ) . '><span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	the_archive_title();
	echo '</span></h1>';

	// display description archive page.
	the_archive_description( '<div class="taxonomy-description">', '</div>' );
	?>

	<main id="main" class="site-main" role="main">

	<?php
	if ( have_posts() ) {

		if ( 'gmr-masonry' === $blog_layout ) {
			echo '<div id="gmr-main-load" class="row grid-container">';
		}

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

			do_action( 'galepro_core_banner_between_posts' );

		endwhile;

		if ( 'gmr-masonry' === $blog_layout ) {
			echo '</div>';
		}

		echo gmr_get_pagination(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} else {
		get_template_part( 'template-parts/content', 'none' );

	}
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
if ( 'sidebar' === $sidebar_layout ) {
	get_sidebar();
}

get_footer();
