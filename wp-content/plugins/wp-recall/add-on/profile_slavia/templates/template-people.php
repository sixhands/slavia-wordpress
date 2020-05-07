<div class="col-lg-12 col-md-12"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1 ib">Список пользователей</h1>
            <div class="row">
                <div class="table-title w-100">
                    <div class="row">
                        <div class="col-lg-1">

                        </div>
                        <div class="col-3 text-left">
                            Имя клиента
                        </div>
                        <div class="col-2 text-left">
                            № Пайщика
                        </div>
                        <div class="col-3 text-left">
                            Дата регистрации
                        </div>
<!--                        <div class="col-2 text-left">-->
<!--                            Рефереалов-->
<!--                        </div>-->
                        <div class="col-2 text-left">

                        </div>

                    </div>
                </div>
                <?php echo do_shortcode("[userlist template='slavia' inpage='10' data='user_registered,profile_fields' orderby='user_registered' exclude='30']"); ?>

<!--                <div class="w-100 text-center">-->
<!--                    <ul class="people-ul">-->
<!--                        <li status="active">1</li>-->
<!--                        <li>2</li>-->
<!--                        <li>3</li>-->
<!--                        <li>...</li>-->
<!--                        <li>50</li>-->
<!--                    </ul>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>

<a style="display: none;" id="modal-54506521" href="#modal-container-54506521" role="button" class="" data-toggle="modal">
</a>
<!--Модальное окно регистрации -->
<div class="modal fade" id="modal-container-54506521" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px; ">
        <div class="modal-content text-left" style="padding: 40px;">
            <div class="row">
                <div class="col-10">
                    <h1 class="coop_maps-h1 ib">Данные пользователя:</h1>
                </div>

                <div class="col-2">
                    <button type="button" class="close ib " data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

            </div>

            <div class="row" id="userdata_content">
                <div class="col-12 input-exchange">
                    <div class="row">
                        <span>Имя пользователя</span>
                        <input class="username" placeholder="Имя пользователя" type="text" name="">
                    </div>
                </div>
                <div class="col-lg-12 input-exchange ">
                    <div class="row ">
                        <span>Email</span>
                        <input class="user_email" placeholder="Email" type="text" name="">
                    </div>
                </div>

                <div class="col-lg-12 input-exchange">
                    <div class="row">
                        <span>Телефон</span>
                        <input class="user_phone" placeholder="Телефон" type="text" name="">
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Номер пайщика</span>
                                <input class="client_num" placeholder="Номер пайщика" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange ">
                            <div class="row ">
                                <span>Верифицирован</span>
                                <input class="is_verified" placeholder="Верифицирован" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Реферальная ссылка</span>
                                <input class="user_ref_link" placeholder="Реферальная ссылка" type="text" name="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <h1 class="coop_maps-h1 ib">Верификация пользователя:</h1>
            </div>

            <div class="row" id="verification_content">

                <div class="col-12" id="no_verification">
                    <div class="row">
                        <div class="col-12 text-center">
                            Для данного пользователя не найдены верификационные данные.
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Адрес PRIZM</span>
                                <input class="verification_prizm_address" placeholder="Адрес PRIZM" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Публичный ключ</span>
                                <div class="select-exchange w-100">
                                    <input class="verification_prizm_public_key" placeholder="Публичный ключ" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Адрес Slav</span>
                                <input class="verification_waves_address" placeholder="Адрес Slav" type="text" name="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Имя</span>
                                <input class="verification_name" placeholder="Имя" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange ">
                            <div class="row ">
                                <span>Фамилия</span>
                                <div class="select-exchange w-100">
                                    <input class="verification_surname" placeholder="Фамилия" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Отчество</span>
                                <input class="verification_last_name" placeholder="Отчество" type="text" name="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Серия и номер паспорта</span>
                                <input class="verification_passport_number" placeholder="____-______"  type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange ">
                            <div class="row ">
                                <span>Дата выдачи</span>
                                <div class="select-exchange w-100">
                                    <input class="verification_passport_date" placeholder="Дата выдачи" type="date" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Код подразделения</span>
                                <input class="verification_passport_code" placeholder="Код подразделения" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-12 input-exchange">
                            <div class="row">
                                <span>Кем выдан</span>
                                <input class="verification_passport_who" placeholder="Кем выдан" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-8 input-exchange ">
                            <div class="row ">
                                <span>Место жительства по прописке</span>
                                <div class="select-exchange w-100" style="padding-left: 0 !important;">
                                    <input class="verification_passport_address" placeholder="Место жительства по прописке" type="text" name="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 input-exchange">
                            <div class="row">
                                <span>Индекс</span>
                                <input class="verification_passport_index" placeholder="Индекс" type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-12 passport-photo">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <h1 class="coop_maps-h1 ib">Операции пользователя:</h1>
            </div>

            <div class="row" id="exchange_content">
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
                        <div class="col-4 text-center">
                            СТАТУС
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12">
                <h1 class="coop_maps-h1 ib">Статистика пользователя:</h1>
            </div>

            <div class="row stats" id="stats_content">
                <div class="table-title w-100">
                    <div class="row">

                        <div class="col-2 text-center stats_col" style="/*padding-left: 42px;*/">
                            <p>Имя клиента</p>
                        </div>
                        <div class="col-2 text-center stats_col">
                            Номер пайщика
                        </div>
                        <div class="col-2 text-center stats_col">
                            RUB сумма
                        </div>
                        <div class="col-1 text-center stats_col">
                            RUB обменов
                        </div>
                        <div class="col-2 text-center stats_col">
                            PRIZM сумма
                        </div>
                        <div class="col-1 text-center stats_col">
                            PRIZM обменов
                        </div>
                        <div class="col-1 text-center stats_col">
                            SLAV сумма
                        </div>
                        <div class="col-1 text-center stats_col">
                            SLAV обменов
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<script type="text/javascript">
    //По клику получить exchange_requests и stats для этого пользователя
    jQuery('.user-single .show_user_operations').click(function(){
         let el = jQuery(this);
         let modal = jQuery('#modal-container-54506521');
         let request_user_id = el.parents('.user-single').attr('data-user-id');

        var data = {
            request_user_id: request_user_id,
            get_user_operations: 'true',
            get_user_stats: 'true'
        };
        jQuery.post( window.location, data, function(response) {
            if (response) {
                let user_data = JSON.parse(response);
                if (response.exchange_content !== '') {
                    modal.find('.modal-content > #exchange_content .table-text').remove();
                    modal.find('.modal-content > #exchange_content').append(user_data.exchange_content);
                }
                if (response.stats_content !== '') {
                    modal.find('.modal-content > #stats_content .table-text').remove();
                    modal.find('.modal-content > #stats_content').append(user_data.stats_content);
                }
                if (response.verification_content !== '')
                {
                    if (user_data.verification_content !== 'false') {
                        modal.find('.modal-content > #verification_content').children().not('#no_verification').css('display', 'block');
                        modal.find('.modal-content > #verification_content #no_verification').css('display', 'none');
                        let verification_data = user_data.verification_content;

                        jQuery.each(verification_data, function (item) {
                            if (item !== 'passport_photos')
                                if (modal.find('.verification_' + item).length > 0)
                                    modal.find('.verification_' + item).val(verification_data[item]);
                        });
                        //Очищаем место для фотографий
                        modal.find('.passport-photo').children('.row').empty();

                        jQuery.each(verification_data['passport_photos'], function (photo) {
                            modal.find('.passport-photo').children('.row')
                                .append('<div class="col-lg-4">' +
                                    '<div class="row">' +
                                    '<img src="' + verification_data['passport_photos'][photo] + '">' +
                                    '</div>' +
                                    '</div>');
                            //console.log(verification_data['passport_photos'][photo]);
                        });
                        //jQuery('#modal-54506521').trigger('click');
                    }
                    else
                    {
                        modal.find('.modal-content > #verification_content').children().css('display', 'none');
                        modal.find('.modal-content > #verification_content #no_verification').css('display', 'block');
                    }
                        //console.log('Нет верификации для этого пользователя');
                }
                if (response.userdata_content !== '')
                {
                    let userdataContent = user_data.userdata_content;
                    let userdata_inputs = modal.find('#userdata_content input');
                    jQuery.each(userdataContent, function (item) {
                        if (modal.find('#userdata_content input.' + item).length > 0) {
                            if (item === 'is_verified') {
                                if (userdataContent[item] === '')
                                    modal.find('#userdata_content input.' + item).val('Нет');
                                else
                                    modal.find('#userdata_content input.' + item).val('Да');
                            }
                            else
                                modal.find('#userdata_content input.' + item).val(userdataContent[item]);
                        }
                    });
                }
                jQuery('#modal-54506521').trigger('click');

            }
        });
    });
</script>