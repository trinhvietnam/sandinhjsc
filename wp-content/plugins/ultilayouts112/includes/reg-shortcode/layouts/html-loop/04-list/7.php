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
                </div>                            
            </div>
        <?php }?>
        <!--picture-->        
        <!--content-->
        <div class="ultimate-layouts-content entry">            
            <?php echo $post_taxonomy;?>            
            <?php echo $post_title_f24;?>            
            <?php echo $post_metas_1;?>            
            <?php echo $post_excerpt;?>    
            <?php echo $wooBasicElmBlock;?>                                    
            <?php echo $post_metas_2;?>            
        </div><!--content-->                
    </div><!--entry content-->            
</article><!--post item-->