<?php
/**
 * Template Name: Página em branco
 *
 * @package Agatha
 */
?>
<section id="main" class="clearfix">
    <div class="container">
        <div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->
        </div>
    </div>
</section><!-- /#main -->
?>
