<?php
/**
 * Partials template: search form.
 * 
 * This file is discourage.<br>
 * It is not recommended to use but will keep it for in case child theme is using it.
 * 
 * @package bootstrap-basic4
 */

$aria_label = '';
if (isset($args['aria_label']) && !empty($args['aria_label'])) {
    $aria_label = ' aria-label="' . esc_attr( $args['aria_label'] ) . '"';
}
?> 
                            <form class="search-form form"<?php echo $aria_label; ?> method="get" action="<?php echo esc_url(home_url('/')); ?>">
                                <div class="input-group">
                                    <input class="form-control" type="search" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e('Search &hellip;', 'bootstrap-basic4'); ?>" title="<?php esc_attr_e('Search &hellip;', 'bootstrap-basic4'); ?>">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><?php _e('Search', 'bootstrap-basic4'); ?></button>
                                    </span>
                                </div>
                            </form><!--to override this search form, it is in <?php echo __FILE__; ?> -->