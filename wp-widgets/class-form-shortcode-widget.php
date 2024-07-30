<?php
/**
 *  wphex about us widget
 * @package wphex
 * @since 1.0.0
 */
if ( !defined('ABSPATH') ){
    exit(); //exit if access directly
}

class Appgenix_Navigation_Menu_Widget extends WP_Widget{

    public function __construct() {
        parent::__construct(
            'wphex_navigation_menu',
            esc_html__('wphex: Fluent Form','wphex-master'),
            array('description' => esc_html__('Display the Fluent Form','wphex-master'))
        );
    }

    public function form($instance){
        $title        = isset( $instance['title'] ) ? $instance['title'] : '';

        if (!isset($instance['bf_fluent_form_shortcode'])){
            $instance['bf_fluent_form_shortcode'] = '';
        }
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wphex-master' ); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   value="<?php echo esc_attr( $title ) ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_name('bf_fluent_form_shortcode'))?>"><?php esc_html_e('Fluent Form Shortcode','wphex-master')?></label>
            <textarea name="<?php echo esc_attr($this->get_field_name('bf_fluent_form_shortcode'))?>" id="<?php echo esc_attr($this->get_field_id('bf_fluent_form_shortcode'))?>" cols="30" class="wphex-form-control" rows="5"><?php echo esc_html($instance['bf_fluent_form_shortcode'])?></textarea>
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

        $shortcode = $instance['bf_fluent_form_shortcode'];
        $output = do_shortcode($shortcode);

        ?>
        <p class="footer-widget-para"><?php echo $output?></p>
        <?php
        echo wp_kses_post($args['after_widget']);
    }

    public function update($new_instance, $old_instance){
        $instance = array();

        $instance['title']    = sanitize_text_field( $new_instance['title'] );
        $instance['bf_fluent_form_shortcode'] = sanitize_text_field($new_instance['bf_fluent_form_shortcode']);
        return $instance;
    }
}

if (!function_exists('Appgenix_Navigation_Menu_Widget')){
    function Appgenix_Navigation_Menu_Widget(){
        register_widget('Appgenix_Navigation_Menu_Widget');
    }
    add_action('widgets_init','Appgenix_Navigation_Menu_Widget');
}
