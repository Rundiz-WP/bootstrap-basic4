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
        <!--[if lt IE 9]>
            <p class="ancient-browser-alert">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a>.</p>
        <![endif]-->
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
                        <div class="float-xs-right">
                            <?php dynamic_sidebar('header-right'); ?> 
                        </div>
                        <div class="clearfix"></div>
                        <?php } // endif; ?> 
                    </div>
                </div><!--.site-branding-->
                <div class="row main-navigation">
                    <div class="col-md-12">
                        <nav class="navbar navbar-light bg-faded">
                            <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#bootstrap-basic4-topnavbar">
                                &#9776;
                            </button>

                            <div id="bootstrap-basic4-topnavbar" class="collapse navbar-toggleable-xs">
                                <?php 
                                wp_nav_menu(
                                    array(
                                        'depth' => '2',
                                        'theme_location' => 'primary', 
                                        'container' => false, 
                                        'menu_class' => 'nav navbar-nav', 
                                        'walker' => new \BootstrapBasic4\BootstrapBasic4WalkerNavMenu()
                                    )
                                ); 
                                ?> 
                                <div class="float-sm-right">
                                    <?php dynamic_sidebar('navbar-right'); ?> 
                                </div>
                                <div class="clearfix"></div>
                            </div><!--.navbar-toggleable-xs-->
                        </nav>
                    </div>
                </div><!--.main-navigation-->
            </header><!--.page-header-->


            <div id="content" class="site-content row row-with-vspace">