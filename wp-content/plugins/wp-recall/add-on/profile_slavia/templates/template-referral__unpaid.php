<div class="col-12">
    <div class="table-title w-100" style="height: 55px">
        <div class="row">
            <div class="col-2 text-left">
                Дата
            </div>
            <div class="col-2 text-left">
                Имя пригласившего
            </div>
            <div class="col-2 text-left">
                Имя приглашенного
            </div>
            <div class="col-2 text-left">
                Сумма вознаграждения
            </div>
            <div class="col-3 text-center">
                Статус
            </div>

        </div>
    </div>

    <?php if(isset($ref_data) && !empty($ref_data)): ?>
        <?php foreach($ref_data as $item): ?>
            <div class="table-text w-100">
                <div class="row">
                    <div class="col-2 text-left ref_date"><?=$item["date"] ?></div>

                    <div class="col-2 text-left host_name"><?=$item["host_name"] ?></div>

                    <div class="col-2 text-left ref_name"><?=$item["ref_name"] ?></div>

                    <div class="col-2 text-left ref_sum"><?php echo $item["award_sum"]. ' ' . $item["award_currency"] ?></div>

                    <div class="col-3 text-center">
                        <p>
                            <?php
                            switch ($item["status"]) {
                                case "processing":
                                    echo "В обработке";
                                    break;
                                case "paid":
                                    echo "Выплачено";
                                    break;
                            }
                            ?>
                        </p>
                        <?php if ($is_manager): ?>
                            <div class="btn-custom-one btn-ref">
                                Выплатить
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-1 text-left">
                        <a class="remove_operation">×</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<script type="text/javascript">
    jQuery('.ref_unpaid .btn-ref').click(function(){
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
            ref_approve: 'true',
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

        jQuery.post( window.location, data, function(response) {
            // console.log("response: ");
            // console.log(response);
            if (response == 'true') {
                el.parents('.table-text').remove();
            }
        });
    });


</script>
