<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'zh-post-thumbnail' ); ?>
		</div>
	<?php } ?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zh-seo' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<footer class="entry-footer">
		<?php get_template_part( 'template-parts/content', 'author' ); ?>
	</footer>
</article>
