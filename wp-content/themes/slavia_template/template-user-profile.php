<?php /* Template Name: Личный кабинет */ ?>
<?php    get_header(); ?>

    <div id="primary" class="content-area" style="margin-top: 15px;">
        <main id="main" class="site-main">

            <?php
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->


    <div class="col-lg-2 left-panel d-none d-lg-block" style=" margin-top: 10px;">
        <div class="coop_maps question-bg col-lg-12 col-md-4">
            <div class="row ">
                <div class="col-12 text-center" >
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'left-menu',
                        'menu_id'        => 'left-menu',
                        'menu_class'        => 'left-menu',
                        'container'     =>   '',
                        'link_before'    =>   "<div class='profil-user-menu-item w-100 text-center'><img src=''><p>",
                        'link_after'    =>    "</p></div>",
                    ) );
                    ?>
                </div>
            </div>
        </div>


        <div class="coop_maps question-bg col-lg-12 col-md-4">
            <div class="row ">
                <div class="col-12 text-center" >
                    <h1 class="coin-num ">
                        0.897600
                    </h1>
                    <h1 class="coin-num-name ">
                        prizm
                    </h1>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-4">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="img/chat_ico.png" class="chat_ico">
                </div>
            </div>

        </div>
    </div>

<?php
//get_sidebar();
get_footer();
