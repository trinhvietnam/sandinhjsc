<?php
$onepress_contact_id            = get_theme_mod( 'onepress_contact_id', esc_html__('contact', 'onepress') );
$onepress_contact_disable       = get_theme_mod( 'onepress_contact_disable' ) == 1 ?  true : false;
$onepress_contact_title         = get_theme_mod( 'onepress_contact_title', esc_html__('Get in touch', 'onepress' ));
$onepress_contact_subtitle      = get_theme_mod( 'onepress_contact_subtitle', esc_html__('Section subtitle', 'onepress' ));
$onepress_contact_cf7           = get_theme_mod( 'onepress_contact_cf7' );
$onepress_contact_cf7_disable   = get_theme_mod( 'onepress_contact_cf7_disable' );
$onepress_contact_text          = get_theme_mod( 'onepress_contact_text' );
$onepress_contact_address_title = get_theme_mod( 'onepress_contact_address_title' );
$onepress_contact_address       = get_theme_mod( 'onepress_contact_address' );
$onepress_contact_phone         = get_theme_mod( 'onepress_contact_phone' );
$onepress_contact_email         = get_theme_mod( 'onepress_contact_email' );
$onepress_contact_fax           = get_theme_mod( 'onepress_contact_fax' );

if ( onepress_is_selective_refresh() ) {
    $onepress_contact_disable = false;
}

if ( $onepress_contact_cf7 || $onepress_contact_text || $onepress_contact_address_title || $onepress_contact_phone || $onepress_contact_email || $onepress_contact_fax ) {
    $desc = get_theme_mod( 'onepress_contact_desc' );
    ?>
    <?php if (!$onepress_contact_disable) : ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        <section id="<?php if ($onepress_contact_id != '') echo $onepress_contact_id; ?>" <?php do_action('onepress_section_atts', 'counter'); ?>
                 class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-contact section-padding  section-meta onepage-section', 'contact')); ?>">
        <?php } ?>
            <?php do_action('onepress_section_before_inner', 'contact'); ?>
            <div class="container">
                <div class="row">
                    <!--<div class="contact-form col-sm-6 wow slideInUp">-->
                    <!--<div role="form" class="wpcf7" id="wpcf7-f6-o1" lang="en-US" dir="ltr">-->
                    <!--<div class="screen-reader-response"></div>-->
                    <!--<form action="/onepress-plus/#wpcf7-f6-o1" method="post" class="wpcf7-form"-->
                    <!--novalidate="novalidate">-->
                    <!--<div style="display: none;">-->
                    <!--<input type="hidden" name="_wpcf7" value="6"/>-->
                    <!--<input type="hidden" name="_wpcf7_version" value="4.6.1"/>-->
                    <!--<input type="hidden" name="_wpcf7_locale" value="en_US"/>-->
                    <!--<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f6-o1"/>-->
                    <!--<input type="hidden" name="_wpnonce" value="7b488eea5e"/>-->
                    <!--</div>-->
                    <!--<p>Your Name (required)<br/>-->
                    <!--<span class="wpcf7-form-control-wrap your-name"><input type="text"-->
                    <!--name="your-name" value=""-->
                    <!--size="40"-->
                    <!--class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"-->
                    <!--aria-required="true"-->
                    <!--aria-invalid="false"/></span>-->
                    <!--</p>-->
                    <!--<p>Your Email (required)<br/>-->
                    <!--<span class="wpcf7-form-control-wrap your-email"><input type="email"-->
                    <!--name="your-email"-->
                    <!--value="" size="40"-->
                    <!--class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email"-->
                    <!--aria-required="true"-->
                    <!--aria-invalid="false"/></span>-->
                    <!--</p>-->
                    <!--<p>Subject<br/>-->
                    <!--<span class="wpcf7-form-control-wrap your-subject"><input type="text"-->
                    <!--name="your-subject"-->
                    <!--value="" size="40"-->
                    <!--class="wpcf7-form-control wpcf7-text"-->
                    <!--aria-invalid="false"/></span>-->
                    <!--</p>-->
                    <!--<p>Your Message<br/>-->
                    <!--<span class="wpcf7-form-control-wrap your-message"><textarea name="your-message"-->
                    <!--cols="40" rows="10"-->
                    <!--class="wpcf7-form-control wpcf7-textarea"-->
                    <!--aria-invalid="false"></textarea></span>-->
                    <!--</p>-->
                    <!--<p><input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit"/></p>-->
                    <!--<div class="wpcf7-response-output wpcf7-display-none"></div>-->
                    <!--</form>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--<div class="col-sm-6 wow slideInUp">-->
                    <div class="wow slideInUp" style="visibility: visible; animation-name: slideInUp;">
                        <!--<br>-->
                        <!--<h4>WE ARE ACCEPTING NEW PROJECTS.</h4>-->
                        <!--<p>Dorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pulvinar scelerisque-->
                        <!--dictum. Donec iaculis, diam sit amet suscipit feugiat, diam magna volutpat augue.</p>-->
                        <!--<p>Consectetur adipiscing elit. Suspendisse pulvinar scelerisque dictum. Donec iaculis, diam-->
                        <!--sit amet suscipit feugiat, diam magna volutpat augue.</p><br><br>-->

                        <div class="address-box">

                            <h3 style="text-align: center">Công ty cổ phần Sân Đình</h3>

                            <div class="col-sm-4 address-contact">
                                <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-map-marker fa-stack-1x fa-inverse"></i></span>

                                <div class="address-content">Phòng C1009 Golden Palace - Mễ Trì - Nam Từ Liêm -
                                    Hà
                                    Nội
                                </div>
                            </div>

                            <div class="col-sm-4 address-contact">
                                <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-phone fa-stack-1x fa-inverse"></i></span>

                                <div class="address-content">0902.508.308</div>
                            </div>

                            <div class="col-sm-4 address-contact">
                                <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i></span>

                                <div class="address-content"><a href="mailto:tuyendung@sandinh.net">
                                        tuyendung@sandinh.net</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php do_action('onepress_section_after_inner', 'contact'); ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        </section>
        <?php } ?>
    <?php endif;
}
