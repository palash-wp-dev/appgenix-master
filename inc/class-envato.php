<?php

/**
 * Author wphex
 * @since 1.0.0
 * */

if (!defined('ABSPATH')){
	exit(); //exit if access directly
}
if (!class_exists('wphex_Envato')){
	class wphex_Envato{
		//$instance variable
		private static $instance;
		public  $envato_api_base;
		public function __construct() {
			$this->envato_api_base = 'https://api.envato.com/v3/market';
			add_action('admin_post_extract_product_from_envato',array($this,'extract_product_info_from_envato'));
			add_action('admin_post_envato_purchase_verify',array($this,'envato_purchase_verify'));
		}
		/**
		 * get Instance
		 * @since 1.0.0
		 * */
		public static function getInstance(){
			if (null == self::$instance){
				self::$instance = new self();
			}
			return self::$instance;
		}
		/* get thumbnail by envato product id */
		public static function get_product_thumbnail_by_id($item_id,$post_id){
		    $query_args = http_build_query(['id' => $item_id]);
		    $thumbanil_image_id = '';
			$response = wp_remote_get("https://api.envato.com/v3/market/catalog/item?".$query_args,array(
				'headers' => [
					'User-Agent'=> $_SERVER['HTTP_USER_AGENT'],
					'Authorization'=> 'Bearer '. cs_get_option('envato_api_token')
				],
				'timeout' => 120
			));
			if (is_array($response) && !is_wp_error($response)){
				$body = json_decode($response['body']);
				
				 if (property_exists($body,'error')){
				     return '';
				 }
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/image.php');
					
				 //thumbnail image
				$thumbanil_image_id = media_sideload_image($body->previews->icon_preview->icon_url, $post_id, $body->name,'id' );
				$thumbnail_image_url = wp_get_attachment_image_src($thumbanil_image_id,'thumbnail');
			}
			return $thumbanil_image_id;
		}

		
		/* get update date by envato product id */
		public static function get_product_update_time_by_id($item_id){
		    $query_args = http_build_query(['id' => $item_id]);
		    $return_val = '';
			$response = wp_remote_get("https://api.envato.com/v3/market/catalog/item?".$query_args,array(
				'headers' => [
					'User-Agent'=> $_SERVER['HTTP_USER_AGENT'],
					'Authorization'=> 'Bearer '. cs_get_option('envato_api_token')
				],
				'timeout' => 120
			));
			if (is_array($response) && !is_wp_error($response)){
				$body = json_decode($response['body']);
				 if (property_exists($body,'error')){
				   return '0';
				 }
				 $return_val = $body->updated_at;
			}
			return $return_val;
		}		
		
		/* get price by envato product id */
		public static function get_product_price_by_id($item_id){
		    $query_args = http_build_query(['id' => $item_id]);
		    $product_price = '0';
			$response = wp_remote_get("https://api.envato.com/v3/market/catalog/item?".$query_args,array(
				'headers' => [
					'User-Agent'=> $_SERVER['HTTP_USER_AGENT'],
					'Authorization'=> 'Bearer '. cs_get_option('envato_api_token')
				],
				'timeout' => 120
			));
			if (is_array($response) && !is_wp_error($response)){
				$body = json_decode($response['body']);
				 if (property_exists($body,'error')){
				   return '0';
				 }
				 $product_price = number_format((float)$body->price_cents / 100,2);
			}
			return $product_price;
		}
		
		/* get sales by envato product id */
		public static function get_product_sales_by_id($item_id){
		    $query_args = http_build_query(['id' => $item_id]);
		    $product_sales = '0';
			$response = wp_remote_get("https://api.envato.com/v3/market/catalog/item?".$query_args,array(
				'headers' => [
					'User-Agent'=> $_SERVER['HTTP_USER_AGENT'],
					'Authorization'=> 'Bearer '. cs_get_option('envato_api_token')
				],
				'timeout' => 120
			));
			if (is_array($response) && !is_wp_error($response)){
				$body = json_decode($response['body']);
				 if (property_exists($body,'error')){
				   return '0';
				 }
				 $product_sales = $body->number_of_sales;
			}
			return $product_sales;
		}

		
		/* get rating by envato product id */
		public static function get_product_rating_by_id($item_id,$post_id){
		    $query_args = http_build_query(['id' => $item_id]);
		    $retur_val = [ 'rating' => 0,'rating_count' => 0];
			$response = wp_remote_get("https://api.envato.com/v3/market/catalog/item?".$query_args,array(
				'headers' => [
					'User-Agent'=> $_SERVER['HTTP_USER_AGENT'],
					'Authorization'=> 'Bearer '. cs_get_option('envato_api_token')
				],
				'timeout' => 120
			));
			if (is_array($response) && !is_wp_error($response)){
				$body = json_decode($response['body']);
				 if (property_exists($body,'error')){
				   return '0';
				 }
				$retur_val['rating'] = $body->rating;
				$retur_val['rating_count'] = $body->rating_count;
				update_post_meta($post_id,'wphex_rating',$body->rating);
				update_post_meta($post_id,'wphex_rating_count',$body->rating_count);

			}
			return $retur_val;
		}
		/**
		 * extract product from envato by product id
		 * @since 1.0.0
		 * */
		public function extract_product_info_from_envato(){
			$redirect_path = admin_url('/admin.php?page=envato-product-extract');
			if (!isset($_POST['item_id']) && !isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'],'extract_product_from_envato')){
				wp_die();
			}
			$query_args = http_build_query(['id' => $_POST['item_id']]);
			$response = wp_remote_get($this->envato_api_base."/catalog/item?".$query_args,array(
				'headers' => [
					'User-Agent'=> $_SERVER['HTTP_USER_AGENT'],
					'Authorization'=> 'Bearer '. cs_get_option('envato_api_token')
				],
				'timeout' => 120
			));
			if (is_array($response) && !is_wp_error($response)){
				$body = json_decode($response['body']);
				if (property_exists($body,'error')){
					wphex()->set_flash_message('purchase_status',404);
					wphex()->set_flash_message('purchase_message', $body->description);
					wp_safe_redirect($redirect_path);
					die();
				}

				/**
				 * insert basic product information
				 * */
				$name = property_exists($body,'name') ? $body->name : '';
				$description = property_exists($body,'name') ? $body->description : '';
				$insert_post_args = array(
					'post_content' => $description,
					'post_title' => $name,
					'post_status' => 'publish',
					'post_type' => 'download',
					'comment_status' => 'closed',
				);
				$post_id = wp_insert_post($insert_post_args);

				/**
				 * update products tags
				 * */
				$item_tags = property_exists($body,'tags') ? $body->tags : [];
				wp_set_object_terms($post_id,$item_tags,'download_tag');

				/**
				 * grab thumbnail & cover photo from envato
				 * and put them in database
				 * */

                require_once(ABSPATH . 'wp-admin/includes/media.php');
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/image.php');

				if (property_exists($body,'previews') && !empty($post_id)){
					$preview_images = $body->previews;
					//extract thumbnail from envato
					if (property_exists($preview_images,'icon_preview')){
						$thumbnail_image_id = media_sideload_image($preview_images->icon_preview->icon_url, $post_id, $name,'id' );
						$thumbnail_image_url = wp_get_attachment_image_src($thumbnail_image_id,'thumbnail');
						if (is_array($thumbnail_image_url)){
							//update data on database
							add_post_meta($post_id,'wphex_thumbnail',
								array(
									'id' => $thumbnail_image_id,
									'url' => $thumbnail_image_url[0],
									'thumbnail' => $thumbnail_image_url[0]
								)
							);
						}
					}
					//extract cover photo from envato
					if (property_exists($preview_images,'landscape_preview')){
						$featured_image_id = media_sideload_image($preview_images->landscape_preview->landscape_url,$post_id,$name,'id');
						set_post_thumbnail( $post_id, $featured_image_id );
					}
				}
				/**
				 *  Common Property with common order inter in meta data
				 * */

				$wphex_product_info = array(
					'envato_product_id' => property_exists($body,'id') ? $body->id : '',
					'type' => 'envato',
					'rating' => property_exists($body,'rating') ? $body->rating : '',
					'rating_count' => property_exists($body,'rating_count') ? $body->rating_count : '',
					'published_at' => property_exists($body,'published_at') ? $body->published_at : '',
					'updated_at' => property_exists($body,'updated_at') ? $body->updated_at : '',
					'item_url' => property_exists($body,'url') ? $body->url : ''
				);

				//update sales
				if (!empty($post_id) && property_exists($body,'number_of_sales')){
					add_post_meta($post_id,'_edd_download_sales', $body->number_of_sales);
				}
				//update price
				if (!empty($post_id) && property_exists($body,'price_cents')){
					add_post_meta($post_id,'edd_price', number_format($body->price_cents / 100,2));
				}

				if ($_POST['item_type'] == 'wordpress'){
					if (property_exists($body,'attributes')){
						$item_attributes = $body->attributes;

						foreach ($item_attributes as $att){
							$attrb = (array) $att;
							if (in_array('columns',$attrb)){
								$wphex_product_info['columns'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('compatible-browsers',$attrb)){
								$wphex_product_info['compatible_browsers'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('compatible-software',$attrb)){
								$wphex_product_info['compatible-software'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('compatible-with',$attrb)){
								$wphex_product_info['compatible-with'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('demo-url',$attrb)){
								$wphex_product_info['demo_url'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('documentation',$attrb)){
								$wphex_product_info['documentation'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('framework',$attrb)){
								$wphex_product_info['framework'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('gutenberg-optimized',$attrb)){
								$wphex_product_info['gutenberg-optimized'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('high-resolution',$attrb)){
								$wphex_product_info['high_resolution'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('themeforest-files-included',$attrb)){
								$wphex_product_info['themeforest_files_included'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('widget-ready',$attrb)){
								$wphex_product_info['widget_ready'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}
						}
					}
					if(!empty($post_id)){
						wp_set_object_terms($post_id,'wordpress-theme','download_category');
					}

				}elseif($_POST['item_type'] == 'react'){
					if (property_exists($body,'attributes')) {
						$item_attributes = $body->attributes;
						foreach ($item_attributes as $att){
							$attrb = (array) $att;
							if (in_array('columns',$attrb)){
								$wphex_product_info['columns'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('compatible-browsers',$attrb)){
								$wphex_product_info['compatible_browsers'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}
							else if (in_array('compatible-with',$attrb)){
								$wphex_product_info['compatible-with'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('demo-url',$attrb)){
								$wphex_product_info['demo_url'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('documentation',$attrb)){
								$wphex_product_info['documentation'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}
							else if (in_array('high-resolution',$attrb)){
								$wphex_product_info['high_resolution'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('themeforest-files-included',$attrb)){
								$wphex_product_info['themeforest_files_included'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('layout',$attrb)){
								$wphex_product_info['layout'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}
						}
					}
					if(!empty($post_id)){
						wp_set_object_terms($post_id,'react-template','download_category');
					}

				}elseif ($_POST['item_type'] == 'html'){

					if (property_exists($body,'attributes')) {
						$item_attributes = $body->attributes;
						foreach ($item_attributes as $att){
							$attrb = (array) $att;
							if (in_array('columns',$attrb)){
								$wphex_product_info['columns'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('compatible-browsers',$attrb)){
								$wphex_product_info['compatible_browsers'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}
							else if (in_array('compatible-with',$attrb)){
								$wphex_product_info['compatible-with'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}else if (in_array('demo-url',$attrb)){
								$wphex_product_info['demo_url'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('documentation',$attrb)){
								$wphex_product_info['documentation'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}
							else if (in_array('high-resolution',$attrb)){
								$wphex_product_info['high_resolution'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('layout',$attrb)){
								$wphex_product_info['layout'] = !empty($attrb['value']) ? $attrb['value'] : '';

							}else if (in_array('themeforest-files-included',$attrb)){
								$wphex_product_info['themeforest_files_included'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}
						}
					}

					if(!empty($post_id)){
						wp_set_object_terms($post_id,'html-template','download_category');
					}

				}elseif ($_POST['item_type'] == 'psd'){
					if (property_exists($body,'attributes')) {
						$item_attributes = $body->attributes;
						foreach ($item_attributes as $att){
							$attrb = (array) $att;
							if (in_array('compatible-software',$attrb)){
								$wphex_product_info['compatible-software'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}
							else if (in_array('graphics-files-included',$attrb)){
								$wphex_product_info['graphics_files_included'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

							}
						}
					}
					if(!empty($post_id)){
						wp_set_object_terms($post_id,'psd-template','download_category');
					}
				}elseif ($_POST['item_type'] == 'laravel'){
				    
					 if (property_exists($body,'attributes')){
                        $item_attributes = $body->attributes;

                        foreach ($item_attributes as $att){
                            $attrb = (array) $att;
                           if (in_array('compatible-browsers',$attrb)){
                                $wphex_product_info['compatible_browsers'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

                            }else if (in_array('compatible-software',$attrb)){
                                $wphex_product_info['compatible-software'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

                            }else if (in_array('demo-url',$attrb)){
                                $wphex_product_info['demo_url'] = !empty($attrb['value']) ? $attrb['value'] : '';

                            }else if (in_array('high-resolution',$attrb)){
                                $wphex_product_info['high_resolution'] = !empty($attrb['value']) ? $attrb['value'] : '';

                            }
                            else if (in_array('software-framework',$attrb)){
                                $wphex_product_info['software_framework'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

                            }else if (in_array('source-files-included',$attrb)){
                                $wphex_product_info['source-files-included'] = !empty($attrb['value']) ? implode(' , ',$attrb['value']) : '';

                            }
                        }
                    }
                    if(!empty($post_id)){
                        wp_set_object_terms($post_id,'laravel-script','download_category');
                    }
                    
				}

				if (!empty($post_id)){
					foreach ($wphex_product_info as $key => $value){
						add_post_meta($post_id,'wphex_'.$key,$value );
					}
				}

				wphex()->set_flash_message('purchase_status',200);
				wphex()->set_flash_message('extract_message',esc_html__('Product Extract & Imported Success'));
				wp_safe_redirect($redirect_path);

				die();
			}

			die();
		}
		/**
		 * purchase verify from envato using purchase code
		 * @since 1.0.0
		 * */
		public function envato_purchase_verify(){
			$redirect_path = admin_url('/admin.php?page=envato-purchase-verify');
			if (!isset($_POST['purchase_code']) || empty($_POST['purchase_code']) || !isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'],'envato_purchase_verify')){
				wp_safe_redirect($redirect_path);
				die();
			}
			$query_args = http_build_query(['code' => $_POST['purchase_code']]);
			$response = wp_remote_get($this->envato_api_base."/author/sale?".$query_args,array(
				'headers' => [
					'User-Agent'=> $_SERVER['HTTP_USER_AGENT'],
					'Authorization'=> 'Bearer '. cs_get_option('envato_api_token')
				],
				'timeout' => 120
			));
			if (is_array($response) && !is_wp_error($response)){
				$body = json_decode($response['body']);
				if ($body->error == 404){
					wphex()->set_flash_message('purchase_status',404);
					wphex()->set_flash_message('purchase_message', $body->description);
					wp_safe_redirect($redirect_path);
					die();
				}

				$purchase_verify_info = [
					'purchase_message' => esc_html__('Purchase Verify Success, Purchase Details Below','wphex'),
					'buyer' => $body->buyer,
					'license' => $body->license,
					'sold_at' => $body->sold_at,
					'purchase_count' => $body->purchase_count,
					'supported_until' => $body->supported_until,
					'item_name' => $body->item->name,
					'purchase_status' => 200,
				];

				foreach ($purchase_verify_info as $key => $message){
					wphex()->set_flash_message($key,$message);
				}
				wp_safe_redirect($redirect_path);
			}

			die();
		}

	}//end class
	if ( class_exists('wphex_Envato')){
		wphex_Envato::getInstance();
	}
}