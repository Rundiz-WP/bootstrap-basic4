                            <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                                <div class="input-group">
                                    <input class="form-control" type="search" name="s" value="<?php esc_attr_e(get_search_query()); ?>" placeholder="<?php esc_attr_e('Search &hellip;', 'bootstrap-basic4'); ?>" title="<?php esc_attr_e('Search &hellip;', 'bootstrap-basic4'); ?>">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><?php _e('Search', 'bootstrap-basic4'); ?></button>
                                    </span>
                                </div>
                            </form><!--to override this search form, it is in <?php echo __FILE__; ?> -->