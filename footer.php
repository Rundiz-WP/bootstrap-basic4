<?php
/** 
 * The theme footer.
 * 
 * @package bootstrap-basic4
 */
?>
            </div><!--.site-content-->


            <footer id="site-footer" class="site-footer page-footer">
                <div id="footer-row" class="row">
                    <div class="col-md-6 footer-left">
                        <?php 
                        if (!dynamic_sidebar('footer-left')) {
                            /* translators: %s: WordPress text with link. */
                            printf(__('Powered by %s', 'bootstrap-basic4'), '<a href="https://wordpress.org" rel="nofollow">WordPress</a>');
                            echo ' | ';
                            if (function_exists('the_privacy_policy_link')) {
                                the_privacy_policy_link('', ' | ');
                            }
                            /* translators: %s: Bootstrap Basic 4 text with link. */
                            printf(__('Theme: %s', 'bootstrap-basic4'), '<a href="https://rundiz.com" rel="nofollow">Bootstrap Basic4</a>');
                        } 
                        ?> 
                    </div>
                    <div class="col-md-6 footer-right text-right">
                        <?php dynamic_sidebar('footer-right'); ?> 
                    </div>
                </div>
            </footer><!--.page-footer-->
        </div><!--.page-container-->


        <!--WordPress footer-->
        <?php wp_footer(); ?> 
        <!--end WordPress footer-->
    </body>
</html>
