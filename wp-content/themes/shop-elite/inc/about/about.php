<?php
/**
 * About setup
 *
 * @package Shop_Elite
 */

if ( ! function_exists( 'shop_elite_about_setup' ) ) :

	/**
	 * About setup.
	 *
	 * @since 1.0.0
	 */
	function shop_elite_about_setup() {

        $useful_plugins_link =  admin_url( 'themes.php?page=shop-elite-about&tab=useful-plugins' );
        $demo_import_link = admin_url( 'themes.php?page=pt-one-click-demo-import' );
        $customizer_link = admin_url( 'customize.php' );
        $widgets_link = admin_url( 'widgets.php' );

        $home_banner_options['autofocus[section]'] = 'home_banner_options';
        $home_banner_link = add_query_arg( $home_banner_options, admin_url( 'customize.php' ) );

        $top_bar_options['autofocus[section]'] = 'top_bar_options';
        $top_bar_link = add_query_arg( $top_bar_options, admin_url( 'customize.php' ) );

        $header_options['autofocus[section]'] = 'header_options';
        $header_link = add_query_arg( $header_options, admin_url( 'customize.php' ) );

        $shop_options['autofocus[section]'] = 'woocommerce_shop_page_options';
        $shop_link = add_query_arg( $shop_options, admin_url( 'customize.php' ) );

        $product_page_options['autofocus[section]'] = 'woocommerce_product_page_options';
        $product_page_link = add_query_arg( $product_page_options, admin_url( 'customize.php' ) );

        $wishlist_page_options['autofocus[section]'] = 'wishlist_options';
        $wishlist_page_link = add_query_arg( $wishlist_page_options, admin_url( 'customize.php' ) );

        $woo_product_images_options['autofocus[section]'] = 'woocommerce_product_images';
        $woo_product_images_link = add_query_arg( $woo_product_images_options, admin_url( 'customize.php' ) );

        $config = array(

			// Welcome content.
			'welcome_content' => sprintf( esc_html__( '%1$s is now installed and ready to use. We want to make sure you have the best experience using the theme and that is why we gathered here all the necessary information for you. Thanks for using our theme!', 'shop-elite' ), 'Shop Elite' ),

			// Tabs.
			'tabs' => array(
				'getting-started' => esc_html__( 'Getting Started', 'shop-elite' ),
				'useful-plugins'  => esc_html__( 'Useful Plugins', 'shop-elite' ),
				'faq'  => esc_html__( 'FAQ', 'shop-elite' ),
				'free-vs-pro'  => esc_html__( 'Free Vs Pro', 'shop-elite' ),
            ),

			// Quick links.
			'quick_links' => array(
                'theme_url' => array(
                    'text' => esc_html__( 'Theme Details', 'shop-elite' ),
                    'url'  => 'https://themesaga.com/theme/shop-elite/',
                ),
                'demo_url' => array(
                    'text' => esc_html__( 'View Demo', 'shop-elite' ),
                    'url'  => 'https://themesaga.com/shop-elite-demos/',
                ),
                'documentation_url' => array(
                    'text'   => esc_html__( 'View Documentation', 'shop-elite' ),
                    'url'    => 'https://docs.themesaga.com/shop-elite/',
                ),
                'view_pro' => array(
                    'text'   => esc_html__( 'View Pro', 'shop-elite' ),
                    'url'    => 'http://themesaga.com/shop-elite-pro',
                    'button' => 'primary',
                ),
                'rate_url'  => array(
                    'text' => __('Rate This Theme','shop-elite'),
                    'url' => 'https://wordpress.org/support/theme/shop-elite/reviews/?filter=5'
                ),
            ),

			// Getting started.
			'getting_started' => array(
				'one' => array(
					'title'       => esc_html__( 'Theme Documentation', 'shop-elite' ),
					'icon'        => 'dashicons dashicons-format-aside',
					'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'shop-elite' ),
					'button_text' => esc_html__( 'View Documentation', 'shop-elite' ),
					'button_url'  => 'https://docs.themesaga.com/shop-elite/',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
				'two' => array(
					'title'       => esc_html__( 'Static Front Page', 'shop-elite' ),
					'icon'        => 'dashicons dashicons-admin-generic',
					'description' => esc_html__( 'To achieve custom home page other than blog listing, you need to create and set static front page.', 'shop-elite' ),
					'button_text' => esc_html__( 'Static Front Page', 'shop-elite' ),
					'button_url'  => admin_url( 'customize.php?autofocus[section]=static_front_page' ),
					'button_type' => 'primary',
					),
				'three' => array(
					'title'       => esc_html__( 'Theme Options', 'shop-elite' ),
					'icon'        => 'dashicons dashicons-admin-customizer',
					'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'shop-elite' ),
					'button_text' => esc_html__( 'Customize', 'shop-elite' ),
					'button_url'  => wp_customize_url(),
					'button_type' => 'primary',
					),
				'four' => array(
					'title'       => esc_html__( 'Demo Content', 'shop-elite' ),
					'icon'        => 'dashicons dashicons-layout',
					'description' => sprintf( esc_html__( 'To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit Import Demo Data menu under Appearance.', 'shop-elite' ), esc_html__( 'One Click Demo Import', 'shop-elite' ) ),
					),
				'five' => array(
					'title'       => esc_html__( 'Theme Preview', 'shop-elite' ),
					'icon'        => 'dashicons dashicons-welcome-view-site',
					'description' => esc_html__( 'You can check out the theme demos for reference to find out what you can achieve using the theme and how it can be customized.', 'shop-elite' ),
					'button_text' => esc_html__( 'View Demo', 'shop-elite' ),
					'button_url'  => 'https://themesaga.com/shop-elite-demos/',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
                'six' => array(
                    'title'       => esc_html__( 'Contact Support', 'shop-elite' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'shop-elite' ),
                    'button_text' => esc_html__( 'Contact Support', 'shop-elite' ),
                    'button_url'  => 'https://themesaga.com/support/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

			// Useful plugins.
			'useful_plugins' => array(
				'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'shop-elite' ),
            ),

            //FAQ
            'faq' => array(
                array(
                    'title'=> __( 'How to make my site like your demo site?', 'shop-elite' ),
                    'desc' => sprintf( wp_kses( __( 'To make your site like our demo site, first you need to <a href="%1$s" class="button button-primary" target="_blank">install & activate</a> all the recommended plugins, then you can import our demo content from <a href="%2$s" class="button button-primary" target="_blank">here</a>', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'class' => array(), 'target' => array()) ) ), esc_url( $useful_plugins_link ), esc_url( $demo_import_link ) )
                ),
                array(
                    'title'=> __( 'Where can I find the settings to customize the theme?', 'shop-elite' ),
                    'desc' => sprintf( wp_kses( __( 'Most of the settings to customize the theme can be found on the <a href="%s" class="button button-primary" target="_blank">customizer</a>', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'class' => array(), 'target' => array()) ) ), esc_url( $customizer_link ) )
                ),
                array(
                    'title'=> __( 'Are there any options to customize the header?', 'shop-elite' ),
                    'desc' => sprintf( wp_kses( __( 'You can find options to customize the header on <a href="%1$s" class="button button-primary" target="_blank">topbar</a> & <a href="%2$s" class="button button-primary" target="_blank">header</a> section.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'class' => array(), 'target' => array()) ) ), esc_url( $top_bar_link ), esc_url( $header_link ) )
                ),
                array(
                    'title'=> __( 'Where can i find homepage banner slider settings?', 'shop-elite' ),
                    'desc' => sprintf( wp_kses( __( 'Homepage banner slider settings can be found <a href="%s" class="button button-primary" target="_blank">here</a>', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'class' => array(), 'target' => array()) ) ), esc_url( $home_banner_link ) )
                ),
                array(
                    'title'=> __( 'How can i add more sections on homepage?', 'shop-elite' ),
                    'desc' => sprintf( wp_kses_post( __( 'We\'ve created a widgetarea for homepage so that you can easily add any new widgets or change the order of the widgets to give new look to your site. Head over to <a href="%s" class="button button-primary" target="_blank">widgets</a> & add widgets under <strong><em>Home Page Full Width Column</em></strong> Widgetarea.', 'shop-elite' ) ), esc_url( $widgets_link ) )
                ),
                array(
                    'title'=> __( 'Does this theme provides any settings for WooCommerce?', 'shop-elite' ),
                    'desc' => sprintf( wp_kses_post( __( 'You can find multiple options for WooCommerce <a href="%1$s" class="button button-primary" target="_blank">shop/archive page</a> & <a href="%2$s" class="button button-primary" target="_blank">product detail page</a> but make sure you\'ve installed and activated <strong><em>WooCommerce</em></strong>. You can also find <a href="%3$s" class="button button-primary" target="_blank">wishlsit options</a> if you have enabled <strong><em>YITH WooCommerce Wishlist</em></strong>.', 'shop-elite' ) ), esc_url( $shop_link ), esc_url( $product_page_link ),esc_url( $wishlist_page_link ) )
                ),
                array(
                    'title'=> __( 'My product images are not uniform and are blurry', 'shop-elite' ),
                    'desc' => sprintf( wp_kses( __( 'It may be because of small image sizes being fetched. WooCommerce provides options to change image for both archive and detail page <a href="%s" class="button button-primary" target="_blank">here</a> After changing the image size, it may take some time to regenerate the new size. If the regeneration is not working, you can use some image regenerate plugin.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'class' => array(), 'target' => array()) ) ), esc_url( $woo_product_images_link ) )
                ),
                array(
                    'title'=> __( 'Can i have different sidebar for shop/catalog pages and product detail page?', 'shop-elite' ),
                    'desc' => sprintf( wp_kses_post( __( 'Yes we\'ve created different widgetarea for shop/catalog pages and product detail page so that you can easily add different types of widgets ( Eg: Filter Products widgets for shop page & Products widgets for product detail page). Head over to <a href="%s" class="button button-primary" target="_blank">widgets</a> & add widgets under <strong><em>WooCommerce Sidebar</em></strong> for shop/catalog pages & add widgets under <strong><em>Product Detail Page Sidebar</em></strong> for product detail page.', 'shop-elite' ) ), esc_url( $widgets_link ) )
                ),
                array(
                    'title'=> __( 'I\'ve already setup my site using free theme, is it difficult to upgrade to pro? ', 'shop-elite' ),
                    'desc' => __( 'It is actually pretty simple to upgrade to pro, you just need to unzip the pro file same as you did for the free theme and activate the pro theme. Most of the settings that you have on the free theme will be usable on the pro theme too. You may need to work on some widgets and customizer settings but that should be relatively easy.', 'shop-elite')
                ),
            ),

            // Free vs Pro
            'free_vs_pro' => array(
                array(
                    'title'=> __( 'Slider Animation', 'shop-elite' ),
                    'desc' => __( 'Homepage Banner Slider Settings Plus Title, Description and Buttons Animation', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Typography Options', 'shop-elite' ),
                    'desc' => __( 'Options to change the fonts family and font sizes of the site', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('(100+ Google Fonts)','shop-elite'),
                ),
                array(
                    'title'=> __( 'Color Options', 'shop-elite' ),
                    'desc' => __( 'Options to change the colors (primary, secondary, menu, footer and many more) of multiple sections of the site ', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Widget Options', 'shop-elite' ),
                    'desc' => __( 'Provides Multiple Theme Widgets', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>'.__('(Limited)','shop-elite'),
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('(More Widgets and Control Options)','shop-elite'),
                ),
                array(
                    'title'=> __( 'Brand Options', 'shop-elite' ),
                    'desc' => __( 'Options to add and show brands of product', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Contact page template', 'shop-elite' ),
                    'desc' => __( 'Custom contact page template for your site', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'FAQ page template', 'shop-elite' ),
                    'desc' => __( 'Custom FAQ page template for your site', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Mailchimp Options', 'shop-elite' ),
                    'desc' => __( 'Supports mailchimp plugin providing a clean desing for the newsletter form', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Instagram Options', 'shop-elite' ),
                    'desc' => __( 'Show your instagram images in a slider', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Testimonial Options', 'shop-elite' ),
                    'desc' => __( 'Options to add and show testimonials', 'shop-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
            ),

        );

		Shop_Elite_About::init( $config );
	}

endif;

add_action( 'after_setup_theme', 'shop_elite_about_setup' );
