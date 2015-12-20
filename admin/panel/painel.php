<?php
/* Remove painel Bem-vindo ao WordPress!*/
remove_action('welcome_panel', 'wp_welcome_panel');

// Customizar o Footer do WordPress
function remove_footer_admin () {
	echo '© <a href="http://ericsoncardoso.com.br" target="_blank">Ágatha Framework</a>. Desenvolvido por <a href="http://ericsoncardoso.com.br" target="_blank">Ericson Cardoso</a> - contato@ericsoncardoso.com.br';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Remover notificações de atualizações para os usuários do site, exceto os administradores
global $user_login;
get_currentuserinfo();
if (!current_user_can('update_plugins')) {
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

// Customizar header do painel


function admin_styles() {

	wp_register_style( 'Estilo Admin', get_template_directory_uri() .'/admin/panel/estilo-painel.css', false, '1.0' );
	wp_enqueue_style( 'Estilo Admin' );

}
add_action( 'admin_enqueue_scripts', 'admin_styles' );

function fb_move_admin_bar() {
    echo '
    <style type="text/css">
    body, html {
    margin: 0!important;
    padding: 0!important;
    }
    body.admin-bar #wphead {
       padding-top: 0;
    }
    body.admin-bar #footer {
       padding-bottom: 28px;
    }
    #wpadminbar {
        top: auto !important;
        bottom: 0;
    }
    #wpadminbar .quicklinks .menupop ul {
        bottom: 28px;
    }
    #wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input {
        margin: 0;
        padding: 0;
        -webkit-box-shadow: 0 3px 5px rgba(0,0,0,.2);
        box-shadow: inset 0px -5px 5px rgba(0,0,0,.2);
        background: #999;
        display: none;
        position: absolute;
        float: none;
        bottom: 37px;
    }
    #wpadminbar .quicklinks .menupop ul li a {
        color: #222!important;
    }
    #wpadminbar .quicklinks .menupop ul {
        bottom: 0!important;
    }
    </style>';
}
// on backend area
add_action( 'admin_head', 'fb_move_admin_bar' );
// on frontend area
add_action( 'wp_head', 'fb_move_admin_bar' );

// Saudação customizada
function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Olá', 'Seja Bem vindo', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );

//Personalizar o logotipo da barra de admin
add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
echo '<style type="text/css">
#wp-admin-bar-wp-logo span.ab-icon {background: url('.get_bloginfo('template_url').'/admin/panel/favicon.png) no-repeat center top !important;background-size: 100%!important;
  background-position-y: 2px!important; }
body #wpadminbar>#wp-toolbar>#wp-admin-bar-root-default #wp-admin-bar-wp-logo span.ab-icon {
  background-image: url('.get_bloginfo('template_url').'/admin/panel/favicon.png)!important;
  background-repeat: no-repeat!important;
  width: 25px;
  height: 25px;
}
#wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before {
  display: none;
}

li#wp-admin-bar-wp-logo .ab-sub-wrapper {
  display: none!important;
}
  </style>';
}

// Register Script
function panel_scripts() {

    wp_register_script( 'Admin Panel', get_template_directory_uri() .'/admin/panel/script.js', false, false, true );
    wp_enqueue_script( 'Admin Panel' );

}
add_action( 'admin_enqueue_scripts', 'panel_scripts' );


?>