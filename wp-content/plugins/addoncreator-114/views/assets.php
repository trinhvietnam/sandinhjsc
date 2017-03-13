<?php

defined('_JEXEC') or die;

$headerTitle = __("Assets Manager", UNITECREATOR_TEXTDOMAIN);
require HelperUC::getPathTemplate("header");


$objAssets = new UniteCreatorAssetsWork();
$objAssets->initByKey("assets_manager");

?>
<div class="uc-assets-manager-wrapper">

	<?php 
	$objAssets->putHTML();
	?>
	
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
	
		var objAdmin = new UniteCreatorAdmin();
		objAdmin.initAssetsManagerView();
	
	});

</script>
<?php 