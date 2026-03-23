<?php
/** 
 * Comments template.
 * 
 * @package bootstrap-basic4
 * 
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect
 */


if (post_password_required()) {
	return;
}

$bootstrap_basic4_Bsb4Design = new \BootstrapBasic4\Bsb4Design();
?> 
<section id="comments" class="comments-area">
    <?php if (have_comments()) { ?> 
        <h2 class="comments-title">
            <?php
            $bootstrap_basic4_comments_number = get_comments_number();
            if ('1' === strval($bootstrap_basic4_comments_number)) {
                /* translators: %s: The post title */
                echo wp_kses_post(
                    /* translators: post title */
                    sprintf(_x('One comment on &ldquo;%s&rdquo;', 'comments title', 'bootstrap-basic4'), get_the_title())
                );
            } else {
                echo wp_kses_post(
                    printf(
                        /* translators: %1$s: Number of comments, %2$s: Post title. */
                        _nx(
                            '%1$s comment on &ldquo;%2$s&rdquo;', 
                            '%1$s comments on &ldquo;%2$s&rdquo;', 
                            $bootstrap_basic4_comments_number, 
                            'comments title', 
                            'bootstrap-basic4'
                        ), 
                        number_format_i18n($bootstrap_basic4_comments_number), 
                        '<span>' . get_the_title() . '</span>'
                    )
                );
            }
            unset($bootstrap_basic4_comments_number);
            ?> 
        </h2>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // are there comments to navigate through ?> 
            <h3 class="screen-reader-text sr-only"><?php esc_html_e('Comment navigation', 'bootstrap-basic4'); ?></h3>
            <ul id="comment-nav-above" class="comment-navigation clearfix" role="navigation">
                <li class="nav-previous previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'bootstrap-basic4')); ?></li>
                <li class="nav-next next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'bootstrap-basic4')); ?></li>
            </ul><!-- #comment-nav-above -->
        <?php } // check for comment navigation ?> 

        <ul class="list-unstyled media-list">
            <?php
            /**
             * Loop through and list the comments. Tell wp_list_comments()
             * to use $bootstrap_basic4_Bsb4Design->displayComments() to format the comments.
             * If you want to override this in a child theme, then you can
             * define displayComments() method and Bsb4Design class and that will be used instead.
             * See displayComments() in inc/classes/Bsb4Design.php for more.
             */
            wp_list_comments(['avatar_size' => '64', 'callback' => [$bootstrap_basic4_Bsb4Design, 'displayComments']]);
            ?> 
        </ul><!-- .comment-list -->

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // are there comments to navigate through ?> 
            <h3 class="screen-reader-text sr-only"><?php esc_html_e('Comment navigation', 'bootstrap-basic4'); ?></h3>
            <ul id="comment-nav-below" class="comment-navigation comment-navigation-below clearfix" role="navigation">
                <li class="nav-previous previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'bootstrap-basic4')); ?></li>
                <li class="nav-next next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'bootstrap-basic4')); ?></li>
            </ul><!-- #comment-nav-below -->
        <?php } // check for comment navigation ?> 

    <?php } // have_comments() ?> 

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && '0' !== strval(get_comments_number()) && post_type_supports(get_post_type(), 'comments')) { ?> 
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'bootstrap-basic4'); ?></p>
    <?php 
    } //endif; 
    ?> 

    <?php 
    $bootstrap_basic4_req = get_option('require_name_email');
    $bootstrap_basic4_aria_req = ($bootstrap_basic4_req ? " aria-required='true'" : '');
    $bootstrap_basic4_html5 = true;

    // re-format comment allowed tags
    $bootstrap_basic4_comment_allowedtags = allowed_tags();
    $bootstrap_basic4_comment_allowedtags = str_replace(["\r\n", "\r", "\n"], '', $bootstrap_basic4_comment_allowedtags);
    $bootstrap_basic4_comment_allowedtags_array = explode('&gt; &lt;', $bootstrap_basic4_comment_allowedtags);
    $bootstrap_basic4_formatted_comment_allowedtags = '';
    foreach ($bootstrap_basic4_comment_allowedtags_array as $bootstrap_basic4_item) {
        $bootstrap_basic4_formatted_comment_allowedtags .= '<code>';

        if ($bootstrap_basic4_comment_allowedtags_array[0] !== $bootstrap_basic4_item) {
            $bootstrap_basic4_formatted_comment_allowedtags .= '&lt;';
        }

        $bootstrap_basic4_formatted_comment_allowedtags .= $bootstrap_basic4_item;

        if (end($bootstrap_basic4_comment_allowedtags_array) !== $bootstrap_basic4_item) {
            $bootstrap_basic4_formatted_comment_allowedtags .= '&gt;';
        }

        $bootstrap_basic4_formatted_comment_allowedtags .= '</code> ';
    }// endforeach;
    unset($bootstrap_basic4_item);
    $bootstrap_basic4_comment_allowed_tags = $bootstrap_basic4_formatted_comment_allowedtags;
    unset($bootstrap_basic4_comment_allowedtags, $bootstrap_basic4_comment_allowedtags_array, $bootstrap_basic4_formatted_comment_allowedtags);

    comment_form(
        [
            'class_submit' => 'btn btn-primary',
            'fields' => [
                'author' => '<div class="form-group row">' . 
                            '<label class="col-form-label col-md-2" for="author">' . __('Name', 'bootstrap-basic4') . ($bootstrap_basic4_req ? ' <span class="required">*</span>' : '') . '</label> ' .
                            '<div class="col-md-10">' . 
                            '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $bootstrap_basic4_aria_req . ' class="form-control" />' . 
                            '</div>' . 
                            '</div>',
                'email'  => '<div class="form-group row">' . 
                            '<label class="col-form-label col-md-2" for="email">' . __('Email', 'bootstrap-basic4') . ($bootstrap_basic4_req ? ' <span class="required">*</span>' : '') . '</label> ' .
                            '<div class="col-md-10">' . 
                            '<input id="email" name="email" ' . ($bootstrap_basic4_html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $bootstrap_basic4_aria_req . ' class="form-control" />' . 
                            '</div>' . 
                            '</div>',
                'url'    => '<div class="form-group row">' . 
                            '<label class="col-form-label col-md-2" for="url">' . __('Website', 'bootstrap-basic4') . '</label> ' .
                            '<div class="col-md-10">' . 
                            '<input id="url" name="url" ' . ($bootstrap_basic4_html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" size="30" class="form-control" />' . 
                            '</div>' . 
                            '</div>',
            ],
            'comment_field' => '<div class="form-group row">' . 
                            '<label class="col-form-label col-md-2" for="comment">' . __('Comment', 'bootstrap-basic4') . '</label> ' . 
                            '<div class="col-md-10">' . 
                            '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="form-control"></textarea>' . 
                            '</div>' . 
                            '</div>',
            'comment_notes_after' => '<p class="form-text text-muted">' . 
                            /* translators: %s: Comment allowed HTML tags. */
                            sprintf(__('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'bootstrap-basic4'), $bootstrap_basic4_comment_allowed_tags) . 
                            '</p>',
        ]
    ); 

    unset($bootstrap_basic4_comment_allowed_tags);
    ?> 
</section><!-- #comments -->
<?php 
unset($bootstrap_basic4_Bsb4Design);
