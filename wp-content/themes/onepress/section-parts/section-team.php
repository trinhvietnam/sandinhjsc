<?php
$onepress_team_id = get_theme_mod('onepress_team_id', esc_html__('team', 'onepress'));
$onepress_team_disable = get_theme_mod('onepress_team_disable') == 1 ? true : false;
$onepress_team_title = get_theme_mod('onepress_team_title', esc_html__('Our Team', 'onepress'));
$onepress_team_subtitle = get_theme_mod('onepress_team_subtitle', esc_html__('Section subtitle', 'onepress'));
$layout = intval(get_theme_mod('onepress_team_layout', 3));
if ($layout <= 0) {
    $layout = 3;
}
$user_ids = onepress_get_section_team_data();
if (onepress_is_selective_refresh()) {
    $onepress_team_disable = false;
}
if (!empty($user_ids)) {
    $desc = get_theme_mod('onepress_team_desc');
    ?>
    <?php if (!$onepress_team_disable) : ?>
        <?php if (!onepress_is_selective_refresh()) { ?>
            <section id="<?php if ($onepress_team_id != '') echo $onepress_team_id; ?>" <?php do_action('onepress_section_atts', 'team'); ?>
            class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-team section-padding section-meta onepage-section', 'team')); ?>">
        <?php } ?>
        <?php do_action('onepress_section_before_inner', 'team'); ?>
        <div class="container">
            <div class="section-title-area">
                <!--<h5 class="section-subtitle">Section subtitle</h5>-->
                <h2 class="section-title">Nhân tài</h2></div>
            <div class="team-members row team-layout-4">
                <?php
                $args = array(
                    'category_name' => 'nhan-su',
                    'order' => 'ASC',
                    'posts_per_page' => 8
                );
                $the_query = new WP_Query($args);

                if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                    ?>
                    <div class="team-member wow slideInUp">
                        <div class="member-thumb">
                            <?php if (!has_post_thumbnail()) { ?>
                                <img src="http://fh1k9e2mgp47mzv028skubvh.wpengine.netdna-cdn.com/onepress-plus/wp-content/uploads/sites/18/2016/02/team5-480x300.jpg"
                                     alt="">
                            <?php } else  the_post_thumbnail('medium') ?>
                            <!--                                    <div class="member-profile">-->
                            <!--                                        <a href="#"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i-->
                            <!--                                                        class="fa fa-globe fa-stack-1x fa-inverse"></i></span></a>-->
                            <!--                                        <a href="#"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i-->
                            <!--                                                        class="fa fa-twitter fa-stack-1x fa-inverse"></i></span></a>-->
                            <!--                                        <a href="#"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i-->
                            <!--                                                        class="fa fa-facebook fa-stack-1x fa-inverse"></i></span></a>-->
                            <!--                                        <a href="#"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i-->
                            <!--                                                        class="fa fa-google-plus fa-stack-1x fa-inverse"></i></span></a>-->
                            <!--                                        <a href="#"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i-->
                            <!--                                                        class="fa fa-linkedin fa-stack-1x fa-inverse"></i></span></a>-->
                            <!---->
                            <!--                                    </div>-->
                        </div>
                        <div class="member-info">
                            <h5 class="member-name"><?php the_title() ?></h5>
                            <span class="member-position"><?php echo get_field('position'); ?></span>
                        </div>
                    </div>
                <?php endwhile ?>
                <?php endif; ?>


            </div>
        </div>
        <?php do_action('onepress_section_after_inner', 'team'); ?>
        <?php if (!onepress_is_selective_refresh()) { ?>
            </section>
        <?php } ?>
    <?php endif;
}
