<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slavia_template
 */
if ( ! is_active_sidebar( 'left-sidebar' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar( 'left-sidebar' ); ?>
</aside><!-- #secondary -->