<!--post item--> 
<article class="ultimate-layouts-item hentry">
    <!--entry content-->
    <div class="ultimate-layouts-entry-wrapper entry-content">    
        <!--picture-->
        <?php if($post_image!='' && $s_image==true){?>
            <div class="ultimate-layouts-picture">               
                <div class="ultimate-layouts-picture-wrap ultimate-layouts-get-pic">
                    <?php echo $post_image;?> 
                    <?php echo $post_overlay;?>                                  
                    <div class="ultimate-layouts-absolute-gradient"></div> 
                    <?php echo $post_icon;?>                            
                    <div class="ultimate-layouts-absolute-content">                
                        <?php echo $post_taxonomy_absolute;?>                
                        <?php echo $post_title_white_f24;?>
                        <?php echo $post_metas_1_silver;?>                    
                        <?php echo $post_excerpt_white;?>                    
                        <?php echo $post_metas_2;?> 
                    </div>                 
                </div>                                                   
            </div>
        <?php }?>    
        <!--picture-->
        <!--content-->
        <?php if($post_image=='' || $s_image==false || $wooBasicElmBlock!=''){?>
            <div class="ultimate-layouts-content entry"> 
                <?php if($post_image=='' || $s_image==false){
                    echo $post_taxonomy;
                    echo $post_title;
                    echo $post_metas_1;
					echo $post_excerpt;
					echo $wooBasicElmBlock;
					echo $post_metas_2;
                }else{					
					echo $wooBasicElmBlock;					
				}?>         
            </div>
        <?php }?>
        <!--content-->                                 
    </div><!--entry content-->            
</article><!--post item-->