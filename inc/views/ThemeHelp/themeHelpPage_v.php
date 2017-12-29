<div class="wrap">
    <h2><?php _e('Bootstrap Basic4 help', 'bootstrap-basic4'); ?></h2>

    <h3><?php _e('Notice', 'bootstrap-basic4'); ?></h3>
    <p><?php echo sprintf(__('Please note that Bootstrap 4 currently is still in beta (%s). So, any update in the future may change the html structure or class name.', 'bootstrap-basic4'), '2017-12-29'); ?></p>

    <h3><?php _e('Menu', 'bootstrap-basic4'); ?></h3>
    <p><?php _e('To display menu correctly, please create at least 1 menu and set as primary and save.', 'bootstrap-basic4'); ?></p>

    <h3><?php _e('Bootstrap features', 'bootstrap-basic4'); ?></h3>
        <p><?php _e('This theme can use all Bootstrap 4 classes, elements and styles. Please read the <a href="https://getbootstrap.com/docs/4.0" target="bootstrap4_doc">Bootstrap 4 document</a>.', 'bootstrap-basic4'); ?></p>

    <h3><?php _e('Responsive image', 'bootstrap-basic4'); ?></h3>
    <p><?php echo sprintf(__('For responsive image please add img-fluid class to img element. Example: %s', 'bootstrap-basic4'), '<code>&lt;img src=&quot;...&quot; alt=&quot;&quot; class=&quot;img-fluid&quot;&gt;</code>'); ?></p>

    <h3><?php _e('Responsive video', 'bootstrap-basic4'); ?></h3>
    <?php echo sprintf(__('Cloak video element (video element or embeded video) with %s.', 'bootstrap-basic4'), '<code>&lt;div class=&quot;flexvideo&quot;&gt;...&lt;/div&gt;</code>'); ?>

    <?php do_action('bootstrapbasic4_theme_help_content'); ?>

    <p style="margin-top: 20px;"><span style="font-size: 1.2rem;"><?php _e('&#128147;', 'bootstrap-basic4'); ?></span> <?php _e('If my theme can help you, your jobs, your projects please <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9HQE4GVV4KTZE" target="donations_link">buy me some foods</a>.', 'bootstrap-basic4'); ?></p>
</div>