<?php
/**
 * Bootstrap 4 utilities
 * 
 * @package bootstrap-basic4
 */


namespace BootstrapBasic4;

if (!class_exists('\\BootstrapBasic4\\Bootstrap4Utilities')) {
    /**
     * Bootstrap 4 utilities such as grid column size, classes, element styles.
     */
    class Bootstrap4Utilities
    {


        /**
         * Calculate main column size base on each sidebar column size and their widgets activated.
         * 
         * @global integer $bootstrapbasic4_sidebar_left_size The left sidebar column size.
         * @global integer $bootstrapbasic4_sidebar_right_size The right sidebar column size.
         */
        public static function getMainColumnSize()
        {
            global $bootstrapbasic4_sidebar_left_size, $bootstrapbasic4_sidebar_right_size;
            if ($bootstrapbasic4_sidebar_left_size == null || !is_numeric($bootstrapbasic4_sidebar_left_size)) {
                $bootstrapbasic4_sidebar_left_size = 3;
            }
            if ($bootstrapbasic4_sidebar_right_size == null || !is_numeric($bootstrapbasic4_sidebar_right_size)) {
                $bootstrapbasic4_sidebar_right_size = 3;
            }

            if (is_active_sidebar('sidebar-left') && is_active_sidebar('sidebar-right')) {
                $main_column_size = (12 - $bootstrapbasic4_sidebar_left_size - $bootstrapbasic4_sidebar_right_size);
            } elseif (is_active_sidebar('sidebar-left') && !is_active_sidebar('sidebar-right')) {
                $main_column_size = (12 - $bootstrapbasic4_sidebar_left_size);
            } elseif (!is_active_sidebar('sidebar-left') && is_active_sidebar('sidebar-right')) {
                $main_column_size = (12 - $bootstrapbasic4_sidebar_right_size);
            } else {
                $main_column_size = 12;
            }

            return $main_column_size;
        }// getMainColumnSize


    }
}