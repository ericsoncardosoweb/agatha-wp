<?php
/**
 * @package Ágatha
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
    if ( has_post_format( 'gallery' )) { ?>
    <!-- Formato Galeria -->
    <h2><?php the_title(); ?></h2>
    <section>
        <?php the_content(); ?>
    </section>
    <?php }
    elseif ( has_post_format( 'image' ))  { ?>
    <!-- Formato Imagem -->
    <h2><?php the_title(); ?></h2>
    <section>
        <?php the_content(); ?>
    </section>
    <?php }
    elseif ( has_post_format( 'quote' ))  { ?>
    <!-- Formato Citação -->
    <h2><?php the_title(); ?></h2>
    <section>
        <?php the_content(); ?>
    </section>
    <?php }
    elseif ( has_post_format( 'video' ))  { ?>
    <!-- Formato Vídeo -->
    <h2><?php the_title(); ?></h2>
    <section>
        <?php the_content(); ?>
    </section>

    <?php }
    elseif ( has_post_format( 'audio' ))  { ?>
    <!-- Formato Áudio -->

    <?php }
    else  { ?>
    <!-- Formato Padrão -->
    <?php if(has_post_thumbnail()) { ?>
    <div class="post-thumb">
      <?php the_post_thumbnail('post-thumb'); ?>
    </div>
  <?php } ?>
  <header class="entry-header">
    <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
  </header><!-- .entry-header -->

    <div class="entry-meta">
      <p><span class="author vcard"><i class="fa fa-user"></i> <?php echo __('Publicado por ','agatha') . get_the_author(); ?></span>
      <span class="categories-links"><i class="fa fa-folder"></i> <?php echo __('Em ','agatha'). get_the_category_list( __( ', ', 'agatha' ) ) ?> </span>
      </p>
      <p><div class="dates">
        <span class="date"><?php the_time('d'); ?> de </span><span class="month"><?php the_time('F'); ?> de</span>
        <span class="year"><?php the_time('Y'); ?> / </span>
        <span class="comments-counts"><span><?php comments_number( '0 ', '1 ', '% ' ); ?></span><?php comments_number( 'Comentário', 'Comentário', 'Comentários' ); ?></span>
      </div></p>
    </div><!-- .entry-meta -->


  <div class="entry-content">
    <?php the_excerpt(); ?>
  </div><!-- .entry-content -->
  <div class="row">
    <div class="col-sm-6">
      <a class="btn read-more" href="<?php echo get_permalink() ?>"><?php echo __( 'Continue Lendo', 'agatha' ) ?></a>
    </div>
    <div class="col-sm-6">
      <div class="share">
        <span><i class="fa fa-share-alt"></i> <?php echo __('Compartilhar: ','Ágatha'); ?></span>
        <span><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>"><i class="fa fa-facebook"></i></a></span>
        <span><a target="_blank" href="http://twitter.com/share?text=<?php echo urlencode(the_title()); ?>&url=<?php echo urlencode(the_permalink()); ?>&via=twitter&related=<?php echo urlencode("coderplus:Wordpress Tips, jQuery and more"); ?>"><i class="fa fa-twitter"></i></a></span>
        <span><a target="_blank" href="https://plus.google.com/share?url=<?php the_permalink() ?>"><i class="fa fa-google-plus"></i></a></span>
      </div>
    </div>
  </div>

    <?php } ?>

</article><!-- #post-## -->