<?php
/**
 * Display the post content in "quote" format.
 * This will be use in the loop and full page display.
 * 
 * @package bootstrap-basic4
 * 
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact, Generic.WhiteSpace.ScopeIndent.Incorrect
 */


$bootstrap_basic4_Bsb4Design = new \BootstrapBasic4\Bsb4Design();
?> 
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <?php the_content($bootstrap_basic4_Bsb4Design->continueReading(true)); ?> 
        <div class="clearfix"></div>
        <?php 
        /**
         * This wp_link_pages option adapt to use bootstrap pagination style.
         */
        wp_link_pages([
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'bootstrap-basic4') . ' <ul class="pagination">',
            'after'  => '</ul></div>',
            'separator' => '',
        ]);
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php if ('post' === get_post_type()) { // Hide category and tag text for pages on Search ?> 
        <div class="entry-meta-category-tag">
            <?php
                /* translators: used between list items, there is a space after the comma */
                $bootstrap_basic4_categories_list = get_the_category_list(esc_html__(', ', 'bootstrap-basic4'));
                if (!empty($bootstrap_basic4_categories_list)) {
            ?> 
            <span class="cat-links">
                <?php $bootstrap_basic4_Bsb4Design->categoriesList($bootstrap_basic4_categories_list); ?> 
            </span>
            <?php } // End if categories ?> 

            <?php
                /* translators: used between list items, there is a space after the comma */
                $bootstrap_basic4_tags_list = get_the_tag_list('', esc_html__(', ', 'bootstrap-basic4'));
                if ($bootstrap_basic4_tags_list) {
            ?> 
            <span class="tags-links">
                <?php $bootstrap_basic4_Bsb4Design->tagsList($bootstrap_basic4_tags_list); ?> 
            </span>
            <?php } // End if $bootstrap_basic4_tags_list ?> 
        </div><!--.entry-meta-category-tag-->
        <?php } // End if 'post' == get_post_type() ?> 

        <div class="entry-meta-comment-tools">
            <?php if (! post_password_required() && (comments_open() || '0' !== strval(get_comments_number()))) { ?> 
            <span class="comments-link"><?php $bootstrap_basic4_Bsb4Design->commentsLink(); ?></span>
            <?php } //endif; ?> 

            <?php $bootstrap_basic4_Bsb4Design->editPostLink(); ?> 
        </div><!--.entry-meta-comment-tools-->
    </footer><!-- .entry-meta -->
</article><!-- #post -->
<?php 
unset($bootstrap_basic4_Bsb4Design);
