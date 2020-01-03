<?php /* Template Name: Администратор настройки */ ?>
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

    <div class="col-lg-10 col-md-12"  style="z-index: 4; margin-top: 10px;">
        <div class="row">
            <div class="coop_maps question-bg col-lg-12">
                <h1 class="coop_maps-h1 ib">Настройки комиссии банков</h1>


                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 input-exchange input-custom-procent">
                            <div class="row">
                                <span>Название банка 1</span>
                                <input value="0.5" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange input-custom-rubl">
                            <div class="row ">
                                <span class="select-exchange">Название банка 2</span>
                                <div class="select-exchange w-100">
                                    <input value="0.25" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange input-custom-rubl">
                            <div class="row ">
                                <span class="select-exchange">Название банка 3</span>
                                <div class="select-exchange w-100">
                                    <input value="0.25" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange input-custom-procent">
                            <div class="row">
                                <span>Название банка 6</span>
                                <input value="0.5" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange input-custom-rubl">
                            <div class="row ">
                                <span class="select-exchange">Название банка 4</span>
                                <div class="select-exchange w-100">
                                    <input value="0.25" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange input-custom-rubl">
                            <div class="row ">
                                <span class="select-exchange">Название банка 5</span>
                                <div class="select-exchange w-100">
                                    <input value="0.25" type="text" name="">
                                </div>
                            </div>
                        </div>


                    </div>
                </div> <br>

                <div class="col-lg-3 text-center">
                    <div class="row">
                        <div class="btn-custom-one">
                            Добавить банк
                        </div>
                    </div>
                </div>

            </div>
            <div class="coop_maps question-bg col-lg-12">
                <h1 class="coop_maps-h1 ib">Вознаграждение по реферальной программе</h1>


                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 input-exchange input-custom-procent">
                            <div class="row">
                                <span>За каждого реферала</span>
                                <input value="0.5" type="text" name="">
                            </div>
                        </div>



                    </div>
                </div> <br>


            </div>
        </div>
    </div>

<?php
//get_sidebar();
get_footer();
