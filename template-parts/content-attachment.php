<?php
/** 
 * Display attachment content.
 * This content called from attachment.php page.
 * 
 * @package bootstrap-basic4
 */


$bootstrap_basic4_Bsb4Design = new \BootstrapBasic4\Bsb4Design();
?> 
<article id="post-<?php the_ID(); ?>" <?php post_class('post-view-attachment'); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?> 

        <div class="entry-meta">
            <?php
            echo wp_kses_post(
                /* translators: %1$s: Date/time in datetime attribute, %2$s: Date/time text. */
                sprintf(__('Published <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>', 'bootstrap-basic4'),
                    esc_attr(get_the_date('c')),
                    esc_html(get_the_date())
                )
            );
            $bootstrap_basic4_metadata = wp_get_attachment_metadata();
            if (is_array($bootstrap_basic4_metadata) && array_key_exists('width', $bootstrap_basic4_metadata) && array_key_exists('height', $bootstrap_basic4_metadata) && !empty($bootstrap_basic4_metadata['width']) && !empty($bootstrap_basic4_metadata['height'])) {
                echo ' ';
                echo wp_kses_post(
                    /* translators: %1$s: URL to attachment, %2$s: Attachment width, %3$s: Attachment height. */
                    sprintf(__('at <a href="%1$s" title="Link to attachment file">%2$s &times; %3$s</a>', 'bootstrap-basic4'),
                        esc_url(wp_get_attachment_url()),
                        $bootstrap_basic4_metadata['width'],
                        $bootstrap_basic4_metadata['height']
                    )
                );
            }
            echo ' ';
            echo wp_kses_post(
                /* translators: %1$s: URL to post parent, %2$s: Post parent title in the title attribute, %3$s: Post parent title. */
                sprintf(__('in <a href="%1$s" title="Return to %2$s" rel="gallery">%3$s</a>', 'bootstrap-basic4'),
                    esc_url(get_permalink($post->post_parent)),
                    esc_attr(wp_strip_all_tags(get_the_title($post->post_parent))),
                    get_the_title($post->post_parent)
                )
            );
            if (
                !is_array($bootstrap_basic4_metadata) ||
                (
                    is_array($bootstrap_basic4_metadata) && 
                    (
                        !array_key_exists('width', $bootstrap_basic4_metadata) ||
                        !array_key_exists('height', $bootstrap_basic4_metadata) ||
                        empty($bootstrap_basic4_metadata['width']) ||
                        empty($bootstrap_basic4_metadata['height'])
                    )
                )
            ) {
                echo ' ';
                echo wp_kses_post(
                    /* translators: %1$s: URL to attachment. */
                    sprintf(__('(<a href="%1$s" title="Link to attachment file">attachment file</a>)', 'bootstrap-basic4'),
                        esc_url(wp_get_attachment_url())
                    )
                );
            }

            echo ' ';
            $bootstrap_basic4_Bsb4Design->editPostLink();
            unset($bootstrap_basic4_metadata);
            ?> 
        </div><!-- .entry-meta -->

        <div class="row mb-3">
            <div class="nav-previous col-6"><?php previous_image_link(false, __('<span class="meta-nav">&larr;</span> Previous', 'bootstrap-basic4')); ?></div>
            <div class="nav-next col-6 text-right"><?php next_image_link(false, __('Next <span class="meta-nav">&rarr;</span>', 'bootstrap-basic4')); ?></div>
        </div><!-- #image-navigation -->
    </header><!-- .entry-header -->

    <div class="entry-content">
        <div class="entry-attachment">
            <div class="attachment">
                <?php $bootstrap_basic4_Bsb4Design->attachment(); ?> 
            </div><!-- .attachment -->

            <?php if (has_excerpt()) { ?> 
            <div class="entry-caption">
                <?php the_excerpt(); ?> 
            </div><!-- .entry-caption -->
            <?php } //endif; ?> 
        </div><!-- .entry-attachment -->

        <?php
        the_content();

        /**
         * This wp_link_pages option adapt to use bootstrap pagination style.
         * 
         * This wp_link_pages on attachment.php or image.php page will results in page not found.
         * 
         * @link https://github.com/WordPress/twentysixteen/issues/438 Some people have issue about this in the topic "Remove wp_link_pages() from image.php".
        */
        wp_link_pages([
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'bootstrap-basic4') . ' <ul class="pagination">',
            'after'  => '</ul></div>',
            'separator' => '',
        ]);
        ?> 
    </div><!-- .entry-content -->
</article><!-- #post-## -->
<?php 
unset($bootstrap_basic4_Bsb4Design);
