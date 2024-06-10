<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Blog layout options via customizer.
$blog_layout = get_theme_mod( 'gmr_blog_layout', 'gmr-smallthumb' );

// Disable thumbnail options via customizer.
$thumbnail = get_theme_mod( 'gmr_active-blogthumb', 0 );

// Disable page navigation posts in archive options via customizer.
$pagenav = get_theme_mod( 'gmr_active-pagenavposts', 0 );

// Disable excerpt options via customizer.
$excerpt_opsi = get_theme_mod( 'gmr_active-excerptarchive', 0 );

// Blog Content options via customizer.
$blog_content = get_theme_mod( 'gmr_blog_content', 'excerpt' );

// Sidebar layout options via customizer.
$sidebar_layout = get_theme_mod( 'gmr_blog_sidebar', 'sidebar' );


if ( 'gmr-masonry' === $blog_layout ) {
	// layout masonry base sidebar options.
	if ( 'fullwidth' === $sidebar_layout ) {
		$classes = array(
			'col-masonry-4',
			'item',
		);
	} else {
		$classes = array(
			'col-masonry-6',
			'item',
		);
	}
} elseif ( 'gmr-smallthumb' === $blog_layout ) {
	$classes = array(
		'gmr-smallthumb',
		'clearfix',
	);
} else {
	$classes = array(
		'clearfix',
	);
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?> <?php echo galepro_itemtype_schema( 'CreativeWork' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="gmr-box-content gmr-archive clearfix">
		<?php
		// Add thumnail.
		if ( 0 === $thumbnail ) :
			$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

			if ( ! empty( $featured_image_url ) ) {
				if ( 'gmr-masonry' === $blog_layout ) :
					echo '<div class="content-thumbnail">';
						echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="' . the_title_attribute(
							array(
								'before' => __( 'Permalink to: ', 'galepro' ),
								'after'  => '',
								'echo'   => false,
							)
						) . '" rel="bookmark">';
							the_post_thumbnail( 'masonry-size', array( 'itemprop' => 'image' ) );
						echo '</a>';
					echo '</div>';

				elseif ( 'gmr-smallthumb' === $blog_layout ) :
					echo '<div class="content-thumbnail">';
						echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="' . the_title_attribute(
							array(
								'before' => __( 'Permalink to: ', 'galepro' ),
								'after'  => '',
								'echo'   => false,
							)
						) . '" rel="bookmark">';
							the_post_thumbnail( 'medium', array( 'itemprop' => 'image' ) );
						echo '</a>';
					echo '</div>';

				endif; // endif blog_layout.

			} else {
				if ( 'gmr-masonry' === $blog_layout ) :
					do_action( 'galepro_core_get_images', 'masonry-size', true, 'content-thumbnail' );

				elseif ( 'gmr-smallthumb' === $blog_layout ) :
					do_action( 'galepro_core_get_images', 'medium', true, 'content-thumbnail' );

				endif;

			} // endif has_post_thumbnail.
		endif; // endif thumbnail.
		?>

		<div class="item-article">

			<header class="entry-header">
				<h2 class="entry-title" <?php echo galepro_itemprop_schema( 'headline' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<a href="<?php the_permalink(); ?>" <?php echo galepro_itemprop_schema( 'url' ); // phpcs:ignore ?> title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'galepro' ), 'after' => '' ) ); // phpcs:ignore ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>

				<?php
				if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta screen-reader-text">
						<?php gmr_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php
				endif; // endif get_post_type.
				?>

			</header><!-- .entry-header -->

			<?php
			// Add thumnail.
			if ( 0 === $thumbnail ) :
				$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

				if ( ! empty( $featured_image_url ) ) {
					if ( 'gmr-default' === $blog_layout ) :
						echo '<div class="content-thumbnail">';
							echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="' . the_title_attribute(
								array(
									'before' => __( 'Permalink to: ', 'galepro' ),
									'after'  => '',
									'echo'   => false,
								)
							) . '" rel="bookmark">';
								the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
							echo '</a>';

						echo '</div>';

					endif; // endif blog_layout.
				} else {
					if ( 'gmr-default' === $blog_layout ) :
						do_action( 'galepro_core_get_images', 'full', true, 'content-thumbnail' );

					endif;

				}
			endif; // endif thumbnail.
			?>

			<div class="entry-content" <?php echo galepro_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
				if ( 0 === $excerpt_opsi ) :
					if ( 'fullcontent' === $blog_content ) :
						the_content();
					else :
						the_excerpt();
					endif;
				endif;

				if ( 'gmr-default' === $blog_layout ) :
					$numberimage = get_theme_mod( 'gmr_numbergallery', 4 );
					do_action( 'galepro_get_attachment_gallery', 'date', $numberimage, '', 'inherit', true, false );
				endif;

				if ( 0 === $pagenav ) :
					wp_link_pages(
						array(
							'before'      => '<div class="page-links clearfix"><span class="page-text">' . esc_html__( 'Pages:', 'galepro' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span class="page-link-number">',
							'link_after'  => '</span>',
						)
					);
				endif;
				?>
			</div><!-- .entry-content -->
		</div><!-- .item-article -->
	<?php if ( is_sticky() ) { ?>
		<kbd class="kbd-sticky"><?php esc_html_e( 'Sticky', 'galepro' ); ?></kbd>
	<?php } ?>

	</div><!-- .gmr-box-content -->

</article><!-- #post-## -->
