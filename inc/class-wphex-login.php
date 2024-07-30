<?php
/*
 * @package wphex
 * @since 1.0.0
 * */

if ( !defined('ABSPATH') ){
	exit(); // exit if access directly
}


if ( !class_exists('wphex_Master_Login_shortcodes') ){

	class wphex_Master_Login_shortcodes{

		/*
		* $instance
		* @since 1.0.0
		* */
		private static $instance;

		/**
		* construct()
		* @since 1.0.0
		* */
		public function __construct() {
			//social post share
			add_shortcode('wphex_user_login',array($this,'user_login'));
		}

		/**
	   * getInstance()
	   * @since 1.0.0
	   * */
		public static function getInstance(){
			if ( null == self::$instance ){
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Shortcode :: dizzcox_post_share
		 * @since 1.0.0
		 * */
		public static function user_login($atts, $content = null){

			$output = '<section class="wphex_login_form_wrapper">';
			
				global $user_login;
	
				// In case of a login error.
				if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ){
					$output .= '<div class="aa_error"><p>'. esc_html__( 'FAILED: Try again!', 'wphex-master' ).'</p></div>';
				}
	
				// If user is already logged in.
			if ( is_user_logged_in() ){
				$output .= '<div class="aa_logout">'.esc_html__( 'Hello ', 'wphex-master' ).'<span class="logged_user">'.$user_login.'</span></br>';
						
				$output .= '<p>'.esc_html__( 'You are already logged in.', 'wphex-master' ).'</p>'.'</div>';
		
				$output .= '<a id="wp-submit" href="'. wp_logout_url() .'" title="Logout">'.esc_html__( 'Logout', 'wphex-master' ).'</a>';
			}else{
				// Login form arguments.
				$args = array(
					'echo'           => false,
					'redirect'       => home_url( '/wp-admin/' ), //have to set condition if is admin then redirect admin panel other wise redirect homepage
					'form_id'        => 'loginform',
					'label_username' => __( 'Username' ,'wphex-master'),
					'label_password' => __( 'Password','wphex-master' ),
					'label_remember' => __( 'Remember Me' ,'wphex-master'),
					'label_log_in'   => __( 'Log In' ,'wphex-master'),
					'id_username'    => 'user_login',
					'id_password'    => 'user_pass',
					'id_remember'    => 'rememberme',
					'id_submit'      => 'wp-submit',
					'remember'       => true,
					'value_username' => NULL,
					'value_remember' => true
				); 

				// Calling the login form.
				$output .=	 wp_login_form( $args );
			}
			
			$output .= '</section>';

			return $output;
		}

	}//end class

	if ( class_exists('wphex_Master_Login_shortcodes') ){
		wphex_Master_Login_shortcodes::getInstance();
	}

}//end if
