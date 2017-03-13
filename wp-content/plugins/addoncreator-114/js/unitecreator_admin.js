function UniteCreatorAdmin(){
	
	var t = this;
	var g_providerAdmin = new UniteProviderAdminUC();
	var g_objIncludes = new UniteCreatorIncludes();
	
	var g_generalSettings = new UniteSettingsUC();
	
	var g_paramsEditorMain = new UniteCreatorParamsEditor()
	var g_paramsEditorItems = new UniteCreatorParamsEditor()
	
	var g_objDialogParam = new UniteCreatorParamsDialog();
	var g_objDialogItemVariable = new UniteCreatorParamsDialog();
	var g_objDialogMainVariable	= new UniteCreatorParamsDialog();
	
	var g_codemirrorCss = null, g_codemirrorJs = null;
	var g_codemirrorHtmlItem = null, g_codemirrorHtml = null;
	var g_codemirrorHtmlItem2 = null, g_objButtonsPanel;
	
	var g_objAssetsManager = new UCAssetsManager();
	var g_objAssetsIncludes = new UCAssetsManager();
	var g_settingsItem = new UniteSettingsUC();
	var g_addonID = null, g_objItemSettingsWrapper, g_objWrapperItems;
	
	//param panels
	var g_paramsPanelMain = new UniteCreatorParamsPanel();
	
	var g_paramsPanelItem = new UniteCreatorParamsPanel();
	var g_paramsPanelItem2 = new UniteCreatorParamsPanel();
	
	var g_paramsPanelJs = new UniteCreatorParamsPanel();
	var g_paramsPanelCss = new UniteCreatorParamsPanel();
	
	var g_objVariables = new UniteCreatorVariables();
	
	
	var g_temp = {
			isAssetsUpdated: false,
			includesLoadPath: ""
	};
	
	
	if(!g_ucAdmin)
		var g_ucAdmin = new UniteAdminUC();
	

	function ____________COMMON____________(){};
	
	
	/**
	 * get addon options
	 */
	function getAddonOptions(){
		
		//get item settings
		var data = g_settingsItem.getSettingsValues();
		data.path_assets = t.getPathAssets();
		
		var generalSettingsData = g_generalSettings.getSettingsValues();
		
		data = jQuery.extend(data, generalSettingsData);
		
		return(data);
	}
	
	
	/**
	 * get data from addon view
	 */
	function getDataFromAddonView(){
		
		var objParams = g_paramsEditorMain.getParamsData();
		var objParamsItems = g_paramsEditorItems.getParamsData();
		
		var html = g_codemirrorHtml ? g_codemirrorHtml.getValue() : jQuery("#area_addon_html").val();
		var htmlItem = g_codemirrorHtmlItem ? g_codemirrorHtmlItem.getValue() : jQuery("#area_addon_html_item").val();
		var htmlItem2 = g_codemirrorHtmlItem2 ? g_codemirrorHtmlItem2.getValue() : jQuery("#area_addon_html_item2").val();
		
		var css = g_codemirrorCss ? g_codemirrorCss.getValue() : jQuery("#area_addon_css").val();
		var js = g_codemirrorJs ? g_codemirrorJs.getValue() : jQuery("#area_addon_js").val();
		
		var dataIncludes = g_objIncludes.getIncludesTabData();
		
		var options = getAddonOptions();
				
		var variables_item = g_objVariables.getArrVars(g_objVariables.types.ITEM);		
		var variables_main = g_objVariables.getArrVars(g_objVariables.types.MAIN);
		
		var data = {
				title: jQuery("#text_addon_title").val(),
				name: jQuery("#text_addon_name").val(),
				html: html,
				html_item: htmlItem,
				html_item2: htmlItem2,
				css: css,
				js: js,
				includes_js: dataIncludes.arrJS,
				includes_jslib: dataIncludes.arrJSLib,
				includes_css: dataIncludes.arrCSS,
				params: objParams,
				params_items: objParamsItems,
				options: options,
				variables_item: variables_item,
				variables_main: variables_main
		};
		
		if(g_addonID)
			data.id = g_addonID;
		
		return(data);
	}
	
	
	/**
	 * set the editor to the text area
	 */
	function setCodeMirrorEditor(type){
		
		switch(type){
		
			case "html":
				
				if(g_codemirrorHtml)
					return(false);
				
				setTimeout(function(){
				      var mixedMode = {
				    	        name: "htmlmixed",
				      };
				      var optionsCM = {
								mode: mixedMode,
								lineNumbers: true
					        };
				      
					g_codemirrorHtml = CodeMirror.fromTextArea(document.getElementById("area_addon_html"), optionsCM);
										
					/*
					g_codemirrorHtml.on("change", function(){
						trace("on change");
					});
					*/
					
				}, 500);
				
			break;
			case "html_item":
				if(g_codemirrorHtmlItem)
					return(false);
				if(isItemsEnabled() == false)
					return(false);
				
				setTimeout(function(){
				      var mixedMode = {
				    	        name: "htmlmixed",
				      };
				      var optionsCM = {
								mode: mixedMode,
								lineNumbers: true
					        };
				      					
					g_codemirrorHtmlItem = CodeMirror.fromTextArea(document.getElementById("area_addon_html_item"), optionsCM);
										
				}, 500);
				
			break;
			
			case "html_item2":
				if(g_codemirrorHtmlItem2)
					return(false);
				if(isItemsEnabled() == false)
					return(false);
				
				setTimeout(function(){
				      var mixedMode = {
				    	        name: "htmlmixed",
				      };
				      var optionsCM = {
								mode: mixedMode,
								lineNumbers: true
					        };
				      					
					g_codemirrorHtmlItem2 = CodeMirror.fromTextArea(document.getElementById("area_addon_html_item2"), optionsCM);
										
				}, 500);
				
			break;
			
			case "css":
				
				if(g_codemirrorCss)
					return(false);

				setTimeout(function(){
					g_codemirrorCss = CodeMirror.fromTextArea(document.getElementById("area_addon_css"), {
			            mode: {name: "css"},
			            lineNumbers: true
			        });
				}, 500);
				
			break;
			case "js":
				
				if(g_codemirrorJs)
					return(false);
				
				setTimeout(function(){
					g_codemirrorJs = CodeMirror.fromTextArea(document.getElementById("area_addon_js"), {
			            mode: {name: "javascript"},
			            lineNumbers: true
			        });
				}, 500);
				
			break;
		}
		
	}
	
	function ____________ITEMS_RELATED____________(){};
	
	/**
	 * is items enabled
	 */
	function isItemsEnabled(){
		
		var objValues = g_settingsItem.getSettingsValues();
		var enableItems = objValues.enable_items;
		enableItems = g_ucAdmin.strToBool(enableItems);
		
		return(enableItems);
	}
	
	
	/**
	 * hide items related objects
	 */
	function hideItemsRelated(){
		g_objWrapperItems.hide();
		jQuery(".uc-items-related").hide();
	}
	
	
	/**
	 * show items related objects
	 */
	function showItemsRelated(){
		g_objWrapperItems.show();
		jQuery(".uc-items-related").show();
	}
	
	
	/**
	 * get if items is visible
	 */
	function isItemsVisible(){
		
		var isVisible = g_objWrapperItems.is(":visible");
		return(isVisible);
	}
	
	
	function ____________PARAMS_PANEL____________(){};

	
	/**
	 * sync params from ed
	 */
	function paramsPanelMainSync(){
		
		var arrParams = g_paramsEditorMain.getParamsData();
		var arrVars = g_objVariables.getArrVars(g_objVariables.types.MAIN);
		
		//add items param
		var hasItems = isItemsEnabled();

		g_paramsPanelJs.setParams(arrParams);
		g_paramsPanelCss.setParams(arrParams);
		
		//add items related functions
		if(hasItems == true){
			var paramPutItems = {type:"uc_function", name:"put_items()"};
			var paramPutItems2 = {type:"uc_function", name:"put_items2()"};
			
			arrParams.unshift(paramPutItems2);
			arrParams.unshift(paramPutItems);
		}
		
		g_paramsPanelMain.setParams(arrParams, arrVars);
		
		//sync item params as well
		paramsPanelItemSync();
	}
	
	
	/**
	 * sync params from ed
	 */
	function paramsPanelItemSync(){
		
		var arrParamsItems = g_paramsEditorItems.getParamsData();
		var arrVarsItems = g_objVariables.getArrVars(g_objVariables.types.ITEM);
		
		var arrParamsMain = g_paramsEditorMain.getParamsData();
		var arrVarsMain = g_objVariables.getArrVars(g_objVariables.types.MAIN);
	
		var arrPanels = [g_paramsPanelItem, g_paramsPanelItem2];
		
		jQuery.map(arrPanels,function(objPanel){
			
			objPanel.removeAllParams();
			objPanel.setParams(arrParamsItems, arrVarsItems, "item");
			objPanel.setParams(arrParamsMain, arrVarsMain, "main");
			
		});
		
		
	}
	
	
	
	/**
	 * init the params panel
	 */
	function initParamsPanels(arrPanelKeys, arrPanelItemKeys){
		
		//add to beginning main params
		var objWrapperMain = jQuery("#uc_params_panel_main");
		var objWrapperJs = jQuery("#uc_params_panel_js");
		var objWrapperCss = jQuery("#uc_params_panel_css");
		var objWrapperItem = jQuery("#uc_params_panel_item");
		var objWrapperItem2 = jQuery("#uc_params_panel_item2");
		
		g_paramsPanelMain.init(objWrapperMain,"main", null, arrPanelKeys);
		g_paramsPanelJs.init(objWrapperJs,"js", null, arrPanelKeys);
		g_paramsPanelCss.init(objWrapperCss,"css", null, arrPanelKeys);
		
		//init items panels
		var arrPanelItems = [
		                     [g_paramsPanelItem, objWrapperItem], 
		                     [g_paramsPanelItem2, objWrapperItem2]
		];
		
		var itemPrefix = {"item":"item."};
		
		jQuery.map(arrPanelItems, function(arr){
			
			var itemsPanel = arr[0];
			var objPanelWrapper = arr[1];
				
			itemsPanel.init(objPanelWrapper,"item", itemPrefix, arrPanelItemKeys);
			itemsPanel.initConstants(arrPanelKeys, "main");
			itemsPanel.initConstants(arrPanelItemKeys, "item");
			
		});
		
		paramsPanelMainSync();
		paramsPanelItemSync();

		//on params update event
		g_paramsEditorMain.onUpdateEvent(paramsPanelMainSync);
		g_paramsEditorItems.onUpdateEvent(paramsPanelItemSync);
		
		//on click events
		g_paramsPanelMain.onParamClick(function(textToAdd){
			g_ucAdmin.insertToCodeMirror(g_codemirrorHtml, textToAdd);
		});
		
		g_paramsPanelJs.onParamClick(function(textToAdd){
			g_ucAdmin.insertToCodeMirror(g_codemirrorJs, textToAdd);
		});
		
		g_paramsPanelCss.onParamClick(function(textToAdd){
			g_ucAdmin.insertToCodeMirror(g_codemirrorCss, textToAdd);
		});
		
		g_paramsPanelItem.onParamClick(function(textToAdd){
			g_ucAdmin.insertToCodeMirror(g_codemirrorHtmlItem, textToAdd);
		});
		
		g_paramsPanelItem2.onParamClick(function(textToAdd){
			g_ucAdmin.insertToCodeMirror(g_codemirrorHtmlItem2, textToAdd);
		});
		
		
		//delete main variable:
		g_paramsPanelMain.onDeleteVariable(function(event, varName){
			
			g_objVariables.deleteVar(g_objVariables.types.MAIN, varName);
			paramsPanelMainSync();
		});
		
		
		//delete item variable:
		g_paramsPanelItem.onDeleteVariable(function(event, varName){
			
			g_objVariables.deleteVar(g_objVariables.types.ITEM, varName);
			paramsPanelItemSync();
			
		});
		
		//delete item2 variable:
		g_paramsPanelItem2.onDeleteVariable(function(event, varName){
			
			g_objVariables.deleteVar(g_objVariables.types.ITEM, varName);
			paramsPanelItemSync();
			
		});
		
		//on edit Item variable
		function onParamsPanelEditItemVariable(event, varIndex){
			if(!varIndex || varIndex == undefined)
				var varIndex = 0;
			
			var objVar = g_objVariables.getVariable(g_objVariables.types.ITEM, varIndex);
			
			g_ucAdmin.validateNotEmpty(objVar, "variable: " + varIndex);
			
			g_objDialogItemVariable.open(objVar, varIndex, function(objUpdatedVar, varIndex){
				
				g_objVariables.update(g_objVariables.types.ITEM, varIndex, objUpdatedVar);
				
				paramsPanelItemSync();
				
			});
		}
		
		//edit item variable:
		g_paramsPanelItem.onEditVariable(onParamsPanelEditItemVariable);
		g_paramsPanelItem2.onEditVariable(onParamsPanelEditItemVariable);
		
		
		//edit main variable
		g_paramsPanelMain.onEditVariable(function(event, varIndex){
			if(!varIndex || varIndex == undefined)
				var varIndex = 0;
			
			var objVar = g_objVariables.getVariable(g_objVariables.types.MAIN, varIndex);
			
			g_ucAdmin.validateNotEmpty(objVar, "variable: " + varIndex);
			
			g_objDialogMainVariable.open(objVar, varIndex, function(objUpdatedVar, varIndex){
				
				g_objVariables.update(g_objVariables.types.MAIN, varIndex, objUpdatedVar);
				
				paramsPanelMainSync();
				
			});
			
		});
		
		
		//on settings change event
		g_settingsItem.setEventOnChange(function(){
			paramsPanelMainSync();
		});
		
	}
	
	function ____________VARIABLES_BUTTONS____________(){};
	
	
	
	/**
	 * init add variable button
	 */
	function initAddVariableButton(){
		
		//init item add variable
		var objButtonAddVariableItem = jQuery("#uc_params_panel_item_addvar");
		var objButtonAddVariableItem2 = jQuery("#uc_params_panel_item_addvar2");
		
		//on click - open add variable dialog
		objButtonAddVariableItem.add(objButtonAddVariableItem2).click(function(){
			
			g_objDialogItemVariable.open(null, 0, function(objVar){
				
				g_objVariables.add(g_objVariables.types.ITEM, objVar);
				
				paramsPanelItemSync();
				
			});
			
		});
		
		
		//init main add variable
		var objButtonAddVariableMain = jQuery("#uc_params_panel_main_addvar");
		
		objButtonAddVariableMain.click(function(){
						
			g_objDialogMainVariable.open(null, 0, function(objVar){
				
				g_objVariables.add(g_objVariables.types.MAIN, objVar);
				
				paramsPanelMainSync();
				
			});
			
		});
		
		
	}
	
	
	/**
	 * init variables, must init before the params panels
	 */
	function initVariables(arrVarItems, arrVarMain){
		
		g_objVariables.addFromArray(g_objVariables.types.ITEM, arrVarItems);
		g_objVariables.addFromArray(g_objVariables.types.MAIN, arrVarMain);
		
		initAddVariableButton();
	}
	
	
	function ____________INCLUDES_TAB____________(){};

	
	/**
	 * update include assets checkboxes
	 */
	function updateIncludesAssetsCheckboxes(){
		
		var arrIncludes = g_objIncludes.getArrAllIncludesUrls();
		
		g_objAssetsIncludes.checkByUrls(arrIncludes);
		
	}
	
	
	/**
	 * init assets manager in includes folder
	 */
	function initAssetsManagerIncludes(){
		
		//on checkbox click, add/remove include
		g_objAssetsIncludes.eventOnSelectOperation(function(checked, itemData){
			
			if(checked == true)
				g_objIncludes.addIncludesFromAssets(itemData);
			else{
				g_objIncludes.removeIncludeByAsset(itemData);
			}
			
		});
		
		//on load path - add addonID
		g_objAssetsIncludes.eventOnAjaxLoadpath(function(data){
			data.addonID = g_addonID;
			return(data);
		});
		
		//after update filelist, check assets by url
		g_objAssetsIncludes.eventOnUpdateFilelist(function(){
			updateIncludesAssetsCheckboxes();
		});
		
		//check assets by urls
		updateIncludesAssetsCheckboxes();
		
	}
	
	
	/**
	 * init includes tab
	 */
	function initIncludesTab(){
		
		g_objIncludes.initIncludesTab(t);
		
		var objIncludesBrowserWrapper = jQuery("#uc_includes_browser");
		g_objAssetsIncludes.init(objIncludesBrowserWrapper);
		
		//init includes browser
		initAssetsManagerIncludes();
		
		//set on delete event
		g_objIncludes.eventOnDelete(function(){
			updateIncludesAssetsCheckboxes();
		});
		
		g_objIncludes.eventOnInputBlur(function(){
			updateIncludesAssetsCheckboxes();
		});
		
	}
	
	
	function ____________ASSETS_TAB____________(){};
	
	/**
	 * get assets path
	 */
	this.getPathAssets = function(){
		var pathAssets = jQuery("#uc_assets_path").data("path");
		return(pathAssets);
	}
	
	
	/**
	 * get assets url
	 */
	function getUrlAssets(){
		var pathAssets = t.getPathAssets();
		if(!pathAssets)
			return(pathAssets);
		
		var urlAssets = g_urlAssetsUC + pathAssets + "/";
		
		return(urlAssets);
	}
	
	
	/**
	 * update path for image select based on the assets path
	 */
	function updateImageSelectPath(){
		
		var pathAddonAssets = t.getPathAssets();
		var urlAssets = getUrlAssets();
		
		if(pathAddonAssets){
			pathAddonAssets = g_pathAssetsUC+pathAddonAssets;
		}
		
		var urlAssets = getUrlAssets();
		
		g_ucAdmin.triggerEvent("update_assets_path", urlAssets);
		
		g_ucAdmin.setAddImagePath(pathAddonAssets, urlAssets);
		
	}
	
	
	/**
	 * check set path of assets button, enable / disable if needed
	 */
	function assetsPathCheckButtons(){
		
		//disable button
		if(g_objAssetsManager.isStartPath() == true)
			g_ucAdmin.disableButton("#uc_button_set_assets_folder");
		else
			g_ucAdmin.enableButton("#uc_button_set_assets_folder");
		
	}
	
	
	
	/**
	 * init assets path related functions
	 */
	function initAssetsPath(){
		
		assetsPathCheckButtons();
		
		//init assets folder acions
		g_objAssetsManager.eventOnUpdateFilelist(function(){
			assetsPathCheckButtons();
		});
		
		//set path button:
		jQuery("#uc_button_set_assets_folder").click(function(){
			
			if(g_ucAdmin.isButtonEnabled(jQuery(this)) == false)
				return(false);
			
			var path = g_objAssetsManager.getActivePathRelative();
			jQuery("#uc_assets_path").html(path).data("path", path);
			jQuery("#uc_button_set_assets_unset").show();
			
			g_temp.includesLoadPath = path;
			
			updateImageSelectPath();
		});
		
		//unset path button:
		jQuery("#uc_button_set_assets_unset").click(function(){
			var textNotSet = jQuery("#uc_assets_path").data("textnotset");
			jQuery("#uc_assets_path").html(textNotSet).data("path", "");
			jQuery(this).hide();
			
			g_temp.includesLoadPath = "";
			
			updateImageSelectPath();
		});
		
	}
	
	
	/**
	 * init assets tab
	 */
	function initAssetsTab(){

		//init assets manager
		var objAssetsManagerWrapper = jQuery("#uc_assets_manager");
		if(objAssetsManagerWrapper.length == 0)
			return(false);
		
		g_objAssetsManager.init(objAssetsManagerWrapper);
		
		initAssetsPath();
		
		//set flag if the assets updated
		g_objAssetsManager.eventOnUpdateFiles(function(){
			g_temp.isAssetsUpdated = true;
		});
		
	}
	
	
	function ____________EVENTS____________(){};
	
	
	/**
	 * on update addon button click
	 */
	function onUpdateAddonClick(){
		
		var data = getDataFromAddonView();
		
		g_ucAdmin.setAjaxLoaderID("uc_loader_update");
		g_ucAdmin.setSuccessMessageID("uc_message_addon_updated");
		g_ucAdmin.setAjaxHideButtonID("button_update_addon");
		g_ucAdmin.setErrorMessageID("uc_update_addon_error");
		
		g_ucAdmin.ajaxRequest("update_addon", data);
	}

	
	/**
	 * on export addon click
	 */
	function onExportAddonClick(){
		
		var params = "id="+g_addonID;
		var urlExport = g_ucAdmin.getUrlAjax("export_addon", params);
		
		location.href=urlExport;
	}
	
	
	/**
	 * select tab in addon view
	 * tab is the link object to tab
	 */
	function addonSelectTab(objTab, nohash){

		if(objTab.hasClass("uc-tab-selected"))
			return(false);
		
		var contentID = objTab.data("contentid");
		var tabID = objTab.prop("id");
		
		jQuery("#uc_tab_contents .uc-tab-content").hide();
		
		jQuery("#" + contentID).show();
		
		jQuery("#uc_tabs a").not(objTab).removeClass("uc-tab-selected");
		objTab.addClass("uc-tab-selected");
		
		//add hash:
		if(nohash !== true)
			location.hash = "tab="+tabID;
		
		switch(contentID){
			case "uc_tab_html":
				setCodeMirrorEditor("html");
				setCodeMirrorEditor("html_item");
				setCodeMirrorEditor("html_item2");
			break;
			case "uc_tab_js":
				setCodeMirrorEditor("js");
			break;
			case "uc_tab_css":
				setCodeMirrorEditor("css");
			break;
			case "uc_tab_includes":
				
				//load includes path
				
				if(g_temp.isAssetsUpdated == true || g_temp.includesLoadPath != ""){
					g_temp.isAssetsUpdated = false;
					
					if(g_objAssetsIncludes){
						var loadPath = "";
						if(g_temp.includesLoadPath != ""){
							loadPath = g_temp.includesLoadPath;
							g_temp.includesLoadPath = "";
						}
						g_objAssetsIncludes.loadPath(loadPath);
					}
					
				}
				
			break;
		}
		
	}
	
	
	
	/**
	 * init events
	 */
	function initEvents(){
		
		//item tab events
		
		//change files event
		g_settingsItem.setEventOnChange(function(){
			var enableItems = isItemsEnabled();
			var isVisible = isItemsVisible();
			
			if(enableItems == true && isVisible == false)
				showItemsRelated();
			else
				if(enableItems == false && isVisible == true)
					hideItemsRelated();
				
		});
		
	}
	
	function ____________STICKY_MENU____________(){};
	
	/**
	 * init sticky menu
	 */
	function initStickyButtonsPanel(){
		
		jQuery(window).scroll(function () {
			var desTop = jQuery(document).scrollTop();
			
			//clearTrace()
			//trace(desTop);
			
			if(desTop > 79){
				g_objButtonsPanel.addClass("uc-stick-top");
			} else {
				g_objButtonsPanel.removeClass("uc-stick-top");
			}
		});		
		
	}
	
	function ____________INIT____________(){};

	
	/**
	 * init the params editors
	 */
	function initParamsEditors(objParamsMain, objParamsItems){
		
		var objWrapperMain = jQuery("#attr_wrapper_main");
		g_objWrapperItems = jQuery("#attr_wrapper_items");
		var objDialogParam = jQuery("#uc_dialog_param_main");
		var objDialogItemVariable = jQuery("#uc_dialog_param_variable_item");
		var objDialogMainVariable = jQuery("#uc_dialog_param_variable_main");
		
		g_objDialogParam.init(objDialogParam, t);
		g_objDialogItemVariable.init(objDialogItemVariable, t);
		g_objDialogMainVariable.init(objDialogMainVariable, t);
		
		g_paramsEditorMain.init(objWrapperMain, objParamsMain, g_objDialogParam);
		g_paramsEditorItems.init(g_objWrapperItems, objParamsItems, g_objDialogParam);
		
	}
	
	
	/**
	 * init tabs
	 */
	function initTabs(){
		
		//select current tab
		var initTabID = jQuery("#uc_tabs").data("inittab");
		
		var objCurrentTab = jQuery("#"+initTabID);
		var hash = location.hash;
		if(hash){
			var tabID = hash.replace("tab=","");
			var objTab = jQuery(tabID);
			if(objTab.length)
				objCurrentTab = objTab;
		}
		
		addonSelectTab(objCurrentTab, true);
		
		jQuery("#uc_tabs a").click(function(){
			var objTab = jQuery(this);
			addonSelectTab(objTab);
			
		});
		
	}
	
	
	/**
	 * init items tab
	 */
	function initItemsTab(){
		
		g_objItemSettingsWrapper = jQuery("#uc_tab_itemattr").children(".unite_settings_wrapper");
		
		g_settingsItem.init(g_objItemSettingsWrapper);
		
	}
	
	
	/**
	 * get control attributes with their values
	 */
	this.getControlParams = function(type){
		
		switch(type){
			default:
			case "main":
				var arrData = g_paramsEditorMain.getParamsData("control", true);
			break;
			case "item":
				var arrData = g_paramsEditorItems.getParamsData("control", true);
			break;
		}
		
		return(arrData);
	}
	
	
	/**
	 * edit addon view
	 */
	this.initEditAddonView = function(){
		
		var objConfig = jQuery("#uc_edit_item_config");
		var objParamsMain = objConfig.data("params");
		
		var objParamsItems = objConfig.data("params-items");
		var arrPanelKeys = objConfig.data("panel-keys");
		
		var arrPanelItemKeys = objConfig.data("panel-item-keys");
		var arrVariablesItems = objConfig.data("variables-items"); 
		var arrVariablesMain = objConfig.data("variables-main"); 
		
		var objSettingsWrapper = jQuery("#uc_general_settings");
		
		if(jQuery("#addon_id").length)
			g_addonID = jQuery("#addon_id").data("addonid");
		
		g_objButtonsPanel = jQuery("#uc_buttons_panel");
		
		initStickyButtonsPanel();
		
		initItemsTab();
		
		initTabs();
		
		g_generalSettings.init(objSettingsWrapper);
		
		initIncludesTab();
				
		initParamsEditors(objParamsMain, objParamsItems);
		
		initAssetsTab();
		
		initVariables(arrVariablesItems, arrVariablesMain);	//must init before params panels
		
		initParamsPanels(arrPanelKeys, arrPanelItemKeys);
		
		
		jQuery("#button_update_addon").click(onUpdateAddonClick);
		jQuery("#button_export_addon").click(onExportAddonClick);
		
		//focus the title if empty
		var title = jQuery("#text_addon_title").val();
		if(jQuery.trim(title) == "")
			jQuery("#text_addon_title").focus();
		
		initEvents();
		
		updateImageSelectPath();
	}
	
	this.________________INIT_OTHER_VIEWS_______________ = function(){}
	
	/**
	 * init assets manager view
	 */
	this.initAssetsManagerView = function(){
		
		var objAssetsManagerWrapper = jQuery("#uc_assets_manager");
		if(objAssetsManagerWrapper.length == 0)
			throw new Error("Assets manager not found");
		
		g_objAssetsManager.init(objAssetsManagerWrapper);
		
	}

	
	
	
};

