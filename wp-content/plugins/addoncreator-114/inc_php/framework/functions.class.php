<?php
/**
 * @package Addon Creator
 * @author UniteCMS.net / Valiano
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');


	class UniteFunctionsUC{
		
		public static function throwError($message,$code=null){
			if(!empty($code))
				throw new Exception($message);
			else
				throw new Exception($message);
		}

		//------------------------------------------------------------
		// get variable from post or from get. get wins.
		public static function getPostGetVariable($name,$initVar = ""){
			$var = $initVar;
			if(isset($_POST[$name])) $var = $_POST[$name];
			else if(isset($_GET[$name])) $var = $_GET[$name];
			return($var);
		}
		
		
		//------------------------------------------------------------
		
		public static function getPostVariable($name,$initVar = ""){
			$var = $initVar;
			if(isset($_POST[$name])) $var = $_POST[$name];
			return($var);
		}
		
		//------------------------------------------------------------
		
		
		public static function getGetVar($name,$initVar = ""){
			$var = $initVar;
			if(isset($_GET[$name])) $var = $_GET[$name];
			return($var);
		}
		
				
		public static function z________________ARRAYS_______________(){}
		
		
		/**
		 * get value from array. if not - return alternative
		 */
		public static function getVal($arr,$key,$altVal=""){
						
			if(isset($arr[$key]))
			  return($arr[$key]);
			
			return($altVal);
		}
		
		
		/**
		 * get first not empty key from array
		 */
		public static function getFirstNotEmptyKey($arr){
		
			foreach($arr as $key=>$item){
				if(!empty($key))
					return($key);
			}
		
			return("");
		}
		
		
		/**
		 * filter array, leaving only needed fields - also array
		 *
		 */
		public static function filterArrFields($arr, $fields, $isFieldsAssoc = false){
			$arrNew = array();
			
			if($isFieldsAssoc == false){
				foreach($fields as $field){
					if(array_key_exists($field, $arr))
						$arrNew[$field] = $arr[$field];
				}
			}else{
				foreach($fields as $field=>$value){
					if(array_key_exists($field, $arr))
						$arrNew[$field] = $arr[$field];
				}
			}
			
			return($arrNew);
		}
		
		
		/**
		 * Convert std class to array, with all sons
		 */
		public static function convertStdClassToArray($d){
		
			if (is_object($d)) {
				$d = get_object_vars($d);
			}
			
			if (is_array($d)){
			
				return array_map(array("UniteFunctionsUC","convertStdClassToArray"), $d);
			} else {
				return $d;
			}
			
		}
		
		
		/**
		 *
		 * get random array item
		 */
		public static function getRandomArrayItem($arr){
			$numItems = count($arr);
			$rand = rand(0, $numItems-1);
			$item = $arr[$rand];
			return($item);
		}
		
		/**
		 * get different values in $arr from the default $arrDefault
		 * $arrMustKeys - keys that must be in the output
		 *
		 */
		public static function getDiffArrItems($arr, $arrDefault, $arrMustKeys = array()){
		
			if(gettype($arrDefault) != "array")
				return($arr);
		
			if(!empty($arrMustKeys))
				$arrMustKeys = UniteFunctionsUC::arrayToAssoc($arrMustKeys);
		
			$arrValues = array();
			foreach($arr as $key => $value){
		
				//treat must value
				if(array_key_exists($key, $arrMustKeys) == true){
					$arrValues[$key] = self::getVal($arrDefault, $key);
					if(array_key_exists($key, $arr) == true)
						$arrValues[$key] = $arr[$key];
					continue;
				}
		
				if(array_key_exists($key, $arrDefault) == false){
					$arrValues[$key] = $value;
					continue;
				}
		
				$defaultValue = $arrDefault[$key];
				if($defaultValue != $value){
					$arrValues[$key] = $value;
					continue;
				}
		
			}
		
			return($arrValues);
		}
		
		/**
		 *
		 * Convert array to assoc array by some field
		 */
		public static function arrayToAssoc($arr,$field=null){
			$arrAssoc = array();
		
			foreach($arr as $item){
				if(empty($field))
					$arrAssoc[$item] = $item;
				else
					$arrAssoc[$item[$field]] = $item;
			}
		
			return($arrAssoc);
		}
		
		
		/**
		 *
		 * convert assoc array to array
		 */
		public static function assocToArray($assoc){
			$arr = array();
			foreach($assoc as $item)
				$arr[] = $item;
		
			return($arr);
		}
		
		/**
		 *
		 * convert assoc array to array
		 */
		public static function assocToArrayKeyValue($assoc, $keyName, $valueName, $firstItem = null){
			
			$arr = array();
			if(!empty($firstItem))
				$arr = $firstItem;
			
			foreach($assoc as $item){
				if(!array_key_exists($keyName, $item))
					UniteFunctionsUC::throwError("field: $keyName not found in array");
				
				if(!array_key_exists($valueName, $item))
					UniteFunctionsUC::throwError("field: $valueName not found in array");
				
				$key = $item[$keyName];
				$value = $item[$valueName];
				
				$arr[$key] = $value;
			}
		
			return($arr);
		}
		
		
		/**
		 *
		 * do "trim" operation on all array items.
		 */
		public static function trimArrayItems($arr){
			if(gettype($arr) != "array")
				UniteFunctionsUC::throwError("trimArrayItems error: The type must be array");
		
			foreach ($arr as $key=>$item)
				$arr[$key] = trim($item);
		
			return($arr);
		}
		
		/**
		 *
		 * encode array into json for client side
		 */
		public static function jsonEncodeForClientSide($arr){
			
			if(empty($arr))
				$arr = array();
						
			$json = json_encode($arr);
			$json = addslashes($json);
			
			$json = "'".$json."'";
		
			return($json);
		}
		
		
		/**
		 * encode json for html data like data-key="json"
		 */
		public static function jsonEncodeForHtmlData($arr, $dataKey=""){
			$strJson = "";
			if(!empty($arr)){
				$strJson = json_encode($arr);
				$strJson = htmlspecialchars($strJson);
			}
			if(!empty($dataKey))
				$strJson = " data-{$dataKey}=\"{$strJson}\"";
			
			return($strJson);
		}
		
		
		public static function z______________STRINGS_____________(){}
		
		/**
		 * get random string
		 */
		public static function getRandomString($length = 10, $numbersOnly = false){
		
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
			if($numbersOnly == true)
				$characters = '0123456789';
				
			$randomString = '';
		
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
		
			return $randomString;
		}
		
		
		/**
		 * limit string chars to max size
		 */
		public static function limitStringSize($str, $numChars, $addDots = true){
			
			if(function_exists("mb_strlen") == false)
				return($str);
				
			if(mb_strlen($str) <= $numChars)
				return($str);
			
			if($addDots)
				$str = mb_substr($str, 0, $numChars-3)."...";				
			else
				$str = mb_substr($str, 0, $numChars);
			
			return($str);
		}
		
		
		/**
		 * convert array to xml
		 */
		public static function arrayToXML($array, $rootName, $xml = null){
			
			if($xml === null){
				$xml = new SimpleXMLElement("<{$rootName}/>");
				self::arrayToXML($array, $rootName, $xml);
				
				$strXML = $xml->asXML();
				
				if($strXML === false)
					UniteFunctionsUC::throwError("Wrong xml output");
				
				return($strXML);
			}
			
			//for inner elements:
			foreach($array as $key => $value){
				
				if(is_numeric($key))
					$key = 'item' . $key;
				
				if(is_array($value)){
					$node = $xml->addChild($key);
					self::arrayToXML($value,$rootName,$node);
				}
				else{
					$xml->addChild($key, htmlspecialchars($value));
				}
			}
			
		}
		
		
		/**
		 * format xml string
		 */
		public static function formatXmlString($xml){
	
			$xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
			$token      = strtok($xml, "\n");
			$result     = '';
			$pad        = 0;
			$matches    = array();
			while ($token !== false) :
			if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
			$indent=0;
			elseif (preg_match('/^<\/\w/', $token, $matches)) :
			$pad--;
			$indent = 0;
			elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
			$indent=1;
			else :
			$indent = 0;
			endif;
			$line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
			$result .= $line . "\n";
			$token   = strtok("\n");
			$pad    += $indent;
			endwhile;
			return $result;
		}		
		
		public static function z______________URLS_____________(){}
		
		/**
		 *
		 * get url contents
		 */
		public static function getUrlContents($url,$arrPost=array(),$method = "post",$debug=false){
			$ch = curl_init();
			$timeout = 0;
		
			$strPost = '';
			foreach($arrPost as $key=>$value){
				if(!empty($strPost))
					$strPost .= "&";
				$value = urlencode($value);
				$strPost .= "$key=$value";
			}
		
		
			//set curl options
			if(strtolower($method) == "post"){
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$strPost);
			}
			else	//get
				$url .= "?".$strPost;
		
			//remove me
			//Functions::addToLogFile(SERVICE_LOG_SERVICE, "url", $url);
		
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
			$headers = array();
			$headers[] = "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8";
			$headers[] = "Accept-Charset:utf-8;q=0.7,*;q=0.7";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
			$response = curl_exec($ch);
		
			if($debug == true){
				dmp($url);
				dmp($response);
				exit();
			}
		
			if($response == false)
				throw new Exception("getUrlContents Request failed");
		
			curl_close($ch);
			return($response);
		}
		
		
		/**
		 * convert url to handle
		 *
		 */
		public static function urlToHandle($url = ''){
						
			// Replace all weird characters with dashes
			$url = preg_replace('/[^\w\-'. '~_\.' . ']+/u', '-', $url);
		
			// Only allow one dash separator at a time (and make string lowercase)
			return mb_strtolower(preg_replace('/--+/u', '-', $url), 'UTF-8');
		}
		
		
		/**
		 * add params to url
		 */
		public static function addUrlParams($url, $params){
			
			if(empty($params))
				return($url);
			
			if(strpos($url, "?") !== false)
				$url .= "&";
			else
				$url .= "?";
			
			$url .= $params;
			
			return($url);
		}
		
		
		public static function z______________VALIDATIONS_____________(){}
		
		
		/**
		 * 
		 * validate that some file exists, if not - throw error
		 */
		public static function validateFilepath($filepath,$errorPrefix=null){
			if(file_exists($filepath) == true)
				return(false);
			if($errorPrefix == null)
				$errorPrefix = "File";
			$message = $errorPrefix." $filepath not exists!";
			self::throwError($message);
		}
		
		/**
		 *
		 * validate that some directory exists, if not - throw error
		 */
		public static function validateDir($pathDir, $errorPrefix=null){
			if(is_dir($pathDir) == true)
				return(false);
			
			if($errorPrefix == null)
				$errorPrefix = "Directory";
			$message = $errorPrefix." $pathDir not exists!";
			self::throwError($message);
		}
		
		//--------------------------------------------------------------
		//validate if some directory is writable, if not - throw a exception
		private static function validateWritable($name,$path,$strList,$validateExists = true){
		
			if($validateExists == true){
				//if the file/directory doesn't exists - throw an error.
				if(file_exists($path) == false)
					throw new Exception("$name doesn't exists");
			}
			else{
				//if the file not exists - don't check. it will be created.
				if(file_exists($path) == false) return(false);
			}
		
			if(is_writable($path) == false){
				chmod($path,0755);		//try to change the permissions
				if(is_writable($path) == false){
					$strType = "Folder";
					if(is_file($path)) $strType = "File";
					$message = "$strType $name is doesn't have a write permissions. Those folders/files must have a write permissions in order that this application will work properly: $strList";
					throw new Exception($message);
				}
			}
		}
		
		
		/**
		 * 
		 * validate that some value is numeric
		 */
		public static function validateNumeric($val,$fieldName=""){
			self::validateNotEmpty($val,$fieldName);
			
			if(empty($fieldName))
				$fieldName = "Field";
			
			if(!is_numeric($val))
				self::throwError("$fieldName should be numeric ");
		}
		
		/**
		 * 
		 * validate that some variable not empty
		 */
		public static function validateNotEmpty($val,$fieldName=""){
			
			if(empty($fieldName))
				$fieldName = "Field";
				
			if(empty($val) && is_numeric($val) == false)
				self::throwError("Field <b>$fieldName</b> should not be empty");
		}

		
		/**
		 * check the php version. throw exception if the version beneath 5
		 */
		private static function validatePHPVersion(){
			$strVersion = phpversion();
			$version = (float)$strVersion;
			if($version < 5) 
				self::throwError("You must have php5 and higher in order to run the application. Your php version is: $version");
		}
		
		
		/**
		 * valiadte if gd exists. if not - throw exception
		 * @throws Exception
		 */
		public static function validateGD(){
			if(function_exists('gd_info') == false)
				throw new Exception("You need GD library to be available in order to run this application. Please turn it on in php.ini");
		}
		
		
		/**
		 * return if the variable is alphanumeric
		 */
		public static function isAlphaNumeric($val){
			$match = preg_match('/^[\w_]+$/', $val);
			
			if($match == 0)
				return(false);
			
			return(true);
		}
		
		/**
		 * validate id's list, allowed only numbers and commas
		 * @param $val
		 */
		public static function validateIDsList($val, $fieldName=""){
			
			if(empty($val))
				return(true);
			
			$match = preg_match('/^[0-9,]+$/', $val);
			
			if($match == 0)
				self::throwError("Field <b>$fieldName</b> allow only numbers and comas.");
				
		}
		
		
		/**
		 * validate that the value is alphanumeric
		 * underscores also alowed
		 */
		public static function validateAlphaNumeric($val, $fieldName=""){
			
			if(empty($fieldName))
				$fieldName = "Field";
			
			if(self::isAlphaNumeric($val) == false)
				self::throwError("Field <b>$fieldName</b> allow only english words, numbers and underscore.");
		
		}
		
		
		/**
		 *
		 * convert php array to js array text
		 * like item:"value"
		 */
		public static function phpArrayToJsArrayText($arr, $tabPrefix="			"){
			$str = "";
			$length = count($arr);
		
			$counter = 0;
			foreach($arr as $key=>$value){
				$str .= $tabPrefix."{$key}:\"{$value}\"";
				$counter ++;
				if($counter != $length)
					$str .= ",\n";
			}
		
			return($str);
		}
		
		public static function z______________FILE_SYSTEM_____________(){}
		
		
		
		/**
		 *
		 * if directory not exists - create it
		 * @param $dir
		 */
		public static function checkCreateDir($dir){
			if(!is_dir($dir))
				mkdir($dir);
		}
		
		
		//------------------------------------------------------------
		//get path info of certain path with all needed fields
		public static function getPathInfo($filepath){
			$info = pathinfo($filepath);
		
			//fix the filename problem
			if(!isset($info["filename"])){
				$filename = $info["basename"];
				if(isset($info["extension"]))
					$filename = substr($info["basename"],0,(-strlen($info["extension"])-1));
				$info["filename"] = $filename;
			}
		
			return($info);
		}
		
		
		
		//------------------------------------------------------------
		//save some file to the filesystem with some text
		public static function writeFile($str,$filepath){
			$fp = fopen($filepath,"w+");
			fwrite($fp,$str);
			fclose($fp);
		}
		
		
		/**
		 *
		 * get list of all files in the directory
		 */
		public static function getFileList($path){
			$dir = scandir($path);
			$arrFiles = array();
			foreach($dir as $file){
				if($file == "." || $file == "..") continue;
				$filepath = $path . "/" . $file;
				if(is_file($filepath)) $arrFiles[] = $file;
			}
			return($arrFiles);
		}

		
		/**
		 * get recursive file list inside folder and subfolders
		 */
		public static function getFileListTree($path, $filetype = null, $arrFiles = null){
			
			if(empty($arrFiles))
				$arrFiles = array();
			
			if(is_dir($path) == false)
				return($arrFiles);
			
			$path = self::addPathEndingSlash($path);
			
			$arrPaths = scandir($path);
			foreach($arrPaths as $file){
				if($file == "." || $file == "..")
					continue;
				
				$filepath = $path.$file;
				
				if(is_dir($filepath)){
					$arrFiles = self::getFileListTree($filepath, $filetype, $arrFiles);
				}

				$info = pathinfo($filepath);
				
				$ext = self::getVal($info, "extension");
				$ext = strtolower($ext);
				
				if(!empty($filetype) && $filetype != $ext)
					continue;
				
				$arrFiles[] = $filepath;
			}
			
			
			return($arrFiles);
		}
		
		
		/**
		 *
		 * get list of all directories in the directory
		 */
		public static function getDirList($path){
			$arrDirs = scandir($path);
		
			$arrFiles = array();
			foreach($arrDirs as $dir){
				if($dir == "." || $dir == "..")
					continue;
				$dirpath = $path . "/" . $dir;
		
				if(is_dir($dirpath))
					$arrFiles[] = $dir;
			}
		
			return($arrFiles);
		}
		
		
		//------------------------------------------------------------
		//save some file to the filesystem with some text
		public static function writeDebug($str,$filepath="debug.txt",$showInputs = true){
			$post = print_r($_POST,true);
			$server = print_r($_SERVER,true);
		
			if(getType($str) == "array")
				$str = print_r($str,true);
		
			if($showInputs == true){
				$output = "--------------------"."\n";
				$output .= $str."\n";
				$output .= "Post: ".$post."\n";
			}else{
				$output = "---"."\n";
				$output .= $str . "\n";
			}
		
			if(!empty($_GET)){
				$get = print_r($_GET,true);
				$output .= "Get: ".$get."\n";
			}
		
			//$output .= "Server: ".$server."\n";
		
			$fp = fopen($filepath,"a+");
			fwrite($fp,$output);
			fclose($fp);
		}
		
		
		/**
		 *
		 * clear debug file
		 */
		public static function clearDebug($filepath = "debug.txt"){
		
			if(file_exists($filepath))
				unlink($filepath);
		}
		
		/**
		 *
		 * save to filesystem the error
		 */
		public static function writeDebugError(Exception $e,$filepath = "debug.txt"){
			$message = $e->getMessage();
			$trace = $e->getTraceAsString();
		
			$output = $message."\n";
			$output .= $trace."\n";
		
			$fp = fopen($filepath,"a+");
			fwrite($fp,$output);
			fclose($fp);
		}
		
		
		//------------------------------------------------------------
		//save some file to the filesystem with some text
		public static function addToFile($str,$filepath){
			$fp = fopen($filepath,"a+");
			fwrite($fp,"---------------------\n");
			fwrite($fp,$str."\n");
			fclose($fp);
		}
		
		/**
		 *
		 * recursive delete directory or file
		 */
		public static function deleteDir($path,$deleteOriginal = true, $arrNotDeleted = array(),$originalPath = ""){
		
			if(empty($originalPath))
				$originalPath = $path;
		
			//in case of paths array
			if(getType($path) == "array"){
				$arrPaths = $path;
				foreach($path as $singlePath)
					$arrNotDeleted = self::deleteDir($singlePath,$deleteOriginal,$arrNotDeleted,$originalPath);
				return($arrNotDeleted);
			}
		
			if(!file_exists($path))
				return($arrNotDeleted);
		
			if(is_file($path)){		// delete file
				$deleted = unlink($path);
				if(!$deleted)
					$arrNotDeleted[] = $path;
			}
			else{	//delete directory
				$arrPaths = scandir($path);
				foreach($arrPaths as $file){
					if($file == "." || $file == "..")
						continue;
					$filepath = realpath($path."/".$file);
					$arrNotDeleted = self::deleteDir($filepath,$deleteOriginal,$arrNotDeleted,$originalPath);
				}
		
				if($deleteOriginal == true || $originalPath != $path){
					$deleted = @rmdir($path);
					if(!$deleted)
						$arrNotDeleted[] = $path;
				}
		
			}
		
			return($arrNotDeleted);
		}
		
		
		/**
		 * copy directory contents to another directory
		 */
		public static function copyDir($src,$dst) {
			$dir = opendir($src);
			@mkdir($dst);
			while(false !== ( $file = readdir($dir)) ) {
				if (( $file != '.' ) && ( $file != '..' )) {
					if ( is_dir($src . '/' . $file) ) {
						self::copyDir($src . '/' . $file,$dst . '/' . $file);
					}
					else {
						copy($src . '/' . $file,$dst . '/' . $file);
					}
				}
			}
			closedir($dir);
		}		
		
		
		/**
		 * add ending to the path
		 */
		public static function addPathEndingSlash($path){
		
			$slashType = (strpos($path, '\\')===0) ? 'win' : 'unix';
		
			$lastChar = substr($path, strlen($path)-1, 1);
		
			if ($lastChar != '/' && $lastChar != '\\')
				$path .= ($slashType == 'win') ? '\\' : '/';
		
			return($path);
		}
		
		
		/**
		 * remove path ending slash
		 */
		public static function removePathEndingSlash($path){
			$path = rtrim($path, "/");
			$path = rtrim($path,"\\");
			
			return($path);
		}
		
		
		/**
		 * convert path to unix format slashes
		 */
		public static function pathToUnix($path){
			$path = str_replace('\\', '/', $path);
			$path = preg_replace('/\/+/', '/', $path); // Combine multiple slashes into a single slash
			
			return($path);
		}
		
		
		/**
		 * convert path to relative path, based on basepath
		 */
		public static function pathToRelative($path, $basePath){
			
			$path = str_replace($basePath, "", $path);
			$path = ltrim($path, '/');
			return($path);
		}
		
		/**
		 * join paths
		 * @param $path
		 */
		public static function joinPaths($basePath, $path){
			
			$newPath = $basePath."/".$path;
			$newPath = self::pathToUnix($newPath);
			return($newPath);
		}
		
		
		/**
		 * turn path to realpath
		 * output only unix format, if not found - return ""
		 * @param $path
		 */
		public static function realpath($path, $addEndingSlash = true){
			
			$path = realpath($path);
			if(empty($path))
				return($path);
			
			$path = self::pathToUnix($path);
			
			if(is_dir($path) && $addEndingSlash == true)
				$path .= "/";
			
			return($path);
		}
		
		
		/**
		 * check if path under base path
		 */
		public static function isPathUnderBase($path, $basePath){
						
			$path = self::pathToUnix($path);
			$basePath = self::pathToUnix($basePath);
			
			if(strpos($path, $basePath) === 0)
				return(true);
			
			return(false);
		}
		
		
		public static function z______________OTHERS_____________(){}

		//---------------------------------------------------------------------------------------------------
		// convert timestamp to time string
		public static function timestamp2Time($stamp){
			$strTime = date("H:i",$stamp);
			return($strTime);
		}
		
		//---------------------------------------------------------------------------------------------------
		// convert timestamp to date and time string
		public static function timestamp2DateTime($stamp){
			$strDateTime = date("d M Y, H:i",$stamp);
			return($strDateTime);
		}
		
		//---------------------------------------------------------------------------------------------------
		// convert timestamp to date string
		public static function timestamp2Date($stamp){
			$strDate = date("d M Y",$stamp);	//27 Jun 2009
			return($strDate);
		}
		
		
		/**
		 * 
		 * strip slashes from textarea content after ajax request to server
		 */
		public static function normalizeTextareaContent($content){
			if(empty($content))
				return($content);
			$content = stripslashes($content);
			$content = trim($content);
			return($content);
		}
		
				
		/**
		 * Download Image
		 */
		public function downloadImage($filepath, $filename, $mimeType=""){
			$contents = file_get_contents($filepath);
			$filesize = strlen($contents);
		
			if($mimeType == ""){
				$info = UniteFunctionsUC::getPathInfo($filepath);
				$ext = $info["extension"];
				$mimeType = "image/$ext";
			}
		
			header("Content-Type: $mimeType");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Length: $filesize");
			echo $contents;
			exit();
		}
		
		
		/**
		 * send file to download
		 */
		public static function downloadFile($filepath, $filename = null){
			
			UniteFunctionsUC::validateFilepath($filepath,"export file");
			
			if(empty($filename))
				$filename = basename($filepath);
			
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));
			readfile($filepath);
			exit();
		}

		
		/**
		 *
		 * convert string to boolean
		 */
		public static function strToBool($str){
			if(is_bool($str))
				return($str);
		
			if(empty($str))
				return(false);
		
			if(is_numeric($str))
				return($str != 0);
		
			$str = strtolower($str);
			if($str == "true")
				return(true);
		
			return(false);
		}
		
		/**
		 * bool to str
		 */
		public static function boolToStr($bool){
			$bool = self::strToBool($bool);
			
			if($bool == true)
				return("true");
			else
				return("false");
		}
		
		
		//------------------------------------------------------------
		// get black value from rgb value
		public static function yiq($r,$g,$b){
			return (($r*0.299)+($g*0.587)+($b*0.114));
		}
		
		//------------------------------------------------------------
		// convert colors to rgb
		public static function html2rgb($color){
			if ($color[0] == '#')
				$color = substr($color, 1);
			if (strlen($color) == 6)
				list($r, $g, $b) = array($color[0].$color[1],
						$color[2].$color[3],
						$color[4].$color[5]);
			elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
			else
				return false;
			$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
			return array($r, $g, $b);
		}
		
		/**
		 * 
		 *turn some object to string
		 */
		public static function toString($obj){
			return(trim((string)$obj));
		}

		
		/**
		 * 
		 * remove utf8 bom sign
		 * @return string
		 */
		public static function remove_utf8_bom($content){
			$content = str_replace(chr(239),"",$content);
			$content = str_replace(chr(187),"",$content);
			$content = str_replace(chr(191),"",$content);
			$content = trim($content);
			return($content);
		}
		
		
		/**
		 * print the path to this function
		 */
		public static function printPath(){
			
			try{
				throw new Exception("We are here");
			}catch(Exception $e){
				dmp($e->getTraceAsString());
				exit();
			}
			
		}
		
		
		
	}
	
?>