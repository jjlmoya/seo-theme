<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package ZH-SEO
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'No se ha encontrado la página', 'zh-seo' ); ?></h1>
				</header>
				<div class="page-content">
				</div>
			</section>
		</main>
	</div>
<?php get_footer(); ?>
