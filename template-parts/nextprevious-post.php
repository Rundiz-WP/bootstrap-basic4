<?php
/**
 * Display next/previous post. This would work in a singular page such as single.php.
 *
 * The code below was copied from TwentyTwenty theme.
 * 
 * @package bootstrap-basic4
 * @since 1.2.6
 */


$next_post = get_next_post();
$prev_post = get_previous_post();

if ($next_post || $prev_post) {

	$pagination_classes = '';

	if ( ! $next_post ) {
            $pagination_classes = ' only-one only-prev';
	} elseif ( ! $prev_post ) {
            $pagination_classes = ' only-one only-next';
	}

    ?> 
    <nav class="pagination-single section-inner<?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e('Post', 'bootstrap-basic4'); ?>" role="navigation">
        <ul class="pagination justify-content-between">
            <?php if ($prev_post) { ?> 
            <li class="page-item">
                <a class="previous-post page-link" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                    <span class="arrow" aria-hidden="true">&larr;</span>
                    <span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($prev_post->ID)); ?></span></span>
                </a>
            </li>
            <?php
            }// endif; $prev_post

            if ($next_post) {
            ?> 
            <li class="page-item">
                <a class="next-post page-link" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                    <span class="title"><span class="title-inner"><?php echo wp_kses_post(get_the_title($next_post->ID)); ?></span></span>
                    <span class="arrow" aria-hidden="true">&rarr;</span>
                </a>
            </li>
            <?php }// endif; $next_post ?> 
        </ul>
    </nav><!-- .pagination-single -->
    <?php
}
