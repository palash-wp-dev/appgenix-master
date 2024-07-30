<?php
/**
 *  appgenix about us widget
 * @package appgenix
 * @since 1.0.0
 */

if ( !defined('ABSPATH') ){
	exit(); //exit if access directly
}
class Appgenix_About_Us_Widget extends WP_Widget{

	public function __construct() {
		parent::__construct(
			'appgenix_about_us',
			esc_html__('appgenix: About Us','appgenix-master'),
			array(
                    'description' => esc_html__('Experience journey of building online business with unparall comprehensive','appgenix-master')
            )
		);

        // Enqueue necessary scripts for the media uploader.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_media'));

	}

    // Enqueue media uploader scripts.
    public function enqueue_media() {
        wp_enqueue_media();
    }

    public function form($instance){

		if (!isset($instance['bf_logo'])){
			$instance['bf_logo'] = '';
		}

		if (!isset($instance['bf_description'])){
			$instance['bf_description'] = '';
		}

		$social_icons = array(
			'facebook',
			'twitter',
			'linkedin',
			"instagram",
			"google-plus",
			"youtube",
		);

		foreach ( $social_icons as $sc ) {
			if ( ! isset( $instance[ $sc ] ) ) {
				$instance[ $sc ] = "";
			}
		}
		?>
        <div class="image-upload">
            <input type="file" class="widefat appgenix_logo_id" id="<?php echo esc_attr($this->get_field_id('bf_logo')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('bf_logo')) ?>"
                   value="<?php echo esc_attr($instance['bf_logo']); ?>"/>

            <div class="appgenix-logo-preview">
                <?php if (!empty($instance['bf_logo'])) : ?>
                    <img src="<?php echo esc_url(wp_get_attachment_url($instance['bf_logo'][0])); ?>" alt=""/>
                <?php endif; ?>
            </div>
        </div>


        <p>
			<label for="<?php echo esc_attr($this->get_field_name('bf_description'))?>"><?php esc_html_e('About Widget Description','appgenix-master')?></label>
        </p>
        <p>
			<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('bf_description'))?>" id="<?php echo esc_attr($this->get_field_id('bf_description'))?>" cols="30" class="appgenix-form-control" rows="5"><?php echo esc_html($instance['bf_description'])?></textarea>
		</p>

		<?php foreach ( $social_icons as $sci ) : ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( $sci ) ); ?>"><?php echo esc_html( ucfirst( $sci ) . " " . esc_html__( 'URL', 'appgenix-master' ) ); ?>
                    : </label>
                <br/>

                <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( $sci ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( $sci ) ); ?>"
                       value="<?php echo esc_attr( $instance[ $sci ] ); ?>"/>
                <small><?php echo esc_html__('Leave it blank if you don\'t want this social icon','appgenix-master')?></small>
            </p>
		<?php

		endforeach;

	}

	public function widget($args,$instance){

		$display_image = false;

		if(!empty($instance['bf_logo'])){
			$display_image=1;
			$image_src = wp_get_attachment_image_src($instance['bf_logo'],"full");
			$image_src_alt = get_post_meta($instance['bf_logo'],'_wp_attachment_image_alt',true);
		}

		$social_icons = array(
			'facebook',
			'twitter',
			'linkedin',
			"instagram",
			"google-plus",
			"youtube",
		);

		echo wp_kses_post($args['before_widget']);
		?>

		<?php if ($display_image):?>
            <div class="about_us_widget">
                <a href="<?php echo esc_url(home_url('/'));?>" class="footer_logo"> <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_2.png" alt="appgenix"></a>
            </div>

		<?php endif;?>
        <div class="footer_widget__inner mt-4">
        <p class="footer_widget__para"><?php echo esc_html($instance['bf_description'])?></p>

		<?php

		if ( !empty($instance['facebook']) || !empty($instance['twitter']) || !empty($instance['linkedin']) || !empty($instance['instagram']) || !empty($instance['google-plus']) || !empty($instance['youtube'])):
			printf('<ul class="footer_widget__social list_none mt-4">');
			foreach ( $social_icons as $social ):
				$url = trim( $instance[ $social ] );
				if ( ! empty( $url ) ) {
                        if( 'facebook' == $social ) {
                            printf( '<li class="lists"><a class="%2$s" href="%1$s"><i class="fa-brands fa-%2$s-f"></i></a></li>',esc_url( $url ) , esc_attr( $social ));
                        }
                        else {
                            printf('<li class="lists"><a class="%2$s" href="%1$s"><i class="fa-brands fa-%2$s"></i></a></li>', esc_url($url), esc_attr($social));
                        }
				}

			endforeach;

			echo wp_kses_post('</ul></div>')	;

		endif;

		echo wp_kses_post($args['after_widget']);
	}

	public function update($new_instance, $old_instance){
		$instance = array();

		$instance['bf_logo'] = ! empty( $new_instance['bf_logo'] ) ? sanitize_text_field($new_instance['bf_logo']) : '';
		$instance['bf_description'] = sanitize_text_field($new_instance['bf_description']);
		$instance['facebook']    = esc_url_raw( $new_instance['facebook'] );
		$instance['twitter']     = esc_url_raw( $new_instance['twitter'] );
		$instance['linkedin']    = esc_url_raw( $new_instance['linkedin'] );
		$instance['instagram']   = esc_url_raw( $new_instance['instagram'] );
		$instance['google-plus'] = esc_url_raw( $new_instance['google-plus'] );
		$instance['youtube']     = esc_url_raw( $new_instance['youtube'] );

		return $instance;
	}

}

if (!function_exists('Appgenix_About_Us_Widget')){
	function Appgenix_About_Us_Widget(){
		register_widget('Appgenix_About_Us_Widget');
	}

	add_action('widgets_init','Appgenix_About_Us_Widget');
}