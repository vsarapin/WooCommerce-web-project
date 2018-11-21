<?php

if (!defined('ABSPATH')) {
    exit;
}

class Shop_Elite_Posts_Listings extends Shop_Elite_Widget_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->widget_cssclass = 'shop_elite widget_post_listings';
        $this->widget_description = __("Displays default posts", 'shop-elite');
        $this->widget_id = 'shop_elite_posts_listings';
        $this->widget_name = __('SE: Posts Listings', 'shop-elite');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'shop-elite'),
            ),
            'desc'  => array(
                'type'  => 'text',
                'label' => __( 'Description', 'shop-elite' ),
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 3,
                'label' => __('Number of posts to show', 'shop-elite'),
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => __('Order by', 'shop-elite'),
                'options' => array(
                    'date' => __('Date', 'shop-elite'),
                    'id' => __('ID', 'shop-elite'),
                    'title' => __('Title', 'shop-elite'),
                    'rand' => __('Random', 'shop-elite'),
                ),
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'desc',
                'label' => __('Order', 'shop-elite'),
                'options' => array(
                    'asc' => __('ASC', 'shop-elite'),
                    'desc' => __('DESC', 'shop-elite'),
                ),
            ),
            'category' => array(
                'type' => 'dropdown-taxonomies',
                'label' => __('Select Category', 'shop-elite'),
                'desc' => __('Leave empty if you don\'t want the posts to be category specific', 'shop-elite'),
                'args' => array(
                    'taxonomy' => 'category',
                    'class' => 'widefat',
                    'hierarchical' => true,
                    'show_count' => 1,
                    'show_option_all' => __('&mdash; Select &mdash;', 'shop-elite'),
                ),
            ),
            'show_category_desc' => array(
                'type' => 'checkbox',
                'std' => 1,
                'label' => __('Show category description', 'shop-elite'),
            ),
            'category_desc_msg' => array(
                'type' => 'subtitle',
                'label' => __('Will override the Widget Description field', 'shop-elite'),
            ),
            'excerpt_length' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 0,
                'max' => '',
                'std' => 10,
                'label' => __('Excerpt Length', 'shop-elite'),
                'desc' => __('Enter 0 if you don\'t want to show the excerpt ', 'shop-elite'),
            ),
            'center_align_text' => array(
                'type' => 'checkbox',
                'label' => __('Center Align Text', 'shop-elite'),
            ),
            'show_date' => array(
                'type' => 'checkbox',
                'label' => __('Show Published Date', 'shop-elite'),
                'std' => 1,
            ),
            'show_author' => array(
                'type' => 'checkbox',
                'label' => __('Show Author', 'shop-elite'),
                'std' => 1,
            ),
            'enable_slider' => array(
                'type' => 'checkbox',
                'label' => __('Enable Slider', 'shop-elite'),
            ),
        );

        parent::__construct();
    }

    /**
     * Query the posts and return them.
     * @param  array $args
     * @param  array $instance
     * @return WP_Query
     */
    public function get_posts($args, $instance)
    {
        $number = !empty($instance['number']) ? absint($instance['number']) : $this->settings['number']['std'];
        $orderby = !empty($instance['orderby']) ? sanitize_title($instance['orderby']) : $this->settings['orderby']['std'];
        $order = !empty($instance['order']) ? sanitize_title($instance['order']) : $this->settings['order']['std'];

        $query_args = array(
            'posts_per_page' => $number,
            'post_status' => 'publish',
            'no_found_rows' => 1,
            'order' => $order,
        );

        if (!empty($instance['category']) && -1 != $instance['category'] && 0 != $instance['category']) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $instance['category'],
            );
        }

        switch ($orderby) {
            case 'id' :
                $query_args['orderby'] = 'ID';
                break;
            case 'title' :
                $query_args['orderby'] = 'title';
                break;
            case 'rand' :
                $query_args['orderby'] = 'rand';
                break;
            default :
                $query_args['orderby'] = 'date';
        }

        return new WP_Query(apply_filters('shop_elite_posts_widget_query_args', $query_args));
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

        if (($posts = $this->get_posts($args, $instance)) && $posts->have_posts()) {
            $this->widget_start($args, $instance);

            if ( $instance['desc'] && $instance['show_category_desc'] == 0 ) {
                ?>
                <div class="divider"></div>
                <div class="saga-desc-wrapper">
                    <?php echo wpautop(wp_kses_post($instance['desc']));?>
                </div>
                <?php
            }

            if ($instance['show_category_desc'] && 0 != $instance['category'] && 1 != $instance['category']) {
                echo wp_kses_post(term_description($instance['category']));
            }

            $class = 'slider-disabled';
            if($instance['enable_slider'] == 1){
                $class = 'slider-enabled';
            }
            if($instance['center_align_text'] == 1){
                $class .= ' text-center';
            }

            echo wp_kses_post(apply_filters('shop_elite_before_widget_post_list', '<div class="shop_elite_post_widget '.esc_attr($class).'">'));

            while ($posts->have_posts()) {
                $posts->the_post();
                ?>
                <div class="article-block-wrapper">
                    <div class="entry-image">
                        <?php
                        $class = 'data-bg';
                        $image = '';

                        if (has_post_thumbnail()) {
                            $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'shop-elite-medium');
                            if ($image_attributes) {
                                $class = 'bg-image';
                                $image = '<img src="'.esc_url($image_attributes[0]).'"/>';
                            }
                        }
                        ?>
                        <a href="<?php the_permalink() ?>>" class="<?php echo esc_attr($class);?> bg-image-1 bg-color">
                            <?php echo wp_kses_post($image);?>
                        </a>
                    </div>
                    <div class="article-details">
                        <h3 class="entry-title">
                            <a href="<?php the_permalink() ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <div class="entry-meta">
                        <?php
                        if ($instance['show_date']) {
                            shop_elite_posted_on();
                        }
                        if ($instance['show_author']) {
                            ?>
                            <span class="author">
                                <i class="ion-ios-person-outline saga-icon"></i>
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>">
                                    <?php echo esc_html(get_the_author()) ?>
                                </a>
                            </span>
                            <?php
                        }
                        ?>
                        </div>

                        <div class="entry-caption">
                            <?php
                            if ($instance['excerpt_length'] > 0) {
                                $content = wp_trim_words( get_the_content(), $instance['excerpt_length'], '...' );
                                echo apply_filters( 'the_content', $content );
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <?php
            }

            echo wp_kses_post(apply_filters('shop_elite_after_widget_post_list', '</div>'));

            $this->widget_end($args);
        }

        wp_reset_postdata();

        echo ob_get_clean();

    }
}