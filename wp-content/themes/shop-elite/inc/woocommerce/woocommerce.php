<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Shop_Elite
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function shop_elite_woocommerce_setup()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'shop_elite_woocommerce_setup');

if (!function_exists('shop_elite_remove_wc_breadcrumbs')) {
    /**
     * Removes Default WooCommerce breadcrumb.
     *
     * @return  void
     */
    function shop_elite_remove_wc_breadcrumbs()
    {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    }
}
add_action('init', 'shop_elite_remove_wc_breadcrumbs');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function shop_elite_woocommerce_scripts()
{
    wp_enqueue_style('shop-elite-woocommerce-style', get_template_directory_uri() . '/woocommerce.css');

    $font_path = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

    wp_add_inline_style('shop-elite-woocommerce-style', $inline_font);
}

add_action('wp_enqueue_scripts', 'shop_elite_woocommerce_scripts');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function shop_elite_woocommerce_active_body_class($classes)
{
    $classes[] = 'woocommerce-active';

    return $classes;
}

add_filter('body_class', 'shop_elite_woocommerce_active_body_class');

/*Products Per Page*/
if (!function_exists('shop_elite_woocommerce_products_per_page')) :
    /**
     * Products per page.
     *
     * @return integer number of products.
     */
    function shop_elite_woocommerce_products_per_page()
    {
        $products_per_page = shop_elite_get_option('shop_products_per_page', true);
        return absint($products_per_page);
    }
endif;
add_filter('loop_shop_per_page', 'shop_elite_woocommerce_products_per_page');

/*Product gallery thumbnail columns.*/
if (!function_exists('shop_elite_woocommerce_thumbnail_columns')) :
    /**
     * Product gallery thumbnail columns.
     *
     * @return integer number of columns.
     */
    function shop_elite_woocommerce_thumbnail_columns($product_thumbnails_per_row)
    {
        $product_thumbnails_per_row = shop_elite_get_option('product_thumbnails_per_row', true);
        return absint($product_thumbnails_per_row);
    }
endif;
add_filter('woocommerce_product_thumbnails_columns', 'shop_elite_woocommerce_thumbnail_columns');

/*Products per row*/
if (!function_exists('shop_elite_woocommerce_loop_columns')) :
    /**
     * Default loop columns on product archives.
     *
     * @return integer products per row.
     */
    function shop_elite_woocommerce_loop_columns()
    {
        $products_per_row = shop_elite_get_option('shop_products_per_row', true);
        if ($products_per_row < 1 || $products_per_row > 6) {
            return 4;
        } else {
            return absint($products_per_row);
        }
    }
endif;
add_filter('loop_shop_columns', 'shop_elite_woocommerce_loop_columns');


/*Show related products*/
$show_related_products = shop_elite_get_option('show_related_products', true);
if (!$show_related_products) {
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}
/**/

/*Related Products Args.*/
if (!function_exists('shop_elite_woocommerce_related_products_args')) :
    /**
     * Related Products Args.
     *
     * @param array $args related products args.
     * @return array $args related products args.
     */
    function shop_elite_woocommerce_related_products_args($args)
    {
        $no_of_related_products = absint(shop_elite_get_option('no_of_related_products', true));
        $related_products_per_row = absint(shop_elite_get_option('related_products_per_row', true));
        $defaults = array(
            'posts_per_page' => $no_of_related_products,
            'columns' => $related_products_per_row,
        );

        $args = wp_parse_args($defaults, $args);

        return $args;
    }
endif;
add_filter('woocommerce_output_related_products_args', 'shop_elite_woocommerce_related_products_args');
/**/

if (!function_exists('shop_elite_woocommerce_product_columns_wrapper')) {
    /**
     * Product columns wrapper.
     *
     * @return  void
     */
    function shop_elite_woocommerce_product_columns_wrapper()
    {
        $columns = shop_elite_woocommerce_loop_columns();
        echo '<div class="columns-' . absint($columns) . '">';
    }
}
add_action('woocommerce_before_shop_loop', 'shop_elite_woocommerce_product_columns_wrapper', 40);

if (!function_exists('shop_elite_woocommerce_product_columns_wrapper_close')) {
    /**
     * Product columns wrapper close.
     *
     * @return  void
     */
    function shop_elite_woocommerce_product_columns_wrapper_close()
    {
        echo '</div>';
    }
}
add_action('woocommerce_after_shop_loop', 'shop_elite_woocommerce_product_columns_wrapper_close', 40);

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('shop_elite_woocommerce_wrapper_before')) {
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function shop_elite_woocommerce_wrapper_before()
    {
        ?>
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
    }
}
add_action('woocommerce_before_main_content', 'shop_elite_woocommerce_wrapper_before');

if (!function_exists('shop_elite_woocommerce_wrapper_after')) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function shop_elite_woocommerce_wrapper_after()
    {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php
    }
}
add_action('woocommerce_after_main_content', 'shop_elite_woocommerce_wrapper_after');

if (!function_exists('shop_elite_woocommerce_cart_link_fragment')) {
    /**
     * Cart Fragments.
     *
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param array $fragments Fragments to refresh via AJAX.
     * @return array Fragments to refresh via AJAX.
     */
    function shop_elite_woocommerce_cart_link_fragment($fragments)
    {
        ob_start();
        shop_elite_woocommerce_cart_link();
        $fragments['a.saga-mincart-trigger'] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'shop_elite_woocommerce_cart_link_fragment');

if (!function_exists('shop_elite_woocommerce_cart_link')) {
    /**
     * Cart Link.
     *
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @return void
     */
    function shop_elite_woocommerce_cart_link()
    {
        ?>
        <a class="saga-mincart-trigger" href="javascript:void(0)">
            <?php
            $cart_icon = shop_elite_get_option('mini_cart_icon', true);
            if ($cart_icon) {
                echo '<i class="' . esc_attr($cart_icon) . '"></i>';
            }
            ?>
            <span class="saga-woo-counter"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('shop_elite_woocommerce_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function shop_elite_woocommerce_header_cart()
    {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <div class="saga-minicart saga-woo-nav">
            <div class="saga-wooicon <?php echo esc_attr($class); ?>">
                <?php shop_elite_woocommerce_cart_link(); ?>
            </div>
            <div class="saga-mincart-items">
                <?php
                $instance = array(
                    'title' => '',
                );
                the_widget('WC_Widget_Cart', $instance);
                ?>
            </div>
        </div>
        <?php
    }
}

/*Change product gallery thumbnail image size*/
add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
    return 'woocommerce_thumbnail';
} );

/*============= For product Listing pages ==================== */

/*Open wrapper for image section*/
if (!function_exists('shop_elite_product_img_section_wrap_start')):
    function shop_elite_product_img_section_wrap_start()
    {
        echo '<div class="saga-product-wrapper">';
    }
endif;
add_action('woocommerce_before_shop_loop_item', 'shop_elite_product_img_section_wrap_start', 8);

/*Open wrapper for image info*/
if (!function_exists('shop_elite_product_img_info_wrap_start')):
    function shop_elite_product_img_info_wrap_start(){
        echo '<div class="saga-product-image">';
    }
endif;
add_action('woocommerce_before_shop_loop_item', 'shop_elite_product_img_info_wrap_start', 9);

/* Remove anchor tag for the image*/
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

/*Open wrapper for image info*/
if (!function_exists('shop_elite_product_img_info_wrap_end')):
    function shop_elite_product_img_info_wrap_end(){
        echo '</div>';
    }
endif;
add_action('woocommerce_before_shop_loop_item_title', 'shop_elite_product_img_info_wrap_end', 11);

/*Open wrapper for the product buttons*/
if (!function_exists('shop_elite_product_btn_wrap_start')):
    function shop_elite_product_btn_wrap_start(){
        echo '<div class="saga-product-buttons">';
    }
endif;
add_action('woocommerce_before_shop_loop_item_title', 'shop_elite_product_btn_wrap_start', 12);
/**/

/*Add wrapper for add to cart btn*/
if (!function_exists('shop_elite_product_cart_wrap_start')):
    function shop_elite_product_cart_wrap_start(){
        echo '<div class="cart-btn">';
    }
endif;
add_action('woocommerce_before_shop_loop_item_title', 'shop_elite_product_cart_wrap_start', 13);

/*Move add to cart button position to below the image*/
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 14);
/**/

/*Close wrapper for add to cart btn*/
if (!function_exists('shop_elite_product_cart_wrap_end')):
    function shop_elite_product_cart_wrap_end(){
        echo '</div>';
    }
endif;
add_action('woocommerce_before_shop_loop_item_title', 'shop_elite_product_cart_wrap_end', 15);

/*Yith wihslit btn is bind on priority 16*/

/*Close wrapper for the product buttons*/
if (!function_exists('shop_elite_product_btn_wrap_end')):
    function shop_elite_product_btn_wrap_end(){
        echo '</div>';
    }
endif;
add_action('woocommerce_before_shop_loop_item_title', 'shop_elite_product_btn_wrap_end', 17);
/**/

/*Close wrapper for the image section*/
if (!function_exists('shop_elite_product_img_section_wrap_end')):
    function shop_elite_product_img_section_wrap_end(){
        echo '</div>';
    }
endif;
add_action('woocommerce_before_shop_loop_item_title', 'shop_elite_product_img_section_wrap_end', 18);
/**/

/*Open wrapper for the remaining info of the product*/
if (!function_exists('shop_elite_product_info_wrap_start')):
    function shop_elite_product_info_wrap_start(){
        echo '<div class="saga-product-details">';
    }
endif;
add_action('woocommerce_shop_loop_item_title', 'shop_elite_product_info_wrap_start', 8);

/*Open anchor tag for the remaining info of the product*/
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9);

/*Close wrapper for the remaining info of the product*/
if (!function_exists('shop_elite_product_info_wrap_end')):
    function shop_elite_product_info_wrap_end(){
        echo '</div>';
    }
endif;
add_action('woocommerce_after_shop_loop_item', 'shop_elite_product_info_wrap_end', 20);

/*Change add to cart button for archive products*/
if (!function_exists('shop_elite_change_loop_add_to_cart')){
    function shop_elite_change_loop_add_to_cart( $html, $product, $args ){

        /*Return html as it is if we're in wishlist page*/
        if (shop_elite_is_wishlist_active()){
            $wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
            $current_page_id = get_queried_object_id();
            if($wishlist_page_id){
                if($current_page_id == $wishlist_page_id){
                    return $html;
                }
            }
        }
        /**/

        /*Add Cart Icon*/
        $add_to_cart_icon = shop_elite_get_option('loop_cart_icon', true);
        if( $add_to_cart_icon ){
            $add_to_cart = '<i class="' . esc_attr($add_to_cart_icon). ' add-icon saga-alt-icon"></i>';
        }else{
            $add_to_cart = '<i class="ion-ios-cart-outline add-icon saga-alt-icon"></i>';
        }
        /**/

        /*Added to Cart Icon*/
        $added_to_cart_icon = shop_elite_get_option('loop_added_to_cart_icon', true);
        if( $added_to_cart_icon ){
            $added_to_cart = '<i class="' . esc_attr($added_to_cart_icon). ' saga-alt-icon added-icon hidden"></i>';
        }else{
            $added_to_cart = '<i class="ion-ios-cart saga-alt-icon added-icon hidden"></i>';
        }
        /**/

        $html = sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            $add_to_cart.$added_to_cart
        );

        /*Add Tooltip*/
        $tooltip_start = '<div data-toggle="tooltip" data-placement="top" title="'.$product->add_to_cart_text().'">';
        $tooltip_end = '</div>';
        return $tooltip_start.$html.$tooltip_end;
    }
}
add_filter('woocommerce_loop_add_to_cart_link', 'shop_elite_change_loop_add_to_cart', 10, 3 );

/*Add product added to cart message to fragment data*/
if (!function_exists('shop_elite_add_to_cart_fragments')){
    function shop_elite_add_to_cart_fragments($data) {
        $product = isset( $_REQUEST['product_id'] ) ? wc_get_product( $_REQUEST['product_id'] ) : false;
        $product_image = $product_title = '' ;

        if( $product ){
            $product_image = $product->get_image();
            $product_title = sprintf(__('%s has been added to your cart.', 'shop-elite'), '<strong>'.$product->get_title().'</strong>');
        }else{
            $product_title =  __( 'Product Added to cart', 'shop-elite' );
        }

        ob_start();
        ?>
        <div class="saga-notification-header">
            <h3><?php _e('Cart Items', 'shop-elite')?></h3>
        </div>
        <div class="saga-notification">
            <div class="saga-notification-image">
                <?php echo $product_image;?>
            </div>
            <div class="saga-notification-title">
                <?php echo $product_title;?>
            </div>
        </div>
        <div class="saga-notification-button">
            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' )) );?>">
                <?php _e('View Cart', 'shop-elite');?>
            </a>
        </div>

        <?php
        $data['shop_elite_added_to_cart_msg'] = ob_get_clean();

        return $data;
    }
}
add_filter( 'woocommerce_add_to_cart_fragments', 'shop_elite_add_to_cart_fragments' );
/* ============================================= */

