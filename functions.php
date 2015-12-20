<?php
/*
===========================================================================================================

Aqui você está na área de funções do tema, porém esta área é exclusiva para as funções padrões.

Se precisar alterar alguma função padrão ou adicionar uma nova vá em includes/functions e encontre ou crie seu arquivo. Em seguida importe seu arquivo por aqui para ser reconhecido pelo tema.

===========================================================================================================
*/

// Option Tree Framework
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
require( trailingslashit( get_template_directory() ) . 'admin/option-tree/ot-loader.php' );

/**
 * Opções do Tema
 */
require( trailingslashit( get_template_directory() ) . 'admin/option-tree/theme-options.php' );

require( get_template_directory() . '/resource/function/require-plugins.php' );
require( get_template_directory() . '/admin/panel/painel.php' );
require( get_template_directory() . '/admin/login/login.php' );

// Copyright

function comicpress_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
		SELECT
		YEAR(min(post_date_gmt)) AS firstdate,
		YEAR(max(post_date_gmt)) AS lastdate
		FROM
		$wpdb->posts
		WHERE
		post_status = 'publish'
		");
	$output = '';
	if($copyright_dates) {
		$copyright = "&copy; " . $copyright_dates[0]->firstdate;
		if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
			$copyright .= '-' . $copyright_dates[0]->lastdate;
		}
		$output = $copyright;
	}
	return $output;
}

// Remover link RSD
remove_action ('wp_head', 'rsd_link');
// Ativa posts-formats
add_theme_support( 'post-formats', array( 'gallery','image','quote','video','audio') );
// Remove a versão do WordPress do cabeçalho
remove_action('wp_head', 'wp_generator');
// Remove estilos da galeria
add_filter( 'use_default_gallery_style', '__return_false' );
// Força o wordpress a ler shortcodes em textos de widgets
add_filter('widget_text', 'do_shortcode');
// HTML5
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
// Remove link automático nas imagens no editor WP
update_option('image_default_link_type','none');
update_option('image_default_link_type','post');

// Title Tag
add_theme_support( 'title-tag' );
// Feed Links
add_theme_support( 'automatic-feed-links' );
// Imagem de Destaque no Feed de Notícias
add_filter('the_content_feed', 'rss_post_thumbnail');
function rss_post_thumbnail($content) {
	global $post;
	if( has_post_thumbnail($post->ID) )
		$content = '<p>' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</p>' . $content;
	return $content;
}

function excerpt_readmore($more) {
	return '... <a href="'. get_permalink($post->ID) . '" class="leiaMais">' . 'Ler Mais' . '</a>';
}
add_filter('excerpt_more', 'excerpt_readmore');

// Alterar o Gravatar Padrão
add_filter( 'avatar_defaults', 'newgravatar' );
function newgravatar ($avatar_defaults) {
	$caminho = get_bloginfo('template_url');
	$myavatar = $caminho .'/images/gravatar.png';
	$avatar_defaults[$myavatar] = "<img src='". $caminho ."/images/gravatar.png' style='position: relative;left: -39px;top: 15px;width: 40px;height: 40px;background-color: #FFF;' > <span style='position: relative;left: -39px;top: 1px;'>Seu Logo</span>";
	return $avatar_defaults;
}

add_theme_support('menus');

// Adiciona tamanhos de imagens customizados
add_image_size( 'thumbnail', 150, 150, true );
add_image_size( 'miniatura', 300, 250, true );
add_image_size( 'media', 800, 1140, false );
add_image_size( 'grande', 1400, 3633, true );
add_image_size( 'post-single', 900, 280, true );
// Thumbnails
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-thumbnails', array( 'post' ) );          // Posts only
add_theme_support( 'post-thumbnails', array( 'page' ) );          // Pages only
add_theme_support( 'post-thumbnails', array( 'post', 'movie' ) ); // Posts and Movies
//Qualidade das Imagens padrão do WP
add_filter( 'jpeg_quality', 'wp_jpeg_quality' );
function wp_jpeg_quality() {
	return 80;
}
// Rodar PHP nos Widgets de Texto e habilitar shortcodes
add_filter('widget_text','execute_php',100);
function execute_php($html){
	if(strpos($html,"<"."?php")!==false){
		ob_start();
		eval("?".">".$html);
		$html=ob_get_contents();
		ob_end_clean();
	}
	return $html;
}

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
add_filter('the_content_rss', 'do_shortcode');

// Jquery UI - CND Google
function load_jquery_ui_google_cdn() {
	global $wp_scripts;

	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-slider');

    // get the jquery ui object
	$queryui = $wp_scripts->query('jquery-ui-core');

    // load the jquery ui theme
	$url = "http//ajax.googleapis.com/ajax/libs/jqueryui/".$queryui->ver."/themes/smoothness/jquery-ui.css";
	wp_enqueue_style('jquery-ui-smoothness', $url, false, null);
}

add_action('wp_enqueue_scripts', 'load_jquery_ui_google_cdn');

// Inicia uma sessão
if ( ! function_exists( 'agatha_session_start' ) ) {
    // Cria a função
	function agatha_session_start() {
        // Inicia uma sessão PHP
		if ( ! session_id() ) session_start();
	}
    // Executa a ação
	add_action( 'init', 'agatha_session_start' );
}

// Add Post Meta
if ( ! function_exists( 'agatha_count_post_views' ) ) {
    // Conta os views do post
	function agatha_count_post_views () {
        // Garante que vamos tratar apenas de posts
		if ( is_single() ) {

            // Precisamos da variável $post global para obter o ID do post
			global $post;

            // Se a sessão daquele posts não estiver vazia
			if ( empty( $_SESSION[ 'agatha_post_counter_' . $post->ID ] ) ) {

                // Cria a sessão do posts
				$_SESSION[ 'agatha_post_counter_' . $post->ID ] = true;

                // Cria ou obtém o valor da chave para contarmos
				$key = 'agatha_post_counter';
				$key_value = get_post_meta( $post->ID, $key, true );

                // Se a chave estiver vazia, valor será 1
                if ( empty( $key_value ) ) { // Verifica o valor
                	$key_value = 1;
                	update_post_meta( $post->ID, $key, $key_value );
                } else {
                    // Caso contrário, o valor atual + 1
                	$key_value += 1;
                	update_post_meta( $post->ID, $key, $key_value );
                } // Verifica o valor

            } // Checa a sessão

        } // is_single

        return;

    }
    add_action( 'get_header', 'agatha_count_post_views' );
}


/* FUNÇÕES DO TEMA */

require( get_template_directory() . '/includes/function/breadcrumbs.php' );
require( get_template_directory() . '/includes/function/post-populares.php' );
require( get_template_directory() . '/includes/widgets/widgets.php' );
require( get_template_directory() . '/includes/function/perfil.php' );
require( get_template_directory() . '/includes/function/posts-relacionados.php' );

define( 'PW_URL', get_home_url() . '/' );
define( 'PW_URL_THEME', get_bloginfo( 'template_url' ) . '/' );
define( 'PW_SITE_NAME', get_bloginfo( 'title' ) );


$siteUrl = get_bloginfo('url');
$siteTemplate = get_bloginfo('template_url');

function fn_siteUrl(){
	return get_bloginfo('url');
}
add_shortcode('site-url','fn_siteUrl');

function fn_siteTemplate(){
	return get_bloginfo('template_url');
}
add_shortcode('template-url','fn_siteTemplate');

function fn_urlMidia(){
	return get_bloginfo('url') . "/wp-content/uploads/";
}
add_shortcode('url-midia','fn_urlMidia');

function cwc_mail_shortcode( $atts , $content=null ) {
	for ($i = 0; $i < strlen($content); $i++) $encodedmail .= "&#" . ord($content[$i]) . ';';
		return '<a href="mailto:'.$encodedmail.'">'.$encodedmail.'</a>';
}
add_shortcode('mailto', 'cwc_mail_shortcode');
/* [mailto]email@seudominio.com[/mailto] */

// Barra Admin

function wps_admin_bar() {
	global $wp_admin_bar;
    // $wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );

// Otimizador de HTML para o Editor do Wordpress
function fb_change_mce_options($initArray) {
    // Comma separated string od extendes tags
    // Command separated string of extended elements
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
	if ( isset( $initArray['extended_valid_elements'] ) ) {
		$initArray['extended_valid_elements'] .= ',' . $ext;
	} else {
		$initArray['extended_valid_elements'] = $ext;
	}

    // maybe; set tiny paramter verify_html
    //$initArray['verify_html'] = false;
	return $initArray;
}
add_filter('tiny_mce_before_init', 'fb_change_mce_options');

// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
function all_settings_link() {
	add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
add_action('admin_menu', 'all_settings_link');

// REMOVE THE WORDPRESS UPDATE NOTIFICATION FOR ALL USERS EXCEPT SYSADMIN
global $user_login;
get_currentuserinfo();
   if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins
   	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
   	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
   }

// SHORTCODE GOOGLE MAPA
   function fn_googleMaps($atts, $content = null) {
   	extract(shortcode_atts(array(
   		"width" => '640',
   		"height" => '480',
   		"src" => ''
   		), $atts));
   	return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'"></iframe>';
   }
   add_shortcode("googlemap", "fn_googleMaps");
   /* [googlemap width="600" height"360" src="http://google.com/maps/?ie=..."] */


// PAGINAÇÃO
   function pagination() {
   	global $wp_query;

   	$big = 999999999;

   	echo paginate_links( array(
   		'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
   		'format'    => '?paged=%#%',
   		'current'   => max( 1, get_query_var('paged') ),
   		'total'     => $wp_query->max_num_pages,
   		'prev_next' => True,
   		'prev_text' => __('« Voltar'),
   		'next_text' => __('Avançar »'),
   		) );
   }

// WIDGET
   function agatha_widgets_init(){
   	register_sidebar(array(
   		'name'          => __('Sidebar Padrão', 'agatha'),
   		'id'            => 'sidebar',
   		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
   		'after_widget'  => '</aside>',
   		'before_title'  => '<h3 class="widget-title">',
   		'after_title'   => '</h3>'
   		));
   	register_sidebar(array(
   		'name'          => __('Sidebar Blog', 'agatha'),
   		'id'            => 'sidebar_blog',
   		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
   		'after_widget'  => '</aside>',
   		'before_title'  => '<h3 class="widget-title">',
   		'after_title'   => '</h3>'
   		));
   	register_sidebar(array(
   		'name'          => __('Sidebar Páginas', 'agatha'),
   		'id'            => 'sidebar_page',
   		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
   		'after_widget'  => '</aside>',
   		'before_title'  => '<h3 class="widget-title">',
   		'after_title'   => '</h3>'
   		));
   	register_sidebar(array(
   		'name'          => __('Footer Área 1', 'agatha'),
   		'id'            => 'footer1',
   		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
   		'after_widget'  => '</aside>',
   		'before_title'  => '<h3 class="widget-title">',
   		'after_title'   => '</h3>'
   		));
   	register_sidebar(array(
   		'name'          => __('Footer Área 2', 'agatha'),
   		'id'            => 'footer2',
   		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
   		'after_widget'  => '</aside>',
   		'before_title'  => '<h3 class="widget-title">',
   		'after_title'   => '</h3>'
   		));
   }

   add_action('widgets_init', 'agatha_widgets_init');


// REGISTRO DE SCRIPT
   function agatha_scripts() {

   	wp_register_script( 'Script do Tema', get_template_directory_uri() .'/includes/script/agatha-script.min.js', false, '1.0', true );
   	wp_enqueue_script( 'Script do Tema' );

   	wp_register_script( 'Customização de Script', get_template_directory_uri() .'/includes/script/script-customization.js', false, '1.0', true );
   	wp_enqueue_script( 'Customização de Script' );

   }
   add_action( 'wp_enqueue_scripts', 'agatha_scripts' );

// Register Script
   function preloaderScripts() {

   	wp_register_script( 'classie', get_template_directory_uri() .'/template/preloading/js/classie.js', false, false, true );
   	wp_enqueue_script( 'classie' );

   	wp_register_script( 'pathLoader', get_template_directory_uri() .'/template/preloading/js/pathLoader.js', false, false, true );
   	wp_enqueue_script( 'pathLoader' );

   	wp_register_script( 'main', get_template_directory_uri() .'/template/preloading/js/main.js', false, false, true );
   	wp_enqueue_script( 'main' );

   	wp_register_script( 'custom', get_template_directory_uri() .'/template/preloading/js/modernizr.custom.js', false, false, false );
   	wp_enqueue_script( 'custom' );

   }
   add_action( 'wp_enqueue_scripts', 'preloaderScripts' );


// REGISTRO DE STYLE

   function preloaderStyles() {

   	wp_register_style( 'effect1', get_template_directory_uri() .'/template/preloading/css/effect1.css', false, false );
   	wp_enqueue_style( 'effect1' );

   }
   add_action( 'wp_enqueue_scripts', 'preloaderStyles' );


   function header_styles() {

   	wp_register_style( 'Header', get_template_directory_uri() .'/template/header/'. ot_get_option( 'modelo-header', '', false, true, 0 ) .'/style.css', false, '1.0' );
   	wp_enqueue_style( 'Header' );

   	wp_register_style( 'Header Responsive', get_template_directory_uri() .'/template/header/'. ot_get_option( 'modelo-header', '', false, true, 0 ) .'/responsive.css', false, '1.0' );
   	wp_enqueue_style( 'Header Responsive' );

   }
   add_action( 'wp_enqueue_scripts', 'header_styles' );


   ?>