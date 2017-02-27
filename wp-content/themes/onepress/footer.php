<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */
?>
<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer-connect">
        <div class="container">
            <div class="row">
                <div class="col-sm-2"></div>
                <!--<div class="col-sm-4">-->
                <!--<div class="footer-subscribe">-->
                <!--<h5 class="follow-heading">Join our Newsletter</h5>-->
                <!--<form novalidate="" target="_blank" class="" name="mc-embedded-subscribe-form"-->
                <!--id="mc-embedded-subscribe-form" method="post"-->
                <!--action="//famethemes.us8.list-manage.com/subscribe/post?u=521c400d049a59a4b9c0550c2&#038;id=83187e0006">-->
                <!--<input type="text" placeholder="Enter your e-mail address" id="mce-EMAIL"-->
                <!--class="subs_input" name="EMAIL" value="">-->
                <!--<input type="submit" class="subs-button" value="Subscribe" name="subscribe">-->
                <!--</form>-->
                <!--</div>-->
                <!--</div>-->

                <div class="col-sm-8">
                    <div class="footer-social">
                        <h5 class="follow-heading">Kết Nối Sân Đình</h5>
                        <div class="footer-social-icons">
                            <!--<a target="_blank" href="#twittter" title="twitter">-->
                            <!--<i-->
                            <!--class="fa fa-twitter"></i>-->
                            <!--</a>-->
                            <a target="_blank" href="https://www.facebook.com/sandinh.game"
                               title="Facebook"><i class="fa fa-facebook"></i></a>
                            <a target="_blank" href="https://www.youtube.com/channel/UCIMmvyinwDgAiOyKll_BsLQ"
                            title="Youtube">
                            <i
                            class="fa fa-youtube"></i>
                            </a>
                            <!--<a target="_blank" href="#Instagram"-->
                            <!--title="Instagram">-->
                            <!--<i-->
                            <!--class="fa fa-instagram"></i>-->
                            <!--</a>-->
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>

    <div class="site-info">
        <div class="container">
            <div class="btt">
                <a class="back-top-top" href="#page" title="Back To Top"><i class="fa fa-angle-double-up wow flash"
                                                                            data-wow-duration="2s"></i></a>
            </div>
            Copyright &copy; 2017 Sân Đình JSC
        </div>
    </div>
    <!-- .site-info -->

</footer><!-- #colophon -->
<?php
/**
 * Hooked: onepress_site_footer
 *
 * @see onepress_site_footer
 */
do_action( 'onepress_site_end' );
?>
</div><!-- #page -->

<?php wp_footer(); ?>
<script type='text/javascript'
        src='<?php echo get_stylesheet_directory_uri()?>/assets/js/gmap.js'></script>
<script type='text/javascript'
        src='https://maps.google.com/maps/api/js?key=AIzaSyC97ib0SwAgdFsndmPYKZr3Gl9ODCK6G-4&sensor=false&#038;ver=4.6.3'></script>
</body>
</html>
