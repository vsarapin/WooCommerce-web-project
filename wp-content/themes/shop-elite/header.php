<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shop_Elite
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
<body <?php body_class(); ?>>

<?php
$show_preloader = shop_elite_get_option('show_preloader', true);
if($show_preloader){
    ?>
    <div class="preloader"></div>
    <?php
}
?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'shop-elite'); ?></a>
<?php

/**
 * Hook - shop_elite_header.
 *
 * @hooked shop_elite_header_wrapper_start - 10
 * @hooked shop_elite_header_content - 20
 * @hooked shop_elite_header_wrapper_end - 30
 */
do_action( 'shop_elite_header' );

/**
 * Hook - shop_elite_before_content.
 *
 * @hooked shop_elite_content_wrapper_start - 10
 * @hooked shop_elite_display_breadcrumb - 20
 */
do_action( 'shop_elite_before_content' );
