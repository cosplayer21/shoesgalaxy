<?php
/**
 * Woocommerce Compatibility File.
 *
 * @link https://wordpress.org/plugins/woocommerce/
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gmr_woocommerce_support' ) ) :
	/**
	 * Declare WooCommerce support.
	 *
	 * @since 1.0.0
	 */
	function gmr_woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif; // endif gmr_woocommerce_support.
add_action( 'after_setup_theme', 'gmr_woocommerce_support' );

if ( ! function_exists( 'gmr_override_page_title' ) ) :
	/**
	 * Disable title archive in shop template
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	function gmr_override_page_title() {
		return false;
	}
endif; // endif gmr_override_page_title.
add_filter( 'woocommerce_show_page_title', 'gmr_override_page_title' );

if ( ! function_exists( 'gmr_theme_wrapper_start' ) ) :
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since 1.0.0
	 *
	 * @return  void
	 */
	function gmr_theme_wrapper_start() {
		$setting = 'gmr_wc_sidebar';
		$class   = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( 'fullwidth' === $class ) :
			$classes = wp_filter_nohtml_kses( 'col-md-12' );
		else :
			$classes = wp_filter_nohtml_kses( 'col-md-8' );
		endif;
		?>
		<div id="primary" class="content-area <?php echo esc_html( $classes ); ?>">
			<main id="main" class="site-main" role="main">
		<?php
	}
endif; // endif gmr_theme_wrapper_start.

if ( ! function_exists( 'gmr_theme_wrapper_end' ) ) :
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since 1.0.0
	 *
	 * @return  void
	 */
	function gmr_theme_wrapper_end() {
		?>
			</main> <!-- #main -->
		</div>	<!-- #primary -->
		<?php
	}
endif; // endif gmr_theme_wrapper_end.

// Remove default content wrapper.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Add new content wrapper.
add_action( 'woocommerce_before_main_content', 'gmr_theme_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'gmr_theme_wrapper_end', 10 );

if ( ! function_exists( 'gmr_remove_woocommerce_sidebar' ) ) :
	/**
	 * Remove_action woocommerce_sidebar
	 * Remove default woocommerce sidebar
	 *
	 * @since 1.0.0
	 */
	function gmr_remove_woocommerce_sidebar() {
		$setting = 'gmr_wc_sidebar';
		$class   = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( 'fullwidth' === $class ) :
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		endif;
	}
endif; // endif gmr_remove_woocommerce_sidebar.
add_action( 'woocommerce_before_main_content', 'gmr_remove_woocommerce_sidebar' );

// Remove woocommerce default Breadcrumb.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/**
 * Change and remove default woocommerce pagination
 *
 * @since 1.0.0
 *
 * @return void
 */
function woocommerce_pagination() {
	echo gmr_get_pagination(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );
remove_action( 'woocommerce_pagination', 'woocommerceframework_pagination', 10 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination_wrap_open', 5 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination_wrap_close', 25 );
add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );

if ( ! function_exists( 'gmr_theme_loop_start' ) ) :
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since 1.0.0
	 *
	 * @return  void
	 */
	function gmr_theme_loop_start() {
		?>
		<div class="gmr-box-product">
		<?php
	}
endif; // endif gmr_theme_loop_start.
add_action( 'woocommerce_shop_loop_item_title', 'gmr_theme_loop_start', 5 );

if ( ! function_exists( 'gmr_theme_loop_end' ) ) :
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since 1.0.0
	 *
	 * @return  void
	 */
	function gmr_theme_loop_end() {
		?>
		</div> <!-- .gmr-box-product -->
		<?php
	}
endif; // endif gmr_theme_loop_end.
add_action( 'woocommerce_after_shop_loop_item_title', 'gmr_theme_loop_end', 10 );

if ( ! function_exists( 'gmr_woocommerce_product_columns' ) ) :
	/**
	 * Product columns class
	 *
	 * @since 1.0.0
	 *
	 * @param  array $classes current body classes.
	 * @return array          new body classes
	 * @filter body_class
	 */
	function gmr_woocommerce_product_columns( $classes ) {
		$setting = 'gmr_wc_column';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		// (int) sanitize integer.
		$classes[] = 'product-columns-' . (int) $mod;

		// Cross Sells.
		if ( is_checkout() ) :
			// (int) sanitize integer
			$classes[] = 'product-columns-2';

		endif;
		return $classes;
	}
endif; // endif gmr_woocommerce_product_columns.
add_filter( 'body_class', 'gmr_woocommerce_product_columns' );

if ( ! function_exists( 'gmr_woocommerce_products_row' ) ) :
	/**
	 * Return the desired products per row
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	function gmr_woocommerce_products_row() {
		$setting = 'gmr_wc_column';

		// Default options in default page..
		$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		// only Cross Sells in cart and checkout page.
		if ( is_checkout() ) :
			$mod = '2';
		endif;
		// (int) sanitize integer.
		return (int) $mod;
	}
endif; // endif gmr_woocommerce_products_row.
add_filter( 'loop_shop_columns', 'gmr_woocommerce_products_row' );

if ( ! function_exists( 'gmr_woocommerce_related_products' ) ) :
	/**
	 * Return related products
	 *
	 * @since 1.0.0
	 *
	 * @param  array $args current related product args.
	 * @return array $args
	 */
	function gmr_woocommerce_related_products( $args ) {
		$setting = 'gmr_wc_column';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		// (int) sanitize integer.
		$args['posts_per_page'] = (int) $mod; // settings related products.
		$args['columns']        = (int) $mod; // arranged in settings columns.
		return $args;
	}
endif; // endif gmr_woocommerce_related_products.
add_filter( 'woocommerce_output_related_products_args', 'gmr_woocommerce_related_products' );

if ( ! function_exists( 'gmr_woocommerce_output_upsells' ) ) :
	/**
	 * Change number of upsells displayed and number of columns
	 *
	 * @since 1.0.0
	 *
	 * @link https://docs.woothemes.com/wc-apidocs/function-woocommerce_upsell_display.html
	 */
	function gmr_woocommerce_output_upsells() {
		$setting = 'gmr_wc_column';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		// (int) sanitize integer
		woocommerce_upsell_display( (int) $mod, (int) $mod, 'rand' ); // Display products in rows of setting and order by rand.
	}
endif; // endif gmr_woocommerce_output_upsells.
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'gmr_woocommerce_output_upsells', 15 );

if ( ! function_exists( 'gmr_wp_nav_menu_items' ) ) :
	/**
	 * This function adds the WooCommerce or Easy Digital Downloads cart icons/items to the primary menu area as the last item.
	 *
	 * @since 1.0.0
	 *
	 * @link https://slocumthemes.com/2015/06/how-to-display-shopping-cart-details-wordpress-menu/
	 *
	 * @param string $items Items.
	 * @param array  $args Args.
	 * @param bool   $ajax default false.
	 * @return string
	 */
	function gmr_wp_nav_menu_items( $items, $args, $ajax = false ) {
		// Option remove cart button.
		$setting = 'gmr_active-cartbutton';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		// Primary Navigation Area Only.
		if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && 'primary' === $args->theme_location && 0 === $mod ) ) {
			// WooCommerce.
			if ( class_exists( 'WooCommerce' ) ) {
				$css_class = 'menu-item menu-item-type-cart menu-item-type-woocommerce-cart gmr-menu-cart pull-right';

				$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a class="cart-contents" href="' . esc_url( wc_get_cart_url() ) . '">';
				$items .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0 0 20.01 4H5.21l-.94-2H1v2h2l3.6 7.59l-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2s-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2s2-.9 2-2s-.9-2-2-2z" fill="currentColor"/></svg><sup>' . wp_kses_data( WC()->cart->get_cart_contents_count() ) . '</sup>';
				$items .= '</a>';
				$items .= '</li>';
			} elseif ( class_exists( 'Easy_Digital_Downloads' ) ) {
				$css_class = 'menu-item menu-item-type-cart menu-item-type-edd-cart gmr-menu-cart pull-right';

				$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a class="cart-contents" href="' . esc_url( edd_get_checkout_uri() ) . '">';
				$items .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0 0 20.01 4H5.21l-.94-2H1v2h2l3.6 7.59l-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2s-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2s2-.9 2-2s-.9-2-2-2z" fill="currentColor"/></svg><sup>' . wp_kses_data( edd_get_cart_quantity() ) . '</sup>';
				$items .= '</a>';
				$items .= '</li>';
			}
		}
		return $items;
	}
endif; // endif gmr_wp_nav_menu_items.
add_filter( 'wp_nav_menu_items', 'gmr_wp_nav_menu_items', 10, 2 );

if ( ! function_exists( 'gmr_woocommerce_add_to_cart_fragments' ) ) :
	/**
	 * This function updates the Primary Navigation WooCommerce cart link contents when an item is added via AJAX.
	 *
	 * @since 1.0.0
	 *
	 * @param string $fragments Fragments.
	 * @return string
	 */
	function gmr_woocommerce_add_to_cart_fragments( $fragments ) {
		// Add our fragment.
		$fragments['li.menu-item-type-woocommerce-cart'] = gmr_wp_nav_menu_items( '', new stdClass(), true );
		return $fragments;
	}
endif; // endif gmr_woocommerce_add_to_cart_fragments.
add_filter( 'woocommerce_add_to_cart_fragments', 'gmr_woocommerce_add_to_cart_fragments' );

if ( ! function_exists( 'gmr_wc_products_per_page' ) ) :
	/**
	 * Number product per page
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	function gmr_wc_products_per_page() {
		$setting = 'gmr_wc_productperpage';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		// sanitize integer.
		return (int) $mod;
	}
endif; // endif gmr_wc_products_per_page.
add_filter( 'loop_shop_per_page', 'gmr_wc_products_per_page', 20 );

if ( ! function_exists( 'gmr_filter_woocommerce_comment_pagination_args' ) ) :
	/**
	 * Define the woocommerce_comment_pagination_args callback.
	 *
	 * @since 1.0.0
	 *
	 * @link https://github.com/woocommerce/woocommerce/blob/311c540662bc9d064c66a5304457e4161dcc8ece/templates/single-product-reviews.php
	 * @param array $array Array.
	 * @return array $array
	 */
	function gmr_filter_woocommerce_comment_pagination_args( $array ) {
		$array = array(
			'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M17.59 18L19 16.59L14.42 12L19 7.41L17.59 6l-6 6z" fill="currentColor"/><path d="M11 18l1.41-1.41L7.83 12l4.58-4.59L11 6l-6 6z" fill="currentColor"/></svg>',
			'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M6.41 6L5 7.41L9.58 12L5 16.59L6.41 18l6-6z" fill="currentColor"/><path d="M13 6l-1.41 1.41L16.17 12l-4.58 4.59L13 18l6-6z" fill="currentColor"/></svg>',
			'type'      => 'list',
		);
		return $array;
	};
endif; // endif gmr_filter_woocommerce_comment_pagination_args.
add_filter( 'woocommerce_comment_pagination_args', 'gmr_filter_woocommerce_comment_pagination_args', 10, 1 );
