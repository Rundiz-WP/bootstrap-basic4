<?php
/**
 * Bootstrap 4 utilities.
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
            if (!is_numeric($bootstrapbasic4_sidebar_left_size)) {
                $bootstrapbasic4_sidebar_left_size = 3;
            }
            if (!is_numeric($bootstrapbasic4_sidebar_right_size)) {
                $bootstrapbasic4_sidebar_right_size = 3;
            }

            $full_column_size = apply_filters('bootstrap_basic4_full_column_size', 12);
            if (!is_numeric($full_column_size)) {
                $full_column_size = 12;
            }

            if (is_active_sidebar('sidebar-left') && is_active_sidebar('sidebar-right')) {
                $main_column_size = ($full_column_size - $bootstrapbasic4_sidebar_left_size - $bootstrapbasic4_sidebar_right_size);
            } elseif (is_active_sidebar('sidebar-left') && !is_active_sidebar('sidebar-right')) {
                $main_column_size = ($full_column_size - $bootstrapbasic4_sidebar_left_size);
            } elseif (!is_active_sidebar('sidebar-left') && is_active_sidebar('sidebar-right')) {
                $main_column_size = ($full_column_size - $bootstrapbasic4_sidebar_right_size);
            } else {
                $main_column_size = $full_column_size;
            }

            return $main_column_size;
        }// getMainColumnSize


        /**
         * Check if currently there are any selected widget block name.
         * 
         * @link https://wordpress.stackexchange.com/a/392496/41315 Original source code.
         * @param string $blockName The widget block name to check.
         * @return bool Return `true` if found, return `false` if not found or this site is using older version of WordPress that is not supported widget blocks.
         */
        public static function hasWidgetBlock($blockName)
        {
            if (!is_string($blockName)) {
                return false;
            }

            $widget_blocks = get_option('widget_block');
            if (
                (is_array($widget_blocks) || is_object($widget_blocks)) && 
                !empty($widget_blocks) && 
                function_exists('has_block')
            ) {
                foreach ($widget_blocks as $widget_block) {
                    if (
                        isset($widget_block['content']) && 
                        !empty($widget_block['content']) && 
                        has_block($blockName, $widget_block['content'])
                    ) {
                        // if found selected widget block name.
                        unset($widget_block, $widget_blocks);
                        return true;
                    }
                }// endforeach;
                unset($widget_block);
            }

            unset($widget_blocks);
            return false;
        }// hasWidgetBlock


    }
}