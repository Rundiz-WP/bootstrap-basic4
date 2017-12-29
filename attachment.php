<?php
/** 
 * The attachment template.
 * 
 * Use for display the attachment from full post content. Such as image, video, audio, any media or attachment file.
 * 
 * @package bootstrap-basic4
 */


// begins template. -------------------------------------------------------------------------
get_header();
?> 
                <main id="main" class="col-12 site-main" role="main">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            get_template_part('template-parts/content', 'attachment');
                        }// endwhile;
                    } else {
                        get_template_part('template-parts/section', 'no-results');
                    }// endif;
                    ?> 
                </main>
<?php
get_footer();