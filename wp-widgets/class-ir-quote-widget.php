<?php
/**
 *  wphex about us widget
 * @package wphex
 * @since 1.0.0
 */
if ( !defined('ABSPATH') ){
    exit(); //exit if access directly
}

class Appgenix_IR_Quote_Widget extends WP_Widget{

    public function __construct() {
        parent::__construct(
            'wphex_ir_quote',
            esc_html__('wphex: Quote','wphex-master'),
            array('description' => esc_html__('Display a quoted text','wphex-master'))
        );
    }

    public function form($instance){
        $title = isset( $instance['title'] ) ? $instance['title'] : '';


        if (!isset($instance['bf_quoter'])){
            $instance['bf_quoter'] = '';
        }
        if (!isset($instance['bf_quote'])){
            $instance['bf_quote'] = '';
        }

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wphex-master' ); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   value="<?php echo esc_attr( $title ) ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('bf_quoter')); ?>"><?php esc_html_e('Quote Name:', 'wphex-master'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('bf_quoter')) ?>"
                   name="<?php echo esc_attr($this->get_field_name('bf_quoter')); ?>"
                   value="<?php echo esc_attr($instance['bf_quoter']); ?>">
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_name('bf_quote'))?>"><?php esc_html_e('About Quote Description','wphex-master')?></label>
            <textarea name="<?php echo esc_attr($this->get_field_name('bf_quote'))?>" id="<?php echo esc_attr($this->get_field_id('bf_quote'))?>" cols="30" class="wphex-form-control" rows="5"><?php echo esc_html($instance['bf_quote']);?></textarea>
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
        echo '<blockquote class="blog_details__blockquote">
                <h6 class="blog_details__blockquote__title">'.esc_html($instance['bf_quoter']).'</h6>
                <span class="blog_details__blockquote__subtitle mt-3">'.esc_html($instance['bf_quote']).' </span>
            </blockquote>'
        ?>

        <?php

        echo wp_kses_post($args['after_widget']);

    }

    public function update($new_instance, $old_instance){
        $instance = array();

        $instance['title']    = sanitize_text_field( $new_instance['title'] );
        $instance['bf_quoter'] = (isset($new_instance['bf_quoter'])) ? sanitize_text_field($new_instance['bf_quoter']) : '';
        $instance['bf_quote'] = (isset($new_instance['bf_quoter'])) ? sanitize_text_field($new_instance['bf_quote']) : '';



        return $instance;
    }
}

if (!function_exists('Appgenix_IR_Quote_Widget')){
    function Appgenix_IR_Quote_Widget(){
        register_widget('Appgenix_IR_Quote_Widget');
    }
    add_action('widgets_init','Appgenix_IR_Quote_Widget');
}
