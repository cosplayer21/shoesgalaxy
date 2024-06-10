<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
			</div><!-- .row -->
		</div><!-- .container -->
		<div id="stop-container"></div>
		<?php
		if ( ! galepro_is_amp() ) {
			do_action( 'galepro_core_banner_footer' );
		}
		?>

	</div><!-- .gmr-content -->
</div><!-- #site-container -->

	<div id="footer-container">

		<?php
		if ( ! galepro_is_amp() ) {
			$mod = get_theme_mod( 'gmr_footer_column', '3' );
			if ( '4' === $mod ) {
				$class = 'col-md-3';
			} elseif ( '3' === $mod ) {
				$class = 'col-md-4';
			} elseif ( '2' === $mod ) {
				$class = 'col-md-6';
			} else {
				$class = 'col-md-12';
			}

			if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) {
				?>
				<div id="footer-sidebar" class="widget-footer" role="complementary">
					<div class="container">
						<div class="row">
							<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
								<div class="footer-column <?php echo esc_html( $class ); ?>">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div>
							<?php endif; ?>
							<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
								<div class="footer-column <?php echo esc_html( $class ); ?>">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div>
							<?php endif; ?>
							<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
								<div class="footer-column <?php echo esc_html( $class ); ?>">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div>
							<?php endif; ?>
							<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
								<div class="footer-column <?php echo esc_html( $class ); ?>">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php
			}
		}
		?>

		<footer id="colophon" class="site-footer" role="contentinfo" <?php galepro_itemtype_schema( 'WPFooter' ); ?>>
			<div class="container">
				<div class="site-info">
				<?php
				if ( galepro_is_amp() ) {
					/* Add Non AMP Version using <div id="site-version-switcher"> and id="version-switch-link" */
					$nonamp_link = amp_remove_endpoint( amp_get_current_url() );
					echo '<div class="text-center nonamp-button"><div id="site-version-switcher"><a id="version-switch-link" href="' . esc_url( $nonamp_link ) . '" class="amp-wp-canonical-link" title="' . __( 'Non AMP Version', 'superfast' ) . '" rel="noamphtml">' . __( 'Non AMP Version', 'superfast' ) . '</a></div></div>';			
				}
				$copyright = get_theme_mod( 'gmr_copyright' );
				if ( $copyright ) :
					// sanitize html output than convert it again using htmlspecialchars_decode.
					echo wp_kses_post( $copyright );
				else :
					?>
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'galepro' ) ); ?>" title="<?php printf( /* translators: %s: WordPress */ esc_html__( 'Proudly powered by %s', 'galepro' ), 'WordPress' ); ?>"><?php printf( /* translators: %s: WordPress */ esc_html__( 'Proudly powered by %s', 'galepro' ), 'WordPress' ); ?></a>
					<span class="sep"> / </span>
					<a href="<?php echo esc_url( __( 'http://www.gianmr.com/', 'galepro' ) ); ?>" title="<?php printf( /* translators: %s: galepro */ esc_html__( 'Theme: %s', 'galepro' ), 'Galepro' ); ?>"><?php printf( /* translators: %s: galepro */ esc_html__( 'Theme: %s', 'galepro' ), 'Galepro' ); ?></a>
				<?php endif; ?>
				</div><!-- .site-info -->
			</div><!-- .container -->
		</footer><!-- #colophon -->

	</div><!-- #footer-container -->
	
<?php
	if ( ! galepro_is_amp() ) {
		do_action( 'galepro_core_floating_footer' );
		echo '<div class="gmr-ontop gmr-hide"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><path d="M12 22V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 14l7-7l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 2h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g></svg></div>';
	}
?>
	
<?php if ( galepro_is_amp() ) { ?>
	<amp-sidebar id="navigationamp" layout="nodisplay" side="left">
		<?php do_action( 'gmr_the_custom_logo' ); ?>
		<button on="tap:navigationamp.close" class="close-topnavmenu-wrap"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16 2C8.2 2 2 8.2 2 16s6.2 14 14 14s14-6.2 14-14S23.8 2 16 2zm0 26C9.4 28 4 22.6 4 16S9.4 4 16 4s12 5.4 12 12s-5.4 12-12 12z" fill="currentColor"/><path d="M21.4 23L16 17.6L10.6 23L9 21.4l5.4-5.4L9 10.6L10.6 9l5.4 5.4L21.4 9l1.6 1.6l-5.4 5.4l5.4 5.4z" fill="currentColor"/></svg></button>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => 'ul',
				'menu_id'        => 'amp-primary-menu',
				'link_before'    => '<span itemprop="name">',
				'link_after'     => '</span>',
			)
		);
		?>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'secondary',
				'container'      => 'ul',
				'fallback_cb'    => '',
				'menu_id'        => 'amp-primary-menu',
				'link_before'    => '<span itemprop="name">',
				'link_after'     => '</span>',
			)
		);
		?>
		<?php
		// Option remove search button.
		$setting    = 'gmr_active-searchbutton';
		$mod_search = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( 0 === $mod_search ) :
			?>
			<form method="get" class="gmr-searchform searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" name="s" id="s" placeholder="<?php echo esc_html__( 'Search', 'superfast' ); ?>" />
			</form>
		<?php endif; ?>
	</amp-sidebar>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
