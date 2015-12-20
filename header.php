<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="pt-br"><!--<![endif]-->
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title ( '|', true,'right' ); ?></title>

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />


<?php
    /*
     * Habilita os links de estilo e escripts primários do tema, cuidado ao removê-lo.
     */
    get_template_part( 'template/head/head', 'head' );


    /*
     *  Habilita o suporte para comentários da página.
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    wp_enqueue_script('jquery');
    wp_head();


    wp_get_archives('type=monthly&format=link');
?>
</head>
<body <?php body_class(); ?>>
<div id="ip-container" class="ip-container">

<!-- Animação de pré Carregamento -->
<section class="carregamento">
    <?php get_template_part('template/preloading/preloading', 'one' ); ?>
</section>
<!-- / Animação de pré Carregamento -->

<section id="wrapper">

<!-- Header -->
<header>
    <?php get_template_part( 'template/header/header', 'option' ); ?>
</header>
<!-- / Header -->










