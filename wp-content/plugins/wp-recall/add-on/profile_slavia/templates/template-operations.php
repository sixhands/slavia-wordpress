<div class="col-lg-12 col-md-12"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1 ib">Мои заявки</h1>
            <img src="/wp-content/uploads/2019/12/calendar.png" class="ib" style="float: right; margin-top: 20px;">
            <h1 class="coop_maps-h1 ib" style="float: right; font-size: 16px;">08.11.19</h1>

            <div class="row">
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
<!--                        <div class="col-2 text-center">-->
<!--                            ОСТАЛОСЬ-->
<!--                        </div>-->
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
                <?php if (isset($exchange_content) && !empty($exchange_content))
                    echo $exchange_content; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function successCallback(order)
    {
        console.log("success:");
        console.log(order);
    }
    function failureCallback(order)
    {
        console.log("failure:");
        console.log(order);
    }
</script>