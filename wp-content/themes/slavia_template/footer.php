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
    <div class="container">
        <div class="row">
            <div class="col-12">
                <footer id="colophon" class="site-footer">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer-menu',
                        'menu_class'        => 'desctop-menu text-right d-lg-block',
                    ) );
                    ?>
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
            </div>
        </div>
    </div>
</div><!-- #page -->

<?php wp_footer(); ?>
<!-- Begin of Chaport Live Chat code -->
<!--<script type="text/javascript">-->
<!--    (function(w,d,v3){-->
<!--        w.chaportConfig = {-->
<!--            appId : '5e88b18532aac207793c72a3'-->
<!--        };-->
<!---->
<!--        if(w.chaport)return;v3=w.chaport={};v3._q=[];v3._l={};v3.q=function(){v3._q.push(arguments)};v3.on=function(e,fn){if(!v3._l[e])v3._l[e]=[];v3._l[e].push(fn)};var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://app.chaport.com/javascripts/insert.js';var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss)})(window, document);-->
<!--</script>-->
<!-- End of Chaport Live Chat code -->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5e88b7b169e9320caac03eff/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
