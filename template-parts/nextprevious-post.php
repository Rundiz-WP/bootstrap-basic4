<?php
/**
 * Display next/previous post. This would work in a singular page such as single.php.
 *
 * The code below was copied from TwentyTwenty theme.
 * 
 * @package bootstrap-basic4
 * @since 1.2.6
 * 
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact, Generic.WhiteSpace.ScopeIndent.Incorrect
 */


$bootstrap_basic4_next_post = get_next_post();
$bootstrap_basic4_prev_post = get_previous_post();

if ($bootstrap_basic4_next_post || $bootstrap_basic4_prev_post) {

	$bootstrap_basic4_pagination_classes = '';

	if ( ! $bootstrap_basic4_next_post ) {
            $bootstrap_basic4_pagination_classes = ' only-one only-prev';
	} elseif ( ! $bootstrap_basic4_prev_post ) {
            $bootstrap_basic4_pagination_classes = ' only-one only-next';
	}

    ?> 
    <nav class="pagination-single section-inner<?php echo esc_attr($bootstrap_basic4_pagination_classes); ?>" aria-label="<?php esc_attr_e('Post', 'bootstrap-basic4'); ?>" role="navigation">
        <ul class="pagination justify-content-between">
            <?php if ($bootstrap_basic4_prev_post) { ?> 
            <li class="page-item">
                <a class="previous-post page-link" href="<?php echo esc_url(get_permalink($bootstrap_basic4_prev_post->ID)); ?>">
                    <span class="arrow" aria-hidden="true">&larr;</span>
                    <span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($bootstrap_basic4_prev_post->ID)); ?></span></span>
                </a>
            </li>
            <?php
            }// endif; $bootstrap_basic4_prev_post

            if ($bootstrap_basic4_next_post) {
            ?> 
            <li class="page-item">
                <a class="next-post page-link" href="<?php echo esc_url(get_permalink($bootstrap_basic4_next_post->ID)); ?>">
                    <span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($bootstrap_basic4_next_post->ID)); ?></span></span>
                    <span class="arrow" aria-hidden="true">&rarr;</span>
                </a>
            </li>
            <?php }// endif; $bootstrap_basic4_next_post ?> 
        </ul>
    </nav><!-- .pagination-single -->
    <?php
}
