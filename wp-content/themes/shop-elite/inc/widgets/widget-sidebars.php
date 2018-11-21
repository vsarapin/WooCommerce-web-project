<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shop_elite_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'shop-elite'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Displays items on sidebar.', 'shop-elite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="saga-title-wrapper"><h2 class="widget-title">',
        'after_title' => '</h2></div>',
    ));
    if (shop_elite_is_wc_active()) {
        register_sidebar(array(
            'name' => esc_html__('WooCommerce Sidebar', 'shop-elite'),
            'id' => 'wc-sidebar',
            'description' => esc_html__('Displays items only on WooCommerce Shop and Product Category pages.', 'shop-elite'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="saga-title-wrapper"><h2 class="widget-title">',
            'after_title' => '</h2></div>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Product Detail Page Sidebar', 'shop-elite'),
            'id' => 'wc-product-single-sidebar',
            'description' => esc_html__('Displays items only on product detail page.', 'shop-elite'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="saga-title-wrapper"><h2 class="widget-title">',
            'after_title' => '</h2></div>',
        ));
    }
    register_sidebar(array(
        'name' => esc_html__('Home Page Full Width Column', 'shop-elite'),
        'id' => 'home-page-full-width-col',
        'description' => esc_html__('Displays items on homepage fullwidth column.', 'shop-elite'),
        'before_widget' => '<div id="%1$s" class="widget clearfix %2$s"><div class="container">',
        'after_widget' => '</div></div>',
        'before_title' => '<div class="saga-title-wrapper"><h2 class="widget-title"><span>',
        'after_title' => '</span></h2></div>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Column One', 'shop-elite'),
        'id' => 'footer-col-one',
        'description' => esc_html__('Displays items on footer first column.', 'shop-elite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Column Two', 'shop-elite'),
        'id' => 'footer-col-two',
        'description' => esc_html__('Displays items on footer second column.', 'shop-elite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Column Three', 'shop-elite'),
        'id' => 'footer-col-three',
        'description' => esc_html__('Displays items on footer third column.', 'shop-elite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'shop_elite_widgets_init');