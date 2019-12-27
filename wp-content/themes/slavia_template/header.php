<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slavia_template
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php $upload_dir = wp_upload_dir(); ?>

<!-- Вставки на фон -->
<img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/bg-left-bottom.png'?>" class="img-bg-left-bottom">
<img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/bg-right-top.png'?>" class="img-bg-right-top">
<img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/bg-center.png'?>" class="img-bg-center">

<!-- Иконки слева десктоп -->
<div class="desctop-icons text-center " style="z-index: 5">
    <img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/teleg.png'?>"><br>
    <img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/medium.png'?>"> <br>
    <img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/twitter.png'?>"><br>
    <img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/github.png'?>">
</div>

<!--мобильное меню тело -->
<div class="mobile-menu">
    <div class="container">
        <div class="row">
            <ul class="mobile-menu-ul text-left">
                <a href="coop_cards.html"><li>Кооперативные карты</li></a>
                <a href="documents.html"><li>Документы</li></a>
                <a href="partners.html"><li>Партнеры</li></a>
                <a href="about_us.html"><li>О нас</li></a>
                <a id="modal-545065" href="#modal-container-545065" role="button" class="" data-toggle="modal"><li class="btn-custom-one text-center">Авторизация</li></a>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-bg">

</div>

<div class="container">
    <div class="row">
        <!-- Шапка главной страницы -->
        <div class="col-md-12"  style="z-index: 5;">
            <div class="row">
                <div class="col-lg-4 col-9">
                    <a href="http://slv.dig-studio.ru">
                        <!--Логотип и название -->

                        <img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/hands_logo.png' //get_template_directory_uri() . '/assets/img/hands_logo.png' ?>" class="header-logo">
                        <h3 class="header-h3">
                            <span>МПК</span> СЛАВИЯ
                        </h3>
                    </a>

                </div>
                <div class="col-lg-6 col-2 px-0">
                    <!-- Десктоп меню -->
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'menu_class'        => 'desctop-menu text-right d-none d-lg-block',
                    ) );
                    ?>
<!--                    <ul class="desctop-menu text-right d-none d-lg-block" style="float:left; margin-left: 7%">-->
<!--                        <a href="coop_cards.html"><li>Кооперативные карты</li></a>-->
<!--                        <a href="documents.html"><li>Документы</li></a>-->
<!--                        <a href="partners.html"><li>Партнеры</li></a>-->
<!--                        <a href="about_us.html"><li>О нас</li></a>-->
<!--                    </ul>-->

                    <!--Мобильное меню кнопка-->
                    <div class="row d-lg-none">
                        <div class="col-12 text-right">
                            <img id="burger" class="burger-ico  text-right" src= "<?php echo trailingslashit( $upload_dir['baseurl'] ) . "2019/12/burger.png" ?>" status="close">
                        </div>
                    </div>

                </div>
                <div class="col-lg-2 col-1 px-0">
                    <div class="desctop-menu">
                        <a id="modal-545065" href="#modal-container-545065" role="button" class="" data-toggle="modal"><li class="btn-custom-one text-center">Авторизация</li></a>
                    </div>
                </div>
            </div>
        </div>









