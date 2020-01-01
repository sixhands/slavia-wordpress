<?php /* Template Name: Обмен */ ?>
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

    <!-- Основной контент -->
    <div class="col-lg-10 d-none d-lg-block"  style="z-index: 4; margin-top: 10px;">
        <div class="row">
            <div class="coop_maps question-bg col-lg-12">
                <h1 class="coop_maps-h1">Получить рубль</h1>

                <div class="col-12 pryamougolnik">
                    <p>Для получения рубля необходимо отправить монеты на следующий адрес:</p>
                    <h3>PRIZM-AWTX-HDBX-ADDH-7SMM7</h3>
                    <button class="btn-custom-two  text-center">Отправить</button>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3 input-exchange">
                            <div class="row">
                                <span>Количество монет PRIZM</span>
                                <input placeholder="0" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-6 input-exchange ">
                            <div class="row ">
                                <span class="select-exchange">Выбрать банк</span>
                                <div class="select-exchange w-100">
                                    <select>
                                        <option>Название выбранного банка</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 input-exchange orange-input">
                            <div class="row">
                                <span>Вы получите</span>
                                <input placeholder="0" id="exp" type="text" name="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 input-exchange">
                            <div class="row">
                                <input type="text" name="" class="input-pd-right" placeholder="Номер банковской карты для получения">
                            </div>
                        </div>
                        <div class="col-lg-6 input-exchange">
                            <div class="row">
                                <input type="text" name="" placeholder="Имя получателя (как на карте)">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="btn-custom-one exchange-pd text-center">
                                    Отправить
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="coop_maps question-bg col-lg-12">
                <h1 class="coop_maps-h1">Получить PRIZM</h1>


                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3 input-exchange select-custom">
                            <div class="row">
                                <span>&nbsp;</span>
                                <select class="">
                                    <option>ОТПРАВИТЬ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 input-exchange  input-custom-rub">
                            <div class="row ">
                                <span class="select-exchange">Количество</span>
                                <div class="select-exchange w-100">
                                    <input placeholder="0" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 input-exchange orange-input input-custom-prizm">
                            <div class="row">
                                <span>Вы получите</span>
                                <input placeholder="0" id="exp" type="text" name="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">

                        <div class="col-12">
                            <div class="row">
                                <div class="btn-custom-one exchange-pd text-center">
                                    Отправить
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="coop_maps question-bg col-lg-12">
                <h1 class="coop_maps-h1">Получить Waves</h1>


                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3 input-exchange select-custom">
                            <div class="row">
                                <span>&nbsp;</span>
                                <select class="">
                                    <option>ОТПРАВИТЬ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 input-exchange  input-custom-rub">
                            <div class="row ">
                                <span class="select-exchange">Количество</span>
                                <div class="select-exchange w-100">
                                    <input placeholder="0" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 input-exchange orange-input input-custom-waws">
                            <div class="row">
                                <span>Вы получите</span>
                                <input placeholder="0" id="exp" type="text" name="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">

                        <div class="col-12">
                            <div class="row">
                                <div class="btn-custom-one exchange-pd text-center">
                                    Отправить
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>


    <!-- Тело главной страницы mobile -->
    <div class="col-md-12 d-lg-none"  style="z-index: 4; margin-top: 10px;">
        <div class="row">
            <div class="coop_maps question-bg col-lg-12 ex-mob-pd" style="">
                <div class="click_ex" id="one-ex">
                    <h1 class="coop_maps-h1 ib">Получить рубль</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">

                    <div class="tab-ex">
                        <div class="col-12 pryamougolnik">
                            <p>Для получения рубля необходимо отправить монеты на следующий адрес:</p>
                            <h3>PRIZM-AWTX-HDBX-ADDH-7SMM7</h3>
                            <button class="btn-custom-two  text-center">Отправить</button>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-3 input-exchange">
                                    <div class="row">
                                        <span>Количество монет PRIZM</span>
                                        <input placeholder="0" type="text" name="">
                                    </div>
                                </div>
                                <div class="col-lg-6 input-exchange ">
                                    <div class="row ">
                                        <span class="select-exchange">Выбрать банк</span>
                                        <div class="select-exchange w-100">
                                            <select>
                                                <option>Название выбранного банка</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 input-exchange orange-input">
                                    <div class="row">
                                        <span>Вы получите</span>
                                        <input placeholder="0" id="exp" type="text" name="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 input-exchange">
                                    <div class="row">
                                        <input type="text" name="" class="input-pd-right" placeholder="Номер банковской карты для получения">
                                    </div>
                                </div>
                                <div class="col-lg-6 input-exchange">
                                    <div class="row">
                                        <input type="text" name="" placeholder="Имя получателя (как на карте)">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="btn-custom-one exchange-pd text-center">
                                            Отправить
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
                <div class="click_ex" id="two-ex">
                    <h1 class="coop_maps-h1 ib">Получить PRIZM</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                    <div class="tab-ex">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-3 input-exchange select-custom">
                                    <div class="row">
                                        <span>&nbsp;</span>
                                        <select class="">
                                            <option>ОТПРАВИТЬ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 input-exchange  input-custom-rub">
                                    <div class="row ">
                                        <span class="select-exchange">Количество</span>
                                        <div class="select-exchange w-100">
                                            <input placeholder="0" type="text" name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 input-exchange orange-input input-custom-prizm">
                                    <div class="row">
                                        <span>Вы получите</span>
                                        <input placeholder="0" id="exp" type="text" name="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="btn-custom-one exchange-pd text-center">
                                            Отправить
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
                <div class="click_ex" id="three-ex">
                    <h1 class="coop_maps-h1 ib">Получить Waves</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                    <div class="tab-ex">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-3 input-exchange select-custom">
                                    <div class="row">
                                        <span>&nbsp;</span>
                                        <select class="">
                                            <option>ОТПРАВИТЬ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 input-exchange  input-custom-rub">
                                    <div class="row ">
                                        <span class="select-exchange">Количество</span>
                                        <div class="select-exchange w-100">
                                            <input placeholder="0" type="text" name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 input-exchange orange-input input-custom-waws">
                                    <div class="row">
                                        <span>Вы получите</span>
                                        <input placeholder="0" id="exp" type="text" name="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="btn-custom-one exchange-pd text-center">
                                            Отправить
                                        </div>
                                    </div>
                                </div>
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
