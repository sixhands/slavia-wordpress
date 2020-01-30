<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slavia_templatesl
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
    <script>
        var ipay = new IPAY({api_token: 'c5fv4u1thn44fvba2u2jatuva2'});
    </script>
</head>

<body <?php body_class(); ?>>

<?php $upload_dir = wp_upload_dir(); ?>

<?php if (is_front_page()): ?>
<!-- Вставки на фон -->
<img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/bg-left-bottom.png'?>" class="img-bg-left-bottom">
<img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/bg-right-top.png'?>" class="img-bg-right-top">
<img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/bg-center.png'?>" class="img-bg-center">

<?php endif; ?>

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
            <?php
            wp_nav_menu( array(
                'theme_location' => 'menu-1',
                'menu_class'        => 'mobile-menu-ul text-left',
            ) );
            ?>

<!--            <ul class="">-->
<!--                <a href="coop_cards.html"><li>Кооперативные карты</li></a>-->
<!--                <a href="documents.html"><li>Документы</li></a>-->
<!--                <a href="partners.html"><li>Партнеры</li></a>-->
<!--                <a href="about_us.html"><li>О нас</li></a>-->
<!--                <a id="modal-545065" href="#modal-container-545065" role="button" class="" data-toggle="modal"><li class="btn-custom-one text-center">Авторизация</li></a>-->
<!--            </ul>-->
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
                    <a href="http://slv.a99953zd.beget.tech/">
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
                        <?php if ( !is_user_logged_in() ): ?>
                            <a id="modal-545065" href="#modal-container-545065" role="button" class="rcl-login" data-toggle="modal"><li class="btn-custom-one text-center">Авторизация</li></a>
                        <?php else: ?>
                            <a id="modal-545065" href="/profile" role="button">
                                <li class="btn-custom-two text-center" id="profil_user_btn">
                                    <img src="<?php echo trailingslashit( $upload_dir['baseurl'] ) . '2019/12/profil.png'?>"> Профиль
                                </li>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Переделать условие под если залогинен-->
        <?php if ( !is_page( array( 147, 16, 14, 22, 20 ) ) ): ?> <!-- 20-партнеры, 147-главная, 16-документы, 14-корпоративные карты, 22-о нас-->

        <!--Кнопка чата fixed-->
<!--        <img src="/wp-content/uploads/2019/12/chat_ico.png" class="chat_ico-fixed d-lg-none">-->

        <div class="d-lg-none col-md-12"  style="z-index: 4; margin-top: 10px;">
            <div class="row">
                <div class="coop_maps question-bg  ex-mob-pd col-6">
                    <h1 class="ib ex-mobile-h1-num"><?php echo rcl_slavia_get_crypto_price('PZM') . " RUB"; ?></h1>
                    <h1 class="ib ex-mobile-h1-prizm">prizm</h1>
                </div>
                <div id="left-mobile-menu-location" class="col-6">
<!--                    <select class="profil-mobile-menu w-100">-->
<!--                        <option>Главная</option>-->
<!--                        <option>Операции</option>-->
<!--                        <option>Документы</option>-->
<!--                        <option>Заявки</option>-->
<!--                        <option>Люди</option>-->
                            <?php //wp_nav_menu(array(
//                        'theme_location' => 'left-menu', // your theme location here
//                        'walker'         => new Walker_Nav_Menu_Dropdown(),
//                        'items_wrap'     => '<select class="%2$s">%3$s</select>',
//                        'menu_class'     => 'profil-mobile-menu w-100',
//                        'container_class' => 'col-6',
//                        )); ?>
<!--                    </select>-->
                </div>
            </div>
        </div>
        <?php endif; ?>









