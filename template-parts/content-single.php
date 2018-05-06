<?php
/**
 * Template part for displaying single posts.
 *
 * @package ZH-SEO
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'zh-post-thumbnail' ); ?>
			</div>
		<?php } ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zh-seo' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<footer class="entry-footer">
		<?php zh_content_footer(); ?>
	</footer>
</article>
