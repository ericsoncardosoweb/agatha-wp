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
add_action( 'widgets_init', 'Widget_InfosContato' );

/* Função para registrar o Widget */
function Widget_InfosContato() {
    register_widget( 'Widget_InfosContato' );
}

// Widget class.
class Widget_InfosContato extends WP_Widget {


    function Widget_infosContato() {
        /* Configurações */
        $detalhes_widget = array( 'classname' => 'widget_infos_contato_detalhes', 'description' => 'Exiba suas informações e dados de contato onde quiser.' );

        /* Cria o Widget */
        $this->WP_Widget( 'Widget_InfosContato', 'Ágatha | Infos Contato', $detalhes_widget );
    }

    function widget( $args, $modulos ) {
        extract( $args );

        /* Tags dos elementos do Widget */
        $title = apply_filters('widget_title', $modulos['title'] );
        $telefone = $modulos['telefone'];
        $celular = $modulos['celular'];
        $whatsapp = $modulos['whatsapp'];
        $email = $modulos['email'];
        $emailSecundary = $modulos['emailSecundary'];
        $endereco = $modulos['endereco'];
        $bairroCidade = $modulos['bairroCidade'];
        $site = $modulos['site'];
        $icons = $modulos['icons'];
        $logo = $modulos['logo'];
        $logoUrl = $modulos['logoUrl'];

        /* Front End do Widget. */
        echo $front_widget;

        /* Função display do título */
        if ( $title )
            echo $before_title . $title . $after_title;

        /* Exibição dos elementos no Front */
        $logoOption = ot_get_option( 'logotipo' );
        $blogName = get_bloginfo('name');

        $extra_classee = '';
        if($icons) $extra_classe = 'fa fa';
        ?>

        <div class="widget-infos-contato">
            <?php

            if(empty($logo)) {
                echo '';
            } elseif (!empty($logoUrl)) {
                echo '<img src="'. $logoUrl .'" alt="'. $blogName .'"></div>';
            }
            else {
                echo '<img src="'. $logoOption .'" alt="'. $blogName .'"></div>';
            }

            if($telefone) {
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-phone"></i><span><a href="tel:'.$telefone.'">'.$telefone.'</a></span></div>';
            }

            if($celular) {
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-mobile"></i><span><a href="tel:'.$celular.'">'.$celular.'</a></span></div>';
            }

            if($whatsapp) {
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-whatsapp"></i><span><a href="tel:'.$whatsapp.'">'.$whatsapp.'</a></span></div>';
            }

            if($email) {
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-envelope"></i><span><a href="mailto:'.$email.'?subject=Contato">'.$email.'</a></span></div>';
            }

            if($emailSecundary) {
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-envelope-o"></i><span><a href="mailto:'.$emailSecundary.'?subject=Contato">'.$emailSecundary.'</a></span></div>';
            }

            if($site) {
                $site_url = $site;
                if (strpos($a,'http://') !== false) { } else { $site_url = 'http://'.$site_url; }
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-globe"></i><span><a href="'.esc_url($site_url).'" target="_blank">'.$site.'</a></span></div>';
            }

            if($endereco) {
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-map-signs"></i><span>'.$endereco.'</span></div>';
            }

            if($bairroCidade) {
                echo '<div class="infos-contato-item"><i class="'. esc_attr($extra_classe) .'-map-marker"></i><span>'.$bairroCidade.'</span></div>';
            }

            ?>
        </div>


        <?php

        /* Back End do Widget. */
        echo $back_widget;
    }

    function update( $novo_modulo, $modulo_op ) {
        $modulos = $modulo_op;

        /* Tags das atualizações dos filtros do Widget. Cuidado ao alterar! */
        $modulos['title'] = strip_tags( $novo_modulo['title'] );
        $modulos['telefone'] = strip_tags( $novo_modulo['telefone'] );
        $modulos['celular'] = strip_tags( $novo_modulo['celular'] );
        $modulos['whatsapp'] = strip_tags( $novo_modulo['whatsapp'] );
        $modulos['email'] = strip_tags( $novo_modulo['email'] );
        $modulos['email'] = strip_tags( $novo_modulo['email'] );
        $modulos['emailSecundary'] = strip_tags( $novo_modulo['emailSecundary'] );
        $modulos['emailSecundary'] = strip_tags( $novo_modulo['emailSecundary'] );
        $modulos['endereco'] = strip_tags( $novo_modulo['endereco'] );
        $modulos['endereco'] = strip_tags( $novo_modulo['endereco'] );
        $modulos['bairroCidade'] = strip_tags( $novo_modulo['bairroCidade'] );
        $modulos['bairroCidade'] = strip_tags( $novo_modulo['bairroCidade'] );
        $modulos['site'] = strip_tags( $novo_modulo['site'] );
        $modulos['site'] = strip_tags( $novo_modulo['site'] );
        $modulos['icons'] = strip_tags( $novo_modulo['icons'] );
        $modulos['icons'] = strip_tags( $novo_modulo['icons'] );
        $modulos['logo'] = strip_tags( $novo_modulo['logo'] );
        $modulos['logo'] = strip_tags( $novo_modulo['logo'] );
        $modulos['logoUrl'] = strip_tags( $novo_modulo['logoUrl'] );
        $modulos['showmap'] = strip_tags( $novo_modulo['showmap'] );
        return $modulos;
    }

    function form( $modulos ) {

        /* Configuração Padrão do Widget. */
        $padroes = array( 'title' => 'Informações de Contato', 'telefone' => '11 4281-0015', 'whatsapp' => '11 9.4234-3423', 'celular' => '11 9.8784-6444', 'email' => 'contato@ericsoncardoso.com.br', 'emailSecundary' => 'ericson.cardoso10@gmail.com', 'site' => 'www.ericsoncardoso.com.br' , 'endereco' => 'Av. Brasil, 2753-78B, Green Plaza', 'bairroCidade' => 'São Paulo/SP', 'icons' => true, 'logo' => true );
        $modulos = wp_parse_args( (array) $modulos, $padroes ); ?>


        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><b>Título:</b></label>
        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $modulos['title']; ?>" style="width:100%;" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'telefone' ); ?>">Telefone:</label>
        <input id="<?php echo $this->get_field_id( 'telefone' ); ?>" name="<?php echo $this->get_field_name( 'telefone' ); ?>" type="text" value="<?php echo $modulos['telefone']; ?>" style="width:100%;" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'celular' ); ?>">Celular:</label>
        <input id="<?php echo $this->get_field_id( 'celular' ); ?>" name="<?php echo $this->get_field_name( 'celular' ); ?>" type="text" value="<?php echo $modulos['celular']; ?>" style="width:100%;" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'whatsapp' ); ?>">WhatsApp:</label>
        <input id="<?php echo $this->get_field_id( 'whatsapp' ); ?>" name="<?php echo $this->get_field_name( 'whatsapp' ); ?>" type="text" value="<?php echo $modulos['whatsapp']; ?>" style="width:100%;" />
        </p>
<hr>
        <p>
        <label for="<?php echo $this->get_field_id( 'email' ); ?>"><b>E-mail:</b></label>
        <input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $modulos['email']; ?>" style="width:100%;" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'emailSecundary' ); ?>">E-mail 2:</label>
        <input id="<?php echo $this->get_field_id( 'emailSecundary' ); ?>" name="<?php echo $this->get_field_name( 'emailSecundary' ); ?>" type="text" value="<?php echo $modulos['emailSecundary']; ?>" style="width:100%;" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'site' ); ?>">Site:<small>Não insira o "http://"</small></label>
        <input id="<?php echo $this->get_field_id( 'site' ); ?>" name="<?php echo $this->get_field_name( 'site' ); ?>" type="text" value="<?php echo $modulos['site']; ?>" style="width:100%;" />
        </p>
<hr>
        <p>
        <label for="<?php echo $this->get_field_id( 'endereco' ); ?>"><b>Endereço:</b></label>
        <input id="<?php echo $this->get_field_id( 'endereco' ); ?>" name="<?php echo $this->get_field_name( 'endereco' ); ?>" type="text" value="<?php echo $modulos['endereco']; ?>" style="width:100%;" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'bairroCidade' ); ?>">Bairro / Cidade:</label>
        <input id="<?php echo $this->get_field_id( 'bairroCidade' ); ?>" name="<?php echo $this->get_field_name( 'bairroCidade' ); ?>" type="text" value="<?php echo $modulos['bairroCidade']; ?>" style="width:100%;" />
        </p>


        <p>
            <label for="<?php echo $this->get_field_id( 'icons' ); ?>">Deseja exibir os ícones?</label>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'icons' ); ?>" name="<?php echo $this->get_field_name( 'icons' ); ?>" <?php echo ($modulos['icons']) ? 'checked="checked" ' : ''; ?>>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'icons' ); ?>">Deseja exibir o seu logotipo?
                <br><small>Insira a url da imagem ou exibirá a mesma imagem que selecionou para o header do site</small></label>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'logo' ); ?>" name="<?php echo $this->get_field_name( 'logo' ); ?>" <?php echo ($modulos['logo']) ? 'checked="checked" ' : ''; ?>>
            <input id="<?php echo $this->get_field_id( 'logoUrl' ); ?>" name="<?php echo $this->get_field_name( 'logoUrl' ); ?>" type="text" value="<?php echo $modulos['logoUrl']; ?>" style="width:100%;" />
        </p>

        <?php
    }
}