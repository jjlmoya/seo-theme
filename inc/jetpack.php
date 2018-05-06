<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package ZH-SEO
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function zh_seo_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'render'         => 'zh_seo_infinite_scroll_render',
		'footer'         => 'masthead',
		'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4' ),
	) );

	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'jetpack-social-menu', 'svg' );

	add_theme_support( 'jetpack-content-options', array(
		'blog-display' => 'content',
		'author-bio'   => true,
		'post-details' => array(
			'stylesheet' => 'libre-style',
			'date'       => '.posted-on',
			'categories' => '.cat-links',
			'tags'       => '.tags-links',
			'author'     => '.byline',
		),
		'featured-images' => array(
			'archive'         => true, // enable or not the featured image check for archive pages: true or false
        	'archive-default' => false, // the default setting of the featured image on archive pages, if it's enabled or not: true or false
			'post'            => true, // enable or not the featured image check for single posts: true or false
        	'page'            => true, // enable or not the featured image check for single pages: true or false
		),
	) );
} // end function zh_seo_jetpack_setup
add_action( 'after_setup_theme', 'zh_seo_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function zh_seo_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function zh_seo_infinite_scroll_render

/**
 * Return early if Social Menu is not available.
 */
function zh_seo_social_menu() {
	if ( ! function_exists( 'jetpack_social_menu' ) ) {
		return;
	} else {
		jetpack_social_menu();
	}
}
