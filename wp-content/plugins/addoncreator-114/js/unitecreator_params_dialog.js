function UniteCreatorParamsDialog(){
	
	var t = this;
	var g_objWrapper, g_objTabs, g_objTabContentWrapper, g_objLeftArea, g_objRightArea;
	var g_objError, g_objParamTitle, g_objParamName;
	var g_objTexts, g_objParent, g_objData, g_objSettings;
	
	
	var g_arrSpecialInputs = {};	//array of special inputs
	
	
	var events = {
			CHANGE_NAME: "name_change",
			OPEN: "open",
			INIT: "init"
	}
	
	if(!g_ucAdmin){		//for autocomplete
		var g_ucAdmin = new UniteAdminUC();
	}
	
	
	function ____________GETTERS____________(){};
	
	/**
	 * get all param types array
	 */
	function getArrParamTypes(){
		var arrTypes = [];
		
		jQuery.each(g_objTabs, function(index, tab){
			var type = jQuery(tab).data("type");
			arrTypes.push(type);
		});
		
		return(arrTypes);
	}
	
	
	/**
	 * get all inputs
	 */
	function getAllInputs(){
		var objInputs = g_objWrapper.find("input,textarea,select,table");
		return(objInputs);
	}
	
	/**
	 * get current right content
	 */
	function getCurrentRightContent(){

		var objContent = g_objRightArea.find(".uc-content-selected");
		if(objContent.length == 0)
			throw new Error("no current content found");
		
		if(objContent.length > 1)
			throw new Error("multiple selected contents found");
		
		return(objContent);
	}
	
	
	/**
	 * get inputs of params dialog
	 */
	function getCurrentInputs(){
		var selector = "input,textarea,select,table";
		
		var objCurrentContent = getCurrentRightContent();
		
		var objInputsLeft = g_objLeftArea.find(selector);
		var objInputsRight =  objCurrentContent.find(selector);
		
		var objInputs = objInputsLeft.add(objInputsRight);
		
		return objInputs;
	}
	
	
	/**
	 * get content of params dialog
	 */
	function getParamDialogContent(){
		
		var arrInputs = getCurrentInputs();
		
		var objParam = {};
		
		selectedTab = g_objTabs.filter(".uc-tab-selected");
		
		if(selectedTab.length == 0)
			throw new Error("No param tab selected");
		
		objParam.type = selectedTab.data("type");
		
		//set inputs data
		jQuery.each(arrInputs, function(index, input){
			var objInput = jQuery(input);
			var inputType = g_ucAdmin.getInputType(objInput);
			
			var paramName = objInput.prop("name");
			
			var hasName = true;
			if(paramName == undefined || paramName == "")
				hasName = false;
			
			//regular items
			if(hasName == true){
				
				switch(inputType){
					case "text":
					case "textarea":
						var paramValue = objInput.val();
						objParam[paramName] = paramValue;
					break;
					case "radio":
						var isChecked = objInput.is(":checked");
						if(isChecked == true){
							var paramValue = objInput.val();
							objParam[paramName] = paramValue;
						}
					break;
					case "select":
						var paramValue = objInput.val();
						objParam[paramName] = paramValue;
					break;
					case "checkbox":
						var paramValue = objInput.is(":checked");
						objParam[paramName] = paramValue;
					break;
					default:
						throw new Error("Unknown input type: " + inputType);
					break;
					
				}//end switch
					
			}else{		//special items
				
				var isSimpleType = g_ucAdmin.isSimpleInputType(inputType);
				
				//special type get function
				if(isSimpleType == false){
										
					if(g_arrSpecialInputs.hasOwnProperty(inputType) == false)
						throw new Error("The input type: "+ inputType + " should have get function");
					
					var objSpecialInput = g_arrSpecialInputs[inputType];
					var objSpecialData = objSpecialInput.onGetInputData(objInput);
					
					if(typeof objSpecialData != "object")
						throw new Error("The special param get function should return object: "+inputType);
					
					objParam = jQuery.extend(objParam, objSpecialData);
					
				}
				
			}
			
		});
		
		
		return(objParam);
	}
	
	
	function ____________GENERAL____________(){};
	
	
	/**
	 * clear params dialog
	 */
	function clearParamDialog(){
		
		var objInputs = getAllInputs(true);
		
		//clear simple inputs
		objInputs.each(function(index, input){
			var objInput = jQuery(input);
			var initval = objInput.data("initval");
			var attrName = objInput.attr("name");
			
			var inputType = g_ucAdmin.getInputType(objInput);
			
			switch(inputType){
				case "text":
				case "textarea":
					if(initval !== undefined)
						objInput.val(initval);
					else
						objInput.val("");
					
					//check color picker
					if(objInput.hasClass("uc-text-colorpicker"))
						objInput.trigger("keyup");
					objInput.trigger("change");
				break;
				case "radio":
					var objRadioWrapper = objInput.parents(".uc-radioset-wrapper");
					
					if(objRadioWrapper.length == 0)
						throw new Error("Every radio should have a .uc-radioset-wrapper");
					
					var defaultItemChecked = objRadioWrapper.data("defaultchecked");
					var inputValue = objInput.val();
					
					defaultItemChecked = g_ucAdmin.boolToStr(defaultItemChecked);
					
					if(inputValue == defaultItemChecked)
						objInput.trigger("click");
				break;
				case "select":
					var initValue = objInput.data("initval");
					if(initValue != undefined)
						objInput.val(initValue)
					
					//for select unit
					if(objInput.hasClass("uc-select-unit"))
						objInput.siblings(".uc-text-unit-custom").hide();
					
					objInput.trigger("change");
				break;
				case "checkbox":
					var defaultChecked = objInput.data("defaultchecked");
					defaultChecked = g_ucAdmin.strToBool(defaultChecked);
					objInput.prop("checked", defaultChecked);
					objInput.trigger("change");
				break;
			}
			
		});
		
		
		//clear special params
		objInputs.each(function(index, input){
			var objInput = jQuery(input);
			var inputType = g_ucAdmin.getInputType(objInput);
			
			var isSimpleType = g_ucAdmin.isSimpleInputType(inputType);
			if(isSimpleType == true)
				return(true);
			
			if(g_arrSpecialInputs.hasOwnProperty(inputType) == false)
				throw new Error("The input type: "+ inputType + " not found");
			
			var objSpecialInput = g_arrSpecialInputs[inputType];
			
			if(typeof objSpecialInput.onClearInputData == "function")
				objSpecialInput.onClearInputData(objInput);
			
		});
		
	}
	
	
	/**
	 * fill params dialog
	 */
	function fillParamsDialog(objData){
		
		clearParamDialog();
		
		selectParamDialogTabByType(objData.type);
		
		var objInputs = getCurrentInputs();
		
		//fill simple type the inputs
		jQuery.each(objInputs, function(index, input){
			
			var objInput = jQuery(input);
			var inputName = objInput.prop("name");
			var inputType = g_ucAdmin.getInputType(objInput);
						
			var isSimpleType = g_ucAdmin.isSimpleInputType(inputType);
			
			if(isSimpleType == false)
				return(true);
			
			if(objData.hasOwnProperty(inputName) == false)
				return(true);
				
			var value = objData[inputName];
						
			switch(inputType){
				case "text":
				case "textarea":
					objInput.val(value);
					objInput.trigger("change");
				break;
				case "radio":
					var radioValue = objInput.val();
					if(radioValue == value)
						objInput.trigger("click");
				break;
				case "select":
					objInput.val(value);
					if(objInput.hasClass("uc-select-unit") && value == "other")
						objInput.siblings(".uc-text-unit-custom").show();
					objInput.trigger("change");
				break;
				case "checkbox":
					value = g_ucAdmin.strToBool(value);
					objInput.prop("checked", value);
					objInput.trigger("change");
				break;
			}
			
		});
		
		
		//fill special type inputs
		jQuery.each(objInputs, function(index, input){
			
			var objInput = jQuery(input);
			var inputType = g_ucAdmin.getInputType(objInput);
					
			var isSimpleType = g_ucAdmin.isSimpleInputType(inputType);
			if(isSimpleType == true)
				return(true);
						
			if(g_arrSpecialInputs.hasOwnProperty(inputType) == false)
				throw new Error("The input type: "+ inputType + " not found");
			
			var objSpecialInput = g_arrSpecialInputs[inputType];
			
			if(typeof objSpecialInput.onFillInputData == "function")
				objSpecialInput.onFillInputData(objInput, objData);
			
		});
		
		
		//limit edit
		if(objData.hasOwnProperty("limited_edit") && g_ucAdmin.strToBool(objData.limited_edit) == true)
			limitDialog();
		else
			unlimitDialog();
		
	}
	
	
	/**
	 * validate the param dialog
	 */
	function validateParamDialog(objParam){
		
		try{
			if(objParam.hasOwnProperty("title"))
				g_ucAdmin.validateNotEmpty(objParam.title, "Title");
			
			g_ucAdmin.validateNotEmpty(objParam.name, "Name");
			
			g_ucAdmin.validateNameField(objParam.name, "Name");
			
		}catch(error){
			g_objError.show().html(error.message);
			return(false);
		}
		
		return(true);
	}
	
	
	
	/**
	 * open addon add/edit dialog
	 */
	this.open = function(objData, rowIndex, onActionFunc){
		
		var isEdit = false;
		if(objData)
			isEdit = true;
		
		var actionTitle = g_objTexts.add_button;
		var dialogTitle = g_objTexts.add_title;
		
		if(isEdit == true){
			actionTitle = g_objTexts.update_button;
			
			var paramTitle = objData.name;
			if(typeof objData.title != "undefined")
				var paramTitle = objData.title;
			
			dialogTitle = g_objTexts.edit_title + ": " + paramTitle;
		}

		var buttonOpts = {};
		
		//---- cancel click
		
		buttonOpts["Cancel"] = function(){
			g_objWrapper.dialog("close");
		};
		
		//---- action click
		
		buttonOpts[actionTitle] = function(){
			var objParam = getParamDialogContent();
			
			if(typeof onActionFunc != "function")
				throw new Error("on add/edit function not passed");
			
			g_objError.hide();
			
			if(validateParamDialog(objParam) == false)
				return(false);
			
			if(isEdit == false)
				onActionFunc(objParam);		//add function
			else{
				var rowIndex = g_objWrapper.data("rowindex");
				onActionFunc(objParam, rowIndex);		//edit function
			}
			
			g_objWrapper.dialog("close");
		};
		
		//hide error
		g_objError.hide();
		
		//unlimit dialog before open
		if(isEdit == false){		
			unlimitDialog();
		}
		
		
		g_objWrapper.dialog({
			dialogClass:"unite-ui",
			buttons:buttonOpts,
			minWidth:960,
			title: dialogTitle,
			modal:true,
			open:function(){
				
				triggerEvent(events.OPEN);
				
				if(isEdit == false){
					clearParamDialog();
					g_objData = null;
				}
				else{
					g_objWrapper.data("rowindex", rowIndex);
					g_objData = objData;
					fillParamsDialog(objData);
				}
				
				//focus only if empty
				if(isEdit == false){
					if(g_objParamTitle.length)
						g_objParamTitle.focus();
					else
						g_objParamName.focus();
				}
				
			}
		});
		
	}
	
	
	/**
	 * select param dialog tab by type
	 */
	function selectParamDialogTabByType(type){
		
		g_objTabs.each(function(index, tab){
			var objTab = jQuery(tab);
			var tabType = objTab.data("type");
			
			if(tabType == type)
				objTab.trigger("click");
		});
		
	}
	
	
	
	function ____________DROPDOWN_PARAM____________(){};

	
	/**
	 * add row to dropdown param
	 */
	function dropdownParamAddRow(objTable, objRowBefore, objData){
		
		var html = "";
		
		var valueName = "";
		var valueValue = "";
		var selectedClass = "";
		
		if(objData){
			
			if(objData.name)
				valueName = objData.name;
			
			if(objData.value)
				valueValue = objData.value;
			
			if(objData.isDefault == true)
				selectedClass = " uc-selected";
		}
		
		html += "<tr>";
		html += "<td><div class='uc-dropdown-item-handle'></div></td>";
		html += "<td><input type=\"text\" value=\""+valueName+"\" class='uc-dropdown-item-name'></td>";
		html += "<td><input type=\"text\" value=\""+valueValue+"\" class='uc-dropdown-item-value'></td>";
		html += "<td>";
		html += "<div class='uc-dropdown-icon uc-dropdown-item-delete' title=\"Add Item\"></div>";
		html += "<div class='uc-dropdown-icon uc-dropdown-item-add' title=\"Delete Item\"></div>";
		html += "<div class='uc-dropdown-icon uc-dropdown-item-default"+selectedClass+"' title=\"Default Item\"></div>";
		html += "</td>";
		html += "</tr>";
		
		var objNewRow = jQuery(html);
		
		if(!objRowBefore)
			objTable.children("tbody").append(objNewRow);
		else
			objNewRow.insertAfter(objRowBefore);
		
		return(objNewRow);
	}
	
	
	/**
	 * get num, items of dropdown param
	 */
	function dropdownParamGetNumItems(objTable){
		
		var rows = objTable.find("tbody tr");
	
		return(rows.length);
	}
	
	
	/**
	 * get dropdown param data
	 */
	function getDropdownParamData(objTable){
		
		var rows = objTable.find(" tbody tr");
		
		var objOptions = {};
		var defaultOption = "";
		
		jQuery.each(rows, function(index, row){
			var objRow = jQuery(row);
			
			var optionName = objRow.find(".uc-dropdown-item-name").val();
			var optionValue = objRow.find(".uc-dropdown-item-value").val();
			var isDefault = objRow.find(".uc-dropdown-item-default").hasClass("uc-selected");
			
			optionName = jQuery.trim(optionName);
			optionValue = jQuery.trim(optionValue);
			
			if(optionName == "")
				return(true);
			
			if(defaultOption == "")
				defaultOption = optionValue;
			
			if(isDefault == true)
				defaultOption = optionValue;
				
			objOptions[optionName] = optionValue;
			
		});
		
		var objOutput = {
			options: objOptions,
			default_value: defaultOption
		};
		
		return(objOutput);
	}
	
	
	/**
	 * clear dropdown param
	 */
	function clearDropdownParam(objTable, leaveOneRow){
		
		if(objTable.length == 0)
			throw new Error("dropdown parameter not found");
		
		objTable.children("tbody").html("");
		
		if(leaveOneRow === true)
			dropdownParamAddRow(objTable, null,{isDefault:true});
	}
	
	
	/**
	 * fill dropdown param options
	 */
	function fillDropdownParamOptions(objTable, options, defaultValue){
			
		if(objTable.length == 0)
			throw new Error("dropdown parameter not found");
		
		clearDropdownParam(objTable);
		
		if(!options)
			dropdownParamAddRow(objTable);
		else{
			
			jQuery.each(options, function(optionName, optionValue){
				var isDefault = (optionValue == defaultValue);
				dropdownParamAddRow(objTable, null, {name: optionName, value: optionValue , isDefault:isDefault});
			});
		}
		
	}
	
	
	/**
	 * set default first item
	 */
	function dropdownSetDefaultFirstItem(objTable){
		var firstRow = objTable.find("tbody tr:first-child");
		
		if(firstRow.length == 0)
			return(false);
		
		dropdownSetDefaultRow(objTable, firstRow);
	}
	
	
	/**
	 * set default row
	 */
	function dropdownSetDefaultRow(objTable, objRow){
		var objRowDefault = objRow.find(".uc-dropdown-item-default");
		objTable.find("tbody tr .uc-dropdown-item-default").not(objRow).removeClass("uc-selected");
		objRowDefault.addClass("uc-selected");
	}
	
	
	/**
	 * set default item by value
	 */
	function dropdownSetDefaultItem(objTable, defaultValue){
		
		var objRows = objTable.find("tbody tr");
				
		objRows.each(function(index, row){
			
			var objRow = jQuery(row);
			
			var optionValue = objRow.find(".uc-dropdown-item-value").val();
			var isDefault = objRow.find(".uc-dropdown-item-default").hasClass("uc-selected");
			
			optionValue = jQuery.trim(optionValue);
			
			if(optionValue == defaultValue && isDefault == false){
				dropdownSetDefaultRow(objTable, objRow);
				return(false);
			}
			
		});
		
	}
	
	
	/**
	 * on dropdown init
	 */
	function dropdownOnInit(objDialogWrapper){
		
		var objTableDropdown = objDialogWrapper.find(".uc-table-dropdown-items");
		if(objTableDropdown.length == 0)
			throw new Error("The table dropdown should be not empty");

		//sortable:
		objTableDropdown.children("tbody").sortable({
			handle: ".uc-dropdown-item-handle"
		});
		
		//add row button
		objTableDropdown.delegate(".uc-dropdown-item-add", "click", function(){
			var objTable = jQuery(this).parents(".uc-table-dropdown-items");
			var objRow = jQuery(this).parents("tr");
			
			var objNewRow = dropdownParamAddRow(objTable, objRow);
			
			objNewRow.find(".uc-dropdown-item-name").focus();
		});
		
		
		//delete row button
		objTableDropdown.delegate(".uc-dropdown-item-delete", "click", function(){
			var objRow = jQuery(this).parents("tr");
			var objTable = jQuery(this).parents("table");
			
			//if the row is default, select first remaining row
			var isDefault = objRow.find(".uc-dropdown-item-default").hasClass("uc-selected");
						
			objRow.remove();
			
			var numItems = dropdownParamGetNumItems(objTable);
			if(numItems == 0){
				objNewRow = dropdownParamAddRow(objTable);
				objNewRow.find(".uc-dropdown-item-name").focus();
			}

			if(isDefault || numItems == 0)
				objTable.find("tbody tr:first-child .uc-dropdown-item-default").addClass("uc-selected");
			
		});

		//default icon click
		objTableDropdown.delegate(".uc-dropdown-item-default", "click", function(){
			
			var objIcon = jQuery(this);
			if(objIcon.hasClass("uc-selected"))
				return(false);
			
			objTableDropdown.find(".uc-dropdown-item-default").removeClass("uc-selected");
			
			objIcon.addClass("uc-selected");
			
		});
		
		
	}
	
	
	/**
	 * init edit dialog dropdown param
	 */
	function initDropdownParam(){
		
		//validation if dropdown instance exists
		var objTableDropdown = g_objWrapper.find(".uc-table-dropdown-items");
		if(objTableDropdown.length == 0)
			return(false);
		
		var objDropdownParam = {};
		objDropdownParam.onInitDialog = dropdownOnInit;
		
		//clear
		objDropdownParam.onClearInputData = function(objInput){
			clearDropdownParam(objInput, true);
		}
		
		//get
		objDropdownParam.onGetInputData = function(objInput){
			var objParamData = getDropdownParamData(objInput);
			return(objParamData);
		}
		
		//fill
		objDropdownParam.onFillInputData = function(objTable, objData){
			if(objData.options)
				fillDropdownParamOptions(objTable, objData.options, objData.default_value);
		}
		
		
		t.addSpecialInput("table_dropdown", objDropdownParam);
		
		//--------- get values from select related
				
	}
	
	
	function ____________RADIOBOOLEAN_PARAM____________(){};

	
	/**
	 * init radio boolean param
	 */
	function initRadioBooleanParam(){
		
		var objTableDropdown = g_objWrapper.find(".uc-table-dropdown-items");
		if(objTableDropdown.length == 0)
			return(false);
		
		var objRadioBoolean = {};
		
		//clear
		objRadioBoolean.onClearInputData = function(objInput){
			dropdownSetDefaultFirstItem(objInput);
		}
		
		//get
		objRadioBoolean.onGetInputData = function(objInput){
			var radioBooleanData = getDropdownParamData(objInput);
			
			var returnData = {};
			returnData["default_value"] = radioBooleanData["default_value"];
			
			return(returnData);
			
		}
		
		//fill
		objRadioBoolean.onFillInputData = function(objInput, objData){
			
			if(objData.hasOwnProperty("default_value"))
				dropdownSetDefaultItem(objInput, objData.default_value);
			
		}
		
		
		t.addSpecialInput("radio_boolean", objRadioBoolean);
		
	}
	
	
	function ____________NUMBER_PARAM____________(){};

	
	/**
	 * init various params of params dialog
	 */
	function initNumberParam(){
		
		//init unit select:
		g_objWrapper.find(".uc-select-unit").change(function(){
			var objSelect = jQuery(this);
			var value = objSelect.val();
			var objText = objSelect.siblings(".uc-text-unit-custom"); 
			
			if(value == "other")
				objText.show().focus();
			else
				objText.hide();
			
		});
		
	}
	
	
	function ____________COLOR_PICKER_PARAM____________(){};
	
	
	/**
	 * init the color picker element
	 */
	function initColorPicker(){
		
		var pickerInput = g_objWrapper.find(".uc-text-colorpicker");
		
		var colorPicker = jQuery.farbtastic('.unite-color-picker-element');
		
		colorPicker.linkTo(pickerInput);
		
		//on change
		pickerInput.change(function(){
			var objInput = jQuery(this);
			objInput.trigger("keyup");
		});
		
	}
	
	function ____________IMAGE_PARAM____________(){};
	
	/**
	 * init image param
	 */
	function initImageParam(){
		
		//onchange name - update thumbs input fields
		onEvent(events.CHANGE_NAME, function(index, paramName){
			
			g_objWrapper.find(".uc-param-image-thumbname").each(function(index, input){
				var objInput = jQuery(input);
				var suffix = objInput.data("addsuffix");
				paramName = jQuery.trim(paramName);
				if(paramName){
					var value = paramName + "_" + suffix;
					objInput.val(value);
				}
				
			});
			
		});
		
	}
	
	
	function ____________IMAGE_SELECT_FIELD____________(){};
	
	
	/**
	 * update state of the image select field, to disabled or enabled
	 */
	function imageSelectField_updateState(){
		
		var objSettingWrapper = jQuery(this);
					
		var pathAssets = g_objParent.getPathAssets();
		
		var objInput = objSettingWrapper.find("input");
		
		g_objSettings.updateImageFieldState(objInput, pathAssets);
	}
	
	
	/**
	 * init image select field
	 */
	function initImageSelectField(){
		
		var objSettingImage = g_objWrapper.find(".unite-setting-image");
		if(objSettingImage.length == 0)
			return(false);
		
		var objSettings = new UniteSettingsUC();
		
		objSettings.initImageChooser(objSettingImage);
		
		/**
		 * on dialog open, fill selects
		 */
		onEvent(events.OPEN, function(){
			objSettingImage.each(imageSelectField_updateState);
		});
		
		
	}
	
	function ____________SELECT_PARAMS____________(){};

	
	/**
	 * get optons from every control param (dropdown, radio boolean, checkbox)
	 */
	function getControlParamOptions(param){
		
		switch(param.type){
			case "uc_dropdown":
				if(param.hasOwnProperty("options") == false)
					return(null);
				
				return(param.options);
			break;
			case "uc_checkbox":
				var options = {};
				options["true"] = "true";
				options["false"] = "false";
				return(options);
			break;
			case "uc_radioboolean":
				var options = {};
				options[param.true_name] = param.true_value;
				options[param.false_name] = param.false_value;
				return(options);
			break;
			default:
				throw new Error("Wrong control param type: " + param.type);
			break;
		}
		
	}
	
	
	/**
	 * fill select related table
	 */
	function fillSelectRelatedTable(objSelect, objTable){
		
		var value = objSelect.val();
		var objOption = objSelect.find("option:selected");
		
		var objTableBody = objTable.find("tbody");
		if(objTableBody.length == 0)
			throw new Error("Table body not found");
		
		objTableBody.html("");

		var options = objOption.data("options");
		if(!options)
			return(false);
		
		var dataOptions = {};
		if(g_objData && g_objData.hasOwnProperty("options"))
			dataOptions = g_objData.options;
						
		jQuery.each(options, function(name, value){
			
			var putValue = "";
			if(dataOptions.hasOwnProperty(value))
				putValue = dataOptions[value];
			
			var html = "";
			html += "<tr>";
			html += "	<td>";
			html += "		<input type='text' class='uc-item-value uc-dropdown-item-name' disabled value='"+value+"'>";
			html += "	</td>";
			html += "	<td>";
			html += "		<input type='text' class='uc-item-put-value uc-dropdown-item-value' value='"+putValue+"'>";
			html += "	</td>";
			html += "</tr>";
						
			objTableBody.append(html);
		});
				
	}

	
	/**
	 * get table select param data
	 */
	function getTableSelectRelatedData(objTable){

		var rows = objTable.find(" tbody tr");
		
		var objOptions = {};
		
		jQuery.each(rows, function(index, row){
			var objRow = jQuery(row);
			
			var value = objRow.find(".uc-item-value").val();
			var putValue = objRow.find(".uc-item-put-value").val();
			
			value = jQuery.trim(value);
			putValue = jQuery.trim(putValue);
			
			if(value == "")
				return(true);
					
			objOptions[value] = putValue;
			
		});
		
		var objOutput = {
			options: objOptions,
		};
		
		return(objOutput);
		
	}
	
	
	/**
	 * init select related table
	 */
	function initTableSelectRelated(){
				
		var objTables = g_objWrapper.find(".uc-table-select-related");
		if(objTables.length == 0)
			return(false);
		
		var objSpecialInput = {};
		
		//init
		objSpecialInput.onInitDialog = function(){
			
			objTables.each(function(index, table){
				var objTable = jQuery(table);
				var relateToSelector = objTable.data("relateto");
				if(!relateToSelector)
					throw new Error("select table must have relate to data");
				
				var objTabContent = objTable.parents(".uc-tab-content");
				var objSelect = objTabContent.find(relateToSelector);
				
				if(objSelect.length == 0)
					throw new Error("Select with selector: "+relateToSelector+" not found");
				
				//fill table on change
				objSelect.change(function(){
					fillSelectRelatedTable(jQuery(this), objTable);
				});
				
			});
			
		}
		
		//clear - triggered on select change
		objSpecialInput.onClearInputData = null;
		
		//fill - trigered on select change
		objSpecialInput.onFillInputData = null;
		
		
		//get
		objSpecialInput.onGetInputData = getTableSelectRelatedData;
		
		t.addSpecialInput("table_select_related", objSpecialInput);
		
	}
	
	
	/**
	 * init param select
	 */
	function initSelectParams(){
		
		/**
		 * on dialog open, fill selects
		 */
		onEvent(events.OPEN, function(){
			
			var objSelectParams = g_objWrapper.find(".uc-select-param");
			
			var arrParams = g_objParent.getControlParams("main");
			var arrParamsItems = g_objParent.getControlParams("item");
			
			objSelectParams.each(function(index, select){
				var objSelect = jQuery(select);
				objSelect.html("");
				
				g_ucAdmin.addOptionToSelect(objSelect, "", "["+g_uctext.not_selected+"]");
				
				var source = objSelect.data("source");
				switch(source){
					case "main":
						var arrParamsToAdd = arrParams;
					break;
					case "item":
						var arrParamsToAdd = arrParamsItems;
					break;
					default:
						throw new Error("wrong select param source: "+source+", can be only main, item");
					break;
				}
				
				jQuery.each(arrParamsToAdd, function(index, param){
					
					var options = getControlParamOptions(param);
					
					g_ucAdmin.addOptionToSelect(objSelect, param.name, param.name, "options", options);
				});
				
			});
			
		});
		
		
	}
	
	
	
	function ____________EVENTS____________(){};
	
	
	/**
	 * trigger event
	 */
	function triggerEvent(eventName, params){
		if(!params)
			var params = null;
		
		g_objWrapper.trigger(eventName, params);
	}
	
	
	/**
	 * on event name
	 */
	function onEvent(eventName, func){
		g_objWrapper.on(eventName,func);
	}
	
	
	
	function ____________LIMIT____________(){};
	
	
	/**
	 * limit the dialog for edit
	 */
	function limitDialog(){
		
		g_objWrapper.addClass("uc-dialog-limited");
		g_ucAdmin.disableInput(g_objParamName);
	}
	
	
	/**
	 * unlimit dialog for edit
	 */
	function unlimitDialog(){

		g_objWrapper.removeClass("uc-dialog-limited");
		g_ucAdmin.enableInput(g_objParamName);
	}
	
	
	/**
	 * return if the dialog is limited
	 */
	function isDialogLimited(){
		
		if(g_objWrapper.hasClass("uc-dialog-limited"))
			return(true);
		
		return(false);
	}
	
	
	function ____________INIT____________(){};
	
	
	/**
	 * add special param
	 * onClearInputData(objInput)
	 * onGetInputData(objInput)
	 * onFillInputData(objInput,data)
	 * onOpenDialog, onInitDialog
	 */
	this.addSpecialInput = function(inputType, obj){
		
		//on open dialog
		if(obj.hasOwnProperty("onOpenDialog")){
			onEvent(events.OPEN, function(){
				obj.onOpenDialog(g_objWrapper, g_objData);
			});
		}
		
		if(obj.hasOwnProperty("onInitDialog")){
			onEvent(events.INIT, function(){
				obj.onInitDialog(g_objWrapper);
			});
		}
		
		if(obj.hasOwnProperty("onClearInputData") == false)
			throw new Error("Special input myst have function: onClearInputData");
		
		if(obj.hasOwnProperty("onGetInputData") == false)
			throw new Error("Special input myst have function: onGetInputData");

		if(obj.hasOwnProperty("onFillInputData") == false)
			throw new Error("Special input myst have function: onFillInputData");
		
		g_arrSpecialInputs[inputType] = obj;
		
	}
	
	
	/**
	 * init tabs of param dialog
	 */
	function initTabs(){
		
		g_objTabs.click(function(){
			
			var isLimited = isDialogLimited();
			if(isLimited == true)
				return(false);
			
			var objTab = jQuery(this);
			if(objTab.hasClass("uc-tab-selected"))
				return(false);
			
			var contentID = objTab.data("contentid");
			var objContent = jQuery("#" + contentID);

			//show current content
			g_objTabContentWrapper.find(".uc-tab-content").not(objContent).removeClass("uc-content-selected").hide();
			objContent.addClass("uc-content-selected").show();
			
			//set selected tab
			g_objTabs.not(objTab).removeClass("uc-tab-selected");
			objTab.addClass("uc-tab-selected");
			
			//focus title if empty
			var title = g_objParamTitle.val();
			if(title == "")
				g_objParamTitle.focus();
			
		});
		
	}
	
	
	/**
	 * init events
	 */
	function initEvents(){
		
		//trigger on name change event
				
		g_objParamName.on("change",function(){
			var value = jQuery(this).val();
			triggerEvent(events.CHANGE_NAME, value);
		});
		
		g_objParamName.on("keyup",function(){
			var value = jQuery(this).val();
			triggerEvent(events.CHANGE_NAME, value);
		});
		
	}
	
	
	/**
	 * init inputs that are controls
	 */
	function initControls(){
		
		var objControls = g_objWrapper.find(".uc-control");
		
		objControls.change(function(){
			
			var objInput = jQuery(this);
			var type = g_ucAdmin.getInputType(objInput);
			
			var objContent = objInput.parents(".uc-tab-content");
			
			switch(type){
				case "checkbox":
					var toShow = objInput.is(":checked");
				break;
				default:
					throw new Error("Wrong control input type: " + type);
				break;
			}
			
			var controlledID = objInput.data("controlled-selector");
			
			if(controlledID == "" || controlledID == undefined){
				trace(objInput);
				throw new Error("empty controlled selector");
			}
			
			var objControlled = objContent.find(controlledID);
			
			if(objControlled.length == 0)
				throw new Error("controlled item not found: " + controlledID);
				
			if(toShow == true){
				objControlled.show();
			}else{
				objControlled.hide();
			}
			
		});
		
	}
	
	
	/**
	 * init add links. links that adding text to input boxes or textareas
	 */
	function initAddLinks(){
		
		var objAddLinks = g_objWrapper.find(".uc-link-add");
		if(objAddLinks.length == 0)
			return(false);
		
		objAddLinks.click(function(){
			
			var objLink = jQuery(this);
			var objContent = objLink.parents(".uc-tab-content");
			var selector = objLink.data("addto-selector");
			var addtext = objLink.data("addtext");
			
			g_ucAdmin.validateNotEmpty(addtext, "add text");
			
			if(selector == "" || selector == undefined){
				trace(objLink);
				throw new Error("empty addto selector");
			}
			
			var objInput = objContent.find(selector);

			if(objInput.length == 0)
				throw new Error("input or textarea not found: " + selector);
			
			g_ucAdmin.addTextToInput(objInput, addtext);
			
		});
		
	}

	
	
	
	
	
	
	/**
	 * init the dialog
	 */
	function init(){
		
		g_objTexts = g_objWrapper.data("texts");
		
		g_objTabs = g_objWrapper.find(".uc-tabs-paramdialog").children("a");
		g_objTabContentWrapper = g_objWrapper.find(".uc-tabsparams-content-wrapper");
		g_objLeftArea = g_objTabContentWrapper.find(".dialog-param-left");
		g_objRightArea = g_objTabContentWrapper.find(".dialog-param-right");
		g_objError = g_objWrapper.find(".uc-dialog-param-error");
		g_objParamTitle = g_objWrapper.find(".uc-param-title");
		g_objParamName = g_objWrapper.find(".uc-param-name");
		g_objSettings = new UniteSettingsUC();
		
		initTabs();
		
		initEvents();
		
		initControls();
		
		initAddLinks();
		initSelectParams();
		initDropdownParam();
		initRadioBooleanParam();
		initTableSelectRelated();
		initImageSelectField();
		
		//for all the special params that run on init
		triggerEvent(events.INIT);
		
		//init specific params
		var arrParamTypes = getArrParamTypes();
		
		jQuery.each(arrParamTypes, function(index, type){
			
			switch(type){
				case "uc_number":
					initNumberParam();
				break;
				case "uc_colorpicker":
					initColorPicker();
				break;
				case "uc_image":
					initImageParam();
				break;
			}
		
		});
		
	}
	
	
	/**
	 * init the params dialog
	 */
	this.init = function(objWrapper, objParent){
		
		g_objWrapper = objWrapper;
		g_objParent = objParent;
		
		init();
	}
	
}