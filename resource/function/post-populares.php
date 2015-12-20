<?php /* Este recurso mostra os Posts mais populares mais populares */

function agatha_postsPop() {

global $wpdb;
// busca no banco os posts mais visualizados
$result = $wpdb->get_results("SELECT postid FROM {$wpdb->prefix}popularpostsdata ORDER BY pageviews DESC");

// loop para mostrar na tela
$d;
foreach($result AS $pop):
$d[] = $pop->postid;
endforeach;

$filtros = array(
  'showposts'   => 4,
  'post_status' => 'publish'
);

$list_pop = new WP_Query($filtros);
if ($list_pop->have_posts()) : while ($list_pop->have_posts()) : $list_pop->the_post();
            ?>

            <li class="agatha-post clearfix">
                <a href="<?php the_permalink(); ?>">
                    <?php if(has_post_thumbnail()) { ?>
                    <div class="agatha-thumbnail">
                        <?php
                            echo get_the_post_thumbnail();
                        ?>
                    </div>
                    <?php } ?>
                    <div class="agatha-title">
                        <h3><?php the_title(); ?></h3>
                        <p class="resumo">
                        <?php the_excerpt(); ?>
                        </p>
                    </div>
                </a>
            </li>

            <?php endwhile; endif; wp_reset_postdata();
}
// Adiciona um Shortcode
add_shortcode('post-popular', 'agatha_postsPop');
//  agatha_postsPop(); [post-popular]
?>