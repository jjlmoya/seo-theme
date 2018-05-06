<?php
if ( ! function_exists( 'zh_seo_setup' ) ) :
function zh_seo_setup() {
	load_theme_textdomain( 'zh-seo', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_editor_style( array( 'editor-style.css', zh_seo_fonts_url() ) );
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Header', 'zh-seo' ),
	) );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'zh-post-thumbnail', '1088', '9999' );
	add_theme_support( 'custom-logo', array(
		'height'      => 300,
		'width'       => 300,
		'flex-width' => true,
	) );
add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'zh_seo_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );
}
endif; // zh_seo_setup
add_action( 'after_setup_theme', 'zh_seo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function zh_seo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'zh_seo_content_width', 739 );
}
add_action( 'after_setup_theme', 'zh_seo_content_width', 0 );

/*
 * Adjust $content_width for full-width page template
 */

if ( ! function_exists( 'zh_seo_content_width' ) ) :

function zh_seo_content_width() {
     global $content_width;

     if ( is_page_template( 'templates/full-width-page.php' ) ) {
          $content_width = 1088; //pixels
     }
}
add_action( 'template_redirect', 'zh_seo_content_width' );

endif; // if ! function_exists( 'zh_seo_content_width' )

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function zh_seo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'zh-seo' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'zh-seo' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'zh-seo' ),
		'id'            => 'sidebar-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'zh-seo' ),
		'id'            => 'sidebar-4',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'zh_seo_widgets_init' );

/**
 * Register Google Fonts
 */
function zh_seo_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
	 * supported by Libre Baskerville, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre = esc_html_x( 'on', 'Libre Baskerville font: on or off', 'zh-seo' );

	if ( 'off' !== $libre ) {
		$font_families = array();
		$font_families[] = 'Libre Baskerville:400,400italic,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );

}

/**
 * Enqueue scripts and styles.
 */
function zh_seo_scripts() {
	wp_enqueue_style( 'bootstrap_css', get_template_directory_uri() . '/bootstrap.min.css');
	wp_enqueue_style( 'zh-seo-style', get_stylesheet_uri() );
	wp_enqueue_style( 'zh-seo-fonts', zh_seo_fonts_url(), array(), null );

	wp_enqueue_script( 'zh-seo-script', get_template_directory_uri() . '/js/zhseo.js', array( 'jquery' ), '20150623', true );

	$adminbar = is_admin_bar_showing();
	wp_localize_script( 'zh-seo-script', 'libreadminbar', array( $adminbar ) );

	wp_enqueue_script( 'zh-seo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'zh-seo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'zh_seo_scripts' );

/*
 * Filters the Categories archive widget to add a span around the post count
 */

function zh_seo_cat_count_span( $links ) {
	$links = str_replace( '</a> (', '</a><span class="post-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );
	return $links;
}
add_filter( 'wp_list_categories', 'zh_seo_cat_count_span' );

/*
 * Add a span around the post count in the Archives widget
 */

function zh_seo_archive_count_span( $links ) {
  $links = str_replace( '</a>&nbsp;(', '</a><span class="post-count">(', $links );
  $links = str_replace( ')', ')</span>', $links );
  return $links;
}
add_filter( 'get_archives_link', 'zh_seo_archive_count_span' );

if ( ! function_exists( 'zh_seo_continue_reading_link' ) ) :
/**
 * Returns an ellipsis and "Continue reading" plus off-screen title link for excerpts
 */
function zh_seo_continue_reading_link() {
	return '&hellip; <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . sprintf( wp_kses_post( __( 'Continue reading <span class="screen-reader-text">%1$s</span> <span class="meta-nav" aria-hidden="true">&rarr;</span>', 'zh-seo' ) ), esc_attr( strip_tags( get_the_title() ) ) ) . '</a>';
}
endif; // zh_seo_continue_reading_link


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with zh_seo_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function zh_seo_auto_excerpt_more( $more ) {
	return zh_seo_continue_reading_link();
}
add_filter( 'excerpt_more', 'zh_seo_auto_excerpt_more' );


/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function zh_seo_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= zh_seo_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'zh_seo_custom_excerpt_more' );

/*
 * Custom comments display to move Reply link,
 * used in comments.php
 */
function zh_seo_comments( $comment, $args, $depth ) {
?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-metadata">
						<span class="comment-author vcard">
							<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

							<?php printf( '<b class="fn">%s</b>', get_comment_author_link() ); ?>
						</span>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( '<span class="comment-date">%1$s</span><span class="comment-time screen-reader-text">%2$s</span>', get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply">',
							'after'     => '</span>'
						) ) );
						?>
						<?php edit_comment_link( esc_html__( 'Edit', 'zh-seo' ), '<span class="edit-link">', '</span>' ); ?>

					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'zh-seo' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
<?php
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


// updater for WordPress.com themes
if ( is_admin() )
	include dirname( __FILE__ ) . '/inc/updater.php';
