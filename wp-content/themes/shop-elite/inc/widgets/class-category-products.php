<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shop_Elite_Category_Products extends Shop_Elite_Widget_Base {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'shop_elite widget_category_products';
        $this->widget_description = __( "Displays products of a particular category", 'shop-elite' );
        $this->widget_id          = 'shop_elite_category_products';
        $this->widget_name        = __( 'SE: Woo Category Products', 'shop-elite' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'label' => __( 'Title', 'shop-elite' ),
            ),
            'desc'  => array(
                'type'  => 'text',
                'label' => __( 'Description', 'shop-elite' ),
            ),
            'category'  => array(
                'type'  => 'dropdown-taxonomies',
                'label' => __( 'Select Category', 'shop-elite' ),
                'desc' => __( 'Leave empty if you don\'t want the products to be category specific', 'shop-elite' ),
                'args' => array(
                    'taxonomy' => 'product_cat',
                    'class' => 'widefat',
                    'hierarchical' => true,
                    'show_count' => 1,
                    'show_option_all' => __( '&mdash; Select &mdash;' , 'shop-elite'),
                ),
            ),
            'number' => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 4,
                'label' => __( 'Number of products to show', 'shop-elite' ),
            ),
            'orderby' => array(
                'type'  => 'select',
                'std'   => 'date',
                'label' => __( 'Order by', 'shop-elite' ),
                'options' => array(
                    'date'   => __( 'Date', 'shop-elite' ),
                    'price'  => __( 'Price', 'shop-elite' ),
                    'rand'   => __( 'Random', 'shop-elite' ),
                    'sales'  => __( 'Sales', 'shop-elite' ),
                ),
            ),
            'order' => array(
                'type'  => 'select',
                'std'   => 'desc',
                'label' => _x( 'Order', 'Sorting order', 'shop-elite' ),
                'options' => array(
                    'asc'  => __( 'ASC', 'shop-elite' ),
                    'desc' => __( 'DESC', 'shop-elite' ),
                ),
            ),
            'show_category_desc' => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => __( 'Show category description', 'shop-elite' ),
            ),
            'category_desc_msg' => array(
                'type'  => 'subtitle',
                'label' => __( 'Will override the Widget Description field', 'shop-elite' ),
            ),
            'hide_free' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Hide free products', 'shop-elite' ),
            ),
            'show_hidden' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show hidden products', 'shop-elite' ),
                'separator'   => true,
            ),
            'enable_slider' => array(
                'type' => 'checkbox',
                'label' => __('Enable Slider', 'shop-elite'),
            ),
        );
        parent::__construct();
    }

    /**
     * Query the products and return them.
     * @param  array $args
     * @param  array $instance
     * @return WP_Query
     */
    public function get_products( $args, $instance ) {
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
        $orderby = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
        $order = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];
        $product_visibility_term_ids = wc_get_product_visibility_term_ids();

        $query_args = array(
            'posts_per_page' => $number,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'no_found_rows'  => 1,
            'order'          => $order,
            'meta_query'     => array(),
            'tax_query'      => array(
                'relation' => 'AND',
            ),
        );

        if ( empty( $instance['show_hidden'] ) ) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
                'operator' => 'NOT IN',
            );
            $query_args['post_parent']  = 0;
        }

        if ( ! empty( $instance['hide_free'] ) ) {
            $query_args['meta_query'][] = array(
                'key'     => '_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'DECIMAL',
            );
        }

        if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['outofstock'],
                    'operator' => 'NOT IN',
                ),
            );
        }

        if( !empty( $instance['category'] ) && -1 != $instance['category'] && 0 != $instance['category'] ){
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $instance['category'],
            );
        }

        switch ( $orderby ) {
            case 'price' :
                $query_args['meta_key'] = '_price';
                $query_args['orderby']  = 'meta_value_num';
                break;
            case 'rand' :
                $query_args['orderby']  = 'rand';
                break;
            case 'sales' :
                $query_args['meta_key'] = 'total_sales';
                $query_args['orderby']  = 'meta_value_num';
                break;
            default :
                $query_args['orderby']  = 'date';
        }

        return new WP_Query( apply_filters( 'shop_elite_category_products_widget_query_args', $query_args ) );
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        ob_start();

        if ( ( $products = $this->get_products( $args, $instance ) ) && $products->have_posts() ) {
            $this->widget_start( $args, $instance );

            if ($instance['desc'] && $instance['show_category_desc'] == 0 ) {
                ?>
                <div class="divider"></div>
                <div class="saga-desc-wrapper">
                    <?php echo wpautop(wp_kses_post($instance['desc']));?>
                </div>
                <?php
            }

            if( $instance['show_category_desc'] && 0 != $instance['category'] && 1 != $instance['category'] ){
                ?>
                <div class="divider"></div>
                <div class="saga-desc-wrapper">
                    <?php echo wp_kses_post(term_description( $instance['category'] ));?>
                </div>
                <?php
            }

            $class = 'slider-disabled';
            if($instance['enable_slider'] == 1){
                $class = 'slider-enabled';
            }

            echo wp_kses_post( apply_filters( 'shop_elite_before_widget_category_products_list', '<ul class="shop_elite_cat_products_widget '.esc_attr($class).'">' ) );

            while ( $products->have_posts() ) {
                $products->the_post();
                wc_get_template_part( 'content', 'product' );
            }

            echo wp_kses_post( apply_filters( 'shop_elite_after_widget_category_products_list', '</ul>' ) );

            $this->widget_end( $args );
        }

        wp_reset_postdata();

        echo ob_get_clean();
    }
}