<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package slavia_template
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php if (is_page(array(306)) ) echo "style='margin-top: 20px;'"; else {} ?>>
<!--	<header class="entry-header">-->
<!--		--><?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<!--	</header><!-- .entry-header -->

	<?php slavia_template_post_thumbnail(); ?>

	<div class="entry-content <?php if (is_page(array(306)) ) echo "container"; else {} ?>">
		<?php
        if (is_page(array(306)))
        {
            //var_dump(306);
            $GLOBALS['side_text'] = get_field('verification_sidetext');
            $GLOBALS['video_files'] = get_field('verification_video');
            $GLOBALS['video_text'] = get_field('verification_modal_text');
            $GLOBALS['exchange_address'] = get_field('exchange_address');
        }
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'slavia_template' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'slavia_template' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
