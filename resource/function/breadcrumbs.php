<?php
function agatha_breadcrumb() {
    global $post;
    echo '<ul id="trilha">';
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Página inicial';
        echo '</a></li><li class="separador"> / </li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li class="separador"> / </li><li> ');
            if (is_single()) {
                echo '</li><li class="separador"> / </li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li> <li class="separador">/</li>';
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<li><strong> '.get_the_title().'</strong></li>';
            }
        }
    }
    elseif (is_tag()) { single_tag_title();}
    elseif (is_day()) { echo "<li>Arquivo de "; the_time('j \d\e F \d\e Y'); echo'</li>'; }
    elseif (is_month()) { echo "<li>Arquivo de "; the_time('F \d\e Y'); echo'</li>'; }
    elseif (is_year()) { echo "<li>Arquivo de "; the_time('Y'); echo'</li>'; }
    elseif (is_author()) { echo "<li>Arquivo do autor"; echo'</li>'; }
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { echo "<li>Arquivo do blog"; echo'</li>'; }
    elseif (is_search()) { echo "<li>Resultados da pesquisa"; echo'</li>'; }
    echo '</ul>';
}
?>