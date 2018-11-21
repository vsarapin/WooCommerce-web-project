<?php
/**
 * Recommended plugins
 *
 * @package shop-elite
 */
if ( ! function_exists( 'shop_elite_recommended_plugins' ) ) :
	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function shop_elite_recommended_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'One Click Demo Import', 'shop-elite' ),
				'slug'     => 'one-click-demo-import',
				'required' => false,
			),
            array(
                'name'     => esc_html__( 'Woocommerce', 'shop-elite' ),
                'slug'     => 'woocommerce',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'YITH WooCommerce Wishlist', 'shop-elite' ),
                'slug'     => 'yith-woocommerce-wishlist',
                'required' => false,
            )
		);
		tgmpa( $plugins );
	}
endif;
add_action( 'tgmpa_register', 'shop_elite_recommended_plugins' );
