function UCManagerAdmin(){
	
	var g_objWrapper = null;
	var t = this;
	var g_objCats;
	var g_objItems = new UCManagerAdminItems();
	var g_objActions, g_type, g_customOptions = {};
	
	var g_minHeight = 280;
	
	var g_temp = {
			hasCats: true
	}
	
	
	function ___________GENERAL_FUNCTIONS________________(){}	//sap for outline	
	
	
	/**
	 * update global height, by of categories and items
	 */
	function updateGlobalHeight(catHeight, itemsHeight){
		
		if(!catHeight){
			if(g_objCats)
				var catHeight = g_objCats.getCatsHeight();
			else
				catHeight = 0;
		}
		
		if(!itemsHeight)
			var itemsHeight = g_objItems.getItemsMaxHeight();
		
		var maxHeight = catHeight;
		
		if(itemsHeight > maxHeight)
			maxHeight = itemsHeight;
				
		maxHeight += 20;			
		
		if(maxHeight < g_minHeight)
			maxHeight = g_minHeight;
		
		//set list height
		g_objItems.setHeight(maxHeight);
		
		if(g_objCats)
			g_objCats.setHeight(maxHeight);
		
	}
	
	
	/**
	 * validate that the manager is already inited
	 */
	function validateInited(){

		var isInited = g_objWrapper.data("inited");
		
		if(isInited === true)
			throw new Error("Can't init manager twice");
		
		
		g_objWrapper.data("inited", true);
		
	}
	
	
	
	/**
	 * init manager
	 */
	this.initManager = function(selectedCatID){
		initManager(selectedCatID);
	}

	
	/**
	 * return if the items field enabled
	 */
	this.isItemsAreaEnabled = function(){

		if(!g_objCats)
			return(true);
		
		if(g_objCats && g_objCats.isSomeCatSelected() == false)
			return(false);
		
		return(true);
	}
	
	
	/**
	 * 
	 * set some menu on mouse position
	 */
	this.showMenuOnMousePos = function(event,objMenu){
		
		var objOffset = g_objWrapper.offset();
		var managerY = objOffset.top;
		var managerX = objOffset.left;
		
		var menuX = Math.round(event.pageX - managerX);
		var menuY = Math.round(event.pageY - managerY);
		
		jQuery("#manager_shadow_overlay").show();
		objMenu.css({"left":menuX+"px","top":menuY+"px"}).show();
	}
	
	
	/**
	 * hide all context menus
	 */
	this.hideContextMenus = function(){
		jQuery("#manager_shadow_overlay").hide();
		jQuery("ul.unite-context-menu").hide();
	}
	
	
	/**
	 * get mouseover item
	 */
	this.getMouseOverItem = function(){
		
		if(g_objCats){
			var catItem = g_objCats.getMouseOverCat();
			if(catItem)
				return(catItem);
		}
		
		var item = g_objItems.getMouseOverItem();
		
		return(item);
	}

	
	/**
	 * on item context menu click
	 */
	function onContextMenuClick(){
		
		var objLink = jQuery(this);
		var action = objLink.data("operation");
		
		var actionFound = false;
		
		if(g_objCats){
			var catID = g_objCats.getContextMenuCatID();
			actionFound = g_objCats.runCategoryAction(action);
		}
		
		if(actionFound == false)
			t.runItemAction(action);
		
		t.hideContextMenus();
	}
	
	
	/**
	 * init context menu events
	 * other context menu functions are located in the items
	 */
	function initContextMenus(){

		g_objWrapper.add("#manager_shadow_overlay").bind("contextmenu",function(event){
			event.preventDefault();
		});
		
		//on item right menu click
		jQuery(".unite-context-menu li a").mouseup(onContextMenuClick);
		
	}

	
	/**
	 * init gallery view
	 */		
	function initManager(selectedCatID){
		
		g_objWrapper = jQuery("#uc_managerw");
		if(g_objWrapper.length == 0)
			return(false);
		
		g_type = g_objWrapper.data("type");
		
		validateInited();
		
		//set if no cats
		var objCatsSection = jQuery("#cats_section");
		if(objCatsSection.length == 0){
			g_temp.hasCats = false;
			g_objCats = null;
		}else{
			g_objCats = new UCManagerAdminCats();
		}
		
		if(!g_ucAdmin)
			g_ucAdmin = new UniteAdminUC();		
		
		if(g_temp.hasCats == true)
			initCategories();
		
				
		//init actions
		switch(g_type){
			case "addons":
				g_objActions = new UCManagerActionsAddons();
			break;
			case "inline":
				g_objActions = new UCManagerActionsInline();
			break;
			default:
				throw new Error("Wrong manager type: " + g_type);
			break;
		}
				
		if(g_objActions)
			g_objActions.init(t);
		
		//the items must be inited from the manager action file		
		g_objItems.validateInited();
		
		//check first item select
		if(g_objCats){

			if(selectedCatID)
				g_objCats.selectCategory(selectedCatID);
			else
				g_objCats.checkSelectFirstCategory();
		}
		
		updateGlobalHeight();
	};
	
	function ___________CATEGORIES________________(){}	//sap for outline
	
	
	/**
	 * init the categories actions
	 */
	function initCategories(){
		
		g_objCats.init(t);
		
		//init events
		g_objCats.events.onRemoveSelectedCategory = function(){
			t.clearItemsPanel();
		};
		
		g_objCats.events.onHeightChange = function(){
			updateGlobalHeight();
		};
		
	}
	
	
	function ___________ITEMS_FUNCTIONS________________(){}	//sap for outline	
	
	
	/**
	 * update bottom operations
	 */
	function updateBottomOperations(){
		
		var numSelected = g_objItems.getNumItemsSelected();
		
		var numCats = 0;
		
		if(g_objCats)
			var numCats = g_objCats.getNumCats();
		
		jQuery("#num_items_selected").html(numSelected);
				
		//in case of less then 2 cats - disable operations
		if(numCats <= 1){
			
			jQuery("#item_operations_wrapper").hide();
			return(false);
		}
		
		//in case of more then one cat
		jQuery("#item_operations_wrapper").show();
		
		//enable operations
		if(numSelected > 0){
			jQuery("#select_item_category").prop("disabled","");
			jQuery("#item_operations_wrapper").removeClass("unite-disabled");
			jQuery("#button_items_operation").removeClass("button-disabled");
			
		}else{		//disable operations
			jQuery("#select_item_category").prop("disabled","disabled");
			jQuery("#button_items_operation").addClass("button-disabled");
			jQuery("#item_operations_wrapper").addClass("unite-disabled");
		}
		
		//hide / show operation categories 
		jQuery("#select_item_category option").show();
		var arrOptions = jQuery("#select_item_category option").get();
		
		var firstSelected = false;
		
		var selectedCatID = g_objCats.getSelectedCatID();
		
		for(var index in arrOptions){
			var objOption = jQuery(arrOptions[index]);
			var value = objOption.prop("value");
			
			if(value == selectedCatID)
				objOption.hide();
			else
				if(firstSelected == false){
					objOption.attr("selected","selected");
					firstSelected = true;
				}
		}
			
		
	}


	/**
	 * run items action
	 */
	this.runItemAction = function(action){
		g_objActions.runItemAction(action);
	}

	
	/**
	 * init bottom operations
	 */
	this.initBottomOperations = function(){
		
		// do items operations
		jQuery("#button_items_operation").click(onBottomOperationsClick);
		
	}
	
	
	/**
	 * init items actions
	 */
	this.initItems = function(){
		
		g_objItems.initItems(t);
		
		//on selection change
		g_objItems.events.onItemSelectionChange = function(){
			updateBottomOperations();		
		}
		
		//on items height change
		g_objItems.events.onHeightChange = function(itemsHeight){
			updateGlobalHeight(null, itemsHeight);
		}
		
		initContextMenus();
		
		//if items only - clear panel
		if(g_temp.hasCats == false)
			g_objItems.updatePanelView();
		
	}

	
	/**
	 * get categories object
	 */
	this.getObjCats = function(){
		return(g_objCats);
	}

	
	/**
	 * get items objects
	 */
	this.getObjItems = function(){
		
		return(g_objItems);
	}
	
	
	/**
	 * get wrapper object
	 */
	this.getObjWrapper = function(){
		
		return(g_objWrapper);
	}
	
	
    /**
     * on select category event
     */
    this.onCatSelect = function(catID){
    	g_objActions.runItemAction("get_cat_items", catID);
    	g_objItems.unselectAllItems("selectCategory");		
    }
	
    
	/**
	 * run gallery ajax request
	 */
	this.ajaxRequestManager = function(action,data,status,funcSuccess){
		
		jQuery("#status_loader").show();
		jQuery("#status_text").show().html(status);
		
		g_ucAdmin.ajaxRequest(action,data,function(response){
			jQuery("#status_loader").hide();
			jQuery("#status_text").hide();
			if(typeof funcSuccess == "function")
				funcSuccess(response);
			
			g_objItems.checkSelectRelatedItems();
		});
		
	}
	
	
	/**
	 * 
	 * on bottom GO button click,  move items
	 */
	function onBottomOperationsClick(){
			
			var arrIDs = g_objItems.getSelectedItemIDs();
			
			if(arrIDs.length == 0)
				return(false);
			
			var selectedCatID = g_objCats.getSelectedCatID();
			
			var targetCatID = jQuery("#select_item_category").val();
			if(targetCatID == selectedCatID){
				alert("Can't move addons to same category");
				return(false);
			}
			
			var data = {};
			data.targetCatID = targetCatID;
			data.selectedCatID = selectedCatID;
			data.arrAddonIDs = arrIDs;
			
			g_objActions.runItemAction("move_items", data);
			
	}
	
	
	/**
	 * set actions options
	 * some data goes directly to options
	 */
	this.setCustomOptions = function(options){
		g_customOptions = options;
	}
	
	
	/**
	 * get custom option by name
	 */
	this.getCustomOption = function(name){
		if(g_customOptions.hasOwnProperty(name) == false)
			return(undefined);
		
		var value = g_customOptions[name];
		
		return(value);
	}
	
	
	/**
	 * get all items data - from actions
	 */
	this.getItemsData = function(){

		if(typeof g_objActions.getItemsData != "function")
			throw new Error("get items data function not exists in this type");
		
		var arrItems = g_objActions.getItemsData();
		
		return(arrItems);
	}
	
	/**
	 * get items data json
	 */
	this.getItemsDataJson = function(){
		var data = t.getItemsData();
		if(typeof data != "object")
			return("");
		
		var dataJson = JSON.stringify(data);
		
		return(dataJson);
	}
	
	
	/**
	 * set items from data
	 */
	this.setItemsFromData = function(arrItems){
		if(typeof g_objActions.setItemsFromData != "function")
			throw new Error("set items from data function not exists in this type");
		
		g_objActions.setItemsFromData(arrItems);
	} 
	
	
	/**
	 * clear items panel
	 */
	this.clearItemsPanel = function(){
		g_objItems.clearItemsPanel();
	}
	
	function ___________BUTTONS________________(){}		

	
};