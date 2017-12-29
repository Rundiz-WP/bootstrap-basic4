<?php
/** 
 * File not found or web page not found template file.
 * 
 * @package bootstrap-basic4
 */


// begins template. -------------------------------------------------------------------------
get_header();
?> 
                <main id="main" class="col-12 site-main" role="main">
                    <section class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php _e('Oops! That page can&rsquo;t be found.', 'bootstrap-basic4'); ?></h1>
                        </header><!-- .page-header -->
                        <div class="page-content">
                            <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'bootstrap-basic4'); ?></p>

                            <!--search form-->
                            <div class="row-with-vspace">
                                <?php get_template_part('template-parts/partial', 'search-form'); ?> 
                            </div>

                            <div class="row">
                                <div class=" col-sm-6 col-md-3">
                                    <?php the_widget('WP_Widget_Recent_Posts'); ?> 
                                </div>
                                <div class=" col-sm-6 col-md-3">
                                    <div class="widget widget_categories">
                                        <h2 class="widgettitle"><?php _e('Most Used Categories', 'bootstrap-basic4'); ?></h2>
                                        <ul>
                                            <?php
                                            wp_list_categories(array(
                                                'orderby' => 'count',
                                                'order' => 'DESC',
                                                'show_count' => 1,
                                                'title_li' => '',
                                                'number' => 10,
                                            ));
                                            ?> 
                                        </ul>
                                    </div><!-- .widget -->
                                </div>
                                <div class=" col-sm-6 col-md-3">
                                    <?php
                                    /* translators: %1$s: smiley */
                                    $archive_content = '<p>' . sprintf(__('Try looking in the monthly archives. %1$s', 'bootstrap-basic4'), convert_smilies(':)')) . '</p>';
                                    the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content");
                                    ?> 
                                </div>
                                <div class=" col-sm-6 col-md-3">
                                    <?php the_widget('WP_Widget_Tag_Cloud'); ?> 
                                </div>
                            </div>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->
                </main>
<?php
get_footer();