<?php /* Posts Relacionados por categoria */
function agatha_postsrelacionados() {

    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);

    if ($tags) {
    $tag_ids = array();
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
    $args=array(
    'tag__in' => $tag_ids,
    'post__not_in' => array($post->ID),
    'posts_per_page'=>4, // Number of related posts to display.
    'caller_get_posts'=>1
    );

    $my_query = new wp_query( $args ); ?>
    <section id="relatedPost">
        <?php while( $my_query->have_posts() ) {
        $my_query->the_post(); ?>
        <div class="col-md-3 col-xs-6 relatedPost">
            <a rel="external" href="<?php the_permalink()?>"><?php the_post_thumbnail('miniatura'); ?><br />
            <?php the_title(); ?>
            </a>
        </div>
        <?php } ?>
    </section>
    <?php }
        $post = $orig_post;
        wp_reset_query();

} //Fim da função
// Adiciona um Shortcode
add_shortcode('categoryposts', 'agatha_postsrelacionados');
//  agatha_postsbycategory(); [categoryposts]
?>