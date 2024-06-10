<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Galepro
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gmr_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_posted_on() {
		global $post;
		$time_string = '<time class="entry-date published updated" ' . galepro_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" ' . galepro_itemprop_schema( 'datePublished' ) . ' datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf( '%s', $time_string );

		$posted_by = sprintf(
			/* translators: %s: get_the_author() */
			esc_html__( 'by %s', 'galepro' ),
			'<span class="entry-author vcard" ' . galepro_itemprop_schema( 'author' ) . ' ' . galepro_itemtype_schema( 'person' ) . '><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . __( 'Permalink to: ', 'galepro' ) . esc_html( get_the_author() ) . '" ' . galepro_itemprop_schema( 'url' ) . '><span ' . galepro_itemprop_schema( 'name' ) . '>' . esc_html( get_the_author() ) . '</span></a></span>'
		);
		if ( is_single() ) {
			echo '<span class="posted-on">' . $posted_on . '</span><span class="byline">' . $posted_by . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( class_exists( 'WP_Widget_PostViews' ) || class_exists( 'Post_Views_Counter' ) ) {
				echo '<span class="gmr-view">';
				$number = '0';
				if ( class_exists( 'WP_Widget_PostViews' ) ) {
					if ( function_exists( 'the_views' ) ) {
						$post_views = (int) get_post_meta( $post->ID, 'views', true );
						if ( ! empty( $post_views ) ) {
							$number = number_format_i18n( $post_views );
						} else {
							$number = '0';
						}
					}
				} else {
					$number = pvc_get_post_views( $post->ID );
				}
				echo absint( $number ) . ' ' . esc_html__( 'View', 'galepro' );
				echo '</span>';
			}
		} else {
			echo '<div class="gmr-metacontent"><span class="posted-on">' . $posted_on . '</span><span class="byline">' . $posted_by . '</span></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif; // endif gmr_posted_on.

if ( ! function_exists( 'gmr_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'galepro' ) );
			if ( $categories_list ) {
				/* translators: %1$s: categories_list */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'galepro' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'galepro' ) );
			if ( $tags_list ) {
				/* translators: %1$s: tags_list */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'galepro' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'galepro' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'galepro' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif; // endif gmr_entry_footer.

if ( ! function_exists( 'gmr_custom_excerpt_length' ) ) :
	/**
	 * Filter the except length to 22 characters.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function gmr_custom_excerpt_length( $length ) {
		$length = get_theme_mod( 'gmr_excerpt_number', '22' );
		// absint sanitize int non minus.
		return absint( $length );
	}
endif; // endif gmr_custom_excerpt_length.
add_filter( 'excerpt_length', 'gmr_custom_excerpt_length', 999 );

if ( ! function_exists( 'gmr_custom_readmore' ) ) :
	/**
	 * Filter the except length to 20 characters.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more More button.
	 * @return string read more.
	 */
	function gmr_custom_readmore( $more ) {
		$more = get_theme_mod( 'gmr_read_more' );
		if ( empty( $more ) ) {
			return '&nbsp;...';
		} else {
			return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '" title="' . get_the_title( get_the_ID() ) . '" ' . galepro_itemprop_schema( 'url' ) . '>' . esc_html( $more ) . '</a>';
		}
	}
endif; // endif gmr_custom_readmore.
add_filter( 'excerpt_more', 'gmr_custom_readmore' );

if ( ! function_exists( 'gmr_get_pagination' ) ) :
	/**
	 * Retrieve paginated link for archive post pages.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function gmr_get_pagination() {
		global $wp_rewrite;
		global $wp_query;
		return paginate_links(
			apply_filters(
				'gmr_get_pagination_args',
				array(
					'base'      => str_replace( '99999', '%#%', esc_url( get_pagenum_link( 99999 ) ) ),
					'format'    => $wp_rewrite->using_permalinks() ? 'page/%#%' : '?paged=%#%',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $wp_query->max_num_pages,
					'prev_text' => __( 'Prev', 'galepro' ),
					'next_text' => __( 'Next', 'galepro' ),
					'type'      => 'list',
				)
			)
		);
	}
endif; // endif gmr_get_pagination.

if ( ! function_exists( 'gmr_nav_wrap' ) ) :
	/**
	 * This function add search button in menu.
	 *
	 * @since 1.0.0
	 *
	 * @param string $items Items.
	 * @param array  $args Args.
	 * @param bool   $ajax default false.
	 * @return string
	 */
	function gmr_nav_wrap( $items, $args, $ajax = false ) {

		// Option remove search button.
		$setting = 'gmr_active-searchbutton';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		// Primary Navigation Area Only.
		if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && 'primary' === $args->theme_location && 0 === $mod ) ) {

			$css_class = 'menu-item menu-item-type-search-btn gmr-search pull-right';

			$items .= '<li class="' . esc_attr( $css_class ) . '">';
			$items .= '<button class="search-button topnav-button" id="search-menu-button" title="' . __( 'Search', 'galepro' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></g></svg></button>';
			$items .= '<div class="search-dropdown search" id="search-dropdown-container">';
			$items .= '<form method="get" class="gmr-searchform searchform" action="' . esc_url( home_url( '/' ) ) . '">';
			$items .= '<input type="text" name="s" id="s" placeholder="' . __( 'Search', 'galepro' ) . '" />';
			$items .= '</form>';
			$items .= '</div>';
			$items .= '</li>';

		}
		return apply_filters( 'gmr_nav_wrap_filter', $items );
	}
endif; // endif gmr_nav_wrap.
add_filter( 'wp_nav_menu_items', 'gmr_nav_wrap', 15, 2 );

if ( ! function_exists( 'galepro_add_menu_attribute' ) ) :
	/**
	 * Add attribute itemprop="url" to menu link
	 *
	 * @since 1.0.0
	 *
	 * @param string $atts Atts.
	 * @param string $item Item.
	 * @param array  $args Args.
	 * @return string
	 */
	function galepro_add_menu_attribute( $atts, $item, $args ) {
		$atts['itemprop'] = 'url';
		return $atts;
	}
endif; // endif galepro_add_menu_attribute.
add_filter( 'nav_menu_link_attributes', 'galepro_add_menu_attribute', 10, 3 );

if ( ! function_exists( 'gmr_the_custom_logo' ) ) :
	/**
	 * Print custom logo.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_the_custom_logo() {
		echo '<div class="gmr-logomobile">';
		echo '<div class="gmr-logo">';
		// if get value from customizer gmr_logoimage.
		$setting = 'gmr_logoimage';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			// get url image from value gmr_logoimage.
			$image = esc_url_raw( $mod );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" ' . galepro_itemprop_schema( 'url' ) . ' title="' . esc_html( get_bloginfo( 'name' ) ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_html( get_bloginfo( 'name' ) ) . '" title="' . esc_html( get_bloginfo( 'name' ) ) . '" ' . galepro_itemprop_schema( 'image' ) . ' />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</a>';

		} else {
			// if get value from customizer blogname.
			if ( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) ) {
				echo '<div class="site-title" ' . galepro_itemprop_schema( 'headline' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<a href="' . esc_url( home_url( '/' ) ) . '" ' . galepro_itemprop_schema( 'url' ) . ' title="' . esc_html( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo esc_html( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) );
					echo '</a>';
				echo '</div>';

			}
			// if get value from customizer blogdescription.
			if ( get_theme_mod( 'blogdescription', get_bloginfo( 'description' ) ) ) {
				echo '<span class="site-description" ' . galepro_itemprop_schema( 'description' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo esc_html( get_theme_mod( 'blogdescription', get_bloginfo( 'description' ) ) );
				echo '</span>';

			}
		}
		echo '</div>';
		echo '</div>';
	}
endif; // endif gmr_the_custom_logo.
add_action( 'gmr_the_custom_logo', 'gmr_the_custom_logo', 5 );

if ( ! function_exists( 'gmr_move_post_navigation' ) ) :
	/**
	 * Move post navigation in top after content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Content.
	 * @return string $content
	 */
	function gmr_move_post_navigation( $content ) {
		if ( is_singular() && in_the_loop() ) {
			$pagination = wp_link_pages(
				array(
					'before'      => '<div class="page-links clearfix"><span class="page-text">' . esc_html__( 'Pages:', 'galepro' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span class="page-link-number">',
					'link_after'  => '</span>',
					'echo'        => 0,
				)
			);

			$content .= $pagination;
			return $content;
		}
		return $content;
	}
endif; // endif gmr_move_post_navigation.
add_filter( 'the_content', 'gmr_move_post_navigation', 35 );

if ( ! function_exists( 'gmr_move_post_navigation_second' ) ) :
	/**
	 * Move post navigation in top after content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Content.
	 * @return string $content
	 */
	function gmr_move_post_navigation_second( $content ) {
		if ( is_singular() && in_the_loop() ) {
			$pagination_nextprev = wp_link_pages(
				array(
					'before'         => '<div class="prevnextpost-links clearfix">',
					'after'          => '</div>',
					'next_or_number' => 'next',
					'link_before'    => '<span class="prevnextpost">',
					'link_after'     => '</span>',
					'echo'           => 0,
				)
			);

			$content .= $pagination_nextprev;
			return $content;
		}
		return $content;
	}
endif; // endif gmr_move_post_navigation_second.
add_filter( 'the_content', 'gmr_move_post_navigation_second', 2 );

if ( ! function_exists( 'gmr_embed_oembed_html' ) ) :
	/**
	 * Add responsive oembed class only for youtube and vimeo.
	 *
	 * @add_filter embed_oembed_html
	 * @class gmr_embed_oembed_html
	 * @param string $html HTML.
	 * @param string $url url.
	 * @param string $attr Attribute.
	 * @param int    $post_id Post ID.
	 * @link https://developer.wordpress.org/reference/hooks/embed_oembed_html/
	 */
	function gmr_embed_oembed_html( $html, $url, $attr, $post_id ) {
		$classes = array();

		// Add these classes to all embeds.
		$classes_all = array(
			'gmr-video-responsive',
		);

		// Check for different providers and add appropriate classes.

		if ( false !== strpos( $url, 'vimeo.com' ) ) {
			$classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
		}

		if ( false !== strpos( $url, 'youtube.com' ) ) {
			$classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
		}

		if ( false !== strpos( $url, 'youtu.be' ) ) {
			$classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
		}

		$classes = array_merge( $classes, $classes_all );

		if ( has_block( 'core/embed' ) ) {
			return $html;
		} else {
			return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $html . '</div>';
		}
	}
endif; // endif gmr_embed_oembed_html.
add_filter( 'embed_oembed_html', 'gmr_embed_oembed_html', 99, 4 );

if ( ! function_exists( 'galepro_prepend_attachment' ) ) :
	/**
	 * Callback for WordPress 'prepend_attachment' filter.
	 *
	 * Change the attachment page image size to 'large'
	 *
	 * @package WordPress
	 * @category Attachment
	 * @see wp-includes/post-template.php
	 *
	 * @param string $attachment_content the attachment html.
	 * @return string $attachment_content the attachment html
	 */
	function galepro_prepend_attachment( $attachment_content ) {
		$post = get_post();
		if ( wp_attachment_is( 'image', $post ) ) {
			// set the attachment image size to 'large'.
			$attachment_content = sprintf( '<p class="img-center">%s</p>', wp_get_attachment_link( 0, 'full', false ) );

			// return the attachment content.
			return $attachment_content;
		} else {
			// return the attachment content.
			return $attachment_content;
		}
	}
endif; // endif galepro_prepend_attachment.
add_filter( 'prepend_attachment', 'galepro_prepend_attachment' );

if ( ! function_exists( 'gmr_top_search' ) ) :
	/**
	 * This function add search button in menu.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_top_search() {
		echo '<div class="gmr-top-search widget_search">';
			echo '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">';
				echo '<label>';
				echo '<span class="screen-reader-text">Search for:</span>';
				echo '<input type="search" class="search-field" placeholder="' . esc_html__( 'Search', 'galepro' ) . '" value="" name="s" />';
				echo '</label>';
				echo '<input type="submit" class="search-submit" value="Search" />';
			echo '</form>';
		echo '</div>';
	}
endif; // endif gmr_top_search.
add_action( 'gmr_top_search', 'gmr_top_search', 5 );
