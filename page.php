<?php
/**
 * Template padrão para todas as páginas
 *
 * @package Agatha
 */

get_header(); ?>
<section id="main" class="clearfix">
    <div class="container">
        <div class="row">
			<section class="breadcrump">
				<h1><?php the_title(); ?></h1>
				<p><?php agatha_breadcrumb(); ?></p>
			</section>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->
        </div>
    </div>
</section><!-- /#main -->
<?php get_footer(); ?>
