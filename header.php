<?php
/**
 * The theme header.
 * 
 * @package bootstrap-basic4
 */
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <!--wordpress head-->
        <?php wp_head(); ?> 
        <!--end wordpress head-->
    </head>
    <body <?php body_class(); ?>>
        <div class="container page-container">
            <header class="page-header page-header-sitebrand-topbar">
                <div class="row row-with-vspace site-branding">
                    <div class="col-md-6 site-title">
                        <h1 class="site-title-heading">
                            <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                        </h1>
                        <div class="site-description">
                            <small>
                                <?php bloginfo('description'); ?> 
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6 page-header-top-right">
                        <div class="sr-only">
                            <a href="#content" title="<?php esc_attr_e('Skip to content', 'bootstrap-basic4'); ?>"><?php _e('Skip to content', 'bootstrap-basic4'); ?></a>
                        </div>
                        <?php if (is_active_sidebar('header-right')) { ?> 
                        <div class="float-right">
                            <?php dynamic_sidebar('header-right'); ?> 
                        </div>
                        <div class="clearfix"></div>
                        <?php } // endif; ?> 
                    </div>
                </div><!--.site-branding-->
                <div class="row main-navigation">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bootstrap-basic4-topnavbar" aria-controls="bootstrap-basic4-topnavbar" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'bootstrap-basic4'); ?>">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div id="bootstrap-basic4-topnavbar" class="collapse navbar-collapse">
                                <?php 
                                wp_nav_menu(
                                    array(
                                        'depth' => '2',
                                        'theme_location' => 'primary', 
                                        'container' => false, 
                                        'menu_class' => 'navbar-nav mr-auto', 
                                        'walker' => new \BootstrapBasic4\BootstrapBasic4WalkerNavMenu()
                                    )
                                ); 
                                ?> 
                                <div class="float-md-right">
                                    <?php dynamic_sidebar('navbar-right'); ?> 
                                </div>
                                <div class="clearfix"></div>
                            </div><!--.navbar-collapse-->
                            <div class="clearfix"></div>
                        </nav>
                    </div>
                </div><!--.main-navigation-->
            </header><!--.page-header-->


            <div id="content" class="site-content row row-with-vspace">