<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shop_Elite
 */

if( shop_elite_is_wc_active() ){

    $page_layout = shop_elite_get_page_layout();

    if( is_shop() || is_product_category() ){
        if( 'no-sidebar' != $page_layout ){
            if( is_active_sidebar( 'wc-sidebar' ) ) {
                ?>
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar('wc-sidebar'); ?>
                </aside>
                <?php
            }
        }
    }elseif( is_product() ) {
        if( 'no-sidebar' != $page_layout ){
            if( is_active_sidebar( 'wc-product-single-sidebar' ) ) {
                ?>
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar('wc-product-single-sidebar'); ?>
                </aside>
                <?php
            }
        }
    }else{
        if( is_active_sidebar( 'sidebar-1' ) ){
            ?>
            <aside id="secondary" class="widget-area">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            </aside>
            <?php
        }
    }
}else{
    if( is_active_sidebar( 'sidebar-1' ) ){
        ?>
        <aside id="secondary" class="widget-area">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </aside>
    <?php
    }
}
