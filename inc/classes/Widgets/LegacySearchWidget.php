<?php
/**
 * Theme widgets
 * 
 * @package bootstrap-basic4
 * @since 1.3.0
 * @license http://opensource.org/licenses/MIT MIT
 */


namespace BootstrapBasic4\Widgets;

if (!class_exists('\\BootstrapBasic4\\Widgets\\LegacySearchWidget')) {
    class LegacySearchWidget extends \WP_Widget
    {


        /**
         * @var bool Is this widget on navbar or not? Set this to true to use navbar align (navbar-left, navbar-right).
         */
        private $is_navbar = true;

        /**
         * @var bool Show search button or not? Set to true to show search button, false to hide search button. If set to false users have to press enter to begin search.
         */
        private $show_button = true;


        /**
         * @var string Widget title.
         */
        private $widget_title;


        /**
         * Class construction for theme search widget.
         */
        public function __construct()
        {
            parent::__construct(
                    'bootstrapbasic4_legacysearch_widget', // base ID
                    __('Bootstrap Legacy Search', 'bootstrap-basic4'), 
                    ['description' => __('Display Search widget for Bootstrap that can be use in sidebar.', 'bootstrap-basic4')]
            );
        }// __construct


        /**
         * back-end widget form
         * 
         * @see WP_Widget::form()
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) 
        {
            // search widget title
            if (isset($instance['bootstrapbasic4-legacysearch-widget-title'])) {
                $this->widget_title = $instance['bootstrapbasic4-legacysearch-widget-title'];
            }

            // is navbar
            if (isset($instance['bootstrapbasic4-legacysearch-is_navbar']) && is_bool($instance['bootstrapbasic4-legacysearch-is_navbar'])) {
                $is_navbar = $instance['bootstrapbasic4-legacysearch-is_navbar'];
            } else {
                $is_navbar = $this->is_navbar;
            }

            // show search button
            if (isset($instance['bootstrapbasic4-legacysearch-show_button']) && is_bool($instance['bootstrapbasic4-legacysearch-show_button'])) {
                $show_button = $instance['bootstrapbasic4-legacysearch-show_button'];
            } else {
                $show_button = $this->show_button;
            }

            // output form
            $output = '<p>';
            $output .= '<label for="' . $this->get_field_id('bootstrapbasic4-legacysearch-widget-title') . '">' . __('Title:', 'bootstrap-basic4') . '</label>';
            $output .= '<input id="' . $this->get_field_id('bootstrapbasic4-legacysearch-widget-title') . '" class="widefat" type="text" value="' . esc_attr($this->widget_title) . '" name="' . $this->get_field_name('bootstrapbasic4-legacysearch-widget-title') . '">';
            $output .= '</p>';
            // is navbar
            $output .= '<p>';
            $output .= '<input id="' . $this->get_field_id('bootstrapbasic4-legacysearch-is_navbar') . '" type="checkbox" name="' . $this->get_field_name('bootstrapbasic4-legacysearch-is_navbar') . '" value="true"' . (true === $is_navbar ? ' checked="checked"' : '') . '>';
            $output .= '<label for="' . $this->get_field_id('bootstrapbasic4-legacysearch-is_navbar') . '">' . __('Is this search on navigation bar?', 'bootstrap-basic4') . '</label>';
            $output .= '</p>';
            $output .= '<p>';
            $output .= '<input id="' . $this->get_field_id('bootstrapbasic4-legacysearch-show_button') . '" type="checkbox" name="' . $this->get_field_name('bootstrapbasic4-legacysearch-show_button') . '" value="true"' . (true === $show_button ? ' checked="checked"' : '') . '>';
            $output .= '<label for="' . $this->get_field_id('bootstrapbasic4-legacysearch-show_button') . '">' . __('Show search button', 'bootstrap-basic4') . '</label>';
            $output .= '</p>';

            echo $output;

            unset($output);
        }// form


        /**
         * Sanitize widget form values as they are saved.
         * 
         * @see WP_Widget::update()
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) 
        {
            $instance = [];

            if (isset($new_instance['bootstrapbasic4-legacysearch-widget-title'])) {
                $instance['bootstrapbasic4-legacysearch-widget-title'] = strip_tags($new_instance['bootstrapbasic4-legacysearch-widget-title']);
            } else {
                $instance['bootstrapbasic4-legacysearch-widget-title'] = '';
            }

            if (isset($new_instance['bootstrapbasic4-legacysearch-is_navbar']) && 'true' === $new_instance['bootstrapbasic4-legacysearch-is_navbar']) {
                $instance['bootstrapbasic4-legacysearch-is_navbar'] = true;
            } else {
                $instance['bootstrapbasic4-legacysearch-is_navbar'] = false;
            }

            if (isset($new_instance['bootstrapbasic4-legacysearch-show_button']) && 'true' === $new_instance['bootstrapbasic4-legacysearch-show_button']) {
                $instance['bootstrapbasic4-legacysearch-show_button'] = true;
            } else {
                $instance['bootstrapbasic4-legacysearch-show_button'] = false;
            }

            return $instance;
        }// update


        /**
         * front-end display of widget
         * 
         * @see WP_Widget::widget()
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) 
        {
            $widget_title = $this->widget_title;
            if (isset($instance['bootstrapbasic4-legacysearch-widget-title'])) {
                $widget_title = $instance['bootstrapbasic4-legacysearch-widget-title'];
            }

            // is navbar
            if (isset($instance['bootstrapbasic4-legacysearch-is_navbar']) && is_bool($instance['bootstrapbasic4-legacysearch-is_navbar'])) {
                $is_navbar = $instance['bootstrapbasic4-legacysearch-is_navbar'];
            } else {
                $is_navbar = $this->is_navbar;
            }

            // show search button
            if (isset($instance['bootstrapbasic4-legacysearch-show_button']) && is_bool($instance['bootstrapbasic4-legacysearch-show_button'])) {
                $show_button = $instance['bootstrapbasic4-legacysearch-show_button'];
            } else {
                $show_button = $this->show_button;
            }

            // set output front-end widget ---------------------------------
            $output = $args['before_widget'];

            if (
                isset($instance['bootstrapbasic4-legacysearch-widget-title']) && 
                !empty($instance['bootstrapbasic4-legacysearch-widget-title']) &&
                true !== $is_navbar
            ) {
                $output .= $args['before_title'] . apply_filters('widget_title', $instance['bootstrapbasic4-legacysearch-widget-title']) . $args['after_title'] . "\n";
            }

            $searchFormArgs = [];
            $searchFormArgs['echo'] = false;
            $searchFormArgs['bootstrapbasic4']['form_classes'] = (true === $is_navbar ? 'form-inline' : 'normal-sidebar-search-form');
            $searchFormArgs['bootstrapbasic4']['show_button'] = $show_button;

            $output .= get_search_form($searchFormArgs);
            unset($searchFormArgs);

            $output .= $args['after_widget'];

            echo $output;

            // clear unused variables
            unset($output);
        }// widget


    }
}