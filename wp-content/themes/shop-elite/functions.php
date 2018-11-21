<?php
/**
 * Shop Elite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shop_Elite
 */

if ( ! function_exists( 'shop_elite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function shop_elite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Shop Elite, use a find and replace
		 * to change 'shop-elite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'shop-elite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
        add_image_size('shop-elite-medium', 800, 560, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
            'topbar-menu' => esc_html__( 'Top Bar Menu', 'shop-elite' ),
            'social-nav' => esc_html__( 'Social Nav', 'shop-elite' ),
			'primary' => esc_html__( 'Primary', 'shop-elite' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'shop_elite_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'shop_elite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shop_elite_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'shop_elite_content_width', 640 );
}
add_action( 'after_setup_theme', 'shop_elite_content_width', 0 );


/**
 * function for google fonts
 */
if (!function_exists('shop_elite_fonts_url')) :

    /**
     * Return fonts URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function shop_elite_fonts_url(){

        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';


        /* translators: If there are characters in your language that are not supported by Roboto Condensed, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Roboto Condensed: on or off', 'shop-elite')) {
            $fonts[] = 'Roboto+Condensed:300,400,700';
        }

        /* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Open Sans: on or off', 'shop-elite')) {
            $fonts[] = 'Open+Sans:300,400italic,400,700';
        }


        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urldecode(implode('|', $fonts)),
                'subset' => urldecode($subsets),
            ), 'https://fonts.googleapis.com/css');
        }
        return $fonts_url;
    }
endif;
    
/**
 * Enqueue scripts and styles.
 */
function shop_elite_scripts() {

    $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_style('ionicons', get_template_directory_uri() . '/assets/lib/ionicons/css/ionicons' . $min . '.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/lib/animate/animate'. $min . '.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap'. $min . '.css');
    wp_enqueue_style('shop-elite-slider', get_template_directory_uri() . '/assets/saga/css/slider.css');
    wp_enqueue_style( 'shop-elite-style', get_stylesheet_uri() );
    $fonts_url = shop_elite_fonts_url();
    if (!empty($fonts_url)) {
        wp_enqueue_style('shop-elite-google-fonts', $fonts_url, array(), null);
    }

    wp_enqueue_script( 'shop-elite-skip-link-focus-fix', get_template_directory_uri() . '/assets/saga/js/skip-link-focus-fix.js', array(), '20151215', true );
    wp_enqueue_script('slick', get_template_directory_uri() . '/assets/lib/slick/js/slick'. $min . '.js', array('jquery'), '', true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap'. $min . '.js', array('jquery'), '', true);
    wp_enqueue_script('shop-elite-script', get_template_directory_uri() . '/assets/saga/js/shop-elite-script.js', array('jquery'), '', true);

    $args = array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    );
    wp_localize_script( 'shop-elite-script', 'shopElite', $args );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

}
add_action( 'wp_enqueue_scripts', 'shop_elite_scripts' );

function shop_elite_get_customizer_value(){
    global $shop_elite;
    $shop_elite = shop_elite_get_options();
}
add_action( 'init', 'shop_elite_get_customizer_value');

/**
 * Load all required files.
 */
require get_template_directory() . '/inc/init.php';