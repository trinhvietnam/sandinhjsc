<?php
/**
 * @package Addon Creator
 * @author UniteCMS.net / Valiano
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');


	class UniteSettingsOutputInlineUC extends UniteSettingsOutputUC{
		
		
		/**
		 * constuct function
		 */
		public function __construct(){
			$this->isParent = true;
			self::$serial++;
			$this->wrapperID = "unite_settings_wide_output_".self::$serial;
			$this->settingsMainClass = "unite-settings-inline";
			$this->showDescAsTips = true;
		}
		
		
		/**
		 * draw settings row
		 * @param $setting
		 */
		protected function drawSettingRow($setting){
		
			//set cellstyle:
			$cellStyle = "";
			if(isset($setting[UniteSettingsUC::PARAM_CELLSTYLE])){
				$cellStyle .= $setting[UniteSettingsUC::PARAM_CELLSTYLE];
			}
			
			if($cellStyle != "")
				 $cellStyle = "style='".$cellStyle."'";
			
			$textStyle = $this->drawSettingRow_getTextStyle($setting);
			
			$rowStyle = $this->drawSettingRow_getRowStyle($setting);
			
			$rowClass = $this->drawSettingRow_getRowClass($setting, "unite-setting-row");
			
			$text = $this->drawSettingRow_getText($setting);
			
			$description = UniteFunctionsUC::getVal($setting,"description");
			
			
			$addField = UniteFunctionsUC::getVal($setting, UniteSettingsUC::PARAM_ADDFIELD);
			
			?>
						
				<div id="<?php echo $setting["id_row"]?>" <?php echo $rowStyle ?> <?php echo $rowClass?>>
					
					<div class="unite-setting-text" <?php echo $textStyle?> >
						<?php if($this->showDescAsTips == true): ?>
					    	<span class='setting_text' title="<?php echo $description?>"><?php echo $text?></span>
					    <?php else:?>
					    	<?php echo $text?>
					    <?php endif?>
					</div>
					<div class="unite-setting-content" <?php echo $cellStyle?>>
						<?php 
							$this->drawInputs($setting);
							$this->drawInputAdditions($setting);
						?>
					</div>
				</div>
			<?php
		}

		/**
		 * draw wrapper end after settings
		 */
		protected function drawSettingsAfter(){
		
			?><div class="unite-clear"></div><?php
		}
		
		
	
	}
?>