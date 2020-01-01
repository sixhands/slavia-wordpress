<?php /* Template Name: Пользователь операции */ ?>
<?php    get_header(); ?>


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
                        'link_before'    =>   "<div class='profil-user-menu-item w-100 text-center'><img><p>",
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
                    <img src="/wp-content/uploads/2019/12/chat_ico.png" class="chat_ico">
                </div>
            </div>

        </div>
    </div>

    <!--Основной контент-->
    <div class="col-lg-10 col-md-12"  style="z-index: 4; margin-top: 10px;">
        <div class="row">
            <div class="coop_maps question-bg col-lg-12">
                <h1 class="coop_maps-h1 ib">Мои заявки</h1>
                <img src="/wp-content/uploads/2019/12/calendar.png" class="ib" style="float: right; margin-top: 20px;">
                <h1 class="coop_maps-h1 ib" style="float: right; font-size: 16px;">08.11.19</h1>

                <div class="row">
                    <div class="table-title w-100">
                        <div class="row">
                            <div class="col-2 text-center">
                                Дата
                            </div>
                            <div class="col-2 text-center">
                                Отдаю
                            </div>
                            <div class="col-2 text-center">
                                Получаю
                            </div>
                            <div class="col-2 text-center">
                                КОЛИЧЕСТВО
                            </div>
                            <div class="col-2 text-center">
                                ОСТАЛОСЬ
                            </div>
                            <div class="col-2 text-center">
                                СТАТУС
                            </div>
                        </div>
                    </div>
                    <div class="table-text w-100">
                        <div class="row">
                            <div class="col-2 text-center">
                                08.11.19
                            </div>
                            <div class="col-2 text-center">
                                RUB
                            </div>
                            <div class="col-2 text-center">
                                PRIZM
                            </div>
                            <div class="col-2 text-center">
                                0.788 PZM
                            </div>
                            <div class="col-2 text-center">
                                0.9188 PZM
                            </div>
                            <div class="col-2 text-center" style="font-size: 15px; color: #EF701B">
                                Ожидает проверки
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//get_sidebar();
get_footer();
