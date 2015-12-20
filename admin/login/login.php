<?php
function login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'login_logo_url' );

//Title do logo da tela de login
function logo_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'logo_title' );

function login_styles() {

    wp_register_style( 'Login', get_template_directory_uri() .'/admin/login/login-styles.css', false, '1.0' );
    wp_enqueue_style( 'Login' );

}
add_action( 'login_enqueue_scripts', 'login_styles' );


?>