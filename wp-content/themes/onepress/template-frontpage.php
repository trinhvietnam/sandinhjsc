<?php
/**
 *Template Name: Frontpage
 *
 * @package OnePress
 */

get_header(); ?>

	<div id="content" class="site-content">
		<main id="main" class="site-main" role="main">
            <?php

            do_action( 'onepress_frontpage_before_section_parts' );

			if ( ! has_action( 'onepress_frontpage_section_parts' ) ) {

				$sections = apply_filters( 'onepress_frontpage_sections_order', array(
                    'hero', 'features', 'about','counter','products', 'videolightbox', 'gallery',  'team',  'news', 'map','contact'
                ) );

				foreach ( $sections as $section ){
                    /**
                     * Hook before section
                     */
                    do_action('onepress_before_section_'.$section );
                    do_action( 'onepress_before_section_part', $section );

                    /**
                     * Load section template part
                     */
					get_template_part( 'section-parts/section', $section );

                    /**
                     * Hook after section
                     */
                    do_action('onepress_after_section_part', $section );
                    do_action('onepress_after_section_'.$section );
				}

			} else {
				do_action( 'onepress_frontpage_section_parts' );
			}

            do_action( 'onepress_frontpage_after_section_parts' );

			?>
		</main><!-- #main -->
	</div><!-- #content -->
    <script>
        jQuery('.main-navigation .menu-item a').click(function () {
            window.history.pushState("", "", jQuery(this).attr('href'));
            jQuery(this).parent().addClass('onepress-current-item');
        });
        jQuery('.main-navigation .menu-item:first').addClass('onepress-current-item');
    </script>
<?php get_footer(); ?>
