<?php
/**
 * The Bootstrap Basic 4 main functional file.
 * 
 * @package bootstrap-basic4
 */


namespace BootstrapBasic4;

if (!class_exists('\\BootstrapBasic4\\BootstrapBasic4')) {
    /**
     * Bootstrap Basic 4 main functional in class style.
     * 
     * This class will be handle all the main hooks that work with theme features such as add theme support features, register widgets area or sidebar, enqueue scripts and styles.<br>
     * If you want to hook into WordPress and make changes or modification, please use \BootstrapBasic4\Hooks\Bsb4Hooks() class.<br>
     * To use, just code as follows:
     * 
     * $BootstrapBasic4 = new \BootstrapBasic4\BootstrapBasic4();
     * $BootstrapBasic4->addActionsFilters();
     * 
     * That's it.
     */
    class BootstrapBasic4
    {


        /**
         * Add actions and filters to make main theme functional works.
         */
        public function addActionsFilters()
        {
            // Change main content width up to columns available.
            add_action('template_redirect', array(&$this, 'detectContentWidth'));
            // Add theme feature.
            add_action('after_setup_theme', array(&$this, 'themeSetup'));
            // Register sidebars.
            add_action('widgets_init', array(&$this, 'registerSidebars'));
            // Enqueue scripts and styles.
            add_action('wp_enqueue_scripts', array(&$this, 'enqueueScriptsAndStyles'));
        }// addActionsFilters


        /**
         * Detect main content width upto columns available.
         */
        public function detectContentWidth()
        {
            global $content_width, $bootstrapbasic4_sidebar_left_size, $bootstrapbasic4_sidebar_right_size;

            if (is_active_sidebar('sidebar-left') && is_active_sidebar('sidebar-right')) {
                $content_width = 540;
            } elseif (is_active_sidebar('sidebar-left') || is_active_sidebar('sidebar-right')) {
                $content_width = 825;
            }

            $content_width = apply_filters('bootstrap_basic4_content_width', $content_width, $bootstrapbasic4_sidebar_left_size, $bootstrapbasic4_sidebar_right_size);
        }// detectContentWidth


        /**
         * Enqueue scripts and styles.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         */
        public function enqueueScriptsAndStyles()
        {
            wp_enqueue_style('bootstrap-basic4-wp-main', get_stylesheet_uri());

            wp_enqueue_style('bootstrap4', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.1.1');
            wp_enqueue_style('font-awesome5', get_template_directory_uri() . '/assets/css/fontawesome-all.min.css', array(), '5.0.13');
            wp_enqueue_style('bootstrap-basic4-main', get_template_directory_uri() . '/assets/css/main.css');

            if (is_singular() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
            wp_enqueue_script('bootstrap4-bundle', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), '4.1.1', true);// bundled with popper. see https://getbootstrap.com/docs/4.0/getting-started/contents/#comparison-of-css-files
            wp_enqueue_script('bootstrap-basic4-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), false, true);
        }// enqueueScriptsAndStyles


        /**
         * Register sidebars
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         */
        public function registerSidebars()
        {
            register_sidebar(array(
                'name'          => __('Sidebar left', 'bootstrap-basic4'),
                'id'            => 'sidebar-left',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ));

            register_sidebar(array(
                'name'          => __('Sidebar right', 'bootstrap-basic4'),
                'id'            => 'sidebar-right',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ));

            register_sidebar(array(
                'name'          => __('Header right', 'bootstrap-basic4'),
                'id'            => 'header-right',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ));

            register_sidebar(array(
                'name'          => __('Navigation bar right', 'bootstrap-basic4'),
                'id'            => 'navbar-right',
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '',
                'after_title'   => '',
            ));

            register_sidebar(array(
                'name'          => __('Footer left', 'bootstrap-basic4'),
                'id'            => 'footer-left',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ));

            register_sidebar(array(
                'name'          => __('Footer right', 'bootstrap-basic4'),
                'id'            => 'footer-right',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ));
        }// registerSidebars


        /**
         * Add theme feature.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         */
        public function themeSetup()
        {
            // load theme textdomain for translation
            load_theme_textdomain('bootstrap-basic4', get_template_directory() . '/languages');

            // add theme support title-tag
            add_theme_support('title-tag');

            // add theme support post and comment automatic feed links
            add_theme_support('automatic-feed-links');

            // allow the use of html5 markup
            // @link https://codex.wordpress.org/Theme_Markup
            add_theme_support('html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form'));

            // add support menu
            register_nav_menus(array(
                'primary' => __('Primary Menu', 'bootstrap-basic4'),
            ));

            // add post formats support
            add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

            // add post thumbnails support. **This is REQUIRED for post editor to show featured image field.**
            // To display featured image, please use post thumbnail functions.
            // See https://codex.wordpress.org/Post_Thumbnails for reference.
            add_theme_support('post-thumbnails');

            // add support custom background
            add_theme_support(
                'custom-background', 
                apply_filters(
                    'bootstrap_basic4_custom_background_args', 
                    array(
                        'default-color' => 'ffffff', 
                        'default-image' => ''
                    )
                )
            );
        }// themeSetup


    }
}