<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shop_Elite
 */

/**
 * Hook - shop_elite_after_content.
 *
 * @hooked shop_elite_content_wrapper_end - 10
 */
do_action( 'shop_elite_after_content' );

/**
 * Hook - shop_elite_footer.
 *
 * @hooked shop_elite_footer_wrapper_start - 10
 * @hooked shop_elite_footer_content - 20
 * @hooked shop_elite_footer_wrapper_end - 30
 */
do_action( 'shop_elite_footer' );
?>

</div><!-- #page -->
<a id="scroll-up" class="primary-bg"><i class="ion-ios-arrow-up"></i></a>
<?php wp_footer(); ?>

</body>
</html>
