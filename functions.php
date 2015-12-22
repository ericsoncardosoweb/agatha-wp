<?php
/*
===========================================================================================================

Aqui você está na área de funções do tema, porém esta área é exclusiva para as funções padrões.

Se precisar alterar alguma função padrão ou adicionar uma nova vá em includes/functions e encontre ou crie seu arquivo. Em seguida importe seu arquivo por aqui para ser reconhecido pelo tema.

===========================================================================================================
*/

require( get_template_directory() . '/admin/painel/painel.php' );
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

require( get_template_directory() . '/resource/function/breadcrumbs.php' );
require( get_template_directory() . '/resource/function/post-populares.php' );
require( get_template_directory() . '/resource/widgets/widgets.php' );
require( get_template_directory() . '/resource/function/perfil.php' );
require( get_template_directory() . '/resource/function/posts-relacionados.php' );

define( 'PW_URL', get_home_url() . '/' );
define( 'PW_URL_THEME', get_bloginfo( 'template_url' ) . '/' );
define( 'PW_SITE_NAME', get_bloginfo( 'title' ) );


$Url = get_bloginfo('url');
$Template = get_bloginfo('template_url');


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

   	wp_register_script( 'Script do Tema', get_template_directory_uri() .'/resource/script/agatha-script.min.js', false, '1.0', true );
   	wp_enqueue_script( 'Script do Tema' );

   	wp_register_script( 'Customização de Script', get_template_directory_uri() .'/resource/script/script-customization.js', false, '1.0', true );
   	wp_enqueue_script( 'Customização de Script' );

   }
   add_action( 'wp_enqueue_scripts', 'agatha_scripts' );

// Theme the TinyMCE editor
// You should create custom-editor-style.css in your theme folder
add_editor_style('custom-editor-style.css');


// Enable thumbnails
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(200, 200, true); // Normal post thumbnails


// Custom CSS for the login page
// Create wp-login.css in your theme folder
function wpfme_loginCSS() {
  echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/wp-login.css"/>';
}
add_action('login_head', 'wpfme_loginCSS');


// Enable widgetable sidebar
// You may need to tweak your theme files, more info here - http://codex.wordpress.org/Widgetizing_Themes
if ( function_exists('register_sidebar') )
  register_sidebar(array(
  'before_widget' => '<aside>',
  'after_widget' => '</aside>',
  'before_title' => '<h1>',
  'after_title' => '</h1>',
));


// Remove the admin bar from the front end
add_filter( 'show_admin_bar', '__return_false' );


// Customise the footer in admin area
function wpfme_footer_admin () {
  echo 'Theme designed and developed by <a href="#" target="_blank">YourNameHere</a> and powered by <a href="http://wordpress.org" target="_blank">WordPress</a>.';
}
add_filter('admin_footer_text', 'wpfme_footer_admin');


// Set a maximum width for Oembedded objects
if ( ! isset( $content_width ) )
$content_width = 660;


// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );


// Put post thumbnails into rss feed
function wpfme_feed_post_thumbnail($content) {
  global $post;
  if(has_post_thumbnail($post->ID)) {
    $content = '' . $content;
  }
  return $content;
}
add_filter('the_excerpt_rss', 'wpfme_feed_post_thumbnail');
add_filter('the_content_feed', 'wpfme_feed_post_thumbnail');


// Add custom menus
register_nav_menus( array(
  'primary' => __( 'Primary Navigation', 'wpfme' ),
  //'example' => __( 'Example Navigation', 'wpfme' ),
) );


// Custom CSS for the whole admin area
// Create wp-admin.css in your theme folder
function wpfme_adminCSS() {
  echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/wp-admin.css"/>';
}
add_action('admin_head', 'wpfme_adminCSS');


// Enable admin to set custom background images in 'appearance > background'
add_custom_background();


// Randomly chosen placeholder text for post/page edit screen
function wpfme_writing_encouragement( $content ) {
  global $post_type;
  if($post_type == "post"){
  $encArray = array(
    // Placeholders for the posts editor
    "Test post message one.",
    "Test post message two.",
    "<h1>Test post heading!</h1>"
    );
    return $encArray[array_rand($encArray)];
  }
  else{ $encArray = array(
    // Placeholders for the pages editor
    "Test page message one.",
    "Test page message two.",
    "<h1>Test Page Heading</h1>"
    );
    return $encArray[array_rand($encArray)];
  }
}
add_filter( 'default_content', 'wpfme_writing_encouragement' );


//change amount of posts on the search page - set here to 100
function wpfme_search_results_per_page( $query ) {
  global $wp_the_query;
  if ( ( ! is_admin() ) && ( $query === $wp_the_query ) && ( $query->is_search() ) ) {
  $query->set( 'wpfme_search_results_per_page', 100 );
  }
  return $query;
}
add_action( 'pre_get_posts',  'wpfme_search_results_per_page'  );


//create a permalink after the excerpt
function wpfme_replace_excerpt($content) {
  return str_replace('[...]',
    '<a class="readmore" href="'. get_permalink() .'">Continue Reading</a>',
    $content
  );
}
add_filter('the_excerpt', 'wpfme_replace_excerpt');


function wpfme_has_sidebar($classes) {
    if (is_active_sidebar('sidebar')) {
        // add 'class-name' to the $classes array
        $classes[] = 'has_sidebar';
    }
    // return the $classes array
    return $classes;
}
add_filter('body_class','wpfme_has_sidebar');


// Create custom sizes
// This is then pulled through to your theme useing the_post_thumbnail('custombig');
if ( function_exists( 'add_image_size' ) ) {
  add_image_size('customsmall', 300, 200, true); //narrow column
  add_image_size('custombig', 400, 500, true); //wide column
}


// Stop images getting wrapped up in p tags when they get dumped out with the_content() for easier theme styling
function wpfme_remove_img_ptags($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'wpfme_remove_img_ptags');


// Call the google CDN version of jQuery for the frontend
// Make sure you use this with wp_enqueue_script('jquery'); in your header
function wpfme_jquery_enqueue() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
  wp_enqueue_script('jquery');
}
if (!is_admin()) add_action("wp_enqueue_scripts", "wpfme_jquery_enqueue", 11);


//custom excerpt length
function wpfme_custom_excerpt_length( $length ) {
  //the amount of words to return
  return 20;
}
add_filter( 'excerpt_length', 'wpfme_custom_excerpt_length');


// Call Googles HTML5 Shim, but only for users on old versions of IE
function wpfme_IEhtml5_shim () {
  global $is_IE;
  if ($is_IE)
  echo '<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
}
add_action('wp_head', 'wpfme_IEhtml5_shim');


// Remove the version number of WP
// Warning - this info is also available in the readme.html file in your root directory - delete this file!
remove_action('wp_head', 'wp_generator');


// Obscure login screen error messages
function wpfme_login_obscure(){ return '<strong>Sorry</strong>: Think you have gone wrong somwhere!';}
add_filter( 'login_errors', 'wpfme_login_obscure' );


// Disable the theme / plugin text editor in Admin
define('DISALLOW_FILE_EDIT', true);

?>