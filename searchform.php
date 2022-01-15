<?php
/**
 * Widget template for display search form in search widget.
 * 
 * @package bootstrap-basic4
 */

$aria_label = '';
if (isset($args['aria_label']) && !empty($args['aria_label'])) {
    $aria_label = ' aria-label="' . esc_attr( $args['aria_label'] ) . '"';
}
$form_classes = '';
if (isset($args['bootstrapbasic4']['form_classes'])) {
    $form_classes = ' ' . $args['bootstrapbasic4']['form_classes'];
}
$show_button = true;
if (isset($args['bootstrapbasic4']['show_button']) && is_bool($args['bootstrapbasic4']['show_button'])) {
    $show_button = $args['bootstrapbasic4']['show_button'];
}
?> 
<form class="search-form form<?php echo $form_classes; ?>"<?php echo $aria_label; ?> role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="input-group">
        <input class="form-control" type="search" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e('Search &hellip;', 'bootstrap-basic4'); ?>" title="<?php esc_attr_e('Search &hellip;', 'bootstrap-basic4'); ?>">
        <?php if ($show_button === true) { ?> 
        <span class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit"><?php _e('Search', 'bootstrap-basic4'); ?></button>
        </span>
        <?php }// endif; ?> 
    </div>
</form><!--to override this search form, it is in <?php echo __FILE__; ?> -->