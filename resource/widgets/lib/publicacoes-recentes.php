<?php

/*

Plugin Name: Ágatha | Publicações Recentes
Plugin URI: http://ericsoncardoso.com.br
Description: Informações de contato personalizado
Version: 1.0
Author: Ericson Cardoso
Author URI: http://ericsoncardoso.com.br

*/

/* Add função base para o widget widgets_init */
add_action( 'widgets_init', 'widget_publicacao_recente' );

/* Função para registrar o Widget */
function widget_publicacao_recente() {
    register_widget( 'widget_publicacao_recente' );
}

// Widget class.
class widget_publicacao_recente extends WP_Widget {


    function Widget_publicacao_recente() {
        /* Configurações */
        $detalhes_widget = array( 'classname' => 'publicacao_recente', 'description' => 'Exiba suas publicações mais recentes ou populares de forma personalizada e rápida!' );

        /* Cria o Widget */
        $this->WP_Widget( 'widget_publicacao_recente', 'Ágatha | Publicações Recentes', $detalhes_widget );
    }

    function widget( $args, $modulos ) {
        extract( $args );

        /* Tags dos elementos do Widget */
        $title = apply_filters('widget_title', $modulos['title'] );
        $filtro = $modulos['filtro'];
        $numeroPost = $modulos['numeroPost'];
        $categoria = $modulos['categoria'];
        $imagem = $modulos['imagem'];
        $resumo = $modulos['resumo'];
        $limiteCaracter = $modulos['limiteCaracter'];
        $data = $modulos['data'];

        /* Front End do Widget. */
        echo $front_widget;

        echo "<aside id='post-rescentes-agatha'>";

        /* Função para exibição do título */
        if ( $title )
            echo $before_title . $title . $after_title;

        /* Exibição dos elementos no Front */
        $logoOption = ot_get_option( 'logotipo' );
        $blogName = get_bloginfo('name');

        $extra_classee = '';
        if($title) $extra_classe = 'nome da nova classe';
        ?>

        <?php // Aqui sua brincadeira de Front End começa ?>
        <div class="widget-publicacoes-recentes" style="position:relative;width:100%;">
            <ul>
            <?php
            // Função para controle do excerpt
                function controle_excerpt($limit) {
                    $excerpt = explode(' ', get_the_excerpt(), $limit);
                    if (count($excerpt)>=$limit) {
                    array_pop($excerpt);
                    $excerpt = implode(" ",$excerpt).'...';
                    } else {
                    $excerpt = implode(" ",$excerpt);
                    }
                    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
                    return $excerpt;
                }

                // Otimização dos números de publicações
                $numeroPostNew = $numeroPost - 1;

                // Análise de categorias

                $categorias = '';

                if($categoria) {
                    foreach($categoria as $categoriasAdd) {
                        $categorias .= $categoriasAdd.',';
                    }
                } ?>

                <?php if ($filtro == "popular") { ?>
                   <?php
                    global $wpdb;
                    // busca no banco os posts mais visualizados
                    $result = $wpdb->get_results("SELECT postid FROM {$wpdb->prefix}popularpostsdata ORDER BY pageviews DESC");

                    // loop para mostrar na tela
                    $d;
                    foreach($result AS $pop):
                    $d[] = $pop->postid;
                    endforeach;

                    $argumentos = array(
                      'showposts'   => $numeroPostNew,
                      'post_status' => 'publish',
                      'cat' => $categorias,
                    );

                    $list_pop = new WP_Query($argumentos);

                    if ($list_pop->have_posts()) : while ($list_pop->have_posts()) : $list_pop->the_post();
                ?>

            <li class="agatha-post clearfix">
                <a href="<?php the_permalink(); ?>">
                    <?php if($imagem && has_post_thumbnail()) { ?>
                    <div class="agatha-thumbnail">
                        <?php
                            echo get_the_post_thumbnail();
                        ?>
                    </div>
                    <?php } ?>
                    <div class="agatha-title">
                        <h3><?php the_title(); ?></h3>
                        <p class="data">
                            <span class="dia"><?php the_time('d'); ?></span>
                            <span class="mes"><?php the_time('M'); ?></span>
                            <span class="ano"><?php the_time('Y'); ?></span>
                        </p>
                        <p class="resumo">
                            <?php echo controle_excerpt(''.$limiteCaracter.''); ?>
                        </p>
                    </div>
                </a>
            </li>

            <?php endwhile; endif; wp_reset_postdata(); ?>

                <?php } else { ?>
                 <?php // Filtro de ordem de exibição das publicações

                $ordeBy = ' ';

                if ($filtro == "recente") {
                   $orderBy = 'data';
                } elseif ($filtro == "variado") {
                    $orderBy = 'hand';
                }

                $args = array(
                'post_status' => array('publish'),
                'posts_per_page' => $numeroPostNew,
                'post_status' => 'publish',
                'cat' => $categorias,
                'orderby' => $ordeBy,

            );
            $condicoes = new WP_Query($args);


            if ($condicoes->have_posts()) : while ($condicoes->have_posts()) : $condicoes->the_post();
            ?>

            <li class="agatha-post clearfix">
                <a href="<?php the_permalink(); ?>">
                    <?php if($imagem && has_post_thumbnail()) { ?>
                    <div class="agatha-thumbnail">
                        <?php
                            echo get_the_post_thumbnail();
                        ?>
                    </div>
                    <?php } ?>
                    <div class="agatha-title">
                        <h3><?php the_title(); ?></h3>
                        <p class="data">
                            <span class="dia"><?php the_time('d'); ?></span>
                            <span class="mes"><?php the_time('M'); ?></span>
                            <span class="ano"><?php the_time('Y'); ?></span>
                        </p>
                        <p class="resumo">
                            <?php echo controle_excerpt(''.$limiteCaracter.''); ?>
                        </p>
                    </div>
                </a>
            </li>

            <?php endwhile; endif; wp_reset_postdata(); ?>
                <?php }
                 ?>




           </ul>
        </div>

        <?php

        echo "</aside>";

        /* Back End do Widget. */
        echo $back_widget;
    }

    function update( $novo_modulo, $modulo_op ) {
        $modulos = $modulo_op;

        /* Aqui você realiza as atualizações de todas as opções selecionadas no back end do widget
        Cuidado ao alterar! */
        $modulos['title'] = strip_tags( $novo_modulo['title'] );
        $modulos['filtro'] = strip_tags( $novo_modulo['filtro'] );
        $modulos['numeroPost'] = strip_tags( $novo_modulo['numeroPost'] );
        $modulos['categoria'] = $novo_modulo['categoria'];
        $modulos['imagem'] = strip_tags( $novo_modulo['imagem'] );
        $modulos['resumo'] = strip_tags( $novo_modulo['resumo'] );
        $modulos['limiteCaracter'] = strip_tags( $novo_modulo['limiteCaracter'] );
        $modulos['data'] = strip_tags( $novo_modulo['data'] );

        return $modulos;
    }

    function form( $modulos ) {

        /* Configuração Padrão do Widget. */
        $padroes = array( 'title' => 'Título do seu Widget', 'filtro' => 'recente', 'numeroPost' => '5', 'limiteCaracter' => '12' );
        $modulos = wp_parse_args( (array) $modulos, $padroes ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><h4>Título:</h4></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $modulos['title']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><h4>Filtrar por:</h4></label>
            <select id="<?php echo $this->get_field_id('filtro'); ?>" name="<?php echo $this->get_field_name('filtro'); ?>">
                <option <?php if($modulos['filtro'] == "recente") echo 'selected="selected"'; ?> value="recente">Mais Recentes</option>
                <option <?php if($modulos['filtro'] == "popular") echo 'selected="selected"'; ?> value="popular">Mais Populares</option>
                <option <?php if($modulos['filtro'] == "variado") echo 'selected="selected"'; ?> value="variado">Variados</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'numeroPost' ); ?>"><h4>Nº de publicações:</h4></label>
            <input id="<?php echo $this->get_field_id( 'numeroPost' ); ?>" name="<?php echo $this->get_field_name( 'numeroPost' ); ?>" type="text" value="<?php echo $modulos['numeroPost']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'categoria' ); ?>"><h4>Filtrar por Categoria:</h4></label>
            <div style="width:90%; height: auto; max-height:200px; overflow-Y:auto;border:solid 1px #ddd;padding:10px;margin: 20px 0px;">
                <?php

        $categoriaBlog = get_categories();

        foreach ($categoriaBlog as $categoria_blog ) {
            $selecao = "";

            if($modulos['categoria']) {
                if ( in_array($categoria_blog->term_id, $modulos['categoria']) ) { $selecao = 'checked="checked"'; }
            }

            echo '<div class="post-categoria"><input id="'.$this->get_field_id('categoria').$categoria_blog->term_id.'" type="checkbox" name="'.$this->get_field_name( 'categoria' ).'[]" '.$selecao.' value="'.$categoria_blog->term_id.'">'.$categoria_blog->name.'</div>';

        }

        ?>
            </div>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('imagem'); ?>" name="<?php echo $this->get_field_name('imagem'); ?>" type="checkbox" <?php if($modulos['imagem']) echo 'checked="checked"'; ?>>
            <label for="<?php echo $this->get_field_id('imagem'); ?>">Exibir Imagem?</label>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('data'); ?>" name="<?php echo $this->get_field_name('data'); ?>" type="checkbox" <?php if($modulos['data']) echo 'checked="checked"'; ?>>
            <label for="<?php echo $this->get_field_id('data'); ?>">Mostrar Data?</label>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('resumo'); ?>" name="<?php echo $this->get_field_name('resumo'); ?>" type="checkbox" <?php if($modulos['resumo']) echo 'checked="checked"'; ?>>
            <label for="<?php echo $this->get_field_id('resumo'); ?>">Mostrar Resumo?</label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'limiteCaracter' ); ?>"><h4>Nº limite de palavras:</h4></label>
            <input id="<?php echo $this->get_field_id( 'limiteCaracter' ); ?>" name="<?php echo $this->get_field_name( 'limiteCaracter' ); ?>" type="text" value="<?php echo $modulos['limiteCaracter']; ?>" style="width:100%;" />
        </p>



        <?php
    }
}