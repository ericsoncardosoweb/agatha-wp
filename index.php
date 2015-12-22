<?php get_header(); ?>

<!-- <?php echo ot_get_option( 'logotipo' ); ?> -->

<section id="main" class="clearfix">
    <div class="container">
        <div class="row">
            <section class="col-md-9 col-sm-8 col-xs-12">

            <h1><?php the_title(); ?></h1>

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <!-- post -->
                <?php
                    /* Esta função carrega o conteúdo conforme o formato de publicação */
                    get_template_part('content', get_post_format());
                ?>
            <?php endwhile; ?>
            <!-- post navigation -->
            <section class="pagination">
                <?php pagination(); ?>
            </section>
            <?php else: ?>
            <!-- no posts found -->
                <?php get_template_part('content', 'none'); ?>
            <?php endif; ?>
            </section>
            <sidebar class="col-md-3 col-sm-4 col-xs-12">
                <?php echo get_sidebar(); ?>
            </sidebar>
        </div>
        <?php var_dump(get_template_directory()) ?>
    </div>
</section><!-- /#main -->

<?php get_footer(); ?>
