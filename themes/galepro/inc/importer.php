<?php
/**
 * Importer plugin filter.
 *
 * @link https://wordpress.org/plugins/one-click-demo-import/
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'galepro_ocdi_import_files' ) ) :
	/**
	 * Set one click import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 *
	 * @return array
	 */
	function galepro_ocdi_import_files() {

		$arr = array(
			array(
				'import_file_name'             => 'Demo Import Default Layout',
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-data/demo-content.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-data/widgets.json',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-data/customizer.dat',
				'import_preview_image_url'     => 'https://demo.idtheme.com/img/galepro-default-min.jpg',
				'import_notice'                => __( 'Import demo from https://demo.idtheme.com/galepro/.', 'galepro' ),
			),
			array(
				'import_file_name'             => 'Demo Import Gallery Layout',
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-data/demo-content-galeri.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-data/widgets-galeri.json',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-data/customizer-galeri.dat',
				'import_preview_image_url'     => 'https://demo.idtheme.com/img/galepro-gallery-min.jpg',
				'import_notice'                => __( 'Import demo from https://demo.idtheme.com/galepro-galeri/.', 'galepro' ),
			),
			array(
				'import_file_name'             => 'Demo Import Grid Layout',
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-data/demo-content-grid.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-data/widgets-grid.json',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-data/customizer-grid.dat',
				'import_preview_image_url'     => 'https://demo.idtheme.com/img/galepro-grid-min.jpg',
				'import_notice'                => __( 'Import demo from https://demo.idtheme.com/galepro-grid/.', 'galepro' ),
			),
		);
		return $arr;
	}
endif;
add_filter( 'ocdi/import_files', 'galepro_ocdi_import_files' );

if ( ! function_exists( 'galepro_ocdi_before_import_import' ) ) :
	/**
	 * Filter before import content. https://ocdi.com/advanced-integration-guide/
	 *
	 * @since v.1.0.0
	 * @param array $selected_import selection importer data.
	 */
	function galepro_ocdi_before_import_import( $selected_import ) {

		// Find and delete the WP default 'Sample Page'.
		$default_page = get_page_by_title( 'Sample Page' );
		if ( ! empty( $default_page ) ) {
			wp_delete_post( $default_page->ID, $bypass_trash = true );
		}

		// Find and delete the WP default 'Hello world!' post.
		$default_post = get_posts( array( 'title' => 'Hello World!' ) );
		if ( ! empty( $default_post ) ) {
			wp_delete_post( $default_post[0]->ID, $bypass_trash = true );
		}

		/* Remove all widget active from sidebar */
		$null = null;
		update_option( 'sidebars_widgets', $null );
	}
endif;
add_action( 'ocdi/before_content_import', 'galepro_ocdi_before_import_import' );

if ( ! function_exists( 'galepro_ocdi_after_import' ) ) :
	/**
	 * Set action after import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 * @param array $selected_import selection importer data.
	 *
	 * @return void
	 */
	function galepro_ocdi_after_import( $selected_import ) {
		if ( 'Demo Import Default Layout' === $selected_import['import_file_name'] ) {
			// Menus to Import and assign - you can remove or add as many as you want.
			$top_menu = get_term_by( 'name', 'Top menus', 'nav_menu' );

			set_theme_mod(
				'nav_menu_locations',
				array(
					'primary' => $top_menu->term_id,
				)
			);

			// update option post per page.
			update_option( 'posts_per_page', 7 );
		}

		if ( 'Demo Import Gallery Layout' === $selected_import['import_file_name'] ) {
			// Menus to Import and assign - you can remove or add as many as you want.
			$top_menu    = get_term_by( 'name', 'Top menus', 'nav_menu' );
			$second_menu = get_term_by( 'name', 'Second menus', 'nav_menu' );

			set_theme_mod(
				'nav_menu_locations',
				array(
					'primary'   => $top_menu->term_id,
					'secondary' => $second_menu->term_id,
				)
			);
			// update option post per page.
			update_option( 'posts_per_page', 3 );
		}
		if ( 'Demo Import Grid Layout' === $selected_import['import_file_name'] ) {
			// Menus to Import and assign - you can remove or add as many as you want.
			$top_menu = get_term_by( 'name', 'Top menus', 'nav_menu' );
			set_theme_mod(
				'nav_menu_locations',
				array(
					'primary' => $top_menu->term_id,
				)
			);
			// update option post per page.
			update_option( 'posts_per_page', 6 );
		}

		if ( class_exists( 'Menu_Icons', false ) ) {
			$defaults = array(
				'global' => array(
					'icon_types' => array( 'image' ),
				),
			);

			update_option( 'menu-icons', $defaults );
		}

		if ( class_exists( 'Galepro_Core_Init', false ) ) {
			if ( 'Demo Import Default Layout' === $selected_import['import_file_name'] ) {
				$ads_options = array(
					'ads_topbanner'                 => '<img src="https://demo.idtheme.com/img/old/idt-size-72090.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'ads_topbanner_aftermenu'       => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-3.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'ads_after_betweenpost'         => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
					'ads_before_content'            => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_after_content'             => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_inside_content'            => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
					'ads_before_content_attachment' => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_after_content_attachment'  => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_floatbanner_left'          => '',
					'ads_floatbanner_right'         => '',
					'ads_floatbanner_footer'        => '',
					'ads_footerbanner'              => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-2.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
				);

				$ampads_options = array(
					'amp_ads_topbanner'           => '<img src="https://demo.idtheme.com/img/old/idt-size-72090.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'amp_ads_topbanner_aftermenu' => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-3.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'amp_ads_after_betweenpost'   => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
					'amp_ads_before_content'      => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'amp_ads_after_content'       => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'amp_ads_inside_content'      => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
				);

				// Update entire array.
				update_option( 'glpro_ads', $ads_options );
				update_option( 'glpro_amp', $ampads_options );
			}
			if ( 'Demo Import Gallery Layout' === $selected_import['import_file_name'] ) {
				$ads_options = array(
					'ads_topbanner'                 => '<img src="https://demo.idtheme.com/img/old/idt-size-72090.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'ads_topbanner_aftermenu'       => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-3.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'ads_after_betweenpost'         => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
					'ads_before_content'            => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_after_content'             => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_inside_content'            => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
					'ads_before_content_attachment' => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_after_content_attachment'  => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_floatbanner_left'          => '',
					'ads_floatbanner_right'         => '',
					'ads_floatbanner_footer'        => '',
					'ads_footerbanner'              => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-2.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
				);

				$ampads_options = array(
					'amp_ads_topbanner'           => '',
					'amp_ads_topbanner_aftermenu' => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-3.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'amp_ads_after_betweenpost'   => '',
					'amp_ads_before_content'      => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'amp_ads_after_content'       => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'amp_ads_inside_content'      => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
				);

				// Update entire array.
				update_option( 'glpro_ads', $ads_options );
				update_option( 'glpro_amp', $ampads_options );
			}
			if ( 'Demo Import Grid Layout' === $selected_import['import_file_name'] ) {
				$ads_options = array(
					'ads_topbanner'                 => '<img src="https://demo.idtheme.com/img/old/idt-size-72090.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'ads_topbanner_aftermenu'       => '<img src="https://demo.idtheme.com/img/banner-720x90-3.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'ads_after_betweenpost'         => '',
					'ads_before_content'            => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_after_content'             => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_inside_content'            => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
					'ads_before_content_attachment' => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_after_content_attachment'  => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'ads_floatbanner_left'          => '',
					'ads_floatbanner_right'         => '',
					'ads_floatbanner_footer'        => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
					'ads_footerbanner'              => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-2.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
				);

				$ampads_options = array(
					'amp_ads_topbanner'           => '<img src="https://demo.idtheme.com/img/old/idt-size-72090.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'amp_ads_topbanner_aftermenu' => '<img src="https://demo.idtheme.com/img/old/idt-size-72090-3.jpg" alt="banner 728x90" title="banner 728x90" height="90" width="728" />',
					'amp_ads_after_betweenpost'   => '',
					'amp_ads_before_content'      => '<img src="https://demo.idtheme.com/img/old/idt-size-336280-2.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'amp_ads_after_content'       => '<img src="https://demo.idtheme.com/img/old/idt-size-336280.png" alt="banner 336x280" title="banner 336x280" height="280" width="336" />',
					'amp_ads_inside_content'      => '<img src="https://demo.idtheme.com/img/old/idt-size-46860.jpg" alt="banner 468x60" title="banner 468x60" width="468" height="60" />',
				);

				// Update entire array.
				update_option( 'glpro_ads', $ads_options );
				update_option( 'glpro_amp', $ampads_options );
			}
		}

	}
endif;
add_action( 'ocdi/after_import', 'galepro_ocdi_after_import' );

if ( ! function_exists( 'galepro_change_time_of_single_ajax_call' ) ) :
	/**
	 * Change ajax call timeout
	 *
	 * @link https://github.com/awesomemotive/one-click-demo-import/blob/master/docs/import-problems.md.
	 */
	function galepro_change_time_of_single_ajax_call() {
		return 60;
	}
endif;
add_action( 'ocdi/time_for_one_ajax_call', 'galepro_change_time_of_single_ajax_call' );

// disable generation of smaller images (thumbnails) during the content import.
add_filter( 'ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

// disable the branding notice.
add_filter( 'ocdi/disable_pt_branding', '__return_true' );
