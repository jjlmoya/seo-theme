<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ZH-SEO
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) ) : ?>

			<div class="footer-widgets clear">

				<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'sidebar-2' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

				<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'sidebar-3' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

				<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>

					<div class="widget-area">

						<?php dynamic_sidebar( 'sidebar-4' ); ?>

					</div><!-- .widget-area -->

				<?php endif; ?>

			</div><!-- .footer-widgets -->

		<?php endif; ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
