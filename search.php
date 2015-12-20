<?php get_header(); ?>

<!-- <?php echo ot_get_option( 'logotipo' ); ?> -->

<section id="main" class="clearfix">
    <div class="container">
        <div class="row">
            <section class="col-md-9 col-sm-8 col-xs-12">
            <?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Resultados dae pesquisa para: %s', 'agatha' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<h4><?php
global $wp_query;
echo '<p>Foram encontrados <strong>' . $wp_query->found_posts . '</strong> resultados para sua busca.</p>';
?></h4>
			</header><!-- .page-header -->
			<?php while ( have_posts() ) : the_post(); ?>
			<article>


				  <!-- Formato Padrão -->
    <?php if(has_post_thumbnail()) { ?>
    <div class="post-thumb">
    	<a href="<?php get_permalink(); ?>">
      		<?php the_post_thumbnail('post-thumb'); ?>
        </a>
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
            <?php endwhile; ?>
            <!-- post navigation -->
            <section class="pagination">
                <?php pagination(); ?>
            </section>
            <?php else: ?>
            <!-- Nada encontrado -->
                <h2>Nada Encontrado.</h2>
                <p>Desculpe, mas não encontramos nada relacionado a sua pesquisa. </p>
                <p>Certifique-se que digitou corretamente as palavras chaves ou pesquise com outras palavras relacionadas.</p>
                <?php get_search_form(); ?>
            <?php endif; ?>
            </section>
            <sidebar class="col-md-3 col-sm-4 col-xs-12">
                <?php echo get_sidebar(); ?>
            </sidebar>
        </div>
    </div>
    </article>
</section><!-- /#main -->

<script>
jQuery(document).ready(function($) {

// Grifar termos da pesquisa
$(function(){
    var itemTermo = $('h1.page-title span').text();

    var searchTerm = itemTermo.split(" ");

    $("body.search-results .entry-header, body.search-results .entry-content").each(function() {
        var html = $(this).html().toString();
        for(var i = 0; i < searchTerm.length; i++) {
            var pattern = "([^\\w]*)(" + searchTerm[i] + ")([^\\w]*)";
            var rg = new RegExp(pattern);
            var match = rg.exec(html);
            if(match) {
                html = html.replace(rg,match[1] + "<span class='marca'>"+ match[2] +"</span>" + match[3]);
                $(this).html(html);
            }
        }
    });
});

// FIM DA FUNÇÃO READY DOCUMENT
});
</script>

<?php get_footer(); ?>
