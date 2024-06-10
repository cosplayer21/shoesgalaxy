<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<?php

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
	echo esc_html__( 'Search Results For: ', 'galepro' ) . ' ' . esc_attr( apply_filters( 'the_search_query', get_search_query( false ) ) );
	echo '</span></h1>';
	?>

	<main id="main" class="site-main" role="main">

	<?php
	if ( have_posts() ) {

		if ( 'gmr-masonry' === $blog_layout ) :
			echo '<div id="gmr-main-load" class="row grid-container">';
		endif;

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-__.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;

		if ( 'gmr-masonry' === $blog_layout ) :
			echo '</div>';
		endif;

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
