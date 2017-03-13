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
                    <?php echo $post_icon;?>                
                    <div class="ultimate-layouts-absolute-content">                
                        <?php echo $post_taxonomy_absolute;?>                
                        <?php echo $post_title_white_f24;?>                    
                        <?php echo $post_metas_1_silver;?>
                    </div>                 
                </div>                                                   
            </div>
        <?php }?>  
        <!--picture-->
        <?php if($post_image=='' || $s_image==false || $post_excerpt!='' || $post_metas_2!='' || $wooBasicElmBlock!=''){?>  
        	<!--content-->     
            <div class="ultimate-layouts-content entry">
                <?php if($post_image=='' || $s_image==false){
                    echo $post_taxonomy;
                    echo $post_title;
                    echo $post_metas_1;
                }?>            
                <?php echo $post_excerpt;?>
                <?php echo $wooBasicElmBlock;?>            
                <?php echo $post_metas_2;?>            
            </div><!--content-->  
        <?php }?>                               
    </div><!--entry content-->            
</article><!--post item-->