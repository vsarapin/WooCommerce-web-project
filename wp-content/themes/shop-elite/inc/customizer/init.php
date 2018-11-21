<?php
/**
 * Shop Elite Theme Customizer
 *
 * @package Shop_Elite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_elite_customize_register( $wp_customize ) {

    /*Load custom controls for customizer.*/
    require get_template_directory() . '/inc/customizer/controls.php';

    /*Load sanitization functions.*/
    require get_template_directory() . '/inc/customizer/sanitize.php';

    /*Load customize callback.*/
    require get_template_directory() . '/inc/customizer/callback.php';

    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'shop_elite_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'shop_elite_customize_partial_blogdescription',
        ) );
    }

    /*Load customizer options.*/
    require get_template_directory() . '/inc/customizer/options.php';

    /*Register custom section and control types.*/
    $wp_customize->register_section_type( 'Shop_Elite_Customize_Section_Upsell' );

    /*Register sections.*/
    $wp_customize->add_section(
        new Shop_Elite_Customize_Section_Upsell(
            $wp_customize,
            'theme_upsell',
            array(
                'title'    => esc_html__( 'Shop Elite Pro', 'shop-elite' ),
                'pro_text' => esc_html__( 'Buy Pro', 'shop-elite' ),
                'pro_url'  => 'https://themesaga.com/theme/shop-elite-pro/',
                'priority'  => 1,
            )
        )
    );

}
add_action( 'customize_register', 'shop_elite_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function shop_elite_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function shop_elite_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function shop_elite_customize_preview_js() {
    wp_enqueue_script( 'shop-elite-customizer', get_template_directory_uri() . '/assets/saga/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'shop_elite_customize_preview_js' );

/**
 * Customizer control scripts and styles.
 *
 * @since 1.0.0
 */
function shop_elite_customizer_control_scripts(){
    wp_enqueue_style('shop-elite-customizer-css', get_template_directory_uri() . '/assets/saga/css/customizer.css');
    wp_enqueue_script('shop-elite-customizer-controls', get_template_directory_uri() . '/assets/saga/js/customizer-admin.js', array('customize-controls'));
}
add_action('customize_controls_enqueue_scripts', 'shop_elite_customizer_control_scripts', 0);