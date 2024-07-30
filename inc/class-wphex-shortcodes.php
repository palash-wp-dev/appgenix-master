<?php
/*
 * @package wphex
 * @since 1.0.0
 * */

if ( !defined('ABSPATH') ){
	exit(); // exit if access directly
}


if ( !class_exists('wphex_Master_shortcodes') ){

	class wphex_Master_shortcodes{

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
			add_shortcode('wphex_post_share',array($this,'post_share'));

			//info_item
			add_shortcode('wphex_info_item_wrap',array(__CLASS__,'info_item_wrap'));
			add_shortcode('wphex_info_link',array(__CLASS__,'info_link'));
			add_shortcode('wphex_info_inline_text',array(__CLASS__,'info_inline_text'));

			//info item two
			add_shortcode('wphex_info_item_two_wrap',array(__CLASS__,'info_item_two_wrap'));
			add_shortcode('wphex_info_item_two',array(__CLASS__,'info_item_two'));
			//info item two
			add_shortcode('wphex_info_text_wrap',array(__CLASS__,'info_text_wrap'));
			add_shortcode('wphex_info_text_item',array(__CLASS__,'info_text_item'));
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
		public static function post_share($atts, $content = null){

			extract(shortcode_atts(array(
				'custom_class' => '',
			),$atts));

			global $post;
			$output = '';

			if ( is_singular() || is_home() ){

				//get current page url
				$wphex_url = urlencode_deep(get_permalink());
				//get current page title
				$wphex_title = str_replace(' ','%20',get_the_title($post->ID));
				//get post thumbnail for pinterest
				$wphex_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
				$wphex_thumbnail_url = is_array($wphex_thumbnail) && !empty($wphex_thumbnail[0]) ? $wphex_thumbnail[0] : '';
				//all social share link generate
				$facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u='.$wphex_url;
				$twitter_share_link = 'https://twitter.com/intent/tweet?text='.$wphex_title.'&amp;url='.$wphex_url.'&amp;via=Crunchify';
				$linkedin_share_link = 'https://www.linkedin.com/shareArticle?mini=true&url='.$wphex_url.'&amp;title='.$wphex_title;
				$pinterest_share_link = 'https://pinterest.com/pin/create/button/?url='.$wphex_url.'&amp;media='.$wphex_thumbnail_url.'&amp;description='.$wphex_title;

                $output .='<ul class="social-share">';
                $output .='<li class="title">'.esc_html__('Share:','wphex').'</li>';
                $output .='<li><a class="facebook" href="'.esc_url($facebook_share_link).'"><i class="fab fa-facebook-f"></i></a></li>';
                $output .='<li><a class="twitter" href="'.esc_url($twitter_share_link).'"><i class="fab fa-twitter"></i></a></li>';
                $output .='<li><a class="linkedin" href="'.esc_url($linkedin_share_link).'"><i class="fab fa-linkedin"></i></a></li>';
                $output .='<li><a class="pinterest" href="'.esc_url($pinterest_share_link).'"><i class="fab fa-pinterest-p"></i></a></li>';
                $output .='</ul>';

				return $output;

			}
		}

		/**
		 * info item two wrap
		 * @sicne 1.0.0
		 * */
		public static function info_item_two_wrap($atts,$content = null){
			extract(shortcode_atts(array(
				'custom_class' => '',
			),$atts));
			ob_start();?>
			<ul class="info-items-icon <?php echo esc_attr($custom_class);?>">
				<?php echo do_shortcode($content);?>
			</ul>
			<?php
			return ob_get_clean();
		}

		/**
		 * info item wrap
		 * @sicne 1.0.0
		 * */ 
		public static function info_item_wrap($atts,$content = null){
			extract(shortcode_atts(array(
				'custom_class' => '',
			),$atts));
			ob_start();?>
			<ul class="info-items <?php echo esc_attr($custom_class);?>">
				<?php echo do_shortcode($content);?>
			</ul>
			<?php
			return ob_get_clean();
		}
		/**
		 * info item two wrap
		 * @sicne 1.0.0
		 * */
		public static function info_text_wrap($atts,$content = null){
			extract(shortcode_atts(array(
				'custom_class' => '',
			),$atts));
			ob_start();?>
			<ul class="info-items-text <?php echo esc_attr($custom_class);?>">
				<?php echo do_shortcode($content);?>
			</ul>
			<?php
			return ob_get_clean();
		}


		/**
		 * Info Item link
		 * @since 1.0.0
		 * */
		public static function info_link($atts, $content = null){
			extract(shortcode_atts(array(
				'icon' => '',
				'text' => '',
				'url' => ''
			),$atts));

			$icon = (!empty($icon)) ? ' <i class="'.esc_attr($icon).'"></i> ' : '';
			ob_start();

			?>
			<li><a href="<?php echo esc_url($url)?>"><?php echo wp_kses_post($icon);?> <?php echo esc_html($text);?></a></li>
			<?php
			return ob_get_clean();
		}

		/**
		 * Info Item link
		 * @since 1.0.0
		 * */
		public static function info_item_two($atts, $content = null){
			extract(shortcode_atts(array(
				'icon' => '',
				'text' => '',
				'url' => ''
			),$atts));

			$icon = (!empty($icon)) ? ' <i class="'.esc_attr($icon).'"></i> ' : '';
			ob_start();

			?>
			<li><a href="<?php echo esc_url($url)?>" title="<?php echo esc_html($text);?>"><?php echo wp_kses_post($icon);?> </a></li>
			<?php
			return ob_get_clean();
		}

		/**
		 * Info text with link
		 * @sicne 1.0.0
		 * */
		public static function info_inline_text($atts,$content = null){
			extract(shortcode_atts(array(
				'title' => '',
				'url' => ''
			),$atts));

			ob_start();

			?>
			<li><a href="<?php echo esc_url($url)?>"><?php echo esc_html($text);?></a></li>
			<?php
			return ob_get_clean();
		}

		/**
		 * Info Item link
		 * @since 1.0.0
		 * */
		public static function info_text_item($atts, $content = null){
			extract(shortcode_atts(array(
				'icon' => '',
				'text' => '',
			),$atts));

			$icon = (!empty($icon)) ? ' <i class="'.esc_attr($icon).'"></i> ' : '';
			ob_start();

			?>
			<li><?php echo wp_kses_post($icon);?> <?php echo esc_html($text);?></li>
			<?php
			return ob_get_clean();
		}

	}//end class

	if ( class_exists('wphex_Master_shortcodes') ){
		wphex_Master_shortcodes::getInstance();
	}

}//end if
