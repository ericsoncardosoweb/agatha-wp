<?php
/**
 * Template Name: Sidebar Right
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
			<section class="col-md-9 col-xs-12 col-sm-8">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->
			</section>
			<sidebar class="col-md-3 col-xs-12 col-sm-4">
				<?php get_sidebar(); ?>
			</sidebar>
        </div>
    </div>
</section><!-- /#main -->
<?php get_footer(); ?>
