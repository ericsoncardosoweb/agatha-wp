<?php

/*

Plugin Name: Ágatha | Infos de Contato
Plugin URI: http://ericsoncardoso.com.br
Description: Informações de contato personalizado
Version: 1.0
Author: Ericson Cardoso
Author URI: http://ericsoncardoso.com.br

*/

/* Add função base para o widget widgets_init */
add_action( 'widgets_init', 'widget_nomedoseuwidget' );

/* Função para registrar o Widget */
function widget_nomedoseuwidget() {
    register_widget( 'widget_nomedoseuwidget' );
}

// Widget class.
class widget_nomedoseuwidget extends WP_Widget {


    function Widget_nomedoseuwidget() {
        /* Configurações */
        $detalhes_widget = array( 'classname' => 'nomedoseuwidget', 'description' => 'Exiba suas informações e dados de contato onde quiser.' );

        /* Cria o Widget */
        $this->WP_Widget( 'widget_nomedoseuwidget', 'Ágatha | Infos Contato', $detalhes_widget );
    }

    function widget( $args, $modulos ) {
        extract( $args );

        /* Tags dos elementos do Widget */
        $title = apply_filters('widget_title', $modulos['title'] );
        $SuasVariaveis = $modulos['SuasVariaveis'];


        /* Front End do Widget. */
        echo $front_widget;

        /* Função para exibição do título */
        if ( $title )
            echo $before_title . $title . $after_title;

        /* Exibição dos elementos no Front */
        $logoOption = ot_get_option( 'logotipo' );
        $blogName = get_bloginfo('name');

        $extra_classee = '';
        if($title) $extra_classe = 'nome da nova classe';
        ?>

            <!-- Aqui sua brincadeira de Front End começa -->
        <div class="classe-widget">

        </div>


        <?php

        /* Back End do Widget. */
        echo $back_widget;
    }

    function update( $novo_modulo, $modulo_op ) {
        $modulos = $modulo_op;

        /* Aqui você realiza as atualizações de todas as opções selecionadas no back end do widget
        Cuidado ao alterar! */
        $modulos['title'] = strip_tags( $novo_modulo['title'] );
        $modulos['suaVarialvel'] = strip_tags( $novo_modulo['suaVarialvel'] );

        return $modulos;
    }

    function form( $modulos ) {

        /* Configuração Padrão do Widget. */
        $padroes = array( 'title' => 'Título do seu Widget' );
        $modulos = wp_parse_args( (array) $modulos, $padroes ); ?>


        /* Nesta área você insere o código para o back-end do widget */
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Título:</label>
        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $modulos['title']; ?>" style="width:100%;" />
        </p>


        <?php
    }
}