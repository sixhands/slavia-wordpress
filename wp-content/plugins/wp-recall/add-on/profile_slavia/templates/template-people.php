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
                        <div class="col-2 text-left">
                            Рефереалов
                        </div>
                        <div class="col-2 text-left">

                        </div>

                    </div>
                </div>
                <?php echo do_shortcode("[userlist template='slavia' inpage='3' data='user_registered,profile_fields']"); ?>

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
    <div class="modal-dialog" role="document" style="max-width: 700px; ">
        <div class="modal-content text-left" style="padding: 20px;">
            <div class="row">
                <div class="col-10">
                    <h1 class="coop_maps-h1 ib">Операции пользователя:</h1>
                </div>

                <div class="col-2">
                    <button type="button" class="close ib " data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

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
<!--                <div class="table-text w-100">-->
<!--                    <div class="row">-->
<!--                        <div class="col-2 text-center">-->
<!--                            08.11.19-->
<!--                        </div>-->
<!--                        <div class="col-2 text-center">-->
<!--                            RUB-->
<!--                        </div>-->
<!--                        <div class="col-2 text-center">-->
<!--                            PRIZM-->
<!--                        </div>-->
<!--                        <div class="col-2 text-center">-->
<!--                            0.788 PZM-->
<!--                        </div>-->
<!--                        <div class="col-2 text-center">-->
<!--                            0.9188 PZM-->
<!--                        </div>-->
<!--                        <div class="col-2 text-center" style="font-size: 15px; color: #EF701B">-->
<!--                            Ожидает проверки-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
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
                jQuery('#modal-54506521').trigger('click');

            }
        });
    });
</script>