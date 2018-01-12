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
                            printf(__('Powered by %s', 'bootstrap-basic4'), '<a href="https://wordpress.org" rel="nofollow">WordPress</a>');
                            echo ' | ';
                            printf(__('Theme: %s', 'bootstrap-basic4'), '<a href="http://rundiz.com" rel="nofollow">Bootstrap Basic4</a>');
                        } 
                        ?> 
                    </div>
                    <div class="col-md-6 footer-right text-right">
                        <?php dynamic_sidebar('footer-right'); ?> 
                    </div>
                </div>
            </footer><!--.page-footer-->
        </div><!--.page-container-->


        <!--wordpress footer-->
        <?php wp_footer(); ?> 
        <!--end wordpress footer-->
    </body>
</html>
