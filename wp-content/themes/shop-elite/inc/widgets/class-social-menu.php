<?php

if (!defined('ABSPATH')) {
    exit;
}

class Shop_Elite_Social_Menu extends Shop_Elite_Widget_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->widget_cssclass = 'shop_elite widget_social_menu';
        $this->widget_description = __("Displays social menu if you have set it(social menu)", 'shop-elite');
        $this->widget_id = 'shop_elite_social_menu';
        $this->widget_name = __('SE: Social Menu', 'shop-elite');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'shop-elite'),
            ),
        );

        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        ob_start();

        $this->widget_start($args, $instance);

        echo wp_kses_post(apply_filters('shop_elite_before_widget_social_menu', '<div class="shop_elite_social_menu_widget social-widget-menu">'));

        if ( has_nav_menu( 'social-nav' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'social-nav',
                'link_before'    => '<span class="social-name">',
                'link_after'     => '</span>',
            ) );
        }else{
            esc_html_e( 'Social menu is not set. You need to create menu and assign it to Social Menu on Menu Settings.', 'shop-elite' );

        }

        echo wp_kses_post(apply_filters('shop_elite_after_widget_social_menu', '</div>'));

        $this->widget_end($args);

        echo ob_get_clean();
    }
}