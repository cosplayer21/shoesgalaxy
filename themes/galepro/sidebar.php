<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-1' ) || galepro_is_amp() ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-md-4 pos-sticky" role="complementary" <?php galepro_itemtype_schema( 'WPSideBar' ); ?>>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
