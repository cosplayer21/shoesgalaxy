<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<section class="no-results not-found">
	<div class="gmr-box-content">
		<header class="entry-header">
			<h2 class="page-title" <?php echo galepro_itemprop_schema( 'headline' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><span><?php esc_html_e( 'Nothing Found', 'galepro' ); ?></span></h2>
		</header><!-- .page-header -->

		<div class="entry-content" <?php echo galepro_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) :
				?>

				<p><?php printf( wp_kses( /* translators: %1$s: Admin URL */ __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'galepro' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php elseif ( is_search() ) : ?>

				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'galepro' ); ?></p>
				<?php
					get_search_form();

			else :
				?>

				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'galepro' ); ?></p>
				<?php
					get_search_form();

			endif;
			?>
		</div><!-- .page-content -->
	</div><!-- .gmr-box-content -->
</section><!-- .no-results -->
