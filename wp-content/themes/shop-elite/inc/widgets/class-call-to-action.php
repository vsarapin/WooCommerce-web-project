<?php

if (!defined('ABSPATH')) {
    exit;
}

class Shop_Elite_Call_To_Action extends Shop_Elite_Widget_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->widget_cssclass = 'shop_elite widget_call_to_action';
        $this->widget_description = __("Adds Call to action section", 'shop-elite');
        $this->widget_id = 'shop_elite_call_to_action';
        $this->widget_name = __('SE: Call To Action', 'shop-elite');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'shop-elite'),
            ),
            'desc'  => array(
                'type'  => 'text',
                'label' => __( 'Description', 'shop-elite' ),
            ),
            'bg_image'  => array(
                'type'  => 'image',
                'label' => __( 'Background Image', 'shop-elite' ),
            ),
            'bg_image_height'  => array(
                'type'  => 'number',
                'label' => __( 'Image Height', 'shop-elite' ),
                'step'  => 1,
                'min'   => 100,
                'max'   => 2000,
                'std' => 300,
            ),
            'enable_fixed_bg'  => array(
                'type'  => 'checkbox',
                'label' => __( 'Enable Fixed Background Image', 'shop-elite' ),
                'std' => true,
                'separator' => true,
            ),
            'btn_text'  => array(
                'type'  => 'text',
                'label' => __( 'Button Text', 'shop-elite' ),
            ),
            'btn_link'  => array(
                'type'  => 'url',
                'label' => __( 'Button Link', 'shop-elite' ),
            ),
            'link_target'  => array(
                'type'  => 'checkbox',
                'label' => __( 'Open Link in new Tab', 'shop-elite' ),
                'std' => true,
                'separator' => true,
            ),
            'text_alignment'  => array(
                'type'  => 'select',
                'label' => __( 'Text Alignment', 'shop-elite' ),
                'options' => array(
                    'left'  => __( 'Left', 'shop-elite' ),
                    'center' => __( 'Center', 'shop-elite' ),
                    'right' => __( 'Right', 'shop-elite' ),
                ),
            ),
        );

        parent::__construct();
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

        $before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];

        $style = $class = '';
        $bg_image_height = $instance['bg_image_height'];
        if( 300 != $bg_image_height ){
            $style = "height:$bg_image_height".'px';
        }

        $text_alignment = $instance['text_alignment'];
        $text_align_class = "elite-cta-$text_alignment";

        $img_div_open = '<div class="data-bg bg-image-1 bg-color" style="'.esc_attr($style).'">';
        $img_div_close = '</div>';

        if($instance['bg_image'] && 0 != $instance['bg_image']){
            $image_url = wp_get_attachment_url($instance['bg_image']);

            if($instance['enable_fixed_bg']){
                $class = 'bg-fixed';
            }

            if($image_url){
                /*add the image before the container class*/
                $img_div_open = '<div class="bg-image bg-image-1 bg-color '.esc_attr($class).'" style="'.esc_attr($style).'"><img src="'.esc_url($image_url).'"><div class="tb"><div class="tbc"><div class="container">';
                $before_widget = str_replace('<div class="container">', $img_div_open , $before_widget);
                $after_widget = '</div></div>'.$img_div_close.$after_widget;
            }
        }else{
            $before_widget = str_replace('<div class="container">', $img_div_open.'<div class="tb"><div class="tbc"><div class="container">' , $before_widget);
            $after_widget = '</div></div>'.$img_div_close.$after_widget;
        }

        echo wp_kses_post( $before_widget );

        echo wp_kses_post( apply_filters( 'shop_elite_before_widget_call_to_action', '<div class="shop-elite-cta '.esc_attr($text_align_class).'">' ) );

        if ($instance['title']) {
            ?>
            <div class="saga-title-wrapper">
                <h2 class="widget-title secondary-font">
                    <?php echo wp_kses_post($instance['title']); ?>
                </h2>
            </div>
            <?php
        }

        if ($instance['desc']) {
            ?>
            <div class="saga-desc-wrapper">
                <?php echo wpautop(wp_kses_post($instance['desc'])); ?>
            </div>
            <?php
        }

        if ( $instance['btn_text'] && $instance['btn_link'] ) {
            $target = ( $instance['link_target'] ) == 1 ? '_blank' : '_self' ;
            ?>
            <div class="cta-btn-group">
                <a href="<?php echo esc_url($instance['btn_link']);?>" target="<?php echo esc_attr($target);?>" class="main-btn main-btn-primary">
                    <?php echo esc_html($instance['btn_text'])?>
                </a>
            </div>
            <?php
        }

        echo wp_kses_post( apply_filters( 'shop_elite_after_widget_call_to_action', '</div>' ) );

        echo wp_kses_post( $after_widget );

        echo ob_get_clean();
    }
}