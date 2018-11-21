<?php

if (!defined('ABSPATH')) {
    exit;
}

class Shop_Elite_Product_Categories extends Shop_Elite_Widget_Base
{

    /**
     * Product Categories
     *
     * @var array
     */
    public $product_categories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->widget_cssclass = 'shop_elite widget_product_categories';
        $this->widget_description = __("Displays WooCommerce product Categories", 'shop-elite');
        $this->widget_id = 'shop_elite_product_categories';
        $this->widget_name = __('SE: Woo Category', 'shop-elite');

        /*Needs to initialize settings in init for get_terms() to work*/
        add_action('init', array($this, 'init_widget_settings'));

        parent::__construct();

    }

    /**
     * Init widget settings
     */
    public function init_widget_settings()
    {

        $options = array();
        $terms = get_terms(array(
            'taxonomy' => 'product_cat',
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }
        $this->product_categories = $options;

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'shop-elite'),
            ),
            'desc' => array(
                'type' => 'text',
                'label' => __('Description', 'shop-elite'),
                'separator' => true,
            ),
            'categories' => array(
                'type' => 'multi-checkbox',
                'label' => __('Select Categories', 'shop-elite'),
                'options' => $this->product_categories,
                'separator' => true,
            ),
            'enable_cat_desc' => array(
                'type' => 'checkbox',
                'label' => __('Show Category Description', 'shop-elite'),
                'std' => 1,
            ),
            'cat_desc_length' => array(
                'type' => 'number',
                'label' => __('Description Length ( In Words )', 'shop-elite'),
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 20,
                'separator' => true,
            ),
            'enable_slider' => array(
                'type' => 'checkbox',
                'label' => __('Enable Slider', 'shop-elite'),
            ),
        );
        /**/

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

        if (!empty($instance['categories'])) {
            $this->widget_start($args, $instance);

            if ($instance['desc']) {
                ?>
                <div class="divider"></div>
                <div class="saga-desc-wrapper">
                    <?php echo wpautop(wp_kses_post($instance['desc'])); ?>
                </div>
                <?php
            }

            $class = 'slider-disabled';
            if ($instance['enable_slider'] == 1) {
                $class = 'slider-enabled';
            }

            echo wp_kses_post(apply_filters('shop_elite_before_widget_product_cat', '<div class="shop_elite_product_cat_widget ' . esc_attr($class) . '">'));

            foreach ($instance['categories'] as $category) {
                $term = get_term($category, 'product_cat');
                if (!empty($term) && !is_wp_error($term)) {
                    $term_link = get_term_link($term);
                    ?>
                    <div class="article-block-wrapper article-block-wrapper-1">
                        <div class="featured-content-wrapper">
                            <div class="entry-image">
                                <?php

                                $class = 'data-bg';
                                $image = '';

                                $thumbnail_id = get_term_meta($category, 'thumbnail_id', true);
                                $image_attributes = wp_get_attachment_image_src($thumbnail_id, 'woocommerce_single');
                                if ($image_attributes) {
                                    $class = 'bg-image';
                                    $image = '<img src="'.esc_url($image_attributes[0]).'"/>';
                                }
                                ?>
                                <a href="<?php echo esc_url($term_link); ?>" class="<?php echo esc_attr($class);?> bg-image-1 bg-color">
                                    <?php echo wp_kses_post($image);?>
                                </a>
                                <div class="featured-content-title">
                                    <div class="tb">
                                        <div class="tbc">
                                            <h3 class="entry-title">
                                                <a href="<?php echo esc_url($term_link); ?>">
                                                    <?php echo esc_html($term->name); ?>
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                        if ( $instance['enable_cat_desc'] && !empty($term->description) ) {
                            $cat_desc_length = $instance['cat_desc_length'];
                            ?>
                            <div class="entry-caption">
                                <?php echo wp_kses_post(wp_trim_words( $term->description, $cat_desc_length, '...' )); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }

            echo wp_kses_post(apply_filters('shop_elite_after_widget_product_cat', '</div>'));

            $this->widget_end($args);

        }

        echo ob_get_clean();
    }

}

function get_image_sizes()
{
    global $_wp_additional_image_sizes;

    $sizes = array();

    foreach (get_intermediate_image_sizes() as $_size) {
        if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
            $sizes[$_size]['width'] = get_option("{$_size}_size_w");
            $sizes[$_size]['height'] = get_option("{$_size}_size_h");
            $sizes[$_size]['crop'] = (bool)get_option("{$_size}_crop");
        } elseif (isset($_wp_additional_image_sizes[$_size])) {
            $sizes[$_size] = array(
                'width' => $_wp_additional_image_sizes[$_size]['width'],
                'height' => $_wp_additional_image_sizes[$_size]['height'],
                'crop' => $_wp_additional_image_sizes[$_size]['crop'],
            );
        }
    }

    return $sizes;
}
