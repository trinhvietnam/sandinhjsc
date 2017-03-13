<?php


defined('_JEXEC') or die('Restricted access');


	class UniteFunctionsWPUC{

		public static $urlSite;
		public static $urlAdmin;
		
		const SORTBY_NONE = "none";
		const SORTBY_ID = "ID";
		const SORTBY_AUTHOR = "author";
		const SORTBY_TITLE = "title";
		const SORTBY_SLUC = "name";
		const SORTBY_DATE = "date";
		const SORTBY_LAST_MODIFIED = "modified";
		const SORTBY_RAND = "rand";
		const SORTBY_COMMENT_COUNT = "comment_count";
		const SORTBY_MENU_ORDER = "menu_order";
		
		const ORDER_DIRECTION_ASC = "ASC";
		const ORDER_DIRECTION_DESC = "DESC";
		
		const THUMB_SMALL = "thumbnail";
		const THUMB_MEDIUM = "medium";
		const THUMB_LARGE = "large";
		const THUMB_FULL = "full";
		
		const STATE_PUBLISHED = "publish";
		const STATE_DRAFT = "draft";
		
		
		/**
		 * 
		 * init the static variables
		 */
		public static function initStaticVars(){
			//UniteFunctionsUC::printDefinedConstants();
			
			self::$urlSite = site_url();
			
			if(substr(self::$urlSite, -1) != "/")
				self::$urlSite .= "/";
			
			self::$urlAdmin = admin_url();			
			if(substr(self::$urlAdmin, -1) != "/")
				self::$urlAdmin .= "/";
				
		}

		
		/**
		 *
		 * get wp-content path
		 */
		public static function getPathUploads(){
			
			if(is_multisite()){
				if(!defined("BLOGUPLOADDIR")){
					$pathBase = self::getPathBase();
					$pathContent = $pathBase."wp-content/uploads/";
				}else
					$pathContent = BLOGUPLOADDIR;
			}else{
				$pathContent = WP_CONTENT_DIR;
				if(!empty($pathContent)){
					$pathContent .= "/";
				}
				else{
					$pathBase = self::getPathBase();
					$pathContent = $pathBase."wp-content/uploads/";
				}
			}
		
			return($pathContent);
		}
		
		
		/**
		 *
		 * simple enqueue script
		 */
		public static function addWPScript($scriptName){
			wp_enqueue_script($scriptName);
		}
		
		/**
		 *
		 * simple enqueue style
		 */
		public static function addWPStyle($styleName){
			wp_enqueue_style($styleName);
		}
		
		
		/**
		 *
		 * check if some db table exists
		 */
		public static function isDBTableExists($tableName){
			global $wpdb;
		
			if(empty($tableName))
				UniteFunctionsUC::throwError("Empty table name!!!");
		
			$sql = "show tables like '$tableName'";
		
			$table = $wpdb->get_var($sql);
		
			if($table == $tableName)
				return(true);
		
			return(false);
		}
		
		/**
		 *
		 * validate permission that the user is admin, and can manage options.
		 */
		public static function isAdminPermissions(){
		
			if( is_admin() &&  current_user_can("manage_options") )
				return(true);
		
			return(false);
		}
		
		
		/**
		 * add shortcode
		 */
		public static function addShortcode($shortcode, $function){
		
			add_shortcode($shortcode, $function);
		
		}
		
		/**
		 *
		 * add all js and css needed for media upload
		 */
		public static function addMediaUploadIncludes(){
		
			self::addWPScript("thickbox");
			self::addWPStyle("thickbox");
			self::addWPScript("media-upload");
		
		}
		
		/**
		 *
		 * get attachment image url
		 */
		public static function getUrlAttachmentImage($thumbID, $size = self::THUMB_FULL){
		
			$arrImage = wp_get_attachment_image_src($thumbID, $size);
			if(empty($arrImage))
				return(false);
		
			$url = UniteFunctionsUC::getVal($arrImage, 0);
			return($url);
		}
		
		/**
		 *
		 * get single post
		 */
		public static function getPost($postID, $addAttachmentImage = false, $getMeta = false){
		
			$post = get_post($postID);
			if(empty($post))
				UniteFunctionsUC::throwError("Post with id: $postID not found");
		
			$arrPost = $post->to_array();
		
			if($addAttachmentImage == true){
				$arrImage = self::getPostAttachmentImage($postID);
				if(!empty($arrImage))
					$arrPost["image"] = $arrImage;
			}
		
			if($getMeta == true)
				$arrPost["meta"] = self::getPostMeta($postID);
		
			return($arrPost);
		}
		
		/**
		 * get post meta data
		 */
		public static function getPostMeta($postID){
		
			$arrMeta = get_post_meta($postID);
			foreach($arrMeta as $key=>$item){
				if(is_array($item) && count($item) == 1)
					$arrMeta[$key] = $item[0];
			}
		
		
			return($arrMeta);
		}
		
		/**
		 * tells if the page is posts of pages page
		 */
		public static function isAdminPostsPage(){
			
			$screen = get_current_screen();
			$screenID = $screen->base;
			if(empty($screenID))
				$screenID = $screen->id;
			
			
			if($screenID != "page" && $screenID != "post")
				return(false);
			
			
			return(true);
		}
		
		
		
	}	//end of the class
	
	//init the static vars
	UniteFunctionsWPUC::initStaticVars();
	
?>