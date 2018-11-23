<?php

/* Check if is WooCommerce is active */
if ( ! function_exists( 'shop_elite_is_wc_active' ) ) :

    /**
     * Check WooCommerce Status
     *
     * @since 1.0.0
     *
     * return boolean true/false
     */
    function shop_elite_is_wc_active() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }

endif;

/* Check if is Yith Wishlist is active */
if ( ! function_exists( 'shop_elite_is_wishlist_active' ) ) :

    /**
     * Check Yith Wishlist Status
     *
     * @since 1.0.0
     *
     * return boolean true/false
     */
    function shop_elite_is_wishlist_active() {
        return class_exists( 'YITH_WCWL' ) ? true : false;
    }

endif;

/* Change default excerpt length */
if ( ! function_exists( 'shop_elite_excerpt_length' ) ) :

    /**
     * Change excerpt Length.
     *
     * @since 1.0.0
     */
    function shop_elite_excerpt_length($excerpt_length) {
        if( is_admin() && !wp_doing_ajax() ){
            return $excerpt_length;
        }
        $excerpt_length = shop_elite_get_option('excerpt_length',true);
        return absint($excerpt_length);
    }

endif;
add_filter( 'excerpt_length', 'shop_elite_excerpt_length', 999 );

/* Modify Excerpt Read More text */
if ( ! function_exists( 'shop_elite_excerpt_more' ) ) :

    /**
     * Modify Excerpt Read More text.
     *
     * @since 1.0.0
     */
    function shop_elite_excerpt_more($more) {
        if(is_admin()){
            return $more;
        }
        global $post;
        $excerpt_read_more_text = shop_elite_get_option('excerpt_read_more_text',true);
        return '<a class="main-btn main-btn-primary main-btn-small moretag" href="'. esc_url(get_permalink($post->ID)) . '"> '.esc_html($excerpt_read_more_text).'</a>';
    }

endif;
add_filter('excerpt_more', 'shop_elite_excerpt_more');

/* Get Page layout */
if ( ! function_exists( 'shop_elite_get_page_layout' ) ) :

    /**
     * Get Page Layout based on the post meta or customizer value
     *
     * @since 1.0.0
     *
     * @return string Page Layout.
     */
    function shop_elite_get_page_layout() {
        global $post;
        $page_layout = '';

        /*Fetch for homepage*/
        if( is_front_page() && is_home()){
            $page_layout = shop_elite_get_option('home_page_layout',true);
            return $page_layout;
        }elseif ( is_front_page() ) {
            $page_layout = shop_elite_get_option('home_page_layout',true);
            return $page_layout;
        }elseif ( is_home() ) {
            $page_layout_meta = get_post_meta( get_option( 'page_for_posts' ), 'shop_elite_page_layout', true );
            if(!empty($page_layout_meta)){
                return $page_layout_meta;
            }else{
                return $page_layout;
            }
        }
        /**/

        /*Fetch from Post Meta*/
        if ( $post && is_singular() ) {
            $page_layout = get_post_meta( $post->ID, 'shop_elite_page_layout', true );
        }
        /*Fetch from customizer*/
        if(empty($page_layout)){
            $page_layout = shop_elite_get_option('global_layout',true);
        }
        return $page_layout;
    }

endif;

/* Get Image Option */
if ( ! function_exists( 'shop_elite_get_image_option' ) ) :

    /**
     * Get Image Option on the post meta or customizer value
     *
     * @since 1.0.0
     *
     * @return string Image Option.
     */
    function shop_elite_get_image_option() {
        global $post;

        if ( $post && is_singular() ) {
            /*Fetch from Post Meta*/
            $image_option = get_post_meta( $post->ID, 'shop_elite_single_image', true );
            /*Fetch from customizer*/
            if( empty($image_option) ){
                if( is_single() ){
                    $image_option = shop_elite_get_option('single_post_image',true);
                }
                if( is_page() ){
                    $image_option = shop_elite_get_option('single_page_image',true);
                }
            }
        }else{
            /*Fetch from customizer for archive*/
            $image_option = shop_elite_get_option('archive_image',true);
        }

        return $image_option;
    }

endif;

if ( ! function_exists( 'shop_elite_get_all_image_sizes' ) ) :
    /**
     * Returns all image sizes available.
     *
     * @since 1.0.0
     *
     * @param bool $for_choice True/False to construct the output as key and value choice
     * @return array Image Size Array.
     */
    function shop_elite_get_all_image_sizes( $for_choice = false ) {

        global $_wp_additional_image_sizes;

        $sizes = array();

        if( true == $for_choice ){
            $sizes['no-image'] = __( 'No Image', 'shop-elite' );
        }

        foreach ( get_intermediate_image_sizes() as $_size ) {
            if ( in_array( $_size, array('thumbnail', 'medium', 'large') ) ) {

                $width = get_option( "{$_size}_size_w" );
                $height = get_option( "{$_size}_size_h" );

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ]['width']  = $width;
                    $sizes[ $_size ]['height'] = $height;
                    $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
                }
            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                $width = $_wp_additional_image_sizes[ $_size ]['width'];
                $height = $_wp_additional_image_sizes[ $_size ]['height'];

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ] = array(
                        'width'  => $width,
                        'height' => $height,
                        'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
                    );
                }
            }
        }

        if( true == $for_choice ){
            $sizes['full'] = __( 'Full Image', 'shop-elite' );
        }

        return $sizes;
    }
endif;

/* Display Product search form with categories*/
if ( ! function_exists( 'shop_elite_product_search_form' ) ) :
    /**
     * Display Product search form with categories
     *
     * @since 1.0.0
     *
     * @return void
     */
    function shop_elite_product_search_form(){
        ?>
        <form role="search" method="get" class="form-inline woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php
            $product_cats = get_terms(array(
                'taxonomy' => 'product_cat',
            ));
            if (!empty($product_cats) && !is_wp_error($product_cats)):
                $selected_product_cat = get_query_var( 'product_cat' );
                ?>
            <?php endif; ?>
            <div class="form-group">
                <label class="screen-reader-text" for="woocommerce-product-search-field"><?php esc_html_e( 'Search for:', 'shop-elite' ); ?></label>
                <input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'shop-elite' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            </div>
            <button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'shop-elite' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'shop-elite' ); ?></button>
            <input type="hidden" name="post_type" value="product" />
        </form>
        <?php
    }
endif;
