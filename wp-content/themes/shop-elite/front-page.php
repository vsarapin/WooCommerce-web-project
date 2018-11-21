<?php
/**
 * The template for displaying home page.
 * @package Shop_Elite
 */
get_header();

/**
 * Hook - shop_elite_home_before_widget_area.
 *
 * @hooked shop_elite_banner_content - 10
 */
do_action('shop_elite_home_before_widget_area');

/*Home page full width widget area*/
if (is_active_sidebar('home-page-full-width-col')) {
    ?>
    <div class="homepage-widgetarea">
        <?php dynamic_sidebar('home-page-full-width-col'); ?>
    </div>
    <?php
}

/**
 * Hook - shop_elite_home_after_widget_area.
 *
 * @hooked shop_elite_front_page_content - 10
 */
do_action('shop_elite_home_after_widget_area');

get_footer();