<!-- Bootstrap -->
<link href="<?php echo do_shortcode('[template-url]'); ?>/includes/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo do_shortcode('[template-url]'); ?>/includes/css/bootstrap-theme.min.css" rel="stylesheet">
<link  rel= "stylesheet"  href= "https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" >

<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo ot_get_option( 'favicon' ); ?>" />

<?php
/* Esta função cria uma meta description automáticamente para todos as páginas do site, se preferir deixar uma exclusiva para determinadas páginas você pode utilizar a condição is_page do Wordpress */

function create_meta_desc() {
    global $post;
    if (!is_single()) { return; }
    $meta = strip_tags($post->post_content);
    $meta = strip_shortcodes($post->post_content);
    $meta = str_replace(array("\n", "\r", "\t"), ' ', $meta);
    $meta = substr($meta, 0, 125);
    echo "<meta name='description' content='$meta' />";
}
add_action('wp_head', 'create_meta_desc');
?>