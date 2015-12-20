<?php
/**
 * Template para as páginas de Silgle Post
 *
 * @package Agatha
 */

get_header();
?>
<section id="main" class="clearfix">
    <div class="container">
        <div class="row">
          <section class="breadcrump">
            <h1><?php the_title(); ?></h1>
            <p><?php agatha_breadcrumb(); ?></p>
          </section>
            <section class="col-md-9 col-sm-8 col-xs-12">
            <?php while ( have_posts() ) : the_post(); ?>

              <?php get_template_part( 'content', 'single' ); ?>

            <?php
              // Se estiver habilitádo o sistema de comentários no template aparecerá o respectivos campos
              if ( comments_open() || get_comments_number() ) :
                comments_template();
              endif;
            ?>
          <?php endwhile; // end of the loop. ?>
          <!-- Breadcrumbs -->
          <?php echo PostsRelacionados(); ?>
            </section>
            <sidebar class="col-md-3 col-sm-4 col-xs-12">
                <?php echo get_sidebar(); ?>
            </sidebar>
        </div>
    </div>
</section><!-- /#main -->

<?php get_footer(); ?>
