<?php
/**
 * The left sidebar.
 * 
 * @package bootstrap-basic4
 * 
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact, Generic.WhiteSpace.ScopeIndent.Incorrect
 */


global $bootstrap_basic4_sidebar_left_size;
if (empty($bootstrap_basic4_sidebar_left_size) || !is_numeric($bootstrap_basic4_sidebar_left_size)) {
    $bootstrap_basic4_sidebar_left_size = 3;
}

if (is_active_sidebar('sidebar-left')) {
?> 
                <div id="sidebar-left" class="col-md-<?php echo esc_attr($bootstrap_basic4_sidebar_left_size); ?>">
                    <?php 
                    // use WordPress core hook.
                    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
                    do_action('before_sidebar'); 
                    ?> 
                    <?php dynamic_sidebar('sidebar-left'); ?> 
                </div>
<?php
}