<?php
/**
 * Hooks modification on Bootstrap Basic 4 template.
 * 
 * @package bootstrap-basic4
 */


namespace BootstrapBasic4\Hooks;

if (!class_exists('\\BootstrapBasic4\\Hooks\\Bsb4Hooks')) {
    /**
     * This class will be hook into WordPress and make changes to the theme.<br>
     * If you want to hook to enable or add feature to the theme, please use \BootstrapBasic4\BootstrapBasic4() class.
     */
    class Bsb4Hooks
    {


        /**
         * Add actions or filters that will be hook into WordPress and make changes to this theme.
         * 
         * To use, just code as follows:
         * 
         * $Bsb4Hooks = new \BootstrapBasic4\Hooks\Bsb4Hooks();
         * $Bsb4Hooks->addActionsFilters();
         * 
         * That's it.
         */
        public function addActionsFilters()
        {
            // Change title separator from - to the configured in functions.php file.
            add_filter('document_title_separator', array(&$this, 'modifyTitleSeparator'), 10, 1);
            // Modift excerpt more text. (default is [...].)
            add_filter('excerpt_more', array(&$this, 'modifyExcerptMore'), 10, 1);
            // Modify pagination page link
            add_filter('wp_link_pages_link', array(&$this, 'paginationPageLink'), 10, 2);
            // Modify comment reply link class
            add_filter('comment_reply_link', array(&$this, 'modifyCommentReplyLinkClass'), 10, 1);
            // Modify comment navigation link attributes.
            add_filter('previous_comments_link_attributes', array($this, 'modifyCommentNavLinkPrevious'), 10, 1);
            add_filter('next_comments_link_attributes', array($this, 'modifyCommentNavLinkNext'), 10, 1);
            // Modify previous/next image link.
            add_filter('previous_image_link', array($this, 'modifyPreviousNextImageLink'));
            add_filter('next_image_link', array($this, 'modifyPreviousNextImageLink'));
        }// addActionsFilters


        /**
         * Modify comment navigation link (older comments, newer comments link).
         * 
         * @param string $attributes
         * @param string $nav
         * @return string
         */
        protected function modifyCommentNavLink($attributes, $nav)
        {
            $attributes = 'class="btn btn-light';
            if ($nav == 'next') {
                $attributes .= ' float-right';
            } else {
                $attributes .= ' float-left';
            }
            $attributes .= '"';

            return $attributes;
        }// modifyCommentNavLink


        /**
         * Modify comment navigation link
         * 
         * @param string $attributes
         * @return string
         */
        public function modifyCommentNavLinkNext($attributes)
        {
            return $this->modifyCommentNavLink($attributes, 'next');
        }// modifyCommentNavLinkNext


        /**
         * Modify comment navigation link
         * 
         * @param string $attributes
         * @return string
         */
        public function modifyCommentNavLinkPrevious($attributes)
        {
            return $this->modifyCommentNavLink($attributes, 'previous');
        }// modifyCommentNavLinkPrevious


        /**
         * Modify comment reply link class.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         * @param string $class The comment reply link class.
         * @return string Return modified class.
         */
        public function modifyCommentReplyLinkClass($class)
        {
            $class = str_ireplace('comment-reply-link', 'comment-reply-link btn btn-light btn-sm', $class);
            $class = str_ireplace('comment-reply-login', 'comment-reply-login btn btn-light btn-sm', $class);

            return $class;
        }// modifyCommentReplyLinkClass


        /**
         * Modify excerpt more text.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         * @param string $more Default more text is [...].
         * @return string Return the new more text.
         */
        public function modifyExcerptMore($more)
        {
            return ' &hellip;';
        }// modifyExcerptMore


        /**
         * Modify Previous/Next image link.
         * 
         * @link http://wordpress.stackexchange.com/questions/77296/adding-class-to-next-prev-image-link-in-attachment-php Reference.
         * @param string $link
         * @return string
         */
        public function modifyPreviousNextImageLink($link)
        {
            return str_replace( '<a ', '<a class="btn btn-outline-secondary" ', $link );
        }// modifyPreviousNextImageLink


        /**
         * Modify title separator.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         * @global string $bootstrapbasic4_title_separator
         * @return string Return the new title separator.
         */
        public function modifyTitleSeparator()
        {
            global $bootstrapbasic4_title_separator;

            return $bootstrapbasic4_title_separator;
        }// modifyTitleSeparator


        /**
         * Modify pagination page link
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         * @param string $link
         * @param integer $i
         */
        public function paginationPageLink($link, $i)
        {
            if (strpos($link, '<a') === false) {
                return '<li class="page-item active"><a class="page-link" href="#">' . $link . '</a></li>';
            } else {
                $link = str_ireplace('<a', '<a class="page-link"', $link);
                return '<li class="page-item">' . $link . '</li>';
            }
        }// paginationPageLink


    }
}