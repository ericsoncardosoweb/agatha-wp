<?php
function PostsRelacionados(){
    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags( $post->ID );

    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page'=>4,
            'caller_get_posts'=>1
        );

        $queryLoop = new WP_Query($args); ?>
            <section id="postsrelacionados">
                <?php if ($queryLoop->have_posts()): while ($queryLoop->have_posts()) : $queryLoop->the_post();?>
                <div class="col-md-3 col-xs-6 postsRelacionados">
                    <a rel="external" href="<?php the_permalink()?>"><?php the_post_thumbnail('miniatura'); ?><br />
                    <?php the_title(); ?>
                    </a>
                </div>
                <?php endwhile; else:?>
                <?php endif; wp_reset_query();?>
            </section>

        <?php $post = $orig_post; ?>
    <?php } // End if

} //Fim da Função
add_shortcode('postsrelacionados', 'PostsRelacionados' );
// PostsRelacionados(); [postsrelacionados]
?>