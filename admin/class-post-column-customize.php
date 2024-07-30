<?php

/**
 * Package Attrog
 * Author Ir-Tech
 * @since 1.0.0
 * */

if (!defined('ABSPATH')){
	exit(); //exit if access directly
}

if (!class_exists('wphex_Post_Column_Customize')){
	class wphex_Post_Column_Customize{
		//$instance variable
		private static $instance;
		
		public function __construct() {
			//practice area admin add table value hook
			add_filter("manage_edit-practice-area_columns", array($this, "edit_practice_area_columns") );
			add_action('manage_practice-area_posts_custom_column', array($this, 'add_thumbnail_columns'), 10, 2);
			//case study admin add table value hook
			add_filter("manage_edit-case-study_columns", array($this, "edit_case_study_columns") );
			add_action('manage_case-study_posts_custom_column', array($this, 'add_thumbnail_columns'), 10, 2);
			//case study admin add table value hook
			add_filter("manage_edit-attorney_columns", array($this, "edit_attorney_columns") );
			add_action('manage_attorney_posts_custom_column', array($this, 'add_thumbnail_columns'), 10, 2);
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

		/**
		 * edit practice area
		 * @since 1.0.0
		 * */
		public function edit_practice_area_columns($columns){

			$order = ( 'asc' == $_GET['order'] ) ? 'desc' : 'asc';
			$cat_title = $columns['taxonomy-practice-cat'];
			unset($columns);
			$columns['cb'] = '<input type="checkbox" />';
			$columns['title'] = esc_html__('Title','wphex-master');
			$columns['thumbnail'] = '<a href="edit.php?post_type=practice-area&orderby=title&order='.urlencode($order).'">'.esc_html__('Thumbnail','wphex-master').'</a>';
			$columns['taxonomy-practice-cat'] = '<a href="edit.php?post_type=practice-area&orderby=taxonomy&order='.urlencode($order).'">'.$cat_title.'<span class="sorting-indicator"></span></a>';
			$columns['date'] = esc_html__('Date','wphex-master');
			return $columns;
		}
		/**
		 * edit case study
		 * @since 1.0.0
		 * */
		public function edit_case_study_columns($columns){

			$order = ( 'asc' == $_GET['order'] ) ? 'desc' : 'asc';
			$cat_title = $columns['taxonomy-case-study-cat'];
			unset($columns);
			$columns['cb'] = '<input type="checkbox" />';
			$columns['title'] = esc_html__('Title','wphex-master');
			$columns['thumbnail'] = '<a href="edit.php?post_type=case-study&orderby=title&order='.urlencode($order).'">'.esc_html__('Thumbnail','wphex-master').'</a>';
			$columns['taxonomy-case-study-cat'] = '<a href="edit.php?post_type=case-study&orderby=taxonomy&order='.urlencode($order).'">'.$cat_title.'<span class="sorting-indicator"></span></a>';
			$columns['date'] = esc_html__('Date','wphex-master');
			return $columns;
		}

		/**
		 * edit attorney
		 * @since 1.0.0
		 * */
		public function edit_attorney_columns($columns){

			$order = ( 'asc' == $_GET['order'] ) ? 'desc' : 'asc';
			$cat_title = $columns['taxonomy-attorney-cat'];
			$practice_cat_title = $columns['taxonomy-attorney-practice'];
			unset($columns);
			$columns['cb'] = '<input type="checkbox" />';
			$columns['title'] = esc_html__('Title','wphex-master');
			$columns['thumbnail'] = '<a href="edit.php?post_type=attorney&orderby=title&order='.urlencode($order).'">'.esc_html__('Thumbnail','wphex-master').'</a>';
			$columns['taxonomy-attorney-cat'] = '<a href="edit.php?post_type=attorney&orderby=taxonomy&order='.urlencode($order).'">'.$cat_title.'<span class="sorting-indicator"></span></a>';
			$columns['taxonomy-attorney-practice'] = '<a href="edit.php?post_type=attorney&orderby=taxonomy&order='.urlencode($order).'">'.$practice_cat_title.'<span class="sorting-indicator"></span></a>';
			$columns['date'] = esc_html__('Date','wphex-master');
			return $columns;
		}

		/**
		 * add thumbnail
		 * @since 1.0.0
		 * */
		public function add_thumbnail_columns($column,$post_id){
			switch ( $column ) {
				case 'thumbnail' :
					echo '<a class="row-thumbnail" href="'.esc_url(admin_url('post.php?post='.$post_id.'&amp;action=edit')).'">'.get_the_post_thumbnail( $post_id, 'thumbnail' ).'</a>';
					break;
			}
		}

	}//end class
	if ( class_exists('wphex_Post_Column_Customize')){
		wphex_Post_Column_Customize::getInstance();
	}
}