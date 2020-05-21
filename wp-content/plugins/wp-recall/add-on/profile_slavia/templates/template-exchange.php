<?php
//exchange_address - это адрес SLAV
$exchange_address = get_field('exchange_address', 306);
$slav_text = get_field('slav_text', 306);
$asset_inputs = array();

for ($i = 1, $asset_input = get_field('asset_input_'.$i, 306);
     !empty($asset_input) && count($asset_input) > 0;
     $i++, $asset_input = get_field('asset_input_'.$i, 306)
    )
{
//    $log = new Rcl_Log();
//    $log->insert_log('asset_input: '.print_r($asset_input, true));
    if (!empty($asset_input['asset_name']) && !empty($asset_input['asset_requisites']) && !empty($asset_input['asset_rate_rubles']))
        $asset_inputs[] = $asset_input;
    //Условия для добавления prizm и slav в иной паевой взнос/целевой взнос
    elseif (strcasecmp($asset_input['asset_name'], 'prizm') == 0)
    {
        $asset_input['asset_requisites'] = 'PRIZM-AWTX-HDBX-ADDH-7SMM7';
        $asset_input['asset_rate_rubles'] = $prizm_price;

        $asset_inputs[] = $asset_input;
    }
    elseif (strcasecmp($asset_input['asset_name'], 'slav') == 0)
    {
        $asset_input['asset_requisites'] = $exchange_address;
        $asset_input['asset_rate_rubles'] = 1;

        $asset_inputs[] = $asset_input;
    }
}

$asset_outputs = array();

for ($i = 1, $asset_output = get_field('asset_output_'.$i, 306);
     !empty($asset_output) && count($asset_output) > 0;
     $i++, $asset_output = get_field('asset_output_'.$i, 306)
    )
{
    if (!empty($asset_output['asset_name']) && !empty($asset_output['asset_rate_rubles']))
        $asset_outputs[] = $asset_output;
    //Условия для добавления prizm и slav в иной паевой взнос/целевой взнос
    elseif (strcasecmp($asset_output['asset_name'], 'prizm') == 0)
    {
        $asset_output['asset_rate_rubles'] = $prizm_price;

        $asset_outputs[] = $asset_output;
    }
    elseif (strcasecmp($asset_output['asset_name'], 'slav') == 0)
    {
        $asset_output['asset_rate_rubles'] = 1;

        $asset_outputs[] = $asset_output;
    }
}

$deposit_types = array();

for ($i = 1, $deposit_type = get_field('deposit_type_'.$i, 306);
     $deposit_type !== null;
     $i++, $deposit_type = get_field('deposit_type_'.$i, 306)
    )
{
    if (!empty($deposit_type) )
        $deposit_types[] = $deposit_type;
}

?>
<div class="col-lg-12 d-none d-lg-block"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <form id="deposit_waves" class="coop_maps question-bg col-lg-12" action="" method="post" enctype="multipart/form-data" name="exchange">
            <h1 class="coop_maps-h1">Имущественный взнос SLAV</h1>

            <div class="col-12 pryamougolnik">
                <p>Внесите имущественный взнос на адрес</p>
                <h3><?php if (isset($exchange_address) && !empty($exchange_address))
                            echo $exchange_address; ?>
                </h3>
                <button type="submit" class="btn-custom-two  text-center">Отправить</button>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-4" style="margin-top:20px;">
                        <div class="row input-exchange" style="margin-top: 0px">
                            <span>Количество монет SLAV</span>
                            <input type="hidden" value="SLAV" name="exchange[input_currency]">
                            <input required placeholder="0" type="text" class="" name="exchange[input_sum]">
                        </div>

                        <div class="row">
                            <input class="btn-custom-one exchange-pd get-rubles text-center" type="submit" name="" value="Отправить">
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <?php if (isset($slav_text) && !empty($slav_text))
                            echo '<p class="exchange_deposit_text">'.$slav_text.'</p>'; ?>
                    </div>
                </div>
            </div>

        </form>


        <form id="get_prizm" class="coop_maps question-bg col-lg-12" action="" method="post" enctype="multipart/form-data" name="exchange">
            <h1 class="coop_maps-h1">Получить PRIZM</h1>

            <div class="col-12">
                <div class="row">
<!--                    <div class="col-lg-3 input-exchange select-custom">-->
<!--                        <div class="row">-->
<!--                            <span>&nbsp;</span>-->
<!--                            <select class="">-->
<!--                                <option>ОТПРАВИТЬ</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
                    <input type="hidden" value="RUB" name="exchange[input_currency]">
                    <input type="hidden" value="PRIZM" name="exchange[output_currency]">

                    <div class="col-lg-6 input-exchange  input-custom-rub">
                        <div class="row ">
                            <span class="">Количество</span> <!--select-exchange-->
                            <div class="w-100"> <!--select-exchange -->
                                <input required class="rubles_to_prizm" placeholder="0" type="text" name="exchange[input_sum]">
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-6 input-exchange ">-->
<!--                        <div class="row ">-->
<!--                            <span class="select-exchange">Выбрать банк</span>-->
<!--                            <div class="select-exchange w-100">-->
<!--                                <select required id="bank_list_desktop" class="rubles_to_prizm" name="exchange[bank]">-->
<!--                                                        <option>Название выбранного банка</option>-->
<!--                                    --><?php //if (isset($banks) && !empty($banks)): ?>
<!--                                        --><?php //foreach ($banks as $key => $value): ?>
<!--                                            <option value="--><?//=$key?><!--">--><?//=$value['name']?><!--</option>-->
<!--                                        --><?php //endforeach;?>
<!--                                    --><?php //endif; ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="col-lg-6 input-exchange orange-input input-custom-prizm">
                        <div class="row">
                            <span>Вы получите</span>
                            <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
<!--                    <div class="col-lg-6 input-exchange">-->
<!--                        <div class="row">-->
<!--                            <input required type="text" name="get_prizm[card_num]" class="input-pd-right" placeholder="Номер банковской карты">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-lg-6 input-exchange">-->
<!--                        <div class="row">-->
<!--                            <input required type="text" name="get_prizm[card_name]" placeholder="Имя получателя (как на карте)">-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="col-12">
                        <div class="row">
                            <input class="btn-custom-one exchange-pd get-prizm text-center" type="submit" name="" value="Отправить">
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <form id="get_waves" class="coop_maps question-bg col-lg-12" action="" method="post" enctype="multipart/form-data" name="exchange">
            <h1 class="coop_maps-h1">Получить Slav</h1>

            <input type="hidden" value="RUB" name="exchange[input_currency]">
            <input type="hidden" value="SLAV" name="exchange[output_currency]">

            <div class="col-12">
                <div class="row">
<!--                    <div class="col-lg-3 input-exchange select-custom">-->
<!--                        <div class="row">-->
<!--                            <span>&nbsp;</span>-->
<!--                            <select class="">-->
<!--                                <option>ОТПРАВИТЬ</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="col-lg-6 input-exchange  input-custom-rub">
                        <div class="row ">
                            <span class="">Количество</span>
                            <div class="w-100">
                                <input required class="rubles_to_waves" placeholder="0" type="text" name="exchange[input_sum]">
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-6 input-exchange ">-->
<!--                        <div class="row ">-->
<!--                            <span class="select-exchange">Выбрать банк</span>-->
<!--                            <div class="select-exchange w-100">-->
<!--                                <select required id="bank_list_desktop" class="rubles_to_waves" name="exchange[bank]">-->
<!--                                                                        <option>Название выбранного банка</option>-->
<!--                                    --><?php //if (isset($banks) && !empty($banks)): ?>
<!--                                        --><?php //foreach ($banks as $key => $value): ?>
<!--                                            <option value="--><?//=$key?><!--">--><?//=$value['name']?><!--</option>-->
<!--                                        --><?php //endforeach;?>
<!--                                    --><?php //endif; ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="col-lg-6 input-exchange orange-input input-custom-waws">
                        <div class="row">
                            <span>Вы получите</span>
                            <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">

<!--                    <div class="col-lg-6 input-exchange">-->
<!--                        <div class="row">-->
<!--                            <input required type="text" name="get_waves[card_num]" class="input-pd-right" placeholder="Номер банковской карты">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-lg-6 input-exchange">-->
<!--                        <div class="row">-->
<!--                            <input required type="text" name="get_waves[card_name]" placeholder="Имя получателя (как на карте)">-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="col-12">
                        <div class="row">
                            <input class="btn-custom-one exchange-pd get-waves text-center" type="submit" name="" value="Отправить">
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <form id="get_ruble_prizm" class="coop_maps question-bg col-lg-12" action="" method="post" enctype="multipart/form-data" name="exchange">
            <h1 class="coop_maps-h1">Получить Рубль</h1>

            <input type="hidden" value="PRIZM" name="exchange[input_currency]">
            <input type="hidden" value="RUB" name="exchange[output_currency]">

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-3 input-exchange">
                        <div class="row">
                            <span>Количество монет PRIZM</span>
                            <input required placeholder="0" type="text" class="prizm_to_rubles" name="exchange[input_sum]">
                        </div>
                    </div>
                    <div class="col-lg-6 input-exchange ">
                        <div class="row ">
                            <span class="select-exchange">Выбрать банк</span>
                            <div class="select-exchange w-100">
                                <select required id="bank_list_desktop" class="prizm_to_rubles" name="exchange[bank]">
                                    <!--                                    <option>Название выбранного банка</option>-->
                                    <?php if (isset($banks) && !empty($banks)): ?>
                                        <?php foreach ($banks as $key => $value): ?>
                                            <option value="<?=$key?>"><?=$value['name']?></option>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 input-exchange orange-input input-custom-rub">
                        <div class="row">
                            <span>Вы получите</span>
                            <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6 input-exchange">
                        <div class="row">
                            <input required type="text" name="exchange[card_num]" class="input-pd-right" placeholder="Номер банковской карты для получения">
                        </div>
                    </div>
                    <div class="col-6 input-exchange">
                        <div class="row">
                            <input required type="text" name="exchange[card_name]" placeholder="Имя получателя (как на карте)">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <input class="btn-custom-one exchange-pd get-rubles text-center" type="submit" name="" value="Отправить">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form id="get_ruble_waves" class="coop_maps question-bg col-lg-12" action="" method="post" enctype="multipart/form-data" name="exchange">
            <h1 class="coop_maps-h1">Получить Рубль</h1>

            <input type="hidden" value="SLAV" name="exchange[input_currency]">
            <input type="hidden" value="RUB" name="exchange[output_currency]">

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-3 input-exchange">
                        <div class="row">
                            <span>Количество монет SLAV</span>
                            <input required placeholder="0" type="text" class="waves_to_rubles" name="exchange[input_sum]">
                        </div>
                    </div>
                    <div class="col-lg-6 input-exchange ">
                        <div class="row ">
                            <span class="select-exchange">Выбрать банк</span>
                            <div class="select-exchange w-100">
                                <select required id="bank_list_desktop" class="waves_to_rubles" name="exchange[bank]">
                                    <!--                                    <option>Название выбранного банка</option>-->
                                    <?php if (isset($banks) && !empty($banks)): ?>
                                        <?php foreach ($banks as $key => $value): ?>
                                            <option value="<?=$key?>"><?=$value['name']?></option>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 input-exchange orange-input input-custom-rub">
                        <div class="row">
                            <span>Вы получите</span>
                            <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6 input-exchange">
                        <div class="row">
                            <input required type="text" name="exchange[card_num]" class="input-pd-right" placeholder="Номер банковской карты для получения">
                        </div>
                    </div>
                    <div class="col-6 input-exchange">
                        <div class="row">
                            <input required type="text" name="exchange[card_name]" placeholder="Имя получателя (как на карте)">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <input class="btn-custom-one exchange-pd get-rubles text-center" type="submit" name="" value="Отправить">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--ADDITIONAL PAYMENT OPTIONS ***************************************************************** -->

        <form id="other_payments" class="coop_maps question-bg col-lg-12 other_payments" action="" method="post" enctype="multipart/form-data" name="exchange">
            <h1 class="coop_maps-h1">Иной паевой взнос</h1>

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-7 input-exchange">
                        <div class="row">
                            <div class="select-exchange w-100">
<!--                                <span class="select-exchange">Вид вносимого имущества</span>-->
                                <select required class="other_payments input_currency" name="exchange[input_currency]">
                                    <option disabled selected>Вид вносимого имущества</option>
                                    <?php if (isset($asset_inputs) && !empty($asset_inputs)): ?>
                                        <?php foreach ($asset_inputs as $asset_input): ?>
                                            <option data-rate="<?=$asset_input['asset_rate_rubles']?>" data-requisites="<?=$asset_input['asset_requisites']?>" value="<?=htmlspecialchars($asset_input['asset_name'], ENT_QUOTES, 'UTF-8')?>"><?=$asset_input['asset_name']?></option>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 input-exchange">
                        <div class="row">
                            <span>Количество</span>
                            <input required placeholder="0" type="text" class="other_payments_input" name="exchange[input_sum]">
                        </div>
                    </div>

                    <div class="col-lg-7 input-exchange">
                        <div class="row">
                            <div class="select-exchange w-100">
<!--                                <span class="select-exchange">Вид желаемого имущества</span>-->
                                <select class="other_payments output_currency" name="exchange[output_currency]">
                                    <option disabled selected>Вид желаемого имущества</option>
                                    <?php if (isset($asset_outputs) && !empty($asset_outputs)): ?>
                                        <?php foreach ($asset_outputs as $asset_output): ?>
                                            <option data-rate="<?=$asset_output['asset_rate_rubles']?>" value="<?=htmlspecialchars($asset_output['asset_name'], ENT_QUOTES, 'UTF-8')?>"><?=$asset_output['asset_name']?></option>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 input-exchange orange-input">
                        <div class="row">
                            <span>Вы получите</span>
                            <input placeholder="0" class="exp_custom" type="text" name="exchange[output_sum]">
                        </div>
                    </div>

                    <div id="other_payments_bank" class="col-lg-7 input-exchange">
                        <div class="row ">
                            <span class="select-exchange">Выбрать банк</span>
                            <div class="select-exchange w-100">
                                <select id="bank_list_desktop" class="other_payments" name="exchange[bank]">
                                    <option disabled selected="selected">Выбрать банк</option>
                                    <?php if (isset($banks) && !empty($banks)): ?>
                                        <?php foreach ($banks as $key => $value): ?>
                                            <option value="<?=$key?>"><?=$value['name']?></option>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="other_payments_card_num" class="col-5 input-exchange">
                        <div class="row">
                            <input type="text" name="exchange[card_num]" placeholder="Номер банковской карты для получения">
                        </div>
                    </div>
                    <div id="other_payments_card_name" class="col-8 input-exchange">
                        <div class="row">
                            <input type="text" name="exchange[card_name]" placeholder="Имя получателя (как на карте)">
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <input class="btn-custom-one exchange-pd get-rubles text-center" type="submit" name="" value="Отправить">
                    </div>
                    <div class="col-8 input-exchange">
                        <div class="row">
                            <div class="select-exchange w-100" style="margin-top: 30px">
    <!--                            <span class="select-exchange">Наши реквизиты</span>-->
                                <select required class="other_payments requisites" name="exchange[requisites]">
                                    <option disabled selected>Наши реквизиты</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

        <form id="other_deposit" class="coop_maps question-bg col-lg-12 other_deposit" action="" method="post" enctype="multipart/form-data" name="exchange">
            <h1 class="coop_maps-h1">Целевой взнос</h1>

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 input-exchange" style="margin-top: 20px">
                        <div class="row">
                            <span>Количество</span>
                            <input required placeholder="0" type="text" class="other_deposit" name="exchange[input_sum]">
                        </div>
                    </div>
                    <div class="col-lg-6 input-exchange" style="margin-top: 44px;">
                        <div class="row">
                            <div class="select-exchange w-100">
                                <!--                                <span class="select-exchange">Вид вносимого имущества</span>-->
                                <select required class="other_deposit input_currency" name="exchange[input_currency]">
                                    <option disabled selected>Вид вносимого имущества</option>
                                    <?php if (isset($asset_inputs) && !empty($asset_inputs)): ?>
                                        <?php foreach ($asset_inputs as $asset_input): ?>
                                            <option data-rate="<?=$asset_input['asset_rate_rubles']?>" data-requisites="<?=$asset_input['asset_requisites']?>" value="<?=htmlspecialchars($asset_input['asset_name'], ENT_QUOTES, 'UTF-8')?>"><?=$asset_input['asset_name']?></option>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 input-exchange" style="margin-top: 20px;">
                        <div class="row">
                            <div class="select-exchange w-100" style="margin-top: 0px; padding-left: 0; padding-right: 0">
                                <select required class="other_deposit deposit_type" name="exchange[deposit_type]">
                                    <option disabled selected>Вид целевой программы</option>
                                    <?php if (isset($deposit_types) && !empty($deposit_types)): ?>
                                        <?php foreach ($deposit_types as $deposit_type): ?>
                                            <option value="<?=$deposit_type?>"><?=$deposit_type?></option>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 input-exchange" style="margin-top: 20px;">
                        <div class="row">
                            <div class="select-exchange w-100">
                                <!--                            <span class="select-exchange">Наши реквизиты</span>-->
                                <select required class="other_deposit requisites" name="exchange[requisites]">
                                    <option disabled selected>Наши реквизиты</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <input class="btn-custom-one exchange-pd get-rubles text-center" type="submit" name="" value="Отправить">
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>


<!-- Тело главной страницы mobile -->
<div class="col-md-12 d-lg-none"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12 ex-mob-pd" style="">
            <div class="click_ex" id="one-ex">
                <div class="ex-header">
                    <h1 class="coop_maps-h1 ib">Имущественный взнос SLAV</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                </div>

                <form class="tab-ex" action="" method="post" enctype="multipart/form-data" name="exchange_mob">
                    <div class="col-12 pryamougolnik">
                        <p>Для получения рубля необходимо отправить монеты на следующий адрес:</p>
                        <h3>PRIZM-AWTX-HDBX-ADDH-7SMM7</h3>
                        <button class="btn-custom-two  text-center">Отправить</button>
                    </div>
                    <div class="col-lg-12">
                        <?php if (isset($slav_text) && !empty($slav_text))
                            echo '<p class="exchange_deposit_text">'.$slav_text.'</p>'; ?>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-12" style="margin-top:20px;">
                                <div class="row input-exchange" style="margin-top: 0px">
                                    <span>Количество монет SLAV</span>

                                    <input type="hidden" value="SLAV" name="exchange[input_currency]">

                                    <input required placeholder="0" type="text" class="" name="exchange[input_sum]">
                                </div>

                                <div class="row">
                                    <input class="btn-custom-one exchange-pd get-rubles text-center" type="submit" name="" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
            <div class="click_ex" id="two-ex">
                <div class="ex-header">
                    <h1 class="coop_maps-h1 ib">Получить PRIZM</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                </div>
                <form class="tab-ex" action="" method="post" enctype="multipart/form-data" name="exchange_mob">
                    <div class="col-12">
                        <div class="row">
<!--                            <div class="col-lg-3 input-exchange select-custom">-->
<!--                                <div class="row">-->
<!--                                    <span>&nbsp;</span>-->
<!--                                    <select class="">-->
<!--                                        <option>ОТПРАВИТЬ</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="col-lg-6 input-exchange  input-custom-rub">
                                <div class="row ">
                                    <span class="select-exchange">Количество</span>

                                    <input type="hidden" value="RUB" name="exchange[input_currency]">
                                    <input type="hidden" value="PRIZM" name="exchange[output_currency]">

                                    <div class="select-exchange w-100">
                                        <input required class="rubles_to_prizm" placeholder="0" type="text" name="exchange[input_sum]">
                                    </div>
                                </div>
                            </div>

<!--                            <div class="col-lg-6 input-exchange ">-->
<!--                                <div class="row ">-->
<!--                                    <span class="select-exchange">Выбрать банк</span>-->
<!--                                    <div class="select-exchange w-100">-->
<!--                                        <select required id="bank_list_mobile" class="rubles_to_prizm" name="exchange[bank]">-->
<!--                                                                                        <option>Название выбранного банка</option>-->
<!--                                            --><?php //if (isset($banks) && !empty($banks)): ?>
<!--                                                --><?php //foreach ($banks as $key => $value): ?>
<!--                                                    <option value="--><?//=$key?><!--">--><?//=$value['name']?><!--</option>-->
<!--                                                --><?php //endforeach;?>
<!--                                            --><?php //endif; ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-lg-6 input-exchange orange-input input-custom-prizm">
                                <div class="row">
                                    <span>Вы получите</span>
                                    <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">

<!--                            <div class="col-lg-6 input-exchange">-->
<!--                                <div class="row">-->
<!--                                    <input required type="text" name="get_prizm[card_num]" class="input-pd-right" placeholder="Номер банковской карты">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-6 input-exchange">-->
<!--                                <div class="row">-->
<!--                                    <input required type="text" name="get_prizm[card_name]" placeholder="Имя получателя (как на карте)">-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-12">
                                <div class="row">
                                    <input class="btn-custom-one exchange-pd get-prizm text-center" type="submit" name="" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
            <div class="click_ex" id="three-ex">
                <div class="ex-header">
                    <h1 class="coop_maps-h1 ib">Получить Slav</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                </div>
                <form class="tab-ex" action="" method="post" enctype="multipart/form-data" name="exchange_mob">
                    <div class="col-12">
                        <div class="row">
<!--                            <div class="col-lg-3 input-exchange select-custom">-->
<!--                                <div class="row">-->
<!--                                    <span>&nbsp;</span>-->
<!--                                    <select class="">-->
<!--                                        <option>ОТПРАВИТЬ</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="col-lg-6 input-exchange  input-custom-rub">
                                <div class="row ">
                                    <span class="select-exchange">Количество</span>

                                    <input type="hidden" value="RUB" name="exchange[input_currency]">
                                    <input type="hidden" value="SLAV" name="exchange[output_currency]">

                                    <div class="select-exchange w-100">
                                        <input required class="rubles_to_waves" placeholder="0" type="text" name="exchange[input_sum]">
                                    </div>
                                </div>
                            </div>

<!--                            <div class="col-lg-6 input-exchange ">-->
<!--                                <div class="row ">-->
<!--                                    <span class="select-exchange">Выбрать банк</span>-->
<!--                                    <div class="select-exchange w-100">-->
<!--                                        <select required id="bank_list_mobile" class="rubles_to_waves" name="exchange[bank]">-->
<!--                                                                  -->
<!--                                            --><?php //if (isset($banks) && !empty($banks)): ?>
<!--                                                --><?php //foreach ($banks as $key => $value): ?>
<!--                                                    <option value="--><?//=$key?><!--">--><?//=$value['name']?><!--</option>-->
<!--                                                --><?php //endforeach;?>
<!--                                            --><?php //endif; ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-lg-6 input-exchange orange-input input-custom-waws">
                                <div class="row">
                                    <span>Вы получите</span>
                                    <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">

<!--                            <div class="col-lg-6 input-exchange">-->
<!--                                <div class="row">-->
<!--                                    <input required type="text" name="get_waves[card_num]" class="input-pd-right" placeholder="Номер банковской карты">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-lg-6 input-exchange">-->
<!--                                <div class="row">-->
<!--                                    <input required type="text" name="get_waves[card_name]" placeholder="Имя получателя (как на карте)">-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-12">
                                <div class="row">
                                    <input class="btn-custom-one get-waves exchange-pd text-center" type="submit" name="" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
            <div class="click_ex" id="four-ex">
                <div class="ex-header">
                    <h1 class="coop_maps-h1 ib">Получить рубль (внести PRIZM)</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                </div>
                <form class="tab-ex" action="" method="post" enctype="multipart/form-data" name="get_ruble_prizm">
                    <div class="col-12">
                        <div class="row">
                            <!--                            <div class="col-lg-3 input-exchange select-custom">-->
                            <!--                                <div class="row">-->
                            <!--                                    <span>&nbsp;</span>-->
                            <!--                                    <select class="">-->
                            <!--                                        <option>ОТПРАВИТЬ</option>-->
                            <!--                                    </select>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <div class="col-lg-3 input-exchange  input-custom-prizm">
                                <div class="row ">
                                    <span class="select-exchange">Количество</span>

                                    <input type="hidden" value="PRIZM" name="exchange[input_currency]">
                                    <input type="hidden" value="RUB" name="exchange[output_currency]">

                                    <div class="select-exchange w-100">
                                        <input required class="prizm_to_rubles" placeholder="0" type="text" name="exchange[input_sum]">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 input-exchange ">
                                <div class="row ">
                                    <span class="select-exchange">Выбрать банк</span>
                                    <div class="select-exchange w-100">
                                        <select required id="bank_list_mobile" class="prizm_to_rubles" name="exchange[bank]">
                                            <!--                                            <option>Название выбранного банка</option>-->
                                            <?php if (isset($banks) && !empty($banks)): ?>
                                                <?php foreach ($banks as $key => $value): ?>
                                                    <option value="<?=$key?>"><?=$value['name']?></option>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 input-exchange orange-input input-custom-rub">
                                <div class="row">
                                    <span>Вы получите</span>
                                    <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">

                            <div class="col-lg-6 input-exchange">
                                <div class="row">
                                    <input required type="text" name="exchange[card_num]" class="input-pd-right" placeholder="Номер банковской карты">
                                </div>
                            </div>
                            <div class="col-lg-6 input-exchange">
                                <div class="row">
                                    <input required type="text" name="exchange[card_name]" placeholder="Имя получателя (как на карте)">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <input class="btn-custom-one exchange-pd get-prizm text-center" type="submit" name="" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
            <div class="click_ex" id="five-ex">
                <div class="ex-header">
                    <h1 class="coop_maps-h1 ib">Получить рубль (внести SLAV)</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                </div>
                <form class="tab-ex" action="" method="post" enctype="multipart/form-data" name="get_ruble_waves">
                    <div class="col-12">
                        <div class="row">
                            <!--                            <div class="col-lg-3 input-exchange select-custom">-->
                            <!--                                <div class="row">-->
                            <!--                                    <span>&nbsp;</span>-->
                            <!--                                    <select class="">-->
                            <!--                                        <option>ОТПРАВИТЬ</option>-->
                            <!--                                    </select>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <div class="col-lg-3 input-exchange  input-custom-waws">
                                <div class="row ">
                                    <span class="select-exchange">Количество</span>

                                    <input type="hidden" value="SLAV" name="exchange[input_currency]">
                                    <input type="hidden" value="RUB" name="exchange[output_currency]">

                                    <div class="select-exchange w-100">
                                        <input required class="waves_to_rubles" placeholder="0" type="text" name="exchange[input_sum]">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 input-exchange ">
                                <div class="row ">
                                    <span class="select-exchange">Выбрать банк</span>
                                    <div class="select-exchange w-100">
                                        <select required id="bank_list_mobile" class="waves_to_rubles" name="exchange[bank]">
                                            <!--                                            <option>Название выбранного банка</option>-->
                                            <?php if (isset($banks) && !empty($banks)): ?>
                                                <?php foreach ($banks as $key => $value): ?>
                                                    <option value="<?=$key?>"><?=$value['name']?></option>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 input-exchange orange-input input-custom-rub">
                                <div class="row">
                                    <span>Вы получите</span>
                                    <input required placeholder="0" id="exp" type="text" name="exchange[output_sum]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">

                            <div class="col-lg-6 input-exchange">
                                <div class="row">
                                    <input required type="text" name="exchange[card_num]" class="input-pd-right" placeholder="Номер банковской карты">
                                </div>
                            </div>
                            <div class="col-lg-6 input-exchange">
                                <div class="row">
                                    <input required type="text" name="exchange[card_name]" placeholder="Имя получателя (как на карте)">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <input class="btn-custom-one exchange-pd get-prizm text-center" type="submit" name="" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
            <div class="click_ex" id="six-ex">
                <div class="ex-header">
                    <h1 class="coop_maps-h1 ib">Иной паевой взнос</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                </div>
                <form class="tab-ex other_payments" action="" method="post" enctype="multipart/form-data" name="other_payments">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-12 input-exchange">
                                <div class="row">
                                    <div class="select-exchange w-100">
                                        <select required class="other_payments input_currency" name="exchange[input_currency]">
                                            <option disabled selected>Вид вносимого имущества</option>
                                            <?php if (isset($asset_inputs) && !empty($asset_inputs)): ?>
                                                <?php foreach ($asset_inputs as $asset_input): ?>
                                                    <option data-rate="<?=$asset_input['asset_rate_rubles']?>" data-requisites="<?=$asset_input['asset_requisites']?>" value="<?=$asset_input['asset_name']?>"><?=$asset_input['asset_name']?></option>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 input-exchange">
                                <div class="row">
                                    <span class="select-exchange">Количество</span>

                                    <div class="select-exchange w-100">
                                        <input required class="other_payments_input" placeholder="0" type="text" name="exchange[input_sum]">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 input-exchange">
                                <div class="row">
                                    <div class="select-exchange w-100">
                                        <!--                                <span class="select-exchange">Вид желаемого имущества</span>-->
                                        <select class="other_payments output_currency" name="exchange[output_currency]">
                                            <option disabled selected>Вид желаемого имущества</option>
                                            <?php if (isset($asset_outputs) && !empty($asset_outputs)): ?>
                                                <?php foreach ($asset_outputs as $asset_output): ?>
                                                    <option data-rate="<?=$asset_output['asset_rate_rubles']?>" value="<?=$asset_output['asset_name']?>"><?=$asset_output['asset_name']?></option>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 input-exchange orange-input">
                                <div class="row">
                                    <span>Вы получите</span>
                                    <input placeholder="0" class="exp_custom" type="text" name="exchange[output_sum]">
                                </div>
                            </div>
                            <div class="col-12 input-exchange">
                                <div class="row">
                                    <div class="select-exchange w-100" style="margin-top: 30px">
                                        <!--                            <span class="select-exchange">Наши реквизиты</span>-->
                                        <select required class="other_payments requisites" name="exchange[requisites]">
                                            <option disabled selected>Наши реквизиты</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="other_payments_bank" class="col-12 input-exchange">
                                <div class="row ">
                                    <span class="select-exchange">Выбрать банк</span>
                                    <div class="select-exchange w-100">
                                        <select id="bank_list_mobile" class="other_payments" name="exchange[bank]">
                                            <option disabled selected="selected">Выбрать банк</option>
                                            <?php if (isset($banks) && !empty($banks)): ?>
                                                <?php foreach ($banks as $key => $value): ?>
                                                    <option value="<?=$key?>"><?=$value['name']?></option>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="other_payments_card_num" class="col-12 input-exchange">
                                <div class="row">
                                    <input type="text" name="exchange[card_num]" placeholder="Номер банковской карты">
                                </div>
                            </div>
                            <div id="other_payments_card_name" class="col-12 input-exchange">
                                <div class="row">
                                    <input type="text" name="exchange[card_name]" placeholder="Имя получателя (как на карте)">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <input class="btn-custom-one exchange-pd text-center" type="submit" name="" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="coop_maps question-bg col-lg-12 ex-mob-pd">
            <div class="click_ex" id="seven-ex">
                <div class="ex-header">
                    <h1 class="coop_maps-h1 ib">Целевой взнос</h1>
                    <img src="/wp-content/uploads/2019/12/close.png" class="close_ex ib">
                </div>
                <form class="tab-ex other_deposit" action="" method="post" enctype="multipart/form-data" name="other_deposit">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-12 input-exchange">
                                <div class="row">
                                    <div class="select-exchange w-100">
                                        <select required class="other_deposit input_currency" name="exchange[input_currency]">
                                            <option disabled selected>Вид вносимого имущества</option>
                                            <?php if (isset($asset_inputs) && !empty($asset_inputs)): ?>
                                                <?php foreach ($asset_inputs as $asset_input): ?>
                                                    <option data-rate="<?=$asset_input['asset_rate_rubles']?>" data-requisites="<?=$asset_input['asset_requisites']?>" value="<?=$asset_input['asset_name']?>"><?=$asset_input['asset_name']?></option>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 input-exchange">
                                <div class="row">
                                    <span class="select-exchange">Количество</span>

                                    <div class="select-exchange w-100">
                                        <input required class="other_deposit" placeholder="0" type="text" name="exchange[input_sum]">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 input-exchange">
                                <div class="row">
                                    <div class="select-exchange w-100">
                                        <!--                                <span class="select-exchange">Вид желаемого имущества</span>-->
                                        <select required class="other_deposit deposit_type" name="exchange[deposit_type]">
                                            <option disabled selected>Вид целевой программы</option>
                                            <?php if (isset($deposit_types) && !empty($deposit_types)): ?>
                                                <?php foreach ($deposit_types as $deposit_type): ?>
                                                    <option value="<?=$deposit_type?>"><?=$deposit_type?></option>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 input-exchange">
                                <div class="row">
                                    <div class="select-exchange w-100" style="margin-top: 30px">
                                        <!--                            <span class="select-exchange">Наши реквизиты</span>-->
                                        <select required class="other_deposit requisites" name="exchange[requisites]">
                                            <option disabled selected>Наши реквизиты</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <input class="btn-custom-one exchange-pd text-center" type="submit" name="" value="Отправить">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function calc_exchange(input_value, rate, bank_rate, is_reverse = false, is_commision = true)
    {
        let result;
        if (is_reverse)
            result = (input_value / rate);
        else
            result = (input_value * rate);

        if (bank_rate !== false)
            result *= (1 - (bank_rate / 100) );
        //Округляем до 2 знаков после запятой
        result = Math.round(result * 100) / 100;
        return result;
    }

    //Калькулятор
    function keyup_calc(/*event, */el, crypto_price, active_bank_val = false)//, is_backspace = false)
    {
        // var code = (event.keyCode ? event.keyCode : event.which);
        // var is_symbol = (!is_backspace && (
        //     ( (code >= 48 && code <= 57) || (code == 46) ) //numbers || period
        //     || !(code == 46 && jQuery(this).val().indexOf('.') != -1) //уже есть точка
        // ) );
        // var is_backspace_pressed = (is_backspace && code == 8);

        var input_amount;

        input_amount = el.val();
        // //Если backspace - удаляем символ
        // if (is_backspace_pressed)
        // {
        //     input_amount = el.val().slice(0, -1);
        // }
        // else {
        //     if (is_symbol)
        //         input_amount = el.val() + String.fromCharCode(code);
        // }

        if (/*(is_backspace_pressed || is_symbol) && */input_amount !== null)
        {
            if (input_amount === '')
                input_amount = 0;
            else
                input_amount = parseFloat(input_amount);
            var is_commission = false;
            var output_el;
            var is_reverse;
            //Если получение рублей, то комиссия
            if (el.hasClass("prizm_to_rubles") || el.parents(".input-exchange").siblings().find(".prizm_to_rubles").length > 0) {
                is_commission = true;
                //Если ввели количество рублей
                if (el.attr("id") === "exp")
                {
                    is_reverse = true;
                    output_el = el.parents(".input-exchange").siblings().find("input.prizm_to_rubles");
                }
                else
                    output_el = el.parents(".input-exchange").siblings(".orange-input").find("input#exp");
            }

            if (el.hasClass("waves_to_rubles") || el.parents(".input-exchange").siblings().find(".waves_to_rubles").length > 0) {
                is_commission = true;
                //Если ввели количество рублей
                if (el.attr("id") === "exp")
                {
                    is_reverse = true;
                    output_el = el.parents(".input-exchange").siblings().find("input.waves_to_rubles");
                }
                else
                    output_el = el.parents(".input-exchange").siblings(".orange-input").find("input#exp");
            }

            //Если рубли в призму, то считаем наоборот и без комиссии
            if (el.hasClass("rubles_to_prizm") || el.parents(".input-exchange").siblings().find(".rubles_to_prizm").length > 0) {
                //Рубли в призму, ввод призмы
                if (el.attr("id") === "exp")
                {
                    is_reverse = false;
                    output_el = el.parents(".input-exchange").siblings().find("input.rubles_to_prizm");
                }
                //Рубли в призму, ввод рублей
                else {
                    is_reverse = true;
                    output_el = el.parents(".input-exchange").siblings(".orange-input").find("input#exp");
                }
            }

            else
            {
                if (el.hasClass("rubles_to_waves") || el.parents(".input-exchange").siblings().find(".rubles_to_waves").length > 0) {
                    //Рубли в waves, ввод waves
                    if (el.attr("id") === "exp")
                    {
                        is_reverse = false;
                        output_el = el.parents(".input-exchange").siblings().find("input.rubles_to_waves");
                    }
                    //Рубли в waves, ввод рублей
                    else {
                        is_reverse = true;
                        output_el = el.parents(".input-exchange").siblings(".orange-input").find("input#exp");
                    }
                }
            }
            //console.log(output_el);
            output_el.val(calc_exchange(input_amount, crypto_price, active_bank_val, is_reverse, is_commission));
        }
    }
    function get_currency(el, prizm_price, waves_price) {
        let currency;
        if (el.attr("id") === "exp")
        {
            let siblings = el.parents(".input-exchange").siblings();
            if (siblings.find(".prizm_to_rubles").length > 0 || siblings.find(".rubles_to_prizm").length > 0)
                currency = prizm_price;
            else
            if (siblings.find(".rubles_to_waves").length > 0 || siblings.find(".waves_to_rubles").length > 0)
                currency = waves_price;
        }
        else {
            if (el.hasClass("rubles_to_prizm") || el.hasClass("prizm_to_rubles"))
                currency = prizm_price;
            else
            if (el.hasClass("rubles_to_waves") || el.hasClass("waves_to_rubles"))
                currency = waves_price;
        }
        return currency === null ? false : currency;
    }

    function get_active_bank_val(input_el, vals)
    {
        var active_select;
        // if (window.innerWidth >= 992)
        //     active_select = jQuery("#bank_list_desktop");
        // else
        //     active_select = jQuery("#bank_list_mobile");

        //Если правый input
        if (input_el.attr('id') === 'exp')
            active_select = input_el.parents(".input-exchange").prev().find('select');
        else
            if (input_el.attr('class') === 'prizm_to_rubles' ||
                input_el.attr('class') === 'rubles_to_prizm' ||
                input_el.attr('class') === 'rubles_to_waves' ||
                input_el.attr('class') === 'waves_to_rubles')
            {
                active_select = input_el.parents(".input-exchange").next().find('select');
            }

        let active_bank_val; //Комиссия выбранного банка
        jQuery.each(vals, function(key, value){
            if (key === active_select.val()) {
                active_bank_val = value;
                return false;
            }
        });
        //console.log(active_bank_val);
        return active_bank_val ? active_bank_val : false;
    }

    var vals = {<?php if (isset($banks) && !empty($banks)){
            $i = 0;
            foreach ($banks as $key => $value)
            {
                $output = '"'.$key.'": '.$value['value'];
                if ($i < count($banks) - 1)
                    $output .= ', ';
                echo $output;
                ++$i;
            }
        } ?>};

    var prizm_price = <?php echo rcl_slavia_get_crypto_price('PZM'); ?>; //Курс призма
    var waves_price = <?php echo '1';//echo rcl_slavia_get_crypto_price('WAVES'); ?>; //Курс waves

    //При вводе значения
    jQuery('.prizm_to_rubles, .waves_to_rubles, .rubles_to_prizm, .rubles_to_waves, #exp').keyup(function(event) {
        if (event.keyCode === 37 || event.keyCode === 39) {
            event.preventDefault();
            return false;
        }

        let currency = get_currency(jQuery(this), prizm_price, waves_price);
        window.active_input_class = jQuery(this).attr('class');

        //Если получение prizm|slav, то банк не нужен
        if (jQuery(this).parents('#get_prizm').length > 0 || jQuery(this).parents('#get_waves').length > 0) {
            keyup_calc(/*event, */jQuery(this), currency);
        }
        else {
            let active_bank_val = get_active_bank_val(jQuery(this), vals);
            keyup_calc(/*event, */jQuery(this), currency, active_bank_val);
        }
    });
    // //При нажатии backspace
    // jQuery('.prizm_to_rubles, .rubles_to_prizm, .rubles_to_waves, #exp').keydown(function(event) {
    //     let currency = get_currency(jQuery(this), prizm_price, waves_price);
    //     window.active_input_class = jQuery(this).attr('class');
    //     let active_bank_val = get_active_bank_val(jQuery(this), vals);
    //     keyup_calc(event, jQuery(this), currency, active_bank_val, true);
    // });


    jQuery('#bank_list_desktop, #bank_list_mobile').change(function(){
        var active_el;
        var active_class;
        if (typeof window.active_input_class !== 'undefined')
            active_class = window.active_input_class;
        var active_currency;
       if (typeof active_class !== 'undefined' &&
           (active_class === 'prizm_to_rubles' ||/*
           active_class === 'rubles_to_prizm' ||
           active_class === 'rubles_to_waves' ||*/
           active_class === 'waves_to_rubles'))
       {
           active_el = jQuery(this).parents(".input-exchange").prev().find("." + active_class);
           //Определяем валюту
           if (active_class === 'prizm_to_rubles' || active_class === 'rubles_to_prizm')
               active_currency = 'prizm';
           else
               active_currency = 'waves';

           if (active_el.val() !== '') {
               var el = jQuery(this);
               let input_amount = active_el.val();
               input_amount = parseFloat(input_amount);
               //Находим активный банк
               var active_bank_val;
               jQuery.each(vals, function (key, value) {
                   if (key === el.val()) {
                       active_bank_val = value;
                       return false;
                   }
               });
               var is_reverse;
               if (active_class === 'prizm_to_rubles' || active_class === 'waves_to_rubles')
                   is_reverse = false;
               else
                   is_reverse = true;
               el.parents(".input-exchange").next().find("#exp")
                   .val(calc_exchange(input_amount, active_currency === 'prizm' ? prizm_price : waves_price, active_bank_val, is_reverse));
           }
       }
       else
       {
           active_el = jQuery(this).parents(".input-exchange").next().find("#exp");
           if (active_el.val() !== '') {
               var el = jQuery(this);

               var input_el = el.parents(".input-exchange").prev().find('input').not('input[type="hidden"]');
               if (input_el.hasClass('prizm_to_rubles') || input_el.hasClass('rubles_to_prizm'))
                   active_currency = 'prizm';
               else
                   if (input_el.hasClass('rubles_to_waves') || input_el.hasClass('waves_to_rubles'))
                       active_currency = 'waves';
               //Находим активный банк
               var active_bank_val;
               jQuery.each(vals, function (key, value) {
                   if (key === el.val()) {
                       active_bank_val = value;
                       return false;
                   }
               });
               var is_reverse;
               var output_el;
               var input_amount;
               if (input_el.attr('class') === 'prizm_to_rubles' || input_el.attr('class') === 'waves_to_rubles') {
                   is_reverse = true;
                   //Выводим в левый input
                   output_el = input_el;
                   input_amount = active_el.val();
                   input_amount = parseFloat(input_amount);
               }
               else {
                   is_reverse = true;
                   //Выводим в правый input
                   output_el = active_el;
                   input_amount = input_el.val();
                   input_amount = parseFloat(input_amount);
               }

               output_el.val(calc_exchange(input_amount, active_currency === 'prizm' ? prizm_price : waves_price, active_bank_val, is_reverse));
           }
       }
    });

    jQuery('.click_ex form input[type=submit]').on('touchstart', function(){
        //jQuery(this).val('touch');
        let form = jQuery(this).parents('form')[0];
        for (var i=0; i < form.elements.length; i++)
            if (form.elements[i].value === '' && form.elements[i].hasAttribute('required')) {
                form.elements[i].setCustomValidity('Данное поле является обязательным!');
                //jQuery(form.elements[i]).css('border', '2px red');
                return false;
            }
        form.submit();
        //jQuery(this).trigger( "click" );
    });

    //Other payments
    function get_currency_rates()
    {
        let input_rate = jQuery('form.other_payments').find('select.other_payments.input_currency option:selected').not(':first-child');
        let output_rate = jQuery('form.other_payments').find('select.other_payments.output_currency option:selected').not(':first-child');

        if (input_rate.is(':disabled') || output_rate.is(':disabled') || input_rate.length <= 0 || output_rate.length <= 0)
            return false;
        else
        {
            input_rate = input_rate.attr('data-rate');
            output_rate = output_rate.attr('data-rate');
            return {input_rate: input_rate, output_rate: output_rate};
        }
    }
    function calc_other_payments_input_sum(output_sum)
    {
        let currency_rates = get_currency_rates();
        if (!currency_rates)
            return false;
        else {
            let result = (output_sum * currency_rates.output_rate) / currency_rates.input_rate;
            console.log("result: " + result);
            return Math.round(result * 100) / 100;
        }
    }
    function calc_other_payments_output_sum(input_sum)
    {
        let currency_rates = get_currency_rates();
        if (!currency_rates)
            return false;
        else {
            let result = (input_sum * currency_rates.input_rate) / currency_rates.output_rate;
            console.log("result: " + result);
            return Math.round(result * 100) / 100;
        }
    }
    //Задаем элемент, в котором был произведен ввод и функция делает вывод в соседний input
    function other_payments_print_result(input_el)
    {
        let output_el;
        let input_sum = input_el.val();

        console.log(input_sum);

        if (input_el.hasClass('other_payments_input')) //Введена вносимая сумма
        {
            output_el = input_el.parents('.input-exchange').siblings('.input-exchange.orange-input').find('input.exp_custom');
            let output_sum = calc_other_payments_output_sum(input_sum);
            if (output_sum === false)
                return;
            else
                output_el.val(output_sum);

        }
        else
            if (input_el.hasClass('exp_custom')) //Внесена желаемая сумма
            {
                output_el = input_el.parents('.input-exchange.orange-input').siblings('.input-exchange.col-lg-5').find('input.other_payments_input');
                let output_sum = calc_other_payments_input_sum(input_sum);
                if (output_sum === false)
                    return;
                else
                    output_el.val(output_sum);
            }

    }
    jQuery('.other_payments_input, .exp_custom').keyup(function(event) {
        other_payments_print_result(jQuery(this));
    });
    jQuery('form.other_payments select.other_payments.input_currency').change(function(){
        other_payments_print_result(jQuery(this).parents('form.other_payments').find('.other_payments_input'));

        let requisites = jQuery('form.other_payments select.other_payments.requisites');
        requisites.find('option').not(':first-child').remove();
        requisites.append('<option selected>' + jQuery(this).find('option:selected').attr('data-requisites') + '</option>');
    });
    jQuery('form.other_payments select.other_payments.output_currency').change(function(){

        let possible_rub_names = ["RUB", "rub", "Rub", "рубль", "Рубль"]; //Возможные названия рубля, учитывая регистр

        let fields_to_show = jQuery(this).parents('.input-exchange')
            .siblings('#other_payments_card_name, #other_payments_card_num, #other_payments_bank');

        if (possible_rub_names.includes(jQuery(this).val() ) )
            fields_to_show.css('display', 'block');
        else
            fields_to_show.css('display', 'none');

        other_payments_print_result(jQuery(this).parents('form.other_payments').find('.other_payments_input'));
    });

    //jQuery('#other_payments_bank select')
    //other_deposit
    jQuery('form.other_deposit select.other_deposit.input_currency').change(function(){
        let requisites = jQuery('form.other_deposit select.other_deposit.requisites');
        requisites.find('option').not(':first-child').remove();
        requisites.append('<option selected>' + jQuery(this).find('option:selected').attr('data-requisites') + '</option>');
    });
    //output_sum = (input_sum*input_rate)/output_rate
    //input_sum = (output_sum*output_rate)/input_rate
</script>