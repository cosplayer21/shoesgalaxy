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

// Disable thumbnail options via customizer.
$thumbnail = get_theme_mod( 'gmr_active-singlethumb', 0 );

// Disable meta data options via customizer.
$metadata = get_theme_mod( 'gmr_active-metasingle', 0 );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo galepro_itemtype_schema( 'CreativeWork' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<div class="gmr-box-content gmr-single">

		<?php
		if ( 0 === $thumbnail ) :
			if ( has_post_thumbnail() ) {
				?>
				<figure class="wp-caption alignnone">
					<?php the_post_thumbnail( 'full' ); ?>
					<?php
					$get_description = get_post( get_post_thumbnail_id() )->post_excerpt;
					if ( ! empty( $get_description ) ) :
						?>
					<figcaption class="wp-caption-text"><?php echo esc_html( $get_description ); ?></figcaption>
				<?php endif; ?>
				</figure>
				<?php
			}
		endif; // endif thumbnail.
		?>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" ' . galepro_itemprop_schema( 'headline' ) . '>', '</h1>' ); ?>
			<?php
			if ( 0 === $metadata ) :
				gmr_posted_on();
			endif;
			?>
		</header><!-- .entry-header -->

		<div class="entry-content entry-content-single" <?php echo galepro_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
				the_content();
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php
			gmr_entry_footer();

			if ( is_singular( 'post' ) ) {
				the_post_navigation(
					array(
						'prev_text' => __( '<span>Previous post</span> %title', 'galepro' ),
						'next_text' => __( '<span>Next post</span> %title', 'galepro' ),
					)
				);
			}
			?>
		</footer><!-- .entry-footer -->
	</div><!-- .gmr-box-content -->

	<?php do_action( 'galepro_core_author_box' ); ?>

</article><!-- #post-## -->
