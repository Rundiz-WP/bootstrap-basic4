<?php
/**
 * The right sidebar.
 * 
 * @package bootstrap-basic4
 */


global $bootstrapbasic4_sidebar_right_size;
if ($bootstrapbasic4_sidebar_right_size == null || !is_numeric($bootstrapbasic4_sidebar_right_size)) {
    $bootstrapbasic4_sidebar_right_size = 3;
}

if (is_active_sidebar('sidebar-right')) {
?> 
                <div id="sidebar-right" class="col-md-<?php echo $bootstrapbasic4_sidebar_right_size; ?>">
                    <?php do_action('before_sidebar'); ?> 
                    <?php dynamic_sidebar('sidebar-right'); ?> 
                </div>
<?php
}