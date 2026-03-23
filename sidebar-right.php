<?php
/**
 * The right sidebar.
 * 
 * @package bootstrap-basic4
 * 
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact, Generic.WhiteSpace.ScopeIndent.Incorrect
 */


global $bootstrap_basic4_sidebar_right_size;
if (empty($bootstrap_basic4_sidebar_right_size) || !is_numeric($bootstrap_basic4_sidebar_right_size)) {
    $bootstrap_basic4_sidebar_right_size = 3;
}

if (is_active_sidebar('sidebar-right')) {
?> 
                <div id="sidebar-right" class="col-md-<?php echo esc_attr($bootstrap_basic4_sidebar_right_size); ?>">
                    <?php 
                    // use WordPress core hook.
                    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
                    do_action('before_sidebar'); 
                    ?> 
                    <?php dynamic_sidebar('sidebar-right'); ?> 
                </div>
<?php
}
