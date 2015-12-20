<?php get_header(); ?>

<section id="main" class="clearfix">
    <div class="container">
        <div class="row">
            <section class="col-md-9 col-sm-8 col-xs-12">

            <h1 class="page-title">
                    <?php
                        if ( is_category() ) :
                            printf( __( 'Arquivos da categoria: %s', 'agatha' ), '<span>' . single_cat_title( '', false ) . '</span>' );

                        elseif ( is_tag() ) :
                            printf( __( 'Arquivos da palavra: %s', 'agatha' ), '<span>' . single_tag_title( '', false ) . '</span>' );

                        elseif ( is_author() ) :

                            the_post();
                            printf( __( 'Arquivos do autor: %s', 'agatha' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );

                            rewind_posts();

                        elseif ( is_day() ) :
                            printf( __( 'Arquivos diários: %s', 'agatha' ), '<span>' . get_the_date() . '</span>' );

                        elseif ( is_month() ) :
                            printf( __( 'Arquivos mensais: %s', 'agatha' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

                        elseif ( is_year() ) :
                            printf( __( 'Arquivos anuais: %s', 'agatha' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

                        elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
                            _e( 'Trechos', 'agatha' );

                        elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
                            _e( 'Imagens', 'agatha');

                        elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
                            _e( 'Vídeos', 'agatha' );

                        elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
                            _e( 'Citações', 'agatha' );

                        elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
                            _e( 'Links', 'agatha' );

                        else :
                            _e( '', 'agatha' );

                        endif;
                    ?>
                </h1>
                <?php
                    if ( is_category() ) :

                        $category_description = category_description();
                        if ( ! empty( $category_description ) ) :
                            echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );
                        endif;

                    elseif ( is_tag() ) :
                        $tag_description = tag_description();
                        if ( ! empty( $tag_description ) ) :
                            echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
                        endif;

                    endif;
                ?>
            </header><!-- .page-header -->

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
    </div>
</section><!-- /#main -->

<?php get_footer(); ?>
