<?php
/**
 * Custom functions for bbpress
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Remove BBP breadcrumb.
add_filter( 'bbp_no_breadcrumb', '__return_true' );
