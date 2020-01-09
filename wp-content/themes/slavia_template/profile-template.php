<?php /* Template Name: Профиль slavia*/ ?>
<?php    get_header();
while ( have_posts() ) :
the_post();

get_template_part( 'template-parts/content', 'page' );
endwhile; // End of the loop. ?>

<?php get_footer();