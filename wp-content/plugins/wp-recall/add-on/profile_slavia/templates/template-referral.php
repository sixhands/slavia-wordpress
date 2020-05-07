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
                <div class="col-12 paid_sum text-left">
                    <div class="row">

                    </div>
                </div>

                <div class="col-12 text-left">
                    Невыплаченная сумма:
                </div>
                <div class="col-12 unpaid_sum text-left">
                    <div class="row">

                    </div>
                </div>

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
                //console.log(response);
                let sum_data = JSON.parse(response);
                String.prototype.stripSlashes = function(){
                    return this.replace(/\\(.)/mg, "$1");
                };

                let unpaid_sum = sum_data.unpaid_sum;
                let paid_sum = sum_data.paid_sum;

                let unpaid_sum_content = jQuery('.modal-content #stats_content > .unpaid_sum > .row');
                let paid_sum_content = jQuery('.modal-content #stats_content > .paid_sum > .row');

                unpaid_sum_content.empty();
                paid_sum_content.empty();

                for (var key in unpaid_sum) {
                    unpaid_sum_content.append(
                        '<div class="col-12">' + '<span>' + unpaid_sum[key] + ' ' + key.stripSlashes() + '</span></div>'
                    );
                }

                for (var key in paid_sum) {
                    console.log(key);
                    paid_sum_content.append(
                        '<div class="col-12">' + '<span>' + paid_sum[key] + ' ' + key.stripSlashes() + '</span></div>'
                    );
                }

                jQuery('#modal-54506521').trigger('click');
            }
        });
    });

    //Удалить операцию
    jQuery('.ref_unpaid .remove_operation, .ref_paid .remove_operation').click(function(){
        let date = jQuery(this).parent().siblings('.ref_date').text();
        let host_name = jQuery(this).parent().siblings('.host_name').text();
        let ref_name = jQuery(this).parent().siblings('.ref_name').text();
        let award_sum = jQuery(this).parent().siblings('.ref_sum').text();
        let split_sum = award_sum.split(' ');
        //Сумма - все перед первым пробелом
        let sum = split_sum.shift();
        //console.log("sum: ",sum);
        let currency = split_sum.join(' ');
        //console.log("currency: ", currency);
        //console.log('sum: ', 0);
        var data = {
            ref_remove: 'true',
            ref_data: {
                date: date,
                host_name: host_name,
                ref_name: ref_name,
                award_sum: sum,
                award_currency: currency
            }
        };
        // console.log("data:");
        // console.log(data);
        var el = jQuery(this);

        if (confirm("Удалить данную операцию?") == true) {
            jQuery.post(window.location, data, function (response) {
                console.log(response);
                if (response == 'true') {
                    el.parents('.table-text').remove();
                }
            });
        }
        else
            return;
    });
</script>