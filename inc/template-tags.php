<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ZH-SEO
 */

if ( ! function_exists( 'zh_seo_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function zh_seo_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	if ( is_single() ) {
		$posted_on = sprintf( esc_attr__( 'Posted on %1$s', 'zh-seo' ),
						'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
					);
	}
	elseif ( is_sticky() ) {
		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html__( 'Featured', 'zh-seo' ) . '</a>';
	}
	else {
		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	}

	if ( is_single() ) {
		$byline = sprintf( esc_html__( 'by %1$s', 'zh-seo' ),
					'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
				);
	}
	else {
		$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';
	}

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'zh-seo' ), esc_html__( '1 Comment', 'zh-seo' ), esc_html__( '% Comments', 'zh-seo' ) );
		echo '</span>';
	}

	if ( ! is_single() ) {
		edit_post_link( sprintf( esc_html__( 'Edit %1$s', 'zh-seo' ), '<span class="screen-reader-text">' . the_title_attribute( 'echo=0' ) . '</span>' ), '<span class="edit-link">', '</span>' );
	}
}
endif;

if ( ! function_exists( 'zh_content_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function zh_content_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category();
		if ($categories_list) {
			foreach ($categories_list as $category) {
				$name = $category->cat_name;
				print_r('<span class="cat-link"><a href="'.get_site_url().'/'.
					str_replace(
					array(" ", "á", "é", "í", "ó", "ú", "ñ"),
					array("-", "a", "e", "i", "o", "u", "n"),
					 strtolower($name)
					).'/">'.$name.'</a></span>');
			}
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'zh-seo' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'zh-seo' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link( sprintf( esc_html__( 'Edit %1$s', 'zh-seo' ), '<span class="screen-reader-text">' . the_title_attribute( 'echo=0' ) . '</span>' ), '<span class="edit-link">', '</span>' );
}
endif;


/**
 * Flush out the transients used in .
 */
function zh_seo_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'zh_seo_categories' );
}
add_action( 'edit_category', 'zh_seo_category_transient_flusher' );
add_action( 'save_post',     'zh_seo_category_transient_flusher' );
