<?php
/**
 *  wphex about us widget
 * @package wphex
 * @since 1.0.0
 */
if ( !defined('ABSPATH') ){
    exit(); //exit if access directly
}

class Appgenix_WP_Form_Widget extends WP_Widget{

    public function __construct() {
        parent::__construct(
            'wphex_wp_search_form',
            esc_html__('wphex: WP Form','wphex-master'),
            array('description' => esc_html__('Display the WP Search Form','wphex-master'))
        );
    }

    public function form($instance){
        $title        = isset( $instance['title'] ) ? $instance['title'] : '';




        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wphex-master' ); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   value="<?php echo esc_attr( $title ) ?>">
        </p>






        <?php

    }
    public function widget($args,$instance){
        $title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        //widget title
        if ( ! empty( $title ) ) {
            echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );
        }

        echo wp_kses_post($args['before_widget']);

        ?>
        <?php
        echo '<div class="blog_details__sidebar__item">
            <div class="blog_details__sidebar__search">
                <form method="get" action="' . esc_url(home_url('/')) . '">
                    <input class="form--control" type="text" placeholder="' . esc_attr__('Search...', 'text-domain') . '" value="' . get_search_query() . '" name="s">
                    <span class="blog_details__sidebar__search__icon"><i class="fa-solid fa-search"></i></span>
                </form>
            </div>
        </div>'
        ?>

        <?php

        echo wp_kses_post($args['after_widget']);

    }

    public function update($new_instance, $old_instance){
        $instance = array();

        $instance['title']    = sanitize_text_field( $new_instance['title'] );



        return $instance;
    }
}

if (!function_exists('Appgenix_WP_Form_Widget')){
    function Appgenix_WP_Form_Widget(){
        register_widget('Appgenix_WP_Form_Widget');
    }
    add_action('widgets_init','Appgenix_WP_Form_Widget');
}
