<?php
/**
 * Defines customizer options
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'galepro_get_home' ) ) {
	/**
	 * Get homepage without http/https and www
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function galepro_get_home() {
		$protocols = array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' );
		return str_replace( $protocols, '', home_url() );
	}
}

/**
 * Option array customizer library
 *
 * @since 1.0.0
 */
function gmr_library_options_customizer() {

	// Prefix_option.
	$gmrprefix = 'gmr';

	/*
	 * Theme defaults
	 *
	 * @since v.1.0.0
	 */
	// General.
	$color_scheme = '#2ecc71';

	/**
	 * Header Default Options
	 */
	$header_bgcolor    = '#ffffff';
	$sitetitle_color   = '#2ecc71';
	$menu_bgcolor      = '#2ecc71';
	$menu_color        = '#ffffff';
	$menu_hoverbgcolor = '#e74c3c';
	$menu_hovercolor   = '#ffffff';
	$sitedesc_color    = '#999999';

	$topnav_bgcolor    = '#f6f4f1';
	$topnav_color      = '#333333';
	$topnav_hovercolor = '#2ecc71';

	$default_logo = get_template_directory_uri() . '/images/logo.png';

	// content.
	$content_bgcolor        = '#ffffff';
	$content_color          = '#2c3e50';
	$content_linkcolor      = '#e74c3c';
	$content_hoverlinkcolor = '#2ecc71';

	// Footer.
	$footer_bgcolor           = '#f6f4f1';
	$footer_fontcolor         = '';
	$footer_linkcolor         = '';
	$footer_hoverlinkcolor    = '';
	$copyright_bgcolor        = '#fff';
	$copyright_fontcolor      = '';
	$copyright_linkcolor      = '';
	$copyright_hoverlinkcolor = '';

	// Add Lcs.
	$hm         = md5( galepro_get_home() );
	$license    = trim( get_option( 'galepro_core_license_key' . $hm ) );
	$upload_dir = wp_upload_dir();

	// Stores all the controls that will be added.
	$options = array();

	// Stores all the sections to be added.
	$sections = array();

	// Stores all the panels to be added.
	$panels = array();

	// Adds the sections to the $options array.
	$options['sections'] = $sections;

	/*
	 * General Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_general = 'panel-general';
	$panels[]      = array(
		'id'       => $panel_general,
		'title'    => __( 'General', 'galepro' ),
		'priority' => '30',
	);

	$section    = 'layout_options';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'General Layout', 'galepro' ),
		'priority' => 35,
		'panel'    => $panel_general,
	);

	$layout = array(
		'box-layout'       => __( 'Box', 'galepro' ),
		'box-small-layout' => __( 'Box Small (728px)', 'galepro' ),
		'full-layout'      => __( 'Fullwidth', 'galepro' ),
	);

	$options[ $gmrprefix . '_layout' ] = array(
		'id'      => $gmrprefix . '_layout',
		'label'   => __( 'Select Layout', 'galepro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $layout,
		'default' => 'box-layout',
	);

	$options[ $gmrprefix . '_active-logosection' ] = array(
		'id'          => $gmrprefix . '_active-logosection',
		'label'       => __( 'Disable logo section', 'galepro' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 0,
		'description' => __( 'If you disable logo section, ads side logo will not display.', 'galepro' ),
	);

	// Colors.
	$section    = 'colors';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'General Colors', 'galepro' ),
		'panel'    => $panel_general,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_scheme-color' ] = array(
		'id'      => $gmrprefix . '_scheme-color',
		'label'   => __( 'Base Color Scheme', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $color_scheme,
	);

	$options[ $gmrprefix . '_content-bgcolor' ] = array(
		'id'       => $gmrprefix . '_content-bgcolor',
		'label'    => __( 'Background Color - Content', 'galepro' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_bgcolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-color' ] = array(
		'id'       => $gmrprefix . '_content-color',
		'label'    => __( 'Font Color - Body', 'galepro' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_color,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-linkcolor' ] = array(
		'id'       => $gmrprefix . '_content-linkcolor',
		'label'    => __( 'Link Color - Body', 'galepro' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_linkcolor,
		'priority' => 50,
	);

	$options[ $gmrprefix . '_content-hoverlinkcolor' ] = array(
		'id'       => $gmrprefix . '_content-hoverlinkcolor',
		'label'    => __( 'Hover Link Color - Body', 'galepro' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_hoverlinkcolor,
		'priority' => 60,
	);

	$options[ $gmrprefix . '_chrome_mobile_color' ] = array(
		'id'      => $gmrprefix . '_chrome_mobile_color',
		'label'   => __( 'Color In Chrome Mobile', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '',
	);

	// Colors.
	$section    = 'background_image';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Background Image', 'galepro' ),
		'panel'       => $panel_general,
		'description' => __( 'Background Image only display, if using box layout.', 'galepro' ),
		'priority'    => 45,
	);

	// Typography.
	$section      = 'typography';
	$font_choices = customizer_library_get_font_choices();
	$sections[]   = array(
		'id'       => $section,
		'title'    => __( 'Typography', 'galepro' ),
		'panel'    => $panel_general,
		'priority' => 50,
	);

	$options[ $gmrprefix . '_primary-font' ] = array(
		'id'      => $gmrprefix . '_primary-font',
		'label'   => __( 'Heading Font', 'galepro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Open Sans',
	);

	$options[ $gmrprefix . '_secondary-font' ] = array(
		'id'      => $gmrprefix . '_secondary-font',
		'label'   => __( 'Body Font', 'galepro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Open Sans',
	);

	$primaryweight = array(
		'300' => '300',
		'400' => '400',
		'500' => '500',
		'600' => '600',
		'700' => '700',
	);

	$options[ $gmrprefix . '_body_size' ] = array(
		'id'          => $gmrprefix . '_body_size',
		'label'       => __( 'Body font size', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '13',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_secondary-font-weight' ] = array(
		'id'          => $gmrprefix . '_secondary-font-weight',
		'label'       => __( 'Body font weight', 'galepro' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $primaryweight,
		'description' => __( 'Note: some font maybe not display properly, if not display properly try to change this font weight.', 'galepro' ),
		'default'     => '500',
	);

	$options[ $gmrprefix . '_h1_size' ] = array(
		'id'          => $gmrprefix . '_h1_size',
		'label'       => __( 'h1 font size', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '30',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h2_size' ] = array(
		'id'          => $gmrprefix . '_h2_size',
		'label'       => __( 'h2 font size', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '26',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h3_size' ] = array(
		'id'          => $gmrprefix . '_h3_size',
		'label'       => __( 'h3 font size', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '24',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h4_size' ] = array(
		'id'          => $gmrprefix . '_h4_size',
		'label'       => __( 'h4 font size', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '22',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h5_size' ] = array(
		'id'          => $gmrprefix . '_h5_size',
		'label'       => __( 'h5 font size', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '20',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h6_size' ] = array(
		'id'          => $gmrprefix . '_h6_size',
		'label'       => __( 'h6 font size', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '18',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	/*
	 * Header Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_header = 'panel-header';
	$panels[]     = array(
		'id'       => $panel_header,
		'title'    => __( 'Header', 'galepro' ),
		'priority' => '40',
	);

	// Logo.
	$section    = 'title_tagline';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Site Identity', 'galepro' ),
		'priority'    => 30,
		'panel'       => $panel_header,
		'description' => __( 'Allow you to add icon, logo, change site-title and tagline to your website.', 'galepro' ),
	);

	$options[ $gmrprefix . '_logoimage' ] = array(
		'id'          => $gmrprefix . '_logoimage',
		'label'       => __( 'Logo', 'galepro' ),
		'section'     => $section,
		'type'        => 'image',
		'default'     => $default_logo,
		'description' => __( 'If using logo, Site Title and Tagline automatic disappear.', 'galepro' ),
	);

	$options[ $gmrprefix . '_logo_margintop' ] = array(
		'id'          => $gmrprefix . '_logo_margintop',
		'label'       => __( 'Logo Margin Top', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '0',
		'description' => '',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	);

	$section    = 'header_layout';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Header Layout', 'galepro' ),
		'priority' => 35,
		'panel'    => $panel_header,
	);

	$layout = array(
		'with-search' => __( 'Logo + Search', 'galepro' ),
		'with-ads'    => __( 'Logo + Ads', 'galepro' ),
		'only-logo'   => __( 'Only Logo', 'galepro' ),
	);

	$options[ $gmrprefix . '_header-layout' ] = array(
		'id'      => $gmrprefix . '_header-layout',
		'label'   => __( 'Header Layout', 'galepro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $layout,
		'default' => 'with-search',
	);

	$section    = 'header_image';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Header Image', 'galepro' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you customize header sections in home page.', 'galepro' ),
	);

	$options[ $gmrprefix . '_active-headerimage' ] = array(
		'id'          => $gmrprefix . '_active-headerimage',
		'label'       => __( 'Disable header image', 'galepro' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 0,
		'priority'    => 25,
		'description' => __( 'If you disable header image, header section will replace with header color.', 'galepro' ),
	);

	$bgsize = array(
		'auto'    => 'Auto',
		'cover'   => 'Cover',
		'contain' => 'Contain',
		'initial' => 'Initial',
		'inherit' => 'Inherit',
	);

	$options[ $gmrprefix . '_headerimage_bgsize' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgsize',
		'label'       => __( 'Background Size', 'galepro' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgsize,
		'priority'    => 30,
		'description' => __( 'The background-size property specifies the size of the header images.', 'galepro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/css3_pr_background-size.asp', 'galepro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'galepro' ) . '</a>',
		'default'     => 'auto',
	);

	$bgrepeat = array(
		'repeat'   => 'Repeat',
		'repeat-x' => 'Repeat X',
		'repeat-y' => 'Repeat Y',
		'initial'  => 'Initial',
		'inherit'  => 'Inherit',
	);

	$options[ $gmrprefix . '_headerimage_bgrepeat' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgrepeat',
		'label'       => __( 'Background Repeat', 'galepro' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgrepeat,
		'priority'    => 35,
		'description' => __( 'The background-repeat property sets if/how a header image will be repeated.', 'galepro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-repeat.asp', 'galepro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'galepro' ) . '</a>',
		'default'     => 'repeat',
	);

	$bgposition = array(
		'left top'      => 'left top',
		'left center'   => 'left center',
		'left bottom'   => 'left bottom',
		'right top'     => 'right top',
		'right center'  => 'right center',
		'right bottom'  => 'right bottom',
		'center top'    => 'center top',
		'center center' => 'center center',
		'center bottom' => 'center bottom',
	);

	$options[ $gmrprefix . '_headerimage_bgposition' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgposition',
		'label'       => __( 'Background Position', 'galepro' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgposition,
		'priority'    => 40,
		'description' => __( 'The background-position property sets the starting position of a header image.', 'galepro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-position.asp', 'galepro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'galepro' ) . '</a>',
		'default'     => 'center top',
	);

	$bgattachment = array(
		'scroll'  => 'Scroll',
		'fixed'   => 'Fixed',
		'local'   => 'Local',
		'initial' => 'Initial',
		'inherit' => 'Inherit',
	);

	$options[ $gmrprefix . '_headerimage_bgattachment' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgattachment',
		'label'       => __( 'Background Attachment', 'galepro' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgattachment,
		'priority'    => 45,
		'description' => __( 'The background-attachment property sets whether a header image is fixed or scrolls with the rest of the page.', 'galepro' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-attachment.asp', 'galepro' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'galepro' ) . '</a>',
		'default'     => 'scroll',
	);

	$section    = 'header_color';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Header Color', 'galepro' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you customize header color style.', 'galepro' ),
	);

	$options[ $gmrprefix . '_header-bgcolor' ] = array(
		'id'      => $gmrprefix . '_header-bgcolor',
		'label'   => __( 'Background Color - Header', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $header_bgcolor,
	);

	$options[ $gmrprefix . '_sitetitle-color' ] = array(
		'id'      => $gmrprefix . '_sitetitle-color',
		'label'   => __( 'Site title color', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $sitetitle_color,
	);

	$options[ $gmrprefix . '_sitedesc-color' ] = array(
		'id'      => $gmrprefix . '_sitedesc-color',
		'label'   => __( 'Site description color', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $sitedesc_color,
	);

	$options[ $gmrprefix . '_mainmenu-bgcolor' ] = array(
		'id'      => $gmrprefix . '_mainmenu-bgcolor',
		'label'   => __( 'Background Menu', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_bgcolor,
	);

	$options[ $gmrprefix . '_mainmenu-hoverbgcolor' ] = array(
		'id'      => $gmrprefix . '_mainmenu-hoverbgcolor',
		'label'   => __( 'Background Menu Hover and Active', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_hoverbgcolor,
	);

	$options[ $gmrprefix . '_mainmenu-color' ] = array(
		'id'      => $gmrprefix . '_mainmenu-color',
		'label'   => __( 'Text color - Menu', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_color,
	);

	$options[ $gmrprefix . '_hovermenu-color' ] = array(
		'id'      => $gmrprefix . '_hovermenu-color',
		'label'   => __( 'Text hover color - Menu', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_hovercolor,
	);

	$options[ $gmrprefix . '_topnav-bgcolor' ] = array(
		'id'      => $gmrprefix . '_topnav-bgcolor',
		'label'   => __( 'Background Top Navigation', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_bgcolor,
	);

	$options[ $gmrprefix . '_topnav-color' ] = array(
		'id'      => $gmrprefix . '_topnav-color',
		'label'   => __( 'Text color - Top Navigation', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_color,
	);

	$options[ $gmrprefix . '_hovertopnav-color' ] = array(
		'id'      => $gmrprefix . '_hovertopnav-color',
		'label'   => __( 'Text hover color - Top Navigation', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_hovercolor,
	);

	$section    = 'social';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Social & Top Navigation', 'galepro' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you add social icon and disable top navigation.', 'galepro' ),
	);

	$options[ $gmrprefix . '_active-topnavigation' ] = array(
		'id'      => $gmrprefix . '_active-topnavigation',
		'label'   => __( 'Disable top navigation', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-rssicon' ] = array(
		'id'      => $gmrprefix . '_active-rssicon',
		'label'   => __( 'Disable RSS icon in social', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_fb_url_icon' ] = array(
		'id'          => $gmrprefix . '_fb_url_icon',
		'label'       => __( 'FB Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_twitter_url_icon' ] = array(
		'id'          => $gmrprefix . '_twitter_url_icon',
		'label'       => __( 'Twitter Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_pinterest_url_icon' ] = array(
		'id'          => $gmrprefix . '_pinterest_url_icon',
		'label'       => __( 'Pinterest Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_tumblr_url_icon' ] = array(
		'id'          => $gmrprefix . '_tumblr_url_icon',
		'label'       => __( 'Tumblr Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_stumbleupon_url_icon' ] = array(
		'id'          => $gmrprefix . '_stumbleupon_url_icon',
		'label'       => __( 'Stumbleupon Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_wordpress_url_icon' ] = array(
		'id'          => $gmrprefix . '_wordpress_url_icon',
		'label'       => __( 'Wordpress Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_instagram_url_icon' ] = array(
		'id'          => $gmrprefix . '_instagram_url_icon',
		'label'       => __( 'Instagram Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_dribbble_url_icon' ] = array(
		'id'          => $gmrprefix . '_dribbble_url_icon',
		'label'       => __( 'Dribbble Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_vimeo_url_icon' ] = array(
		'id'          => $gmrprefix . '_vimeo_url_icon',
		'label'       => __( 'Vimeo Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_linkedin_url_icon' ] = array(
		'id'          => $gmrprefix . '_linkedin_url_icon',
		'label'       => __( 'Linkedin Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_deviantart_url_icon' ] = array(
		'id'          => $gmrprefix . '_deviantart_url_icon',
		'label'       => __( 'Deviantart Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_myspace_url_icon' ] = array(
		'id'          => $gmrprefix . '_myspace_url_icon',
		'label'       => __( 'Myspace Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_skype_url_icon' ] = array(
		'id'          => $gmrprefix . '_skype_url_icon',
		'label'       => __( 'Skype Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_youtube_url_icon' ] = array(
		'id'          => $gmrprefix . '_youtube_url_icon',
		'label'       => __( 'Youtube Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_picassa_url_icon' ] = array(
		'id'          => $gmrprefix . '_picassa_url_icon',
		'label'       => __( 'Picassa Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_flickr_url_icon' ] = array(
		'id'          => $gmrprefix . '_flickr_url_icon',
		'label'       => __( 'Flickr Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_blogger_url_icon' ] = array(
		'id'          => $gmrprefix . '_blogger_url_icon',
		'label'       => __( 'Blogger Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_spotify_url_icon' ] = array(
		'id'          => $gmrprefix . '_spotify_url_icon',
		'label'       => __( 'Spotify Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_delicious_url_icon' ] = array(
		'id'          => $gmrprefix . '_delicious_url_icon',
		'label'       => __( 'Delicious Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_tiktok_url_icon' ] = array(
		'id'          => $gmrprefix . '_tiktok_url_icon',
		'label'       => __( 'Tiktok Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_telegram_url_icon' ] = array(
		'id'          => $gmrprefix . '_telegram_url_icon',
		'label'       => __( 'Telegram Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_soundcloud_url_icon' ] = array(
		'id'          => $gmrprefix . '_soundcloud_url_icon',
		'label'       => __( 'Soundcloud Url', 'galepro' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'galepro' ),
		'priority'    => 90,
	);

	$section    = 'menu_style';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Primary Menu Style', 'galepro' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you customize menu style.', 'galepro' ),
	);

	$sticky = array(
		'sticky'   => __( 'Sticky', 'galepro' ),
		'nosticky' => __( 'Static', 'galepro' ),
	);

	$options[ $gmrprefix . '_sticky_menu' ] = array(
		'id'      => $gmrprefix . '_sticky_menu',
		'label'   => __( 'Sticky Menu', 'galepro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $sticky,
		'default' => 'sticky',
	);

	$menustyle = array(
		'gmr-boxmenu'   => __( 'Box Menu', 'galepro' ),
		'gmr-fluidmenu' => __( 'Fluid Menu', 'galepro' ),
	);

	$options[ $gmrprefix . '_menu_style' ] = array(
		'id'      => $gmrprefix . '_menu_style',
		'label'   => __( 'Primary Menu Style', 'galepro' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $menustyle,
		'default' => 'gmr-boxmenu',
	);

	$options[ $gmrprefix . '_active-searchbutton' ] = array(
		'id'      => $gmrprefix . '_active-searchbutton',
		'label'   => __( 'Remove search button in Primary Menu', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$section    = 'slider_options';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Slider Options', 'galepro' ),
		'priority'    => 50,
		'panel'       => $panel_header,
		'description' => __( 'Allow you add slider shortcode, and display it in front page.', 'galepro' ),
	);

	$options[ $gmrprefix . '_slider_shortcode' ] = array(
		'id'          => $gmrprefix . '_slider_shortcode',
		'label'       => __( 'Slider Shortcode.', 'galepro' ),
		'section'     => $section,
		'type'        => 'textarea',
		'priority'    => 30,
		'description' => __( 'Please insert slider shortcode here.', 'galepro' ),
	);

	/*
	 * Blog Section Options
	 *
	 * @since v.1.0.0
	 */

	$panel_blog = 'panel-blog';
	$panels[]   = array(
		'id'       => $panel_blog,
		'title'    => __( 'Blog', 'galepro' ),
		'priority' => '50',
	);

	$section    = 'bloglayout';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Blog Layout', 'galepro' ),
		'priority' => 50,
		'panel'    => $panel_blog,
	);

	$bloglayout = array(
		'gmr-default'    => __( 'Big thumnail with gallery', 'galepro' ),
		'gmr-smallthumb' => __( 'Small thumbnail', 'galepro' ),
		'gmr-masonry'    => __( 'Grid', 'galepro' ),
	);

	$options[ $gmrprefix . '_blog_layout' ] = array(
		'id'      => $gmrprefix . '_blog_layout',
		'label'   => __( 'Blog Layout', 'galepro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $bloglayout,
		'default' => 'gmr-smallthumb',
	);

	$options[ $gmrprefix . '_numbergallery' ] = array(
		'id'          => $gmrprefix . '_numbergallery',
		'label'       => __( 'Number Gallery', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '4',
		'description' => __( 'Number gallery if using big thumbnail in gallery layout. Default 4 and maximal 20 images.', 'galepro' ),
		'input_attrs' => array(
			'min'  => 4,
			'max'  => 20,
			'step' => 4,
		),
	);

	$sidebar = array(
		'sidebar'   => __( 'Sidebar', 'galepro' ),
		'fullwidth' => __( 'Fullwidth', 'galepro' ),
	);

	$options[ $gmrprefix . '_blog_sidebar' ] = array(
		'id'      => $gmrprefix . '_blog_sidebar',
		'label'   => __( 'Blog Sidebar', 'galepro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $sidebar,
		'default' => 'sidebar',
	);

	$options[ $gmrprefix . '_single_sidebar' ] = array(
		'id'          => $gmrprefix . '_single_sidebar',
		'label'       => __( 'Single Sidebar', 'galepro' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => $sidebar,
		'description' => __( 'Default layout sidebar for single, if you want disable sidebar only in special post or page, you can use post options.', 'galepro' ),
		'default'     => 'sidebar',
	);

	$options[ $gmrprefix . '_page_sidebar' ] = array(
		'id'          => $gmrprefix . '_page_sidebar',
		'label'       => __( 'Page Sidebar', 'galepro' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => $sidebar,
		'description' => __( 'Default layout sidebar for page, if you want disable sidebar only in special post or page, you can use post options.', 'galepro' ),
		'default'     => 'sidebar',
	);

	$section    = 'blogcontent';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Blog Content', 'galepro' ),
		'priority' => 50,
		'panel'    => $panel_blog,
	);

	$options[ $gmrprefix . '_active-blogthumb' ] = array(
		'id'      => $gmrprefix . '_active-blogthumb',
		'label'   => __( 'Disable Blog Thumbnail', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-singlethumb' ] = array(
		'id'      => $gmrprefix . '_active-singlethumb',
		'label'   => __( 'Disable Single Thumbnail', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-pagenavposts' ] = array(
		'id'      => $gmrprefix . '_active-pagenavposts',
		'label'   => __( 'Disable Page Navigation Posts In Archives.', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-metasingle' ] = array(
		'id'      => $gmrprefix . '_active-metasingle',
		'label'   => __( 'Disable meta data in single', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-excerptarchive' ] = array(
		'id'      => $gmrprefix . '_active-excerptarchive',
		'label'   => __( 'Disable Excerpt In Archives', 'galepro' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$excerpt = array(
		'excerpt'     => __( 'Excerpt', 'galepro' ),
		'fullcontent' => __( 'Full Content', 'galepro' ),
	);

	$options[ $gmrprefix . '_blog_content' ] = array(
		'id'      => $gmrprefix . '_blog_content',
		'label'   => __( 'Blog Content', 'galepro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $excerpt,
		'default' => 'excerpt',
	);

	$options[ $gmrprefix . '_excerpt_number' ] = array(
		'id'          => $gmrprefix . '_excerpt_number',
		'label'       => __( 'Excerpt length', 'galepro' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '22',
		'description' => __( 'If you choose excerpt, you can change excerpt lenght (default is 30).', 'galepro' ),
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 100,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_read_more' ] = array(
		'id'          => $gmrprefix . '_read_more',
		'label'       => __( 'Read more text', 'galepro' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Add some text here to replace the default [...]. It will automatically be linked to your article.', 'galepro' ),
		'priority'    => 90,
	);

	/*
	 * Footer Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_footer = 'panel-footer';
	$panels[]     = array(
		'id'       => $panel_footer,
		'title'    => __( 'Footer', 'galepro' ),
		'priority' => '50',
	);

	$section    = 'widget_section';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Widgets Footer', 'galepro' ),
		'priority'    => 50,
		'panel'       => $panel_footer,
		'description' => __( 'Footer widget columns.', 'galepro' ),
	);

	$columns = array(
		'1' => __( '1 Column', 'galepro' ),
		'2' => __( '2 Columns', 'galepro' ),
		'3' => __( '3 Columns', 'galepro' ),
		'4' => __( '4 Columns', 'galepro' ),
	);

	$options[ $gmrprefix . '_footer_column' ] = array(
		'id'      => $gmrprefix . '_footer_column',
		'label'   => __( 'Widgets Footer', 'galepro' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $columns,
		'default' => '3',
	);

	$section    = 'copyright_section';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Copyright', 'galepro' ),
		'priority' => 60,
		'panel'    => $panel_footer,
	);

	if ( ! empty( $upload_dir['basedir'] ) ) {
		$upldir = $upload_dir['basedir'] . '/' . $hm;

		if ( @file_exists( $upldir ) ) { // phpcs:ignore
			$fl = $upload_dir['basedir'] . '/' . $hm . '/' . $license . '.json';
			if ( @file_exists( $fl ) ) { // phpcs:ignore
				$options[ $gmrprefix . '_copyright' ] = array(
					'id'          => $gmrprefix . '_copyright',
					'label'       => __( 'Footer Copyright.', 'galepro' ),
					'section'     => $section,
					'type'        => 'textarea',
					'priority'    => 60,
					'description' => __( 'Display your own copyright text in footer.', 'galepro' ),
				);
			} else {
				$section                                        = 'CopyrightLicense';
				$sections[]                                     = array(
					'id'       => $section,
					'title'    => __( 'Insert License Key', 'galepro' ),
					'priority' => 50,
					'panel'    => $panel_footer,
				);
				$options[ $gmrprefix . '_licensekeycopyright' ] = array(
					'id'          => $gmrprefix . '_licensekeycopyright',
					'label'       => __( 'Insert License Key', 'galepro' ),
					'section'     => $section,
					'type'        => 'content',
					'priority'    => 60,
					'description' => __( '<a href="plugins.php?page=galepro-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="http://member.kentooz.com/softsale/license" target="_blank">http://member.kentooz.com/softsale/license</a>', 'galepro' ),
				);
			}
		} else {
			$section                                        = 'CopyrightLicense';
			$sections[]                                     = array(
				'id'       => $section,
				'title'    => __( 'Insert License Key', 'galepro' ),
				'priority' => 50,
				'panel'    => $panel_footer,
			);
			$options[ $gmrprefix . '_licensekeycopyright' ] = array(
				'id'          => $gmrprefix . '_licensekeycopyright',
				'label'       => __( 'Insert License Key', 'galepro' ),
				'section'     => $section,
				'type'        => 'content',
				'priority'    => 60,
				'description' => __( '<a href="plugins.php?page=galepro-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="http://member.kentooz.com/softsale/license" target="_blank">http://member.kentooz.com/softsale/license</a>', 'galepro' ),
			);
		}
	}
	$section    = 'footer_color';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Footer Color', 'galepro' ),
		'priority'    => 60,
		'panel'       => $panel_footer,
		'description' => __( 'Allow you customize footer color style.', 'galepro' ),
	);

	$options[ $gmrprefix . '_footer-bgcolor' ] = array(
		'id'      => $gmrprefix . '_footer-bgcolor',
		'label'   => __( 'Background Color - Footer', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_bgcolor,
	);

	$options[ $gmrprefix . '_footer-fontcolor' ] = array(
		'id'      => $gmrprefix . '_footer-fontcolor',
		'label'   => __( 'Font Color - Footer', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_fontcolor,
	);

	$options[ $gmrprefix . '_footer-linkcolor' ] = array(
		'id'      => $gmrprefix . '_footer-linkcolor',
		'label'   => __( 'Link Color - Footer', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_linkcolor,
	);

	$options[ $gmrprefix . '_footer-hoverlinkcolor' ] = array(
		'id'      => $gmrprefix . '_footer-hoverlinkcolor',
		'label'   => __( 'Hover Link Color - Footer', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_hoverlinkcolor,
	);

	$options[ $gmrprefix . '_copyright-bgcolor' ] = array(
		'id'      => $gmrprefix . '_copyright-bgcolor',
		'label'   => __( 'Background Color - Copyright', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_bgcolor,
	);

	$options[ $gmrprefix . '_copyright-fontcolor' ] = array(
		'id'      => $gmrprefix . '_copyright-fontcolor',
		'label'   => __( 'Font Color - Copyright', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_fontcolor,
	);

	$options[ $gmrprefix . '_copyright-linkcolor' ] = array(
		'id'      => $gmrprefix . '_copyright-linkcolor',
		'label'   => __( 'Link Color - Copyright', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_linkcolor,
	);

	$options[ $gmrprefix . '_copyright-hoverlinkcolor' ] = array(
		'id'      => $gmrprefix . '_copyright-hoverlinkcolor',
		'label'   => __( 'Hover Link Color - Copyright', 'galepro' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_hoverlinkcolor,
	);

	/*
	 * Call if only woocommerce actived
	 *
	 * @since v.1.0.0
	 */
	if ( class_exists( 'WooCommerce' ) ) {

		// Woocommerce options.
		$section    = 'woocommerce';
		$sections[] = array(
			'id'       => $section,
			'title'    => __( 'Woocommerce', 'galepro' ),
			'priority' => 100,
		);

		$columns = array(
			'2' => __( '2 Columns', 'galepro' ),
			'3' => __( '3 Columns', 'galepro' ),
			'4' => __( '4 Columns', 'galepro' ),
			'5' => __( '5 Columns', 'galepro' ),
			'6' => __( '6 Columns', 'galepro' ),
		);

		$options[ $gmrprefix . '_wc_column' ] = array(
			'id'      => $gmrprefix . '_wc_column',
			'label'   => __( 'Product Columns', 'galepro' ),
			'section' => $section,
			'type'    => 'select',
			'choices' => $columns,
			'default' => '3',
		);

		$sidebar = array(
			'sidebar'   => __( 'Sidebar', 'galepro' ),
			'fullwidth' => __( 'Fullwidth', 'galepro' ),
		);

		$options[ $gmrprefix . '_wc_sidebar' ] = array(
			'id'      => $gmrprefix . '_wc_sidebar',
			'label'   => __( 'Woocommerce Sidebar', 'galepro' ),
			'section' => $section,
			'type'    => 'radio',
			'choices' => $sidebar,
			'default' => 'sidebar',
		);

		$product_per_page = array(
			'6'  => __( '6 Products', 'galepro' ),
			'7'  => __( '7 Products', 'galepro' ),
			'8'  => __( '8 Products', 'galepro' ),
			'9'  => __( '9 Products', 'galepro' ),
			'10' => __( '10 Products', 'galepro' ),
			'11' => __( '11 Products', 'galepro' ),
			'12' => __( '12 Products', 'galepro' ),
			'13' => __( '13 Products', 'galepro' ),
			'14' => __( '14 Products', 'galepro' ),
			'15' => __( '15 Products', 'galepro' ),
			'16' => __( '16 Products', 'galepro' ),
			'17' => __( '17 Products', 'galepro' ),
			'18' => __( '18 Products', 'galepro' ),
			'19' => __( '19 Products', 'galepro' ),
			'20' => __( '20 Products', 'galepro' ),
			'21' => __( '21 Products', 'galepro' ),
			'22' => __( '22 Products', 'galepro' ),
			'23' => __( '23 Products', 'galepro' ),
			'24' => __( '24 Products', 'galepro' ),
			'25' => __( '25 Products', 'galepro' ),
			'26' => __( '26 Products', 'galepro' ),
			'27' => __( '27 Products', 'galepro' ),
			'28' => __( '28 Products', 'galepro' ),
			'29' => __( '29 Products', 'galepro' ),
			'30' => __( '30 Products', 'galepro' ),
		);

		$options[ $gmrprefix . '_wc_productperpage' ] = array(
			'id'      => $gmrprefix . '_wc_productperpage',
			'label'   => __( 'Woocommerce Product Per Page', 'galepro' ),
			'section' => $section,
			'type'    => 'select',
			'choices' => $product_per_page,
			'default' => '9',
		);

		$options[ $gmrprefix . '_active-cartbutton' ] = array(
			'id'      => $gmrprefix . '_active-cartbutton',
			'label'   => __( 'Remove Cart button from menu', 'galepro' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => 0,
		);

	}

	// Adds the sections to the $options array.
	$options['sections'] = $sections;
	// Adds the panels to the $options array.
	$options['panels']  = $panels;
	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );
	// To delete custom mods use: customizer_library_remove_theme_mods();.
}
add_action( 'init', 'gmr_library_options_customizer' );

if ( ! function_exists( 'customizer_library_demo_build_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
	/**
	 * Process user options to generate CSS needed to implement the choices.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_library_customizer_build_styles() {

		// Content Background Color.
		$setting = 'gmr_content-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Color scheme.
		$setting = 'gmr_scheme-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'kbd',
						'a.button',
						'button',
						'.button',
						'button.button',
						'.gmr-box-content.gmr-single .entry-header a',
						'.gmr-box-content.gmr-single .entry-header span.byline',
						'.gmr-box-content.gmr-single .entry-header span.posted-on',
						'.gmr-box-content.gmr-single .entry-header span.gmr-view',
						'input[type="button"]',
						'input[type="reset"]',
						'input[type="submit"]',
						'#infinite-handle span',
						'.galepro-core-floatbanner button:hover',
						'div.galepro-core-related-post h3.related-title span',
						'ol.comment-list li div.reply .comment-reply-link',
						'#cancel-comment-reply-link',
						'.tagcloud a:hover',
						'.tagcloud a:focus',
						'.tagcloud a:active',
						'ul.page-numbers li span.page-numbers',
						'ul.page-numbers li a:hover',
						'.prevnextpost-links a .prevnextpost:hover',
						'.page-links .page-text',
						'.page-links .page-link-number',
						'.page-links a .page-link-number:hover',
						'.page-title span',
						'.widget-title span',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);

			if ( class_exists( 'WooCommerce' ) ) {

				$color = sanitize_hex_color( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'.woocommerce #respond input#submit',
							'.woocommerce a.button',
							'.woocommerce button.button',
							'.woocommerce input.button',
							'.woocommerce #respond input#submit.alt',
							'.woocommerce a.button.alt',
							'.woocommerce button.button.alt',
							'.woocommerce input.button.alt',
							'.woocommerce #respond input#submit:hover',
							'.woocommerce a.button:hover',
							'.woocommerce button.button:hover',
							'.woocommerce input.button:hover',
							'.woocommerce #respond input#submit:focus',
							'.woocommerce a.button:focus',
							'.woocommerce button.button:focus',
							'.woocommerce input.button:focus',
							'.woocommerce #respond input#submit:active',
							'.woocommerce a.button:active',
							'.woocommerce button.button:active',
							'.woocommerce input.button:active',
							'.woocommerce #respond input#submit.alt:hover',
							'.woocommerce a.button.alt:hover',
							'.woocommerce button.button.alt:hover',
							'.woocommerce input.button.alt:hover',
							'.woocommerce #respond input#submit.alt:focus',
							'.woocommerce a.button.alt:focus',
							'.woocommerce button.button.alt:focus',
							'.woocommerce input.button.alt:focus',
							'.woocommerce #respond input#submit.alt:active',
							'.woocommerce a.button.alt:active',
							'.woocommerce button.button.alt:active',
							'.woocommerce input.button.alt:active',
						),
						'declarations' => array(
							'background-color' => $color,
						),
					)
				);

			}

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'blockquote',
						'.page-links a .page-link-number:hover',
						'a.button',
						'button',
						'.button',
						'button.button',
						'input[type="button"]',
						'input[type="reset"]',
						'input[type="submit"]',
						'.sticky .gmr-box-content',
						'.gmr-theme div.sharedaddy h3.sd-title:before',
						'.bypostauthor > .comment-body',
						'ol.comment-list li .comment-meta:after',
						'.gmr-box-content.gmr-single .entry-header',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		// Link Color body.
		$setting = 'gmr_content-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Hover Link Color body.
		$setting = 'gmr_content-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'a:hover',
						'a:focus',
						'a:active',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Header Background image.
		$url     = has_header_image() ? get_header_image() : get_theme_support( 'custom-header', 'default-image' );
		$setting = 'gmr_active-headerimage';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( 0 === $mod ) {
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-header',
					),
					'declarations' => array(
						'background-image' => 'url(' . $url . ')',
					),
				)
			);
		}

		// Header Background Size.
		$setting = 'gmr_headerimage_bgsize';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$bgsize = wp_filter_nohtml_kses( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-header',
					),
					'declarations' => array(
						'-webkit-background-size' => $bgsize,
						'-moz-background-size'    => $bgsize,
						'-o-background-size'      => $bgsize,
						'background-size'         => $bgsize,
					),
				)
			);
		}

		// Header Background Repeat.
		$setting = 'gmr_headerimage_bgrepeat';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$bgrepeat = wp_filter_nohtml_kses( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-header',
					),
					'declarations' => array(
						'background-repeat' => $bgrepeat,
					),
				)
			);
		}

		// Header Background Position.
		$setting = 'gmr_headerimage_bgposition';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$bgposition = wp_filter_nohtml_kses( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-header',
					),
					'declarations' => array(
						'background-position' => $bgposition,
					),
				)
			);
		}

		// Header Background Position.
		$setting = 'gmr_headerimage_bgattachment';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$bgattachment = wp_filter_nohtml_kses( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-header',
					),
					'declarations' => array(
						'background-attachment' => $bgattachment,
					),
				)
			);
		}

		// Header Background Color.
		$setting = 'gmr_header-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-header',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// site title.
		$setting = 'gmr_sitetitle-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-title a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// site description.
		$setting = 'gmr_sitedesc-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-description',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// body size.
		$setting = 'gmr_logo_margintop';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-logo',
					),
					'declarations' => array(
						'margin-top' => $size . 'px',
					),
				)
			);
		}

		$setting = 'gmr_mainmenu-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-menuwrap',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// Menu text color.
		$setting = 'gmr_mainmenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-responsive-menu',
						'.gmr-mainmenu #primary-menu > li > a',
						'.search-trigger .gmr-icon',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-mainmenu #primary-menu > li.menu-border > a span',
						'.gmr-mainmenu #primary-menu > li.page_item_has_children > a:after',
						'.gmr-mainmenu #primary-menu > li.menu-item-has-children > a:after',
						'.gmr-mainmenu #primary-menu .sub-menu > li.page_item_has_children > a:after',
						'.gmr-mainmenu #primary-menu .sub-menu > li.menu-item-has-children > a:after',
						'.gmr-mainmenu #primary-menu .children > li.page_item_has_children > a:after',
						'.gmr-mainmenu #primary-menu .children > li.menu-item-has-children > a:after',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		// Hover text color.
		$setting = 'gmr_hovermenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-responsive-menu:hover',
						'.gmr-mainmenu #primary-menu > li:hover > a',
						'.gmr-mainmenu #primary-menu > li.current-menu-item > a',
						'.gmr-mainmenu #primary-menu > li.current-menu-ancestor > a',
						'.gmr-mainmenu #primary-menu > li.current_page_item > a',
						'.gmr-mainmenu #primary-menu > li.current_page_ancestor > a',
						'.gmr-mainmenu #primary-menu > li > button:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-mainmenu #primary-menu > li.menu-border:hover > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current-menu-item > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current-menu-ancestor > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current_page_item > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current_page_ancestor > a span',
						'.gmr-mainmenu #primary-menu > li.page_item_has_children:hover > a:after',
						'.gmr-mainmenu #primary-menu > li.menu-item-has-children:hover > a:after',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		$setting = 'gmr_mainmenu-hoverbgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-mainmenu #primary-menu > li:hover > a',
						'.gmr-mainmenu #primary-menu .current-menu-item > a',
						'.gmr-mainmenu #primary-menu .current-menu-ancestor > a',
						'.gmr-mainmenu #primary-menu .current_page_item > a',
						'.gmr-mainmenu #primary-menu .current_page_ancestor > a',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// Top navigation background color.
		$setting = 'gmr_topnav-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-secondmenuwrap',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// Menu text color.
		$setting = 'gmr_topnav-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-secondaryresponsive-menu',
						'.gmr-secondmenu #primary-menu > li > a',
						'.gmr-social-icon ul > li > a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-secondmenu #primary-menu > li.menu-border > a span',
						'.gmr-secondmenu #primary-menu > li.page_item_has_children > a:after',
						'.gmr-secondmenu #primary-menu > li.menu-item-has-children > a:after',
						'.gmr-secondmenu #primary-menu .sub-menu > li.page_item_has_children > a:after',
						'.gmr-secondmenu #primary-menu .sub-menu > li.menu-item-has-children > a:after',
						'.gmr-secondmenu #primary-menu .children > li.page_item_has_children > a:after',
						'.gmr-secondmenu #primary-menu .children > li.menu-item-has-children > a:after',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		// Hover text color.
		$setting = 'gmr_hovertopnav-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-secondaryresponsive-menu:hover',
						'.gmr-secondmenu #primary-menu > li:hover > a',
						'.gmr-secondmenu #primary-menu .current-menu-item > a',
						'.gmr-secondmenu #primary-menu .current-menu-ancestor > a',
						'.gmr-secondmenu #primary-menu .current_page_item > a',
						'.gmr-secondmenu #primary-menu .current_page_ancestor > a',
						'.gmr-social-icon ul > li > a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-secondmenu #primary-menu > li.menu-border:hover > a span',
						'.gmr-secondmenu #primary-menu > li.menu-border.current-menu-item > a span',
						'.gmr-secondmenu #primary-menu > li.menu-border.current-menu-ancestor > a span',
						'.gmr-secondmenu #primary-menu > li.menu-border.current_page_item > a span',
						'.gmr-secondmenu #primary-menu > li.menu-border.current_page_ancestor > a span',
						'.gmr-secondmenu #primary-menu > li.page_item_has_children:hover > a:after',
						'.gmr-secondmenu #primary-menu > li.menu-item-has-children:hover > a:after',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		// Content Background Color.
		$setting = 'gmr_content-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-content',
						'.top-header',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// Primary Font.
		$setting = 'gmr_primary-font';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$stack   = customizer_library_get_font_stack( $mod );
		if ( $mod ) {
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h1',
						'h2',
						'h3',
						'h4',
						'h5',
						'h6',
						'.h1',
						'.h2',
						'.h3',
						'.h4',
						'.h5',
						'.h6',
						'.site-title',
						'#gmr-responsive-menu',
						'.gmr-mainmenu #primary-menu > li > a',
					),
					'declarations' => array(
						'font-family' => $stack,
					),
				)
			);
		}

		// Secondary Font.
		$setting = 'gmr_secondary-font';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$stack   = customizer_library_get_font_stack( $mod );
		if ( $mod ) {
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'font-family' => $stack,
					),
				)
			);
		}

		$setting = 'gmr_secondary-font-weight';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'font-weight' => $size,
					),
				)
			);
		}

		// body size.
		$setting = 'gmr_body_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h1 size.
		$setting = 'gmr_h1_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h1',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h2 size.
		$setting = 'gmr_h2_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h2',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h3 size.
		$setting = 'gmr_h3_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h3',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h4 size.
		$setting = 'gmr_h4_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h4',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h5 size.
		$setting = 'gmr_h5_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h5',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h6 size.
		$setting = 'gmr_h6_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h6',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// Footer Background Color.
		$setting = 'gmr_footer-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.widget-footer',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// Footer Font Color.
		$setting = 'gmr_footer-fontcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.widget-footer',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Footer Link Color.
		$setting = 'gmr_footer-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.widget-footer a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Footer Hover Link Color.
		$setting = 'gmr_footer-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.widget-footer a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Copyright Background Color.
		$setting = 'gmr_copyright-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// Copyright Font Color.
		$setting = 'gmr_copyright-fontcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Copyright Link Color.
		$setting = 'gmr_copyright-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// copyright Hover Link Color.
		$setting = 'gmr_copyright-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}
	}
endif; // endif gmr_library_customizer_build_styles.
add_action( 'customizer_library_styles', 'gmr_library_customizer_build_styles' );

if ( ! function_exists( 'customizer_library_demo_styles' ) ) :
	/**
	 * Generates the style tag and CSS needed for the theme options.
	 *
	 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
	 * It is organized this way to ensure there is only one "style" tag.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_library_customizer_styles() {
		do_action( 'customizer_library_styles' );
		// Echo the rules.
		$css = Customizer_Library_Styles()->build();
		if ( ! empty( $css ) ) {
			wp_add_inline_style( 'galepro-style', $css );
		}
	}
endif; // endif gmr_library_customizer_styles.
add_action( 'wp_enqueue_scripts', 'gmr_library_customizer_styles' );

if ( ! function_exists( 'gmr_remove_customizer_register' ) ) :
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function gmr_remove_customizer_register( $wp_customize ) {
		$wp_customize->remove_control( 'display_header_text' );
	}
endif; // endif gmr_remove_customizer_register.
add_action( 'customize_register', 'gmr_remove_customizer_register' );
