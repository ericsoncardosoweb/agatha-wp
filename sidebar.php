<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Agatha
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
    return;
}
?>

    <?php dynamic_sidebar( 'sidebar' ); ?>


