<?php
/*
Plugin Name: Appgenix Master
Plugin URI: https://themeforest.net/user/ir-tech/portfolio
Description: Plugin to contain short codes and custom post types of the Appgenix theme.
Author: Sharifur
Author URI:https://themeforest.net/user/ir-tech
Version: 1.0
Text Domain: appgenix-master
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//plugin dir path
define( 'APPGENIX_MASTER_ROOT_PATH', plugin_dir_path( __FILE__ ) );
define( 'APPGENIX_MASTER_ROOT_URL', plugin_dir_url( __FILE__ ) );
define( 'APPGENIX_MASTER_SELF_PATH', 'appgenix-master/appgenix-master.php' );
define( 'APPGENIX_MASTER_VERSION', '1.0' );
define( 'APPGENIX_MASTER_INC', APPGENIX_MASTER_ROOT_PATH .'/inc');
define( 'APPGENIX_MASTER_LIB', APPGENIX_MASTER_ROOT_PATH .'/lib');
define( 'APPGENIX_MASTER_ELEMENTOR', APPGENIX_MASTER_ROOT_PATH .'/elementor');
define( 'APPGENIX_MASTER_DEMO_IMPORT', APPGENIX_MASTER_ROOT_PATH .'/demo-data-import');
define( 'APPGENIX_MASTER_ADMIN', APPGENIX_MASTER_ROOT_PATH .'/admin');
define( 'APPGENIX_MASTER_ADMIN_ASSETS', APPGENIX_MASTER_ROOT_URL .'admin/assets');
define( 'APPGENIX_MASTER_WP_WIDGETS', APPGENIX_MASTER_ROOT_PATH .'/wp-widgets');
define( 'APPGENIX_MASTER_ASSETS', APPGENIX_MASTER_ROOT_URL .'assets/');
define( 'APPGENIX_MASTER_CSS', APPGENIX_MASTER_ASSETS .'css');
define( 'APPGENIX_MASTER_JS', APPGENIX_MASTER_ASSETS .'js');
define( 'APPGENIX_MASTER_IMG', APPGENIX_MASTER_ASSETS .'img');

//load appgenix helpers functions
if (!function_exists('appgenix')){
    require_once APPGENIX_MASTER_LIB .'/codestar-framework/codestar-framework.php';
	require_once APPGENIX_MASTER_INC .'/class-appgenix-helper-functions.php';
	if (!function_exists('appgenix')){
		function appgenix(){
			return class_exists('Appgenix_Helper_Functions') ? new Appgenix_Helper_Functions() : false;
		}
	}
}
//load codester framework functions
if ( !appgenix()->is_appgenix_active()) {
	if ( file_exists( APPGENIX_MASTER_ROOT_PATH . '/inc/csf-functions.php' ) ) {
		require_once APPGENIX_MASTER_ROOT_PATH . '/inc/csf-functions.php';
	}
}

//plugin init
if ( file_exists( APPGENIX_MASTER_ROOT_PATH . '/inc/class-appgenix-master-init.php' ) ) {
	require_once APPGENIX_MASTER_ROOT_PATH . '/inc/class-appgenix-master-init.php';
}