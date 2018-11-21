<?php

/*Get default values to set while building customizer elements*/
$default_options = shop_elite_get_default_customizer_values();

/*Get image sizes*/
$image_sizes = shop_elite_get_all_image_sizes(true);

/*Add Home Page Options Panel.*/
$wp_customize->add_panel(
    'theme_home_option_panel',
    array(
        'title' => __( 'Front Page Options', 'shop-elite' ),
        'description' => __( 'Contains all front page settings', 'shop-elite')
    )
);
/**/

/* ========== Home Page Slider Section ========== */
$wp_customize->add_section(
    'home_banner_options' ,
    array(
        'title' => __( 'Slider Options', 'shop-elite' ),
        'panel' => 'theme_home_option_panel',
    )
);

/*Enable Slider Section*/
$wp_customize->add_setting(
    'theme_options[enable_slider_posts]',
    array(
        'default'           => $default_options['enable_slider_posts'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_slider_posts]',
    array(
        'label'    => __( 'Enable Banner Slider', 'shop-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
    )
);

/*Option to choose slider layout*/
$wp_customize->add_setting(
    'theme_options[slider_layout]',
    array(
        'default'           => $default_options['slider_layout'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[slider_layout]',
    array(
        'label'       => __( 'Slider Layout', 'shop-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'fullwidth' => __('FullWidth', 'shop-elite'),
            'boxed' => __('Boxed', 'shop-elite'),
        ),
        'active_callback'  =>  'shop_elite_is_banner_slider_enabled'
    )
);
/**/

/*Option to choose slider content layout*/
$wp_customize->add_setting(
    'theme_options[slider_content_layout]',
    array(
        'default'           => $default_options['slider_content_layout'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[slider_content_layout]',
    array(
        'label'       => __( 'Slider Content Layout', 'shop-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'half_width' => __('Half-Width', 'shop-elite'),
            'full' => __('Full', 'shop-elite'),
        ),
        'active_callback'  =>  'shop_elite_is_banner_slider_enabled'
    )
);
/**/

/*Option to choose product category if WooCommerce is active*/
$slider_post_type_choices = array(
    'post' => __( 'Post', 'shop-elite' )
);
if( shop_elite_is_wc_active() ){
    $slider_post_type_choices['product'] = __( 'Product', 'shop-elite' );
}
$wp_customize->add_setting(
    'theme_options[slider_post_type]',
    array(
        'default'           => $default_options['slider_post_type'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[slider_post_type]',
    array(
        'label'       => __( 'Choose Post Type', 'shop-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => $slider_post_type_choices,
        'active_callback'  =>  'shop_elite_is_banner_slider_enabled'
    )
);
/**/

/*Slider Posts Category.*/
$wp_customize->add_setting(
    'theme_options[slider_post_cat]',
    array(
        'default'           => $default_options['slider_post_cat'],
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_control(
    new Shop_Elite_Dropdown_Taxonomies_Control(
        $wp_customize,
        'theme_options[slider_post_cat]',
        array(
            'label'    => __( 'Choose Category', 'shop-elite' ),
            'section'  => 'home_banner_options',
            'description'  => __( 'Choose Post Category', 'shop-elite' ),
            'active_callback'  =>  function( $control ) {
                return (
                    shop_elite_is_banner_slider_enabled( $control )
                    &&
                    shop_elite_is_post_cat_on_banner( $control )
                );
            }
        )
    )
);

/*Slider Product Category.*/
$wp_customize->add_setting(
    'theme_options[slider_product_cat]',
    array(
        'default'           => $default_options['slider_product_cat'],
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_control(
    new Shop_Elite_Dropdown_Taxonomies_Control(
        $wp_customize,
        'theme_options[slider_product_cat]',
        array(
            'label'    => __( 'Choose Category', 'shop-elite' ),
            'section'  => 'home_banner_options',
            'taxonomy'  => 'product_cat',
            'description'  => __( 'Choose Product Category', 'shop-elite' ),
            'active_callback'  => function( $control ) {
                return (
                    shop_elite_is_banner_slider_enabled( $control )
                    &&
                    shop_elite_is_product_cat_on_banner( $control )
                );
            }
        )
    )
);

/* Number of Posts */
$wp_customize->add_setting(
    'theme_options[no_of_slider_posts]',
    array(
        'default'           => $default_options['no_of_slider_posts'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[no_of_slider_posts]',
    array(
        'label'       => __( 'Number of Posts', 'shop-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'number',
        'active_callback'  => 'shop_elite_is_banner_slider_enabled'
    )
);

/*Enable Slider Description*/
$wp_customize->add_setting(
    'theme_options[enable_slider_description]',
    array(
        'default'           => $default_options['enable_slider_description'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_slider_description]',
    array(
        'label'    => __( 'Enable Description', 'shop-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
        'active_callback'  => 'shop_elite_is_banner_slider_enabled'
    )
);

/* Description Length */
$wp_customize->add_setting(
    'theme_options[slider_desc_length]',
    array(
        'default'           => $default_options['slider_desc_length'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[slider_desc_length]',
    array(
        'label'       => __( 'Description Length', 'shop-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'number',
        'active_callback'  =>  function( $control ) {
            return (
                shop_elite_is_banner_slider_enabled( $control )
                &&
                shop_elite_is_banner_desc_enabled( $control )
            );
        }
    )
);

/*Enable Static Button*/
$wp_customize->add_setting(
    'theme_options[enable_slider_static_btn]',
    array(
        'default'           => $default_options['enable_slider_static_btn'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_slider_static_btn]',
    array(
        'label'    => __( 'Enable Static Button', 'shop-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
        'active_callback'  => 'shop_elite_is_banner_slider_enabled'
    )
);

/*Static Button text*/
$wp_customize->add_setting(
    'theme_options[slider_static_btn_text]',
    array(
        'default'           => $default_options['slider_static_btn_text'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[slider_static_btn_text]',
    array(
        'label'    => __( 'Button Text', 'shop-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'text',
        'active_callback'  =>  function( $control ) {
            return (
                shop_elite_is_banner_slider_enabled( $control )
                &&
                shop_elite_is_banner_static_btn_enabled( $control )
            );
        }
    )
);

/*Static Button Link*/
$wp_customize->add_setting(
    'theme_options[slider_static_btn_link]',
    array(
        'default'           => $default_options['slider_static_btn_link'],
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    'theme_options[slider_static_btn_link]',
    array(
        'label'    => __( 'Button Link', 'shop-elite' ),
        'description' => __( 'Leave empty to link to its respective post link', 'shop-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'text',
        'active_callback'  =>  function( $control ) {
            return (
                shop_elite_is_banner_slider_enabled( $control )
                &&
                shop_elite_is_banner_static_btn_enabled( $control )
            );
        }
    )
);

/* ========== Home Page Slider Section Close ========== */

/* ========== Home Page Layout Section ========== */
$wp_customize->add_section(
    'home_page_layout_options',
    array(
        'title'      => __( 'Front Page Layout Options', 'shop-elite' ),
        'panel'      => 'theme_home_option_panel',
    )
);

/* Home Page Layout */
$wp_customize->add_setting(
    'theme_options[home_page_layout]',
    array(
        'default'           => $default_options['home_page_layout'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[home_page_layout]',
    array(
        'label'       => __( 'Front Page Layout', 'shop-elite' ),
        'section'     => 'home_page_layout_options',
        'type'        => 'select',
        'choices'     => array(
            'right-sidebar' => __( 'Right Sidebar', 'shop-elite' ),
            'left-sidebar' => __( 'Left Sidebar', 'shop-elite' ),
            'no-sidebar' => __( 'No Sidebar', 'shop-elite' )
        ),
    )
);
/* ========== Home Page Layout Section Close ========== */

/*Add Theme Options Panel.*/
$wp_customize->add_panel(
    'theme_option_panel',
    array(
        'title' => __( 'Theme Options', 'shop-elite' ),
        'description' => __( 'Contains all theme settings', 'shop-elite')
    )
);
/**/

/* ========== Preloader Section. ==========*/
$wp_customize->add_section(
    'preloader_options',
    array(
        'title'      => __( 'Preloader Options', 'shop-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/*Show Preloader*/
$wp_customize->add_setting(
    'theme_options[show_preloader]',
    array(
        'default'           => $default_options['show_preloader'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_preloader]',
    array(
        'label'    => __( 'Show Preloader', 'shop-elite' ),
        'section'  => 'preloader_options',
        'type'     => 'checkbox',
    )
);
/* ========== Preloader Section Close========== */

/* ========== Top Bar Section. ==========*/
$wp_customize->add_section(
    'top_bar_options',
    array(
        'title'      => __( 'TopBar Options', 'shop-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/*Show Ad Banner*/
$wp_customize->add_setting(
    'theme_options[show_ad_banner]',
    array(
        'default'           => $default_options['show_ad_banner'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_ad_banner]',
    array(
        'label'    => __( 'Show Ad Banner', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'checkbox',
    )
);

/*Ad Banner Image*/
$wp_customize->add_setting(
    'theme_options[ad_banner_image]',
    array(
        'default'           => $default_options['ad_banner_image'],
        'sanitize_callback' => 'shop_elite_sanitize_image',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'theme_options[ad_banner_image]',
        array(
            'label'           => __( 'Ad Banner Image', 'shop-elite' ),
            'section'         => 'top_bar_options',
            'active_callback' => 'shop_elite_is_ad_banner_enabled',
        )
    )
);

/*Ad Banner Link.*/
$wp_customize->add_setting(
    'theme_options[ad_banner_link]',
    array(
        'default'           => $default_options['ad_banner_link'],
        'sanitize_callback' => 'esc_url_raw'
    )
);
$wp_customize->add_control(
    'theme_options[ad_banner_link]',
    array(
        'label'    => __( 'Ad Banner Link', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'text',
        'active_callback' => 'shop_elite_is_ad_banner_enabled',
    )
);

/*Show Top Bar*/
$wp_customize->add_setting(
    'theme_options[show_top_bar]',
    array(
        'default'           => $default_options['show_top_bar'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_top_bar]',
    array(
        'label'    => __( 'Show TopBar', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'checkbox',
    )
);

/*Address Info.*/
$wp_customize->add_setting(
    'theme_options[address_icon]',
    array(
        'default'           => $default_options['address_icon'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[address_icon]',
    array(
        'label'    => __( 'Address Icon', 'shop-elite' ),
        'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
        'section'  => 'top_bar_options',
        'type'     => 'text',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
$wp_customize->add_setting(
    'theme_options[address_info]',
    array(
        'default'           => $default_options['address_info'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[address_info]',
    array(
        'label'    => __( 'Address Info', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'text',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);

/*Email Address.*/
$wp_customize->add_setting(
    'theme_options[email_icon]',
    array(
        'default'           => $default_options['email_icon'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[email_icon]',
    array(
        'label'    => __( 'Email Icon', 'shop-elite' ),
        'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
        'section'  => 'top_bar_options',
        'type'     => 'text',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
$wp_customize->add_setting(
    'theme_options[email_address]',
    array(
        'default'           => $default_options['email_address'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[email_address]',
    array(
        'label'    => __( 'Email Address', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'text',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
/*Enable MailTo*/
$wp_customize->add_setting(
    'theme_options[enable_mailto]',
    array(
        'default'           => $default_options['enable_mailto'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_mailto]',
    array(
        'label'    => __( 'Enable Mailto for email', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'checkbox',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);

/*Contact Number.*/
$wp_customize->add_setting(
    'theme_options[contact_icon]',
    array(
        'default'           => $default_options['contact_icon'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[contact_icon]',
    array(
        'label'    => __( 'Contact Icon', 'shop-elite' ),
        'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
        'section'  => 'top_bar_options',
        'type'     => 'text',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
$wp_customize->add_setting(
    'theme_options[contact_no]',
    array(
        'default'           => $default_options['contact_no'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[contact_no]',
    array(
        'label'    => __( 'Contact Number', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'text',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
/*Enable Call To attribute*/
$wp_customize->add_setting(
    'theme_options[enable_callto]',
    array(
        'default'           => $default_options['enable_callto'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_callto]',
    array(
        'label'    => __( 'Enable Callto for contact', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'checkbox',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
/*Hide Contact Info in mobile*/
$wp_customize->add_setting(
    'theme_options[hide_contact_info_mobile]',
    array(
        'default'           => $default_options['hide_contact_info_mobile'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[hide_contact_info_mobile]',
    array(
        'label'    => __( 'Hide contact & address info on mobile', 'shop-elite' ),
        'section'  => 'top_bar_options',
        'type'     => 'checkbox',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
/*Show Top Nav Menu*/
$wp_customize->add_setting(
    'theme_options[show_top_nav_menu]',
    array(
        'default'           => $default_options['show_top_nav_menu'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_top_nav_menu]',
    array(
        'label'    => __( 'Show Top Nav Menu', 'shop-elite' ),
        'description' => sprintf( __( 'You can add top nav menu from <a href="%s">here</a>.', 'shop-elite' ), "javascript:wp.customize.control( 'nav_menu_locations[topbar-menu]' ).focus();" ),
        'section'  => 'top_bar_options',
        'type'     => 'checkbox',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);

/*Show Social Nav Menu*/
$wp_customize->add_setting(
    'theme_options[show_social_nav_menu]',
    array(
        'default'           => $default_options['show_social_nav_menu'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_social_nav_menu]',
    array(
        'label'    => __( 'Show Social Nav Menu', 'shop-elite' ),
        'description' => sprintf( __( 'You can add social nav menu from <a href="%s">here</a>.', 'shop-elite' ), "javascript:wp.customize.control( 'nav_menu_locations[social-nav]' ).focus();" ),
        'section'  => 'top_bar_options',
        'type'     => 'checkbox',
        'active_callback' => 'shop_elite_is_top_bar_enabled',
    )
);
/* ========== Top Bar Section Close========== */

/* ========== Header Section ========== */
$wp_customize->add_section(
    'header_options' ,
    array(
        'title' => __( 'Header Options', 'shop-elite' ),
        'panel' => 'theme_option_panel',
    )
);

/*Enable Search Form*/
$wp_customize->add_setting(
    'theme_options[enable_search_form]',
    array(
        'default'           => $default_options['enable_search_form'],
        'sanitize_callback' => 'shop_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_search_form]',
    array(
        'label'    => __( 'Enable Search Form', 'shop-elite' ),
        'section'  => 'header_options',
        'type'     => 'checkbox',
    )
);

if(shop_elite_is_wishlist_active()){
    /* Enable wishlist */
    $wp_customize->add_setting(
        'theme_options[enable_header_wishlist]',
        array(
            'default'           => $default_options['enable_header_wishlist'],
            'sanitize_callback' => 'shop_elite_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'theme_options[enable_header_wishlist]',
        array(
            'label'    => __( 'Enable Wishlist Icon', 'shop-elite' ),
            'section'  => 'header_options',
            'type'     => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'theme_options[wishlist_icon]',
        array(
            'default'           => $default_options['wishlist_icon'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_options[wishlist_icon]',
        array(
            'label'    => __( 'Header Wishlist Icon', 'shop-elite' ),
            'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
            'section'  => 'header_options',
            'type'     => 'text',
            'active_callback' => 'shop_elite_is_wishlist_enabled',
        )
    );
}

if(shop_elite_is_wc_active()){
    /*Enable mini cart on primary navigation*/
    $wp_customize->add_setting(
        'theme_options[enable_header_mini_cart]',
        array(
            'default'           => $default_options['enable_header_mini_cart'],
            'sanitize_callback' => 'shop_elite_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'theme_options[enable_header_mini_cart]',
        array(
            'label'    => __( 'Enable Mini Cart', 'shop-elite' ),
            'section'  => 'header_options',
            'type'     => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'theme_options[mini_cart_icon]',
        array(
            'default'           => $default_options['mini_cart_icon'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_options[mini_cart_icon]',
        array(
            'label'    => __( 'Header Cart Icon', 'shop-elite' ),
            'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
            'section'  => 'header_options',
            'type'     => 'text',
            'active_callback' => 'shop_elite_is_mini_cart_enabled',
        )
    );
}

/* ========== Header Section Close========== */

/* ========== Layout Section ========== */
$wp_customize->add_section(
    'layout_options',
    array(
        'title'      => __( 'Layout Options', 'shop-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/* Global Layout*/
$wp_customize->add_setting(
    'theme_options[global_layout]',
    array(
        'default'           => $default_options['global_layout'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[global_layout]',
    array(
        'label'       => __( 'Global Layout', 'shop-elite' ),
        'section'     => 'layout_options',
        'type'        => 'select',
        'choices'     => array(
            'right-sidebar' => __( 'Right Sidebar', 'shop-elite' ),
            'left-sidebar' => __( 'Left Sidebar', 'shop-elite' ),
            'no-sidebar' => __( 'No Sidebar', 'shop-elite' )
        ),
    )
);
/* Image in Archive Page */
$wp_customize->add_setting(
    'theme_options[archive_image]',
    array(
        'default'           => $default_options['archive_image'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[archive_image]',
    array(
        'label'       => __( 'Image in Archive Page', 'shop-elite' ),
        'section'     => 'layout_options',
        'type'        => 'select',
        'choices'     => $image_sizes
    )
);

/* Image in Single Post*/
$wp_customize->add_setting(
    'theme_options[single_post_image]',
    array(
        'default'           => $default_options['single_post_image'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[single_post_image]',
    array(
        'label'       => __( 'Image in Single Posts', 'shop-elite' ),
        'section'     => 'layout_options',
        'type'        => 'select',
        'choices'     => $image_sizes
    )
);

/* Image in Single Page*/
$wp_customize->add_setting(
    'theme_options[single_page_image]',
    array(
        'default'           => $default_options['single_page_image'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[single_page_image]',
    array(
        'label'       => __( 'Image in Single Page', 'shop-elite' ),
        'section'     => 'layout_options',
        'type'        => 'select',
        'choices'     => $image_sizes
    )
);
/* ========== Layout Section Close ========== */

/* ========== Pagination Section ========== */
$wp_customize->add_section(
    'pagination_options',
    array(
        'title'      => __( 'Pagination Options', 'shop-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/*Pagination Type*/
$wp_customize->add_setting(
    'theme_options[pagination_type]',
    array(
        'default'           => $default_options['pagination_type'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[pagination_type]',
    array(
        'label'       => __( 'Pagination Type', 'shop-elite' ),
        'section'     => 'pagination_options',
        'type'        => 'select',
        'choices'     => array(
            'default' => __( 'Default (Older / Newer Post)', 'shop-elite' ),
            'numeric' => __( 'Numeric', 'shop-elite' ),
        ),
    )
);
/* ========== Pagination Section Close========== */

/* ========== Breadcrumb Section ========== */
$wp_customize->add_section(
    'breadcrumb_options',
    array(
        'title'      => __( 'Breadcrumb Options', 'shop-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/* Breadcrumb Type*/
$breadcrumb_choices = array(
    'disabled' => __( '&mdash; None &mdash;', 'shop-elite' ),
    'default' => __( 'Default', 'shop-elite' ),
);
if( shop_elite_is_wc_active() ){
    $breadcrumb_choices['wc'] = __( 'WooCommerce Breadcrumb', 'shop-elite' );
}
$wp_customize->add_setting(
    'theme_options[breadcrumb_type]',
    array(
        'default'           => $default_options['breadcrumb_type'],
        'sanitize_callback' => 'shop_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[breadcrumb_type]',
    array(
        'label'       => __( 'Breadcrumb Type', 'shop-elite' ),
        'section'     => 'breadcrumb_options',
        'type'        => 'select',
        'choices'     => $breadcrumb_choices
    )
);
/* ========== Breadcrumb Section Close ========== */

/* ========== Excerpt Section ========== */
$wp_customize->add_section(
    'excerpt_options',
    array(
        'title'      => __( 'Excerpt Options', 'shop-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/* Excerpt Length */
$wp_customize->add_setting(
    'theme_options[excerpt_length]',
    array(
        'default'           => $default_options['excerpt_length'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[excerpt_length]',
    array(
        'label'       => __( 'Excerpt Length', 'shop-elite' ),
        'section'     => 'excerpt_options',
        'type'        => 'number',
    )
);

/* Excerpt Read More Text */
$wp_customize->add_setting(
    'theme_options[excerpt_read_more_text]',
    array(
        'default'           => $default_options['excerpt_read_more_text'],
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    )
);
$wp_customize->add_control(
    'theme_options[excerpt_read_more_text]',
    array(
        'label'       => __( 'Read More Text', 'shop-elite' ),
        'section'     => 'excerpt_options',
        'type'        => 'text',
    )
);
/* ========== Excerpt Section Close ========== */

/* ========== Footer Section ========== */
$wp_customize->add_section(
    'footer_options' ,
    array(
        'title' => __( 'Footer Options', 'shop-elite' ),
        'panel' => 'theme_option_panel',
    )
);
/*Copyright Text.*/
$wp_customize->add_setting(
    'theme_options[copyright_text]',
    array(
        'default'           => $default_options['copyright_text'],
        'sanitize_callback' => 'sanitize_text_field',
        'transport'           => 'postMessage',
    )
);
$wp_customize->add_control(
    'theme_options[copyright_text]',
    array(
        'label'    => __( 'Copyright Text', 'shop-elite' ),
        'section'  => 'footer_options',
        'type'     => 'text',
    )
);
/* ========== Footer Section Close========== */

/* Add WooCommerce settings only if WooCommerce is active*/
if(shop_elite_is_wc_active()){
    /* ========== WooCommerce Shop Page Section ========== */
    $wp_customize->add_section(
        'woocommerce_shop_page_options' ,
        array(
            'title' => __( 'WooCommerce Shop/List Page Options', 'shop-elite' ),
            'panel' => 'theme_option_panel',
        )
    );
    /*Shop or archive page add to cart icon*/
    $wp_customize->add_setting(
        'theme_options[loop_cart_icon]',
        array(
            'default'           => $default_options['loop_cart_icon'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_options[loop_cart_icon]',
        array(
            'label'    => __( 'Add to Cart Icon', 'shop-elite' ),
            'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
            'section'  => 'woocommerce_shop_page_options',
            'type'     => 'text',
        )
    );
    /*Shop or archive page added to cart icon*/
    $wp_customize->add_setting(
        'theme_options[loop_added_to_cart_icon]',
        array(
            'default'           => $default_options['loop_added_to_cart_icon'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_options[loop_added_to_cart_icon]',
        array(
            'label'    => __( 'Added to Cart Icon', 'shop-elite' ),
            'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
            'section'  => 'woocommerce_shop_page_options',
            'type'     => 'text',
        )
    );
    /*Shop Page products per page*/
    $wp_customize->add_setting(
        'theme_options[shop_products_per_page]',
        array(
            'default'           => $default_options['shop_products_per_page'],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'theme_options[shop_products_per_page]',
        array(
            'label'    => __( 'Products Per Page', 'shop-elite' ),
            'section'  => 'woocommerce_shop_page_options',
            'type'     => 'number',
        )
    );
    /*Shop Page products per row.*/
    $wp_customize->add_setting(
        'theme_options[shop_products_per_row]',
        array(
            'default'           => $default_options['shop_products_per_row'],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'theme_options[shop_products_per_row]',
        array(
            'label'    => __( 'Products Per Row', 'shop-elite' ),
            'description' => __( 'Enter value between 1 - 6', 'shop-elite' ),
            'section'  => 'woocommerce_shop_page_options',
            'type'     => 'number',
            'input_attrs' => array(
                'min' => 1,
                'max' => 6,
            ),
        )
    );
    /* ========== WooCommerce Shop Page Section Close========== */

    /* ========== WooCommerce Product Page Section ========== */
    $wp_customize->add_section(
        'woocommerce_product_page_options' ,
        array(
            'title' => __( 'WooCommerce Product Page Options', 'shop-elite' ),
            'panel' => 'theme_option_panel',
        )
    );
    /*Product Page product gallery per row.*/
    $wp_customize->add_setting(
        'theme_options[product_thumbnails_per_row]',
        array(
            'default'           => $default_options['product_thumbnails_per_row'],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'theme_options[product_thumbnails_per_row]',
        array(
            'label'    => __( 'Single Product Thumbnails Per Row', 'shop-elite' ),
            'description'    => __( 'Enter value between 2 - 5', 'shop-elite' ),
            'section'  => 'woocommerce_product_page_options',
            'type'     => 'number',
            'input_attrs' => array(
                'min' => 2,
                'max' => 5,
            ),
        )
    );
    /*Show related products*/
    $wp_customize->add_setting(
        'theme_options[show_related_products]',
        array(
            'default'           => $default_options['show_related_products'],
            'sanitize_callback' => 'shop_elite_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'theme_options[show_related_products]',
        array(
            'label'    => __( 'Show related products', 'shop-elite' ),
            'section'  => 'woocommerce_product_page_options',
            'type'     => 'checkbox',
        )
    );
    /*Number of related products*/
    $wp_customize->add_setting(
        'theme_options[no_of_related_products]',
        array(
            'default'           => $default_options['no_of_related_products'],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'theme_options[no_of_related_products]',
        array(
            'label'    => __( 'Number of related products', 'shop-elite' ),
            'section'  => 'woocommerce_product_page_options',
            'type'     => 'number',
            'active_callback'  =>  'shop_elite_is_related_products_enabled'
        )
    );
    /*Related products per row*/
    $wp_customize->add_setting(
        'theme_options[related_products_per_row]',
        array(
            'default'           => $default_options['related_products_per_row'],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'theme_options[related_products_per_row]',
        array(
            'label'    => __( 'Related products per row', 'shop-elite' ),
            'description'    => __( 'Enter value between 1 - 6', 'shop-elite' ),
            'section'  => 'woocommerce_product_page_options',
            'type'     => 'number',
            'input_attrs' => array(
                'min' => 1,
                'max' => 6,
            ),
            'active_callback'  =>  'shop_elite_is_related_products_enabled'
        )
    );
    /* ========== WooCommerce Product Page Section Close========== */
}

/*Add Wishlist options only if yith wishlist is active*/
if( shop_elite_is_wishlist_active() ){
    $wp_customize->add_section(
        'wishlist_options' ,
        array(
            'title' => __( 'Wishlist Options', 'shop-elite' ),
            'panel' => 'theme_option_panel',
        )
    );
    /*Enable add to wishlist on product listings*/
    $wp_customize->add_setting(
        'theme_options[enable_wishlists_on_listings]',
        array(
            'default'           => $default_options['enable_wishlists_on_listings'],
            'sanitize_callback' => 'shop_elite_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'theme_options[enable_wishlists_on_listings]',
        array(
            'label'    => __( 'Enable Wishlist on Product Listings', 'shop-elite' ),
            'section'  => 'wishlist_options',
            'type'     => 'checkbox',
        )
    );
    /*Wishlist Archive Icon*/
    $wp_customize->add_setting(
        'theme_options[add_to_wishlist_icon]',
        array(
            'default'           => $default_options['add_to_wishlist_icon'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_options[add_to_wishlist_icon]',
        array(
            'label'    => __( 'Add to Wishlist Icon', 'shop-elite' ),
            'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
            'section'  => 'wishlist_options',
            'type'     => 'text',
            'active_callback'  =>  'shop_elite_is_wishlist_enabled_on_listings'
        )
    );
    /*In Wishlist Icon*/
    $wp_customize->add_setting(
        'theme_options[already_in_wishlist_icon]',
        array(
            'default'           => $default_options['already_in_wishlist_icon'],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_options[already_in_wishlist_icon]',
        array(
            'label'    => __( 'Already In Wishlist Icon', 'shop-elite' ),
            'description' => sprintf( wp_kses( __( 'Supports <a href="%s" target="_blank">Ionicons</a>.', 'shop-elite' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://ionicons.com/v2/cheatsheet.html' ) ),
            'section'  => 'wishlist_options',
            'type'     => 'text',
            'active_callback'  =>  'shop_elite_is_wishlist_enabled_on_listings'
        )
    );
}