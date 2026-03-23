<?php
/** 
 * The single post.<br>
 * This file works as display full post content page and its comments.
 * 
 * @package bootstrap-basic4
 * 
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact, Generic.WhiteSpace.ScopeIndent.Incorrect
 */


// begins template. -------------------------------------------------------------------------
get_header();
get_sidebar();
?> 
                <main id="main" class="col-md-<?php echo esc_attr(\BootstrapBasic4\Bootstrap4Utilities::getMainColumnSize()); ?> site-main" role="main">
                    <?php
                    if (have_posts()) {
                        $bootstrap_basic4_Bsb4Design = new \BootstrapBasic4\Bsb4Design();
                        while (have_posts()) {
                            the_post();
                            get_template_part('template-parts/content', get_post_format());
                            echo "\n\n";

                            $bootstrap_basic4_Bsb4Design->pagination();
                            echo "\n\n";

                            // display next/previous post. un-comment the code below to display post navigation.
                            // @since 1.2.6
                            // get_template_part('template-parts/nextprevious-post');

                            // If comments are open or we have at least one comment, load up the comment template
                            if (comments_open() || '0' !== strval(get_comments_number())) {
                                comments_template();
                            }
                            echo "\n\n";
                        }// endwhile;

                        
                        unset($bootstrap_basic4_Bsb4Design);
                    } else {
                        get_template_part('template-parts/section', 'no-results');
                    }// endif;
                    ?> 
                </main>
<?php
get_sidebar('right');
get_footer();
