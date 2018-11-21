<?php 

if ( ! function_exists( 'shop_elite_display_posts_navigation' ) ) :

	/**
	 * Display Pagination.
	 *
	 * @since 1.0.0
	 */
	function shop_elite_display_posts_navigation() {

        $pagination_type = shop_elite_get_option( 'pagination_type', true );
        switch ( $pagination_type ) {

            case 'default':
                the_posts_navigation();
                break;

            case 'numeric':
                the_posts_pagination();
                break;

            default:
                break;
        }
		return;
	}

endif;

add_action( 'shop_elite_posts_navigation', 'shop_elite_display_posts_navigation' );
