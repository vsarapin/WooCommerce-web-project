<?php
if (!function_exists('shop_elite_banner_content')) :
    /**
     * Banner Slider Content.
     *
     * @since 1.0.0
     */
    function shop_elite_banner_content()
    {
        /**
         * Hook - shop_elite_content_slider.
         *
         * @hooked shop_elite_display_slider - 10
         */
        do_action('shop_elite_content_slider');
    }
endif;
add_action('shop_elite_home_before_widget_area', 'shop_elite_banner_content', 10);

if (!function_exists('shop_elite_display_slider')) :
    /**
     * Banner Slider Content.
     *
     * @since 1.0.0
     */
    function shop_elite_display_slider()
    {
        $enable_banner_slider = shop_elite_get_option('enable_slider_posts', true);
        if ($enable_banner_slider) {
            $slider_post_type = shop_elite_get_option('slider_post_type', true);
            if ('product' == $slider_post_type) {
                $slider_cat = shop_elite_get_option('slider_product_cat', true);
                $taxonomy = 'product_cat';
            } else {
                $slider_cat = shop_elite_get_option('slider_post_cat', true);
                $taxonomy = 'category';
            }
            if (!empty($slider_cat) && !empty($taxonomy)) {

                $slider_class = '';
                $slider_content_class = 'col-md-6';

                $slider_layout = shop_elite_get_option('slider_layout', true);
                if( 'boxed' == $slider_layout ){
                    $slider_class = 'saga-slider-boxed';
                }

                $slider_content_layout = shop_elite_get_option('slider_content_layout', true);
                if( 'full' == $slider_content_layout ){
                    $slider_content_class = 'col-md-10';
                }

                $slider_static_btn_text = $slider_static_btn_link = '';
                $slider_static_btn = shop_elite_get_option('enable_slider_static_btn', true);
                if ($slider_static_btn) {
                    $slider_static_btn_text = shop_elite_get_option('slider_static_btn_text', true);
                    $slider_static_btn_link = shop_elite_get_option('slider_static_btn_link', true);
                }

                $no_of_posts = absint( shop_elite_get_option('no_of_slider_posts', true) );

                $post_args = array(
                    'post_type' => $slider_post_type,
                    'posts_per_page' => $no_of_posts,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'term_id',
                            'terms' => $slider_cat,
                        ),
                    ),
                );
                $slider_post = new WP_Query($post_args);
                if ($slider_post->have_posts()):
                    ?>
                    <section class="slider-area <?php echo esc_attr($slider_class);?>">
                        <div class="saga-slider">
                            <?php
                            while ($slider_post->have_posts()):$slider_post->the_post();
                                global $post;
                                ?>
                                <div class="item">
                                    <div class="img-fill data-bg"
                                         data-background="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>">
                                        <div class="slider-text overlay text-left">
                                            <div class="tb">
                                                <div class="tbc">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-sm-12 <?php echo esc_attr($slider_content_class);?>">
                                                                <h1><?php the_title(); ?></h1>
                                                                <div class="hidden-xs">
                                                                    <?php
                                                                    $enable_slider_description = shop_elite_get_option('enable_slider_description', true);
                                                                    if( $enable_slider_description ){
                                                                        $slider_desc_length = shop_elite_get_option('slider_desc_length', true);
                                                                        $content = wp_trim_words( get_the_content(), $slider_desc_length, '...' );
                                                                        echo apply_filters( 'the_content', $content );
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                if ($slider_static_btn_text) {
                                                                    if ($slider_static_btn_link) {
                                                                        $link_to = $slider_static_btn_link;
                                                                    } else {
                                                                        $link_to = get_the_permalink(get_the_ID());
                                                                    }
                                                                    echo '<a href="' . esc_url($link_to) . '" class="main-btn main-btn-primary">' . esc_html($slider_static_btn_text) . '</a>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                    </section>
                <?php
                endif;
            }
        }
    }
endif;
add_action('shop_elite_content_slider', 'shop_elite_display_slider', 10);

if (!function_exists('shop_elite_front_page_content')) :
    /**
     * Latest Posts
     *
     * @since 1.0.0
     */
    function shop_elite_front_page_content()
    {

        if (is_front_page()) {
            if ('posts' == get_option('show_on_front')) {
                ?>
                <section class="shop-elite-latest-posts">
                    <div class="container">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main">
                                <?php
                                if ( have_posts() ) :
                                    while ( have_posts() ) : the_post();
                                        get_template_part( 'template-parts/content', get_post_type() );
                                    endwhile;
                                    /**
                                     * Hook - shop_elite_posts_navigation.
                                     *
                                     * @hooked: shop_elite_display_posts_navigation - 10
                                     */
                                    do_action( 'shop_elite_posts_navigation' );
                                endif;
                                ?>
                            </main>
                        </div>
                        <?php
                        $page_layout = shop_elite_get_page_layout();
                        if( 'no-sidebar' != $page_layout ){
                            get_sidebar();
                        }
                        ?>
                    </div>
                </section>
                <?php
            } else {
                while (have_posts()) : the_post();
                    global $post;
                    $class = '';
                    if( $post->post_content == '') {
                        $class = 'empty-static-page';
                    }
                    ?>
                    <section class="shop-elite-static-page <?php echo esc_attr($class);?>">
                        <div class="container">
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-content">
                                    <?php
                                    the_content();
                                    wp_link_pages(array(
                                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'shop-elite'),
                                        'after' => '</div>',
                                    ));
                                    ?>
                                </div>
                            </article>
                        </div>
                    </section>
                <?php
                endwhile;
            }
        }
    }
endif;
add_action('shop_elite_home_after_widget_area', 'shop_elite_front_page_content', 10);