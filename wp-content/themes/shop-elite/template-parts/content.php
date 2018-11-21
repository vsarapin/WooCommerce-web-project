<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Shop_Elite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				    shop_elite_posted_on();
				    shop_elite_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php
    $image_option = shop_elite_get_image_option();
    if ( 'no-image' != $image_option ){
        shop_elite_post_thumbnail($image_option);
    }
    ?>

	<div class="entry-content">
        <footer class="entry-footer">
            <?php shop_elite_entry_footer(); ?>
        </footer><!-- .entry-footer -->
		<?php
        if( is_singular() ){
            the_content( sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'shop-elite' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ) );
        }else{
            the_excerpt();
        }
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shop-elite' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
