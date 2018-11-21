<?php

if ( ! function_exists( 'shop_elite_content_wrapper_end' ) ) :
    /**
     * Display Closing Div Structure for the Content
     *
     * @since 1.0.0
     */
    function shop_elite_content_wrapper_end() {
        ?>
        </div><!-- #content -->
        <?php
    }
endif;
add_action( 'shop_elite_after_content', 'shop_elite_content_wrapper_end' , 10 );

if ( ! function_exists( 'shop_elite_footer_wrapper_star' ) ) :
    /**
     * Display Opening Div Structure for the footer
     *
     * @since 1.0.0
     */
    function shop_elite_footer_wrapper_star() {
        ?>
        <footer id="colophon" class="site-footer">
        <?php
    }
endif;
add_action( 'shop_elite_footer', 'shop_elite_footer_wrapper_star' , 10 );

if ( ! function_exists( 'shop_elite_footer_content' ) ) :
    /**
     * Display footer Content
     *
     * @since 1.0.0
     */
    function shop_elite_footer_content() {
        /**
         * Hook - shop_elite_footer_widget_area.
         *
         * @hooked shop_elite_footer_widgets - 10
         */
        do_action( 'shop_elite_footer_widget_area' );

        /**
         * Hook - shop_elite_footer_bottom.
         *
         * @hooked shop_elite_footer_copyright_info - 10
         */
        do_action( 'shop_elite_footer_bottom' );
    }
endif;
add_action( 'shop_elite_footer', 'shop_elite_footer_content' , 20 );

if ( ! function_exists( 'shop_elite_footer_widgets' ) ) :
    /**
     * Display footer Widgets
     *
     * @since 1.0.0
     */
    function shop_elite_footer_widgets() {
        if (is_active_sidebar('footer-col-one') || is_active_sidebar('footer-col-two') || is_active_sidebar('footer-col-three')): ?>
            <div class="footer-widget-area">
                <div class="container">
                    <div class="row">
                        <?php if (is_active_sidebar('footer-col-one')) : ?>
                            <div class="col-md-4">
                                <?php dynamic_sidebar('footer-col-one'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (is_active_sidebar('footer-col-two')) : ?>
                            <div class="col-md-4">
                                <?php dynamic_sidebar('footer-col-two'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (is_active_sidebar('footer-col-three')) : ?>
                            <div class="col-md-4">
                                <?php dynamic_sidebar('footer-col-three'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
    }
endif;
add_action( 'shop_elite_footer_widget_area', 'shop_elite_footer_widgets' , 10 );

if ( ! function_exists( 'shop_elite_footer_copyright_info' ) ) :
    /**
     * Display footer Copyright info
     *
     * @since 1.0.0
     */
    function shop_elite_footer_copyright_info() {
        ?>
        <div class="site-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <span>
                            <?php
                            $copyright_text = shop_elite_get_option('copyright_text', true);
                            if ($copyright_text) {
                                echo wp_kses_post($copyright_text);
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
endif;
add_action( 'shop_elite_footer_bottom', 'shop_elite_footer_copyright_info' , 10 );

if ( ! function_exists( 'shop_elite_footer_wrapper_end' ) ) :
    /**
     * Display Closing Div Structure for the footer
     *
     * @since 1.0.0
     */
    function shop_elite_footer_wrapper_end() {
        ?>
        </footer>
        <?php
    }
endif;
add_action( 'shop_elite_footer', 'shop_elite_footer_wrapper_end' , 30 );