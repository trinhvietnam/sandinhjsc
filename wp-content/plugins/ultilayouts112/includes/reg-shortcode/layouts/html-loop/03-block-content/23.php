<?php 
if($i<2){
	if($i==1){?>
        <div class="ul-bc-column ul-cb-style-large">
            <div class="ul-bc-wrapper-listing">
<?php }?>
                <!--post item--> 
                <article class="ultimate-layouts-item hentry">
                    <!--entry content-->
                    <div class="ultimate-layouts-entry-wrapper entry-content">    
                        <!--picture-->
                        <?php //if($post_image!='' && $s_image==true){?>
                            <div class="ultimate-layouts-picture">               
                                <div class="ultimate-layouts-picture-wrap ultimate-layouts-get-pic">
                                    <?php echo $post_image;?>                
                                    <div class="ultimate-layouts-absolute-gradient"></div>
                                    <div class="ultimate-layouts-absolute-content">
                                    	<?php echo $post_taxonomy;?>
                                        <?php echo $post_title_white;?>
                                        <?php echo $post_metas_1_silver;?>                    
                                    </div>                
                                    <?php echo $post_overlay;?>
                                    <?php echo $post_icon;?>                 
                                </div>                                
                            </div>
                        <?php //}?> 
                        <!--picture-->
                    </div><!--entry content-->            
                </article><!--post item-->        
<?php 
	if($i==1 || ($sub_opt_query['paged']==$paged_calculator && $i==$percentItems)){?>   
            </div>     
        </div>
<?php 
	}
}
if($i>1){
	if($i==2){
	?>
		<div class="ul-bc-column ul-cb-style-listing">
			<div class="ul-bc-wrapper-listing">
	<?php }?>
			<!--post item--> 
			<article class="ultimate-layouts-item hentry">
				<!--entry content-->
				<div class="ultimate-layouts-entry-wrapper entry-content">
					<!--picture-->
					<?php //if($post_image!='' && $s_image==true){?>
                        <div class="ultimate-layouts-picture">               
                            <div class="ultimate-layouts-picture-wrap ultimate-layouts-get-pic">
                                <?php echo $post_image_small_cb;?>                
                                <div class="ultimate-layouts-absolute-gradient"></div>
                                <div class="ultimate-layouts-absolute-content">
                                	<?php echo $post_taxonomy_small;?>
                                    <?php echo $post_title_f14_white_small;?>
                                    <?php echo $post_metas_1_silver_small;?>                    
                                </div>                
                                <?php echo $post_overlay;?>
                                <?php echo $post_icon;?>                 
                            </div>                             
                        </div>
                    <?php //}?> 
                    <!--picture-->
				</div><!--entry content-->            
			</article><!--post item-->
	<?php 
	if($i==$allItemsPerPage || ($sub_opt_query['paged']==$paged_calculator && $i==$percentItems)){
			?>
			</div>
		</div>
	<?php
	}
}