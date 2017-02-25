<style>
    .spinner {
        animation: 0.8s linear 0s normal none infinite running spin;
        border: 5px solid rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        box-sizing: border-box;
        height: 40px;
        left: 50%;
        margin-left: -20px;
        margin-top: -20px;
        position: absolute;
        top: 50%;
        width: 40px;
    }

    .spinner:after {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: transparent transparent #fff;
        border-image: none;
        border-radius: 50%;
        border-style: solid;
        border-width: 3px;
        bottom: -4px;
        content: "";
        left: -4px;
        position: absolute;
        right: -4px;
        top: -4px;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .section-projects .spinner {
        z-index: 35;
    }

    .project-wrapper {
        font-size: 0;
        max-width: none;
        margin: 0 auto;
        position: relative;
        border-left: 1px solid #e0e0e0;
    }

    .project-wrapper .project-item {
        vertical-align: top;
        display: inline-block;
        border-right: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
        border-top: 1px solid #e0e0e0;
        -webkit-transition: height 500ms ease;
        -o-transition: height 500ms ease;
        transition: height 500ms ease;
    }

    .project-wrapper .project-thumb {
        overflow: hidden;
    }

    .project-wrapper .project-thumb a {
        display: block;
    }

    .project-wrapper .project-thumb img {
        transition: all 0.2s linear 0s;
        -webkit-transition: all 0.2s linear 0s;
        -o-transition: all 0.2s linear 0s;
        overflow: hidden;
        width: 100%;
    }

    .project-wrapper .project-thumb img:hover {
        transform: scale(1.1);
    }

    .project-wrapper .project-header {
        padding: 17px 20px 15px;
        background: #f8f9f9;
    }

    .project-wrapper .project-header .project-small-title {
        margin-bottom: 5px;
        letter-spacing: 0.4px;
    }

    .project-wrapper .project-header .project-meta {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        color: #AAAAAA;
    }

    .project-wrapper .project-trigger {
        cursor: pointer;
    }

    .project-2-column .project-item {
        width: 50%;
    }

    .project-3-column .project-item {
        width: 33.333333333333%;
    }

    .project-4-column .project-item {
        width: 25%;
    }

    @media screen and (max-width: 1140px) {
        .project-2-column .project-item,
        .project-3-column .project-item,
        .project-4-column .project-item {
            width: 50%;
        }
    }

    @media screen and (max-width: 720px) {
        .project-2-column .project-item,
        .project-3-column .project-item,
        .project-4-column .project-item {
            width: 100%;
        }
    }

    .project-item.active .project-thumb img {
        opacity: 0.6;
        -webkit-transition: all 500ms ease-in-out;
        -o-transition: all 500ms ease-in-out;
        transition: all 500ms ease-in-out;
    }

    .project-detail {
        position: absolute;
        left: 0;
        right: 0;
        overflow: hidden;
        max-height: 0;
        -webkit-transition: max-height 500ms ease;
        -o-transition: max-height 500ms ease;
        transition: max-height 500ms ease;
    }

    .project-detail .project-detail-content {
        font-size: 14px;
        padding-top: 10px;
    }

    .project-detail .project-expander-contents {
        padding: 40px 20px 100px;
        background: #f8f9f9;
        border: 1px solid #e0e0e0;
        border-left: none;
    }

    @media screen and (max-width: 940px) {
        .project-detail .project-expander-contents {
            padding: 40px 20px 60px;
        }
    }

    .active .project-detail {
        overflow: visible;
    }

    .project-expander-contents {
        margin: 0 auto;
        position: relative;
    }

    .project-expander-contents div.close {
        position: absolute;
        left: 50%;
        bottom: 30px;
        margin-left: -16px;
        font-size: 13px;
        text-indent: -9999px;
        width: 32px;
        height: 32px;
        cursor: pointer;
        opacity: 1;
    }

    .project-expander-contents div.close:before, .project-expander-contents div.close:after {
        position: absolute;
        display: inline-block;
        height: 2px;
        width: 40px;
        background: #000000;
        content: '';
        right: 0px;
        top: 15px;
        cursor: pointer;
    }

    .project-expander-contents div.close:before {
        -webkit-transform: translateX(4px) translateY(-1px) rotate(45deg);
        -moz-transform: translateX(4px) translateY(-1px) rotate(45deg);
        -ms-transform: translateX(4px) translateY(-1px) rotate(45deg);
        -o-transform: translateX(4px) translateY(-1px) rotate(45deg);
        transform: translateX(4px) translateY(-1px) rotate(45deg);
    }

    .project-expander-contents div.close:after {
        -webkit-transform: translateX(4px) translateY(0px) rotate(-45deg);
        -moz-transform: translateX(4px) translateY(0px) rotate(-45deg);
        -ms-transform: translateX(4px) translateY(0px) rotate(-45deg);
        -o-transform: translateX(4px) translateY(0px) rotate(-45deg);
        transform: translateX(4px) translateY(0px) rotate(-45deg);
    }

    .project-content-inside {
        padding-left: 10px;
        padding-left: 0.625rem;
    }

    .project-detail-title {
        font-weight: 700;
        letter-spacing: -0.7px;
    }

    .project-item, .project-wrapper, .section-projects {
        -webkit-transition: 200ms ease;
        -moz-transition: 200ms ease;
        transition: 200ms ease;
    }

    .project-item .project-expander {
        visibility: hidden;
        -webkit-transition: 200ms ease;
        -moz-transition: 200ms ease;
        transition: 200ms ease;
    }

    .project-item.active .project-expander {
        visibility: visible;
        max-height: initial;
    }

    .project-item.loading .project-content .project-thumb {
        position: relative;
    }

    .project-item.loading .project-content .project-thumb:before {
        content: " ";
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        display: block;
        z-index: 10;
        background-color: rgba(0, 0, 0, 0.4);
    }

    /*
    .project-item.loading .project-content .project-thumb:after {
        content: " ";
        display: block;
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        display: block;
        z-index: 11;
        background: url("assets/images/loading.gif") center center no-repeat ;
    }
    */
    .project-media .video-rp {
        position: relative;
        padding-bottom: 56.25%;
        /* 16:9 */
        padding-top: 25px;
        height: 0;
    }

    .project-media .video-rp iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .project-media:after {
        clear: both;
        content: " ";
        display: block;
    }

    .section-projects.section-inverse .project-wrapper {
        border-left: 1px solid rgba(255, 255, 255, 0.2);
    }

    .section-projects.section-inverse .project-wrapper .project-item {
        border-color: rgba(255, 255, 255, 0.2);
    }

    .section-projects.section-inverse .project-wrapper .project-item .project-header {
        background: #333333;
    }

    .section-projects.section-inverse .project-detail .project-expander-contents {
        background: #333333;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .section-projects.section-inverse .project-expander-contents div.close::before, .section-projects.section-inverse .project-expander-contents div.close::after {
        background: #fff;
    }
</style>
<section id="products" class="section-padding section-projects onepage-section">
    <div class="container">
        <div class="section-title-area">
            <!--<h5 class="section-subtitle">Some of our works</h5>-->
            <h2 class="section-title">Các sản phẩm</h2></div>
        <div class="project-wrapper project-3-column wow slideInUp" style="visibility: visible; animation-name: slideInUp;">


            <?php
            $args = array(
                'post_type' => 'page',
                'nopaging' => true,
                'order' => 'ASC',
                max_num_pages => -1,
                'meta_key' => '_wp_page_template',
                'meta_value' => 'templates/product.php'
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                ?>
                <div class="project-item">
                    <div class="project-content project-contents is-ajax" data-id="1202">
                        <div class="project-thumb project-trigger">
                            <a href="<?php echo get_permalink()?>">
                                <img width="640" height="400" src="<?php the_post_thumbnail_url()?>" alt="<?php the_title()?>">
                            </a>
                        </div>
                        <div class="project-header project-trigger">
                            <h5 class="project-small-title">
                                <a href="<?php echo get_permalink()?>"><?php the_title()?></a>
                            </h5>
                            <div class="project-meta"><?php echo get_field('num_of_user')?> Users</div>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
            <?php endif; ?>


            <div class="clear"></div>
        </div>
    </div>
</section>