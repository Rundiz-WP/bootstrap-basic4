<?php
/** 
 * Display the page content for post type "page".
 * This will be use in full page display.
 * 
 * @package bootstrap-basic4
 */


$Bsb4Design = new \BootstrapBasic4\Bsb4Design();
?> 
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?> 
        <div class="clearfix"></div>
        <?php
        /**
         * This wp_link_pages option adapt to use bootstrap pagination style.
         */
        wp_link_pages(array(
            'before' => '<div class="page-links">' . __('Pages:', 'bootstrap-basic4') . ' <ul class="pagination">',
            'after'  => '</ul></div>',
            'separator' => ''
        ));
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php $Bsb4Design->editPostLink(); ?> 
    </footer>
</article><!-- #post-## -->
<?php unset($Bsb4Design); ?> 