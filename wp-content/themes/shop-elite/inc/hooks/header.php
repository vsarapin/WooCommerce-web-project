<?php

if (!function_exists('shop_elite_header_wrapper_start')) :
    /**
     * Display Opening Div Structure for the header
     *
     * @since 1.0.0
     */
    function shop_elite_header_wrapper_start()
    {
        ?>
        <header id="saga-header" class="site-header">
        <?php
    }
endif;
add_action('shop_elite_header', 'shop_elite_header_wrapper_start', 10);

if (!function_exists('shop_elite_header_content')) :
    /**
     * Display header Content
     *
     * @since 1.0.0
     */
    function shop_elite_header_content()
    {
        $show_ad_banner = shop_elite_get_option('show_ad_banner', true);
        if ($show_ad_banner) {
            ?>
            <div class="saga-top-ad-space">
                <?php
                $ad_banner_image = shop_elite_get_option('ad_banner_image', true);
                $ad_banner_link = shop_elite_get_option('ad_banner_link', true);
                if ($ad_banner_image) {
                    $ad_banner_image_html = '<img src="' . esc_url($ad_banner_image) . '">';
                    $ad_banner_link_open = $ad_banner_link_close = '';
                    if ($ad_banner_link) {
                        $ad_banner_link_open = '<a href="' . esc_url($ad_banner_link) . '" target="_blank" class="border-overlay">';
                        $ad_banner_link_close = '</a>';
                    }
                    echo $ad_banner_link_open . $ad_banner_image_html . $ad_banner_link_close;
                }
                ?>
            </div>
            <?php
        }

        $show_top_bar = shop_elite_get_option('show_top_bar', true);
        if ($show_top_bar) {
            ?>
            <div class="saga-topnav">
                <div class="container">
                    <?php
                    /**
                     * Hook - shop_elite_top_bar.
                     *
                     * @hooked shop_elite_header_top_info - 10
                     * @hooked shop_elite_header_right_nav_wrapper_open - 20
                     * @hooked shop_elite_header_top_nav - 30
                     * @hooked shop_elite_header_social_nav - 40
                     * @hooked shop_elite_header_right_nav_wrapper_close - 50
                     */
                    do_action('shop_elite_top_bar');
                    ?>
                </div>
            </div>
        <?php } ?>
        <div class="header-middle data-bg" data-background="<?php echo(get_header_image()); ?>">
            <div class="container">
                <div class="row">
                    <?php
                    /**
                     * Hook - shop_elite_header_info.
                     *
                     * @hooked shop_elite_site_info - 10
                     * @hooked shop_elite_header_search_space - 20
                     */
                    do_action('shop_elite_header_info');
                    ?>
                </div>
            </div>
        </div>
        <?php
        /**
         * Hook - shop_elite_header_navigation.
         *
         * @hooked shop_elite_header_main_navigation - 10
         */
        do_action('shop_elite_header_navigation');
    }
endif;
add_action('shop_elite_header', 'shop_elite_header_content', 20);

if (!function_exists('shop_elite_header_top_info')) :
    /**
     * Display Info Section on Top Bar
     *
     * @since 1.0.0
     */
    function shop_elite_header_top_info()
    {
        $css = '';
        $hide_contact_info_mobile = shop_elite_get_option('hide_contact_info_mobile', true);
        if($hide_contact_info_mobile){
            $css = 'hidden-xs';
        }
        ?>
        <div class="top-bar-left <?php echo esc_attr($css);?>">
            <?php
            $address_icon = shop_elite_get_option('address_icon', true);
            $address_info = shop_elite_get_option('address_info', true);

            $email_icon = shop_elite_get_option('email_icon', true);
            $email_address = shop_elite_get_option('email_address', true);

            $contact_icon = shop_elite_get_option('contact_icon', true);
            $contact_no = shop_elite_get_option('contact_no', true);
            ?>
            <?php if ($address_info): ?>
                <div class="saga-info">
                    <?php if ($address_icon): ?>
                        <div class="info-icon">
                            <i class="<?php echo esc_attr($address_icon); ?>"></i>
                        </div>
                    <?php endif; ?>
                    <div class="info-content">
                        <span>
                            <?php echo esc_html($address_info); ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($email_address): ?>
                <div class="saga-info">
                    <?php if ($email_icon): ?>
                        <div class="info-icon">
                            <i class="<?php echo esc_attr($email_icon); ?>"></i>
                        </div>
                    <?php endif; ?>
                    <div class="info-content">
                        <span>
                            <?php
                            $email_address = antispambot($email_address);
                            $mailto = shop_elite_get_option('enable_mailto', true);
                            if($mailto){
                                $email_link = sprintf('mailto:%s', $email_address);
                                printf('<a href="%s">%s</a>', esc_url($email_link, array('mailto')), esc_html($email_address));
                            }else{
                                echo esc_html($email_address);
                            }
                            ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($contact_no): ?>
                <div class="saga-info">
                    <?php if ($contact_icon): ?>
                        <div class="info-icon">
                            <i class="<?php echo esc_attr($contact_icon); ?>"></i>
                        </div>
                    <?php endif; ?>
                    <div class="info-content">
                        <span>
                            <?php
                            $callto = shop_elite_get_option('enable_callto', true);
                            if($callto){
                                echo '<a href="callto:' . preg_replace('/\D+/', '', esc_attr($contact_no)) . '">' . esc_html($contact_no) . '</a>';
                            }else{
                                echo esc_html($contact_no);
                            }
                            ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
endif;
add_action('shop_elite_top_bar', 'shop_elite_header_top_info', 10);


if ( ! function_exists( 'shop_elite_header_right_nav_wrapper_open' ) ) :

    /**
     * Outputs opening wrapper for top right navigation
     *
     * @since 1.0.0
     */

    function shop_elite_header_right_nav_wrapper_open() {
        ?>
        <div class="top-bar-right">
        <?php
    }
endif;
add_action( 'shop_elite_top_bar', 'shop_elite_header_right_nav_wrapper_open' , 20 );

if (!function_exists('shop_elite_header_top_nav')) :
    /**
     * Display Top navigation on Top Bar
     *
     * @since 1.0.0
     */
    function shop_elite_header_top_nav()
    {
        $show_top_nav_menu = shop_elite_get_option('show_top_nav_menu', true);
        if ($show_top_nav_menu) {
            ?>
            <div class="top-nav">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'topbar-menu',
                        'menu_id' => 'top-menu',
                        'container' => 'div',
                        'depth' => 1,
                        'fallback_cb' => false,
                        'menu_class' => false
                    )
                );
                ?>
            </div>
            <?php
        }
    }
endif;
add_action('shop_elite_top_bar', 'shop_elite_header_top_nav', 30);

if (!function_exists('shop_elite_header_social_nav')) :
    /**
     * Display Social navigation on Top Bar
     *
     * @since 1.0.0
     */
    function shop_elite_header_social_nav()
    {
        $show_social_nav_menu = shop_elite_get_option('show_social_nav_menu', true);
        if ($show_social_nav_menu) {
            ?>
            <div class="social-icons">
                <?php
                wp_nav_menu(array(
                        'theme_location' => 'social-nav',
                        'link_before' => '<span class="screen-reader-text">',
                        'link_after' => '</span>',
                        'menu_id' => 'social-menu',
                        'fallback_cb' => false,
                        'depth' => 1,
                        'menu_class' => false
                    )
                );
                ?>
            </div>
            <?php
        }
    }
endif;
add_action('shop_elite_top_bar', 'shop_elite_header_social_nav', 40);

if ( ! function_exists( 'shop_elite_header_right_nav_wrapper_close' ) ) :

    /**
     * Outputs closing wrapper for top right navigation
     *
     * @since 1.0.0
     */
function shop_elite_header_right_nav_wrapper_close() {
    ?>
    </div>
    <?php
}
endif;

add_action( 'shop_elite_top_bar', 'shop_elite_header_right_nav_wrapper_close' , 50 );

if (!function_exists('shop_elite_site_info')) :
    /**
     * Display Site Info on the header
     *
     * @since 1.0.0
     */
    function shop_elite_site_info()
    {
        ?>
        <div class="col-md-4 col-sm-12">
            <div class="site-branding">
                <?php
                the_custom_logo();
                if (is_front_page()) :
                    ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php
                else :
                    ?>
                    <p class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </p>
                <?php
                endif;
                $shop_elite_description = get_bloginfo('description', 'display');
                if ($shop_elite_description || is_customize_preview()) :
                    ?>
                    <p class="site-description"><?php echo $shop_elite_description; /* WPCS: xss ok. */ ?></p>
                <?php endif; ?>
            </div><!-- .site-branding -->
        </div>
        <?php
    }
endif;
add_action('shop_elite_header_info', 'shop_elite_site_info', 10);

if (!function_exists('shop_elite_header_search_space')) :
    /**
     * Display Site Ad Info on the header
     *
     * @since 1.0.0
     */
    function shop_elite_header_search_space()
    {
        ?>
        <div class="col-md-8 col-sm-12">
            <div class="head-top-right">
                <div class="mobile-table-align">
                    <div class="mobile-table-cell">
                        <?php
                        $enable_search_form = shop_elite_get_option('enable_search_form', true);
                        if ($enable_search_form) {
                            if (shop_elite_is_wc_active()) {
                                shop_elite_product_search_form();
                            } else {
                                echo get_search_form();
                            }
                        }
                        ?>
                        <div class="hidden-md hidden-lg">
                            <div class="close-popup"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
endif;
add_action('shop_elite_header_info', 'shop_elite_header_search_space', 20);

if (!function_exists('shop_elite_header_main_navigation')) :
    /**
     * Display Main Header Navigation
     *
     * @since 1.0.0
     */
    function shop_elite_header_main_navigation()
    {
        ?>
        <div class="saga-navigation">
            <div class="container">
                <nav id="site-navigation" class="main-navigation saga-nav saga-nav-left">
                        <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                             <span class="screen-reader-text">
                                <?php esc_html_e('Primary Menu', 'shop-elite'); ?>
                            </span>
                            <i class="ham"></i>
                        </span>

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'container' => 'div',
                        'container_class' => 'menu'
                    ));
                    ?>
                </nav><!-- #site-navigation -->
                <div class="saga-nav saga-nav-right">
                    <div class="hidden-md hidden-lg saga-woo-nav">
                        <div class="saga-wooicon">
                            <span class="icon-search">
                                <i class="ion-ios-search-strong"></i>
                            </span>
                        </div>
                    </div>
                <?php
                if (shop_elite_is_wishlist_active()) {
                    $enable_header_wishlist = shop_elite_get_option('enable_header_wishlist', true);
                    if ($enable_header_wishlist) {
                        shop_elite_woocommerce_header_wishlist();
                    }
                }
                if (shop_elite_is_wc_active()) {
                    $enable_header_mini_cart = shop_elite_get_option('enable_header_mini_cart', true);
                    if ($enable_header_mini_cart) {
                        shop_elite_woocommerce_header_cart();
                    }
                }
                ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;
add_action('shop_elite_header_navigation', 'shop_elite_header_main_navigation', 10);

if (!function_exists('shop_elite_header_wrapper_end')) :
    /**
     * Display Closing Div Structure for the header
     *
     * @since 1.0.0
     */
    function shop_elite_header_wrapper_end()
    {
        ?>
        </header>
        <?php
    }
endif;
add_action('shop_elite_header', 'shop_elite_header_wrapper_end', 30);

if (!function_exists('shop_elite_content_wrapper_start')) :
    /**
     * Display Opening Div Structure for the content
     *
     * @since 1.0.0
     */
    function shop_elite_content_wrapper_start()
    {
        ?>
        <div id="content" class="site-content">
        <?php
    }
endif;
add_action('shop_elite_before_content', 'shop_elite_content_wrapper_start', 10);

if (!function_exists('shop_elite_display_breadcrumb')) :
    /**
     * Display breadcrumb.
     *
     * @since 1.0.0
     */
    function shop_elite_display_breadcrumb()
    {

        // Bail if Breadcrumb disabled.
        $breadcrumb_type = shop_elite_get_option('breadcrumb_type', true);
        if ('disabled' === $breadcrumb_type) {
            return;
        }
        // Bail if Home Page.
        if (is_front_page() || is_home()) {
            return;
        }

        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false,
        );

        // Render breadcrumb.
        switch ($breadcrumb_type) {
            case 'default':
                if (!function_exists('breadcrumb_trail')) {
                    require_once get_template_directory() . '/assets/lib/breadcrumbs/breadcrumbs.php';
                }
                breadcrumb_trail($breadcrumb_args);
                break;
            case 'wc':
                if (shop_elite_is_wc_active()) {
                    woocommerce_breadcrumb($breadcrumb_args);
                }
                break;
            default:
                break;

        }
        return;
    }
endif;
add_action('shop_elite_before_content', 'shop_elite_display_breadcrumb', 20);
