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
            ?>

            <div class="ref-tab__content ref_unpaid row">
                <?php
                    echo rcl_get_include_template('template-referral__unpaid.php', __FILE__, array("ref_data" => $arg_to_pass["unpaid"], "is_manager" => $is_manager));
                ?>
            </div>

            <div class="ref-tab__content ref_paid row">
                <?php
                echo rcl_get_include_template('template-referral__paid.php', __FILE__, array("ref_data" => $arg_to_pass["paid"]));
                ?>
            </div>

            <div class="ref-tab__content ref_stats row">
            <?php
                echo rcl_get_include_template('template-referral__stats.php', __FILE__, array("ref_data" => $arg_to_pass["user_ids"]));
            ?>
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
                <div class="col-12 text-left">
                    Выплаченная сумма:
                </div>
                <div class="col-12 paid_sum text-left">1000</div>

                <div class="col-12 text-left">
                    Невыплаченная сумма:
                </div>
                <div class="col-12 unpaid_sum text-left">9000</div>

            </div>


        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('.ref_stats .show_ref_stats > img').click(function(){
        let el = jQuery(this);
        let modal = jQuery('#modal-container-54506521');
        let request_user_id = el.attr('data-user-id');

        var data = {
            ref_user_id: request_user_id,
            get_ref_stats: 'true'
        };

        jQuery.post( window.location, data, function(response) {
            if (response) {
                console.log(response);
                let user_data = JSON.parse(response);
                // if (response.exchange_content !== '') {
                //     modal.find('.modal-content > #exchange_content .table-text').remove();
                //     modal.find('.modal-content > #exchange_content').append(user_data.exchange_content);
                // }
                // if (response.stats_content !== '') {
                //     modal.find('.modal-content > #stats_content .table-text').remove();
                //     modal.find('.modal-content > #stats_content').append(user_data.stats_content);
                // }
                //
                // if (response.userdata_content !== '')
                // {
                //     let userdataContent = user_data.userdata_content;
                //     let userdata_inputs = modal.find('#userdata_content input');
                //     jQuery.each(userdataContent, function (item) {
                //         if (modal.find('#userdata_content input.' + item).length > 0) {
                //             if (item === 'is_verified') {
                //                 if (userdataContent[item] === '')
                //                     modal.find('#userdata_content input.' + item).val('Нет');
                //                 else
                //                     modal.find('#userdata_content input.' + item).val('Да');
                //             }
                //             else
                //                 modal.find('#userdata_content input.' + item).val(userdataContent[item]);
                //         }
                //     });
                // }
                jQuery('#modal-54506521').trigger('click');
            }
        });
        //jQuery('#modal-54506521').trigger('click');
    });


</script>