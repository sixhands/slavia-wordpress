<div class="col-lg-12 col-md-12"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1 ib">Реферальная программа</h1>

            <div class="referral-tabs row">
                <ul class="referral-tabs__items col-12">
                    <li id="ref_unpaid" class="referral-tabs__item btn-custom-one active">
                        <a class="referral-tabs__link">Не выплачено</a>
                    </li>

                    <li id="ref_paid" class="referral-tabs__item btn-custom-one">
                        <a class="referral-tabs__link">Выплачено</a>
                    </li>

                    <li id="ref_stats" class="referral-tabs__item btn-custom-one">
                        <a class="referral-tabs__link">Статистика</a>
                    </li>
                </ul>
            </div>

            <?php
                if ($is_manager)
                    $arg_to_pass = $ref_all;
                else
                    $arg_to_pass = $ref_cur_user;

                if (count($arg_to_pass["user_ids"]) != 1)
                    $data_user_id = 'all';
                else
                    $data_user_id = $arg_to_pass["user_ids"][0];
            ?>

            <div class="ref-tab__content ref_unpaid row" data-user_id="<?=$data_user_id ?>">
                <?php
                    echo rcl_get_include_template('template-referral__unpaid.php', __FILE__, array("ref_data" => $arg_to_pass["unpaid"], "is_manager" => $is_manager));
                ?>
            </div>

            <div class="ref-tab__content ref_paid row" data-user_id="<?=$data_user_id ?>">
                <?php
                echo rcl_get_include_template('template-referral__paid.php', __FILE__, array("ref_data" => $arg_to_pass["paid"]));
                ?>
            </div>

            <div class="ref-tab__content ref_stats row" data-user_id="<?=$data_user_id ?>">
            <?php
                echo rcl_get_include_template('template-referral__stats.php', __FILE__, array("ref_data" => $arg_to_pass["user_ids"]));
            ?>
            </div>
        </div>

        <div id="ref_list" class="coop_maps question-bg col-lg-12">
            <div class="row">
                <div class="col-12">
                    <h1 class="coop_maps-h1 ib">Мои рефералы</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-title w-100" style="height: 55px">
                        <div class="row">
                            <div class="col-4 text-left">
                                Имя приглашенного
                            </div>
                            <div class="col-3 text-left">
                                Дата регистрации
                            </div>

                            <div class="col-4 text-center show_ref_stats">
                                Статистика по рефералу
                            </div>

                        </div>
                    </div>
                    <?php if (isset($arg_to_pass['ref_ids']) && !empty($arg_to_pass['ref_ids'])): ?>
                        <?php foreach($arg_to_pass['ref_ids'] as $user_id): ?>
                            <?php $user_data = get_userdata($user_id); ?>
                            <?php if (!isset($user_data) || empty($user_data))
                                continue; ?>
                            <div class="table-text w-100">
                                <div class="row">
                                    <div class="col-4 text-left ref_name">
                                        <?=$user_data->display_name ?>
                                    </div>
                                    <div class="col-4 text-left">
                                        <?=$user_data->user_registered ?>
                                    </div>
                                    <div class="col-4 text-center show_ref_stats">
                                        <img src="/wp-content/uploads/2019/12/people_href.png" data-user-id="<?=$user_id ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<a style="display: none;" id="modal-54506521" href="#modal-container-54506521" role="button" class="" data-toggle="modal">
</a>

<div class="modal fade" id="modal-container-54506521" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ref-modal" role="document" style="max-width: 800px; ">
        <div class="modal-content text-left" style="padding: 40px;">
            <div class="row">
                <div class="col-10">
                    <h1 class="coop_maps-h1 ib">Статистика пользователя:</h1>
                </div>

                <div class="col-2">
                    <button type="button" class="close ib " data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

            </div>

            <div class="row ref_stats" id="stats_content">
                <div class="col-12 text-center" style="text-transform: uppercase">
                    Выплаченная сумма
                </div>
                <div class="col-12 paid_sum text-left">
                    <div class="table-title w-100">
                        <div class="row">
                            <div class="col-6 text-left ref_currency">
                                Валюта
                            </div>
                            <div class="col-6 text-left ref_sum">
                                Сумма
                            </div>
                        </div>
                    </div>
<!--                    <div class="table-text w-100">-->
<!--                        <div class="row">-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
                </div>

                <div class="col-12 text-center" style="text-transform: uppercase">
                    Невыплаченная сумма
                </div>
                <div class="col-12 unpaid_sum text-left">
                    <div class="table-title w-100">
                        <div class="row">
                            <div class="col-6 text-left">
                                Валюта
                            </div>
                            <div class="col-6 text-left">
                                Сумма
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
</div>

<a style="display: none;" id="modal-54506522" href="#modal-container-54506522" role="button" class="" data-toggle="modal">
</a>
<!--Модальное окно регистрации -->
<div class="modal fade" id="modal-container-54506522" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    jQuery('.ref_stats .show_ref_stats > img, #ref_list .show_ref_stats > img').click(function(){
        let el = jQuery(this);
        let modal = jQuery('#modal-container-54506521');
        let request_user_id = el.attr('data-user-id');

        var data = {
            ref_user_id: request_user_id,
            get_ref_stats: 'true'
        };

        if (el.parents('#ref_list').length > 0)
            data.is_ref_list = 'true';

        jQuery.post( window.location, data, function(response) {
            if (response) {
                //console.log(response);
                let sum_data = JSON.parse(response);
                String.prototype.stripSlashes = function(){
                    return this.replace(/\\(.)/mg, "$1");
                };

                let unpaid_sum = sum_data.unpaid_sum;
                let paid_sum = sum_data.paid_sum;

                let unpaid_sum_content = jQuery('.modal-content #stats_content > .unpaid_sum');
                let paid_sum_content = jQuery('.modal-content #stats_content > .paid_sum');

                // if (data.is_ref_list === 'true')
                // {
                //     unpaid_sum_content =
                //     paid_sum_content = jQuery('.modal-content #stats_content > .paid_sum');
                // }
                // else
                // {
                //     unpaid_sum_content = jQuery('.modal-content #stats_content > .unpaid_sum');
                //     paid_sum_content = jQuery('.modal-content #stats_content > .paid_sum');
                // }

                unpaid_sum_content.find('.table-title ~ .table-text').remove();
                paid_sum_content.find('.table-title ~ .table-text').remove();

                for (var key in unpaid_sum) {
                    unpaid_sum_content.append(
                    '<div class="table-text w-100"> ' +
                        '<div class="row"> ' +
                            '<div class="col-6 text-left">' +
                                '<span>' + key.stripSlashes() + '</span>' +
                            '</div>' +
                            '<div class="col-6 text-left">' +
                                '<span>' + (+unpaid_sum[key].toFixed(2)) + '</span>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                    );
                }

                for (var key in paid_sum) {
                    //console.log(key);
                    paid_sum_content.append(
                        '<div class="table-text w-100"> ' +
                            '<div class="row"> ' +
                                '<div class="col-6 text-left">' +
                                    '<span>' + key.stripSlashes() + '</span>' +
                                '</div>' +
                                '<div class="col-6 text-left">' +
                                    '<span>' + (+paid_sum[key].toFixed(2)) + '</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>'
                    );
                }

                jQuery('#modal-54506521').trigger('click');
            }
        });
    });

    //Сортировка по номеру пайщика
    jQuery('.ref-tab__content .table-title img.client_num_sort_icon').click(function(){
        let el = jQuery(this);
        let is_complete = el.hasClass('complete');

        let container_el = el.parents('.ref-tab__content');
        let container_class = '';
        let is_paid;
        if (container_el.hasClass('ref_unpaid')) {
            container_class = '.ref_unpaid';
            is_paid = false;
        }
        if (container_el.hasClass('ref_paid')) {
            container_class = '.ref_paid';
            is_paid = true;
        }

        if (!is_complete) {
            var data = {
                is_paid: is_paid,
                ref_sort: true,
                sort_field: 'client_num'
            };
        }
        else {
            var data = {
                is_paid: is_paid,
                ref_sort: false,
                sort_field: 'client_num'
            };
        }
        jQuery.post( window.location, data, function(response) {
            //console.log(response);
            if (response) {
                var ref_data = JSON.parse(response);
                var is_manager = ref_data[ref_data.length - 1].is_manager;

                //console.log(ref_data);
                //Очищаем поле для списка людей
                jQuery(container_class + ' .table-title ~ .table-text, ' + container_class + ' .table-title ~ .rcl-pager').remove();

                ref_data.forEach((item) => {
                    if (typeof item.is_manager !== 'undefined')
                        return;
                    //console.log(item);
                    let status;
                    switch (item.status) {
                        case "processing":
                            status = "В обработке";
                            break;
                        case "paid":
                            status = "Выплачено";
                            break;
                    }
                    jQuery(container_class + ' > div').append(
                        '<div class="table-text w-100" data-user-id="' + item.host_id + '">' +
                            '<div class="row">' +
                                '<div class="col-2 text-left ref_date">' + item.date + '</div>' +
                                '<div class="col-2 text-left host_name">' +
                                    (typeof item.host_client_num !== 'undefined' ? item.host_client_num : item.host_name) +
                                '</div>' +
                                '<div class="col-2 text-left ref_name">' + item.ref_name + '</div>' +
                                '<div class="col-2 text-left ref_sum">' + (item.award_sum.toFixed(2)) + ' ' + item.award_currency + '</div>' +
                                '<div class="col-3 text-center">' +
                                    '<p>' + status + '</p>' +
                                    ((is_manager && !is_paid) ? '<div class="btn-custom-one btn-ref">Выплатить</div>' : '') +
                                '</div>' +
                                '<div class="col-1 text-left">' +
                                    '<a class="remove_operation">×</a>' +
                                '</div>' +
                            '</div>' +
                        '</div>'
                    );
                });
                init_ref_buttons();

                //jQuery('.people_list').append(response);

                if (!is_complete)
                    el.addClass('complete');
                else
                    el.removeClass('complete');
            }
        });
    });

    jQuery(document).ready(function() {
        init_ref_buttons();
    });
</script>