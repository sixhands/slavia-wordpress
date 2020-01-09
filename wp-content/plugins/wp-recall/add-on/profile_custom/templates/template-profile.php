<div class="col-lg-10 col-md-12"  style="z-index: 4; margin-top: 10px;">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12">
            <div class="row">
                <div class="col-lg-2">
                    <!--Изображение профиля-->
                    <img src="/wp-content/uploads/2019/12/profil_index_img.png" class="profil-index-img">
                </div>
                <div class="col-lg-8">
                    <!--Имя авторизированного пользователя -->
                    <h1 class="profil-user-h1">
                        С возвращением, Антон Викторович!
                    </h1>
                    <p class="profil-user-verification">Профиль верифицирован</p>
                </div>
                <div class="col-lg-2" style="margin-top: 5%">
                    <div class="btn-modal">
                        <input type="button" class="btn-custom-two text-center" onclick="document.location.href='<?php echo wp_logout_url('http://slv.a99953zd.beget.tech'); ?>';" value="Выход">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-4 input-exchange">
                        <div class="row">
                            <span>Имя пользователя</span>
                            <input value="Борисов Антон Викторович" type="text" name="">
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange ">
                        <div class="row ">
                            <span class="select-exchange">Email</span>
                            <div class="select-exchange w-100">
                                <input value="example@gmail.com" class="verification-ok" type="email" name="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange">
                        <div class="row">
                            <span>Телефон</span>
                            <input value="8 (911) 718 25 22" class="verification-ok" type="text" name="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Реферальная ссылка</h1>
            <div class="col-lg-4 input-exchange  input-custom-copy">
                <div class="row ">
                    <input placeholder="" value="https://slavia.com/5467889" type="text" name="">
                </div>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Номер пайщика</h1>
            <div class="col-lg-4 input-exchange  input-custom-copy">
                <div class="row ">
                    <input placeholder="" value="00073" type="text" name="">
                </div>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Ваш адрес Prizm</h1>
            <div class="row">
                <div class="col-lg-6 input-exchange  custom-padding input-custom-copy">
                    <div class="row ">
                        <span>Адрес PRIZM</span>
                        <input placeholder="" value="00073" type="text" name="">
                    </div>
                </div>
                <div class="col-lg-6 input-exchange custom-padding  input-custom-copy">
                    <div class="row ">
                        <span>Публичный ключ</span>
                        <input placeholder="" value="00073" type="text" name="">
                    </div>
                </div>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Ваш адрес Waves</h1>
            <div class="col-lg-12 input-exchange  input-custom-copy">
                <div class="row ">
                    <span>Адрес Waves</span>
                    <input placeholder="" value="00073" type="text" name="">
                </div>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1 ib">Верификация профиля</h1>
            <a id="modal-54506521" href="#modal-container-54506521" role="button" class="" data-toggle="modal"><img src="/wp-content/uploads/2019/12/info.png" class="ib info-href"></a>

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-4 input-exchange">
                        <div class="row">

                            <input placeholder="Имя" type="text" name="">
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange ">
                        <div class="row ">

                            <div class="select-exchange w-100">
                                <input placeholder="Email" class="" type="email" name="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange">
                        <div class="row">

                            <input placeholder="Отчество" class="" type="text" name="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-4 input-exchange">
                        <div class="row">
                            <span>Серия и номер паспорта</span>
                            <input placeholder="____-______"  type="text" name="">
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange ">
                        <div class="row ">
                            <span>&nbsp;</span>
                            <div class="select-exchange w-100">
                                <input placeholder="Дата выдачи" class="" type="email" name="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange">
                        <div class="row">
                            <span>&nbsp;</span>
                            <input placeholder="Код подразделения" class="" type="text" name="">
                        </div>
                    </div>
                    <div class="col-lg-12 input-exchange">
                        <div class="row">
                            <span>&nbsp;</span>
                            <input placeholder="Кем выдан" class="" type="text" name="">
                        </div>
                    </div>
                    <?php //if ($manager): ?>
                    <div class="col-lg-12 passport-photo">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row">
                                    <img src="/wp-content/uploads/2019/12/zg.png">
                                </div>
                            </div>
                            <div class="col-lg-4 passport-img">

                                <img class="" src="/wp-content/uploads/2019/12/zg.png">

                            </div>

                        </div>
                    </div>
                    <?php //endif; ?>
                    <?php //if ($user): ?>
                    <div class="col-lg-4" style="display: none">
                        <div class="row">
                            <div class="skrepka w-100 text-center">
                                <img src="/wp-content/uploads/2019/12/skrepka.png"> Прикрепить фото
                            </div>
                            <div class="btn-custom-one w-100 text-center" style="margin-top: 30px;">
                                Завершить регистрацию
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8" style="display: none">
                        <div class="row">
                            <p class="passport-text">
                                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                            </p>
                        </div>
                    </div>
                    <?php //endif; ?>

                </div>
            </div>

        </div>
        <!-- Статистика -->
        <?php //if ($manager): ?>
        <div class="coop_maps question-bg col-lg-12">
            <div class="row">
                <div class="col-12">
                    <h1 class="coop_maps-h1 ib">Статистика</h1>
                    <div class="ib" style="float:right">
                        <h1 class="coop_maps-h1 ib" style="font-size: 16px;">08.11.19</h1>
                        <img src="/wp-content/uploads/2019/12/calendar.png" class="ib" style="">
                        <img src="/wp-content/uploads/2019/12/loop.png" class="ib" style="margin-top: 10px;">
                        <img src="/wp-content/uploads/2019/12/donw.png" class="ib" style=" ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="table-title w-100">
                    <div class="row">

                        <div class="col-4 text-left" style="padding-left: 42px;">
                            Имя клиента
                        </div>
                        <div class="col-3 text-left">
                            Номер пайщика
                        </div>
                        <div class="col-2 text-left">
                            Обменов
                        </div>
                        <div class="col-3 text-left">
                            На сумму
                        </div>
                    </div>
                </div>
                <div class="table-text w-100">
                    <div class="row">
                        <div class="col-4 text-left" style="padding-left: 42px;">
                            Имя Фамилия Отчество
                        </div>
                        <div class="col-3 text-left">
                            00002
                        </div>
                        <div class="col-2 text-left">
                            5
                        </div>
                        <div class="col-3 text-left">
                            15 600 RUB
                        </div>
                    </div>
                </div><div class="table-text w-100">
                    <div class="row">
                        <div class="col-4 text-left" style="padding-left: 42px;">
                            Имя Фамилия Отчество
                        </div>
                        <div class="col-3 text-left">
                            00002
                        </div>
                        <div class="col-2 text-left">
                            5
                        </div>
                        <div class="col-3 text-left">
                            15 600 RUB
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php //endif; ?>

    </div>
</div>
<!--Модальное окно информации -->
<div class="modal fade" id="modal-container-54506521" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-left">
            <div class="row">
                <div class="col-10">
                    <h1 class="coop_maps-h1 ib">Верификация профиля</h1>
                </div>
                <div class="col-2">
                    <button type="button" class="close ib " data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

            </div>

            Здесь будет видео
        </div>
    </div>
</div>