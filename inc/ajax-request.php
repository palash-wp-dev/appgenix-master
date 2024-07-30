<?php

/**
 * Author Xgenious
 * @since 1.0.0
 * */

if (!defined('ABSPATH')) {
    exit(); //exit if access directly
}
if (!class_exists('Xgenious_Master_Ajax_Request')) {
    class Xgenious_Master_Ajax_Request
    {
//$instance variable
        private static $instance;

        public function __construct()
        {
            add_action('wp_ajax_wedoc_search_form_ajax', array($this, 'wedoc_search'));
            add_action('wp_ajax_nopriv_wedoc_search_form_ajax', array($this, 'wedoc_search'));
        }

        /**
         * get Instance
         * @since 1.0.0
         * */
        public static function getInstance()
        {
            if (null == self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function wedoc_search()
        {
            if ($_POST['action'] !== 'wedoc_search_form_ajax') {
                return;
            }

            $query_args = [
                'post_type' => 'docs',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'ignore_sticky_posts' => false,
                's' => strip_tags(trim($_POST['q'])),
                'sentence' => true,
                'parent' => 0
            ];
            $queried_doc = new \WP_Query($query_args);

            $output = '';
            $docs = [];
            while ($queried_doc->have_posts()) {
                $queried_doc->the_post();

                // arrange the docs
                $sections = get_children([
                    'post_parent' => get_the_ID(),
                    'post_type' => 'docs',
                    'post_status' => 'publish',
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                ]);

                $arranged[] = [
                    'doc' => [
                        'title' => get_the_title(),
                        'id' => get_the_ID()
                    ],
                    'sections' => $sections,
                ];

                $docs = $arranged;
            }
            wp_reset_postdata();

            if ($docs) {
                foreach ($docs as $main_doc){
                    $output .= '<div class="wedoc-single-search-item">';
                    $output .= '<h4 class="title"><a href="' . esc_url(get_permalink($main_doc['doc']['id'])) . '">' . esc_html($main_doc['doc']['title']) . '</a></h4>';
                    if ($main_doc['sections']) {
                        $output .= ' <ul class="wedoc-seclist">';
                        foreach ($main_doc['sections'] as $section) {
                            $output .= '<li class="wedoc-sec-item"><a href="' . get_the_permalink($section->ID) . '">' . esc_html($section->post_title) . '</a></li>';
                        }
                        $output .= '</ul>';
                    }

                    $output .= '</div>';
                }
            }

            echo $output;
            die();
        }


    }//end class

}
if (class_exists('Xgenious_Master_Ajax_Request')) {
    Xgenious_Master_Ajax_Request::getInstance();
}