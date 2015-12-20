<?php
// CAMPOS DE PERFIL PERSONALIZADOS

function contact_methods( $contactmethods ) {

    // remove os desnecessarios
    unset( $contactmethods[ 'aim' ] );
    unset( $contactmethods[ 'yim' ] );
    unset( $contactmethods[ 'jabber' ] );

    // adiciona os novos
    $contactmethods[ 'subtitulo' ] = 'Subtítulo abaixo do seu nome';
    $contactmethods[ 'telefone' ] = 'Telefone (com DDD)';
    $contactmethods[ 'celular' ] = 'Celular (com DDD)';
    $contactmethods[ 'twitter' ] = 'Twitter (link do perfil)';
    $contactmethods[ 'facebook' ] = 'Facebook (link do perfil)';

    return $contactmethods;
}

add_filter( 'user_contactmethods', 'contact_methods' );
// <?php echo get_the_author_meta('facebook', $post->post_author);
?>