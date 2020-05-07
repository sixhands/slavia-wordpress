<div class="col-12">
    <div class="table-title w-100" style="height: 55px">
        <div class="row">
            <div class="col-2 text-left">
                Дата
            </div>
            <div class="col-3 text-left">
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

                    <div class="col-3 text-left host_name"><?=$item["host_name"] ?></div>

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
<!--                        <div class="btn-custom-one btn-zayavki" data-request_num="3" id="request_approve_6">-->
<!--                            Выплатить-->
<!--                        </div>-->
                    </div>

                    <!--                    <div class="col-2 text-center">-->
                    <!--                        <div class="btn-custom-one btn-zayavki" data-request_num="3" id="request_approve_6">-->
                    <!--                            Закрыть сделку-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                        <div class="col-1 text-left">-->
                    <!--                            <a class="remove_operation" data-user_id="6" data-request_num="3">?</a>-->
                    <!--                        </div>-->
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?php //echo do_shortcode("[userlist template='slavia' inpage='10' data='user_registered,profile_fields' orderby='user_registered' exclude='30']"); ?>
