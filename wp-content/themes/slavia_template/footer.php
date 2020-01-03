<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slavia_template
 */

?>

<?php if ( is_page( array( 147, 16, 14, 22, 20 ) ) ): ?> <!-- 20-партнеры, 147-главная, 16-документы, 14-корпоративные карты, 22-о нас-->

	</div><!-- #content -->

<!--Модальное окно авторизации -->
<div class="modal fade" id="modal-container-545065" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <!-- <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>      -->
            <h1 class="modal-h1 text-center">Авторизация в МПК "Славия"</h1>
            <div class="col-md-12 text-center modal-form">
                <input class="input-modal text-center" type="text" name="login" placeholder="Логин">
                <input class="input-modal text-center" type="password" name="password" placeholder="Пароль">
                <div class="btn-modal ">
                    <div  class="btn-custom-one text-center">
                        Авторизоваться
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php endif; ?>

	<footer id="colophon" class="site-footer">
<!--		<div class="site-info">-->
<!--			<a href="--><?php //echo esc_url( __( 'https://wordpress.org/', 'slavia_template' ) ); ?><!--">-->
<!--				--><?php
//				/* translators: %s: CMS name, i.e. WordPress. */
//				printf( esc_html__( 'Proudly powered by %s', 'slavia_template' ), 'WordPress' );
//				?>
<!--			</a>-->
<!--			<span class="sep"> | </span>-->
<!--				--><?php
//				/* translators: 1: Theme name, 2: Theme author. */
//				printf( esc_html__( 'Theme: %1$s by %2$s.', 'slavia_template' ), 'slavia_template', '<a href="http://underscores.me/">Underscores.me</a>' );
//				?>
<!--		</div> .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
