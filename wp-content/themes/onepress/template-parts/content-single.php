<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php onepress_posted_on(); ?>
            <div class="fb-like" data-href="<?php echo get_permalink()?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'onepress' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <div class="fb-like" data-href="<?php echo get_permalink()?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
    <div class="fb-comments" data-href="<?php echo get_permalink()?>" data-width="100%" data-numposts="5"></div>
<!--	<footer class="entry-footer">-->
<!--		--><?php //onepress_entry_footer(); ?>
<!--	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

