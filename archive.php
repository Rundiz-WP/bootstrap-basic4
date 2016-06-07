<?php
/** 
 * The archive template.
 * 
 * Use for display author archive, category, custom post archive, custom taxonomy archive, tag, date archive.<br>
 * These archive can override by each archive file name such as category will be override by category.php.<br>
 * To learn more, please read on this link. https://developer.wordpress.org/themes/basics/template-hierarchy/
 * 
 * @package bootstrap-basic4
 */


// begins template. -------------------------------------------------------------------------
get_header();
get_sidebar();
?> 
                <main id="main" class="col-md-<?php echo \BootstrapBasic4\Bootstrap4Utilities::getMainColumnSize(); ?> site-main" role="main">
                    <?php if (have_posts()) { ?> 
                    <header class="page-header">
                        <h1 class="page-title">
                            <?php
                            if (is_category()) {
                                single_cat_title();
                            } elseif (is_tag()) {
                                single_tag_title();
                            } elseif (is_author()) {
                                /* Queue the first post, that way we know
                                 * what author we're dealing with (if that is the case).
                                 */
                                the_post();
                                printf(__('Author: %s', 'bootstrap-basic4'), '<span class="vcard">' . get_the_author() . '</span>');
                                /* Since we called the_post() above, we need to
                                 * rewind the loop back to the beginning that way
                                 * we can run the loop properly, in full.
                                 */
                                rewind_posts();
                            } elseif (is_day()) {
                                printf(__('Day: %s', 'bootstrap-basic4'), '<span>' . get_the_date() . '</span>');
                            } elseif (is_month()) {
                                printf(__('Month: %s', 'bootstrap-basic4'), '<span>' . get_the_date('F Y') . '</span>');
                            } elseif (is_year()) {
                                printf(__('Year: %s', 'bootstrap-basic4'), '<span>' . get_the_date('Y') . '</span>');
                            } elseif (is_tax('post_format', 'post-format-aside')) {
                                _e('Asides', 'bootstrap-basic4');
                            } elseif (is_tax('post_format', 'post-format-image')) {
                                _e('Images', 'bootstrap-basic4');
                            } elseif (is_tax('post_format', 'post-format-video')) {
                                _e('Videos', 'bootstrap-basic4');
                            } elseif (is_tax('post_format', 'post-format-quote')) {
                                _e('Quotes', 'bootstrap-basic4');
                            } elseif (is_tax('post_format', 'post-format-link')) {
                                _e('Links', 'bootstrap-basic4');
                            } else {
                                _e('Archives', 'bootstrap-basic4');
                            } //endif;
                            ?> 
                        </h1>
                        <?php
                        // Show an optional term description.
                        $term_description = term_description();
                        if (!empty($term_description)) {
                            printf('<div class="taxonomy-description">%s</div>', $term_description);
                        } //endif;
                        ?>
                    </header><!-- .page-header -->

                    <?php 
                        // Start the Loop
                        while (have_posts()) {
                            the_post();
                            get_template_part('template-parts/content', get_post_format());
                        } //endwhile; 

                        $Bsb4Design = new \BootstrapBasic4\Bsb4Design();
                        $Bsb4Design->pagination();
                        unset($Bsb4Design);
                    } else {
                        get_template_part('template-parts/section', 'no-results');
                    } //endif; 
                    ?> 
                </main>
<?php
get_sidebar('right');
get_footer();