<?php
/**
 * Hooks modification on WordPress original widgets.
 * 
 * @package bootstrap-basic4
 */


namespace BootstrapBasic4\Hooks;

if (!class_exists('\\BootstrapBasic4\\Hooks\\WidgetHooks')) {
    /**
     * This class will hook into WordPress original widgets such as calendar widget.
     */
    class WidgetHooks
    {


        /**
         * Add actions or filters that will be hook into WordPress widgets.
         * 
         * To use, just code as follows:
         * 
         * $WidgetHooks = new \BootstrapBasic4\Hooks\WidgetHooks();
         * $WidgetHooks->addActionsFilters();
         * 
         * That's it.
         */
        public function addActionsFilters()
        {
            // Modify calendar to support Bootstrap 4 style.
            add_filter('get_calendar', array(&$this, 'modifyCalendarWidget'), 10, 1);
        }// addActionsFilters


        /**
         * Modify calendar widget.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         * @param string $calendar The WordPress original calendar widget.
         */
        public function modifyCalendarWidget($calendar)
        {
            $new_calendar = preg_replace('#(<table*\s)(id="wp-calendar")#i', '$1 id="wp-calendar" class="table"', $calendar);
            $new_calendar = '<div class="table-responsive">' . $new_calendar . '</div>';
            return $new_calendar;
        }// modifyCalendarWidget


    }
}