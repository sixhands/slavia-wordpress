<div class="col-lg-12 col-md-12"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1 ib">Настройки комиссии банков</h1>


            <div class="col-12">
                <form class="row" name="settings_banks" id="settings_form_banks" action="" method="post"  enctype="multipart/form-data">
                    <?php if (isset($banks) && !empty($banks)): echo $banks;
                          else: ?>

                        <div class="col-lg-4 input-exchange input-custom-procent">
                            <div class="row">
                                <a class="settings_close">&times;</a>
                                <div class="select-exchange w-100">
                                    <input value="Название банка 1" type="text" name="bank1[name]" style="background: #fff">
                                    <input class="bank_value" value="0.5" type="text" name="bank1[value]">
                                    </div>
                                </div>
                        </div>

                    <?php endif; ?>
                </form>
            </div> <br>

            <div class="col-lg-6 text-center">
                <div class="row">
                    <div class="col-6">
                        <div id="add_bank" class="btn-custom-one">
                            Добавить банк
                        </div>
                    </div>
                    <div class="col-6">
                        <input style="width: 100%" form="settings_form_banks" type="submit" class="btn-custom-one" value="Сохранить" name="submit_settings_banks" />
                    </div>
                </div>
            </div>

        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1 ib">Вознаграждение по реферальной программе</h1>


            <div class="col-12">
                <form class="row" name="settings_ref" id="settings_form_ref" action="" method="post"  enctype="multipart/form-data">

                    <div class='col-lg-4 input-exchange input-custom-procent'>
                        <div class='row' style='height: 100%; padding-top: 30px'>
                            <div class='select-exchange w-100'>
                                <div class='row'>
                                    <div class='col-12'>
                                        <span class='select-exchange' style='display: inline-block'>Обычные пользователи</span></div>
<!--                                    <div class='col-4'>-->
<!--                                        <a class='settings_close' style='display: inline-block; margin-left: -20px; margin-top: -5px'>&times;</a>-->
<!--                                    </div>-->
                                </div>
                                <?php //wp_dropdown_users( array( 'role__in' => array('manager', 'customer', 'user', 'not_verified', 'need-confirm'), 'name' => 'ref_user[0][id]', 'id' => 'ref_user_0', 'class' => 'user_dropdown' )); ?>
                                <?php $normal_percent = rcl_get_option('ref_percent_normal'); ?>
                                <input class='ref_value' value='<?=$normal_percent ?>' type='text' name='ref_normal_users[value]'>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($ref_content) && !empty($ref_content)): echo $ref_content;
                          else: ?>
<!---->
<!--                    <div class="col-lg-4 input-exchange input-custom-procent">-->
<!--                        <div class="row">-->
<!--                            <span>За каждого реферала</span>-->
<!--                            <input value="0.5" type="text" name="ref_amount">-->
<!--                        </div>-->
<!--                    </div>-->

                        <div class='col-lg-4 input-exchange input-custom-procent'>
                            <div class='row' style='height: 100%; padding-top: 30px'>
                                <div class='select-exchange w-100'>
                                    <div class='row'><div class='col-8'>
                                            <span class='select-exchange' style='display: inline-block'>Пользователь</span></div>
                                        <div class='col-4'>
                                            <a class='settings_close' style='display: inline-block; margin-left: -20px; margin-top: -5px'>&times;</a>
                                        </div>
                                    </div>
                                    <?php wp_dropdown_users( array( 'role__in' => array('manager', 'customer', 'user', 'not_verified', 'need-confirm'), 'name' => 'ref_user[0][id]', 'id' => 'ref_user_0', 'class' => 'user_dropdown' )); ?>
                                    <input class='ref_value' value='0.5' type='text' name='ref_user[0][value]'>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

<!--                    <div class="col-lg-3 text-center" style="padding-top: 8%; margin-left: 8%;">-->
<!--                        <div class="row">-->
<!--                            <input form="settings_form_ref" type="submit" class="btn-custom-one" value="Сохранить" name="submit_settings_ref" />-->
<!--                        </div>-->
<!--                    </div>-->


                </form>
            </div>
            <br>
            <div class="col-lg-8 text-center">
                <div class="row">
                    <div class="col-6">
                        <div id="add_ref_user" class="btn-custom-one" style="width: 100%">
                            <span>Добавить пользователя</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <input style="width: 100%" form="settings_form_ref" type="submit" class="btn-custom-one" value="Сохранить" name="" />
                    </div>
                </div>
            </div>


        </div>

        <div class="coop_maps question-bg col-lg-12 settings-commission">
<!--            <h1 class="coop_maps-h1 ib" style="color: red">В РАЗРАБОТКЕ</h1><br>-->
            <h1 class="coop_maps-h1 ib">Настройка процентов по обмену</h1>

            <?php
            $asset_inputs = get_input_currencies_2();
            $asset_outputs = get_output_currencies_2();

            $currencies = get_all_currencies();
            ?>

            <div class="currency-template" style="display: none;">

                <div class="nested_menu">
                    <a class="menu_link">Имущество</a>
                </div>
                <?php print_nested_assets($currencies); ?>

            </div>

            <div class="input_currency_template" style="display: none;">
                <div class="nested_menu">
                    <a class="menu_link">Имущество</a>
                </div>
                <?php print_nested_assets($asset_inputs); ?>
            </div>

            <div class="output_currency_template" style="display: none">
                <div class="nested_menu">
                    <a class="menu_link">Имущество</a>
                </div>
                <?php print_nested_assets($asset_outputs, true); ?>
            </div>

            <div class="col-12">
                <!--ЕДИНИЦЫ ИЗМЕРЕНИЯ-->
                <form class="row" name="settings_commission-all" id="settings_form_commission-all" action="" method="post"  enctype="multipart/form-data">
                    <input type="hidden" name="currency_percent" value="true">
                    <div class="col-12 commission_container">
                        <div id="all-operations_header" class="row">
                            <div class="col-6">
                                <p class="operation_name">Обычные операции</p>
                            </div>
                        </div>
                        <div id="all-operations" class="row no-gutters">
                            <?php
                            $currency_percents = rcl_get_option('currency_percent');
                            //print '<pre>'.print_r($currency_percents, true).'</pre>';
                            ?>
                            <div class="col-2 operation_header">
<!--                                <p class="operation_name">Обычные операции</p>-->
<!--                                <p class="acquiring-percent">комиссия эквайринга</p>-->
                            </div>

                            <div class="col-10">
                                <div class="row no-gutters operation_currencies">
                                    <div class="col-2">
                                        <p class="ruble-sign"><span>комиссия эквайринга</span></p>
                                        <div class='col-12 input-exchange input-custom-procent'>
                                            <input class='commission' value='<?php if (isset($currency_percents['acquiring'])) echo $currency_percents['acquiring']?>' type='text' name='currency_percent[acquiring]'>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="commission_header"><span>комиссия сайта</span></div>
                                        <div class='col-12 input-exchange input-custom-procent'>
                                            <input class='commission' value='<?php if (isset($currency_percents['site'])) echo $currency_percents['site']?>' placeholder="" type='text' name='currency_percent[site]'>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="commission_header">
                                            <a class="settings_close">×</a>
                                            <span>SLAV</span>
                                        </div>
                                        <div class='col-12 input-exchange input-custom-procent'>
                                            <input class='commission' value='<?php if (isset($currency_percents['slav'])) echo $currency_percents['slav']?>' placeholder="" type='text' name='currency_percent[slav]'>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="commission_header">
                                            <a class="settings_close">×</a>
                                            <span>PZM</span>
                                        </div>
                                        <div class='col-12 input-exchange input-custom-procent'>
                                            <input class='commission' value='<?php if (isset($currency_percents['prizm'])) echo $currency_percents['prizm']?>' placeholder="" type='text' name='currency_percent[prizm]'>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="commission_header">
                                            <a class="settings_close">×</a>
                                            <span>ALT</span>
                                        </div>
                                        <div class='col-12 input-exchange input-custom-procent'>
                                            <input class='commission' value='<?php if (isset($currency_percents['alt'])) echo $currency_percents['alt']?>' placeholder="" type='text' name='currency_percent[alt]'>
                                        </div>
                                    </div>

                                    <?php if (isset($currency_percents) && !empty($currency_percents)): ?>
                                        <?php foreach($currency_percents as $currency => $percent): ?>
                                            <?php if ($currency != 'acquiring' && $currency != 'site' &&
                                                    $currency != 'slav' && $currency != 'prizm' && $currency != 'alt'): ?>
                                                <div class="col-2">
                                                    <div class="commission_header">
                                                        <a class="settings_close">×</a>
                                                        <?//=$currency?>
                                                        <select class="currencies">
                                                            <option value="<?=htmlspecialchars($currency, ENT_QUOTES, 'UTF-8')?>"><?=$currency?></option>
                                                        </select>
                                                    </div>
                                                    <div class='col-12 input-exchange input-custom-procent'>
                                                        <input class='commission' value='<?=$percent?>' placeholder="" type='text' name='currency_percent[<?=htmlspecialchars($currency, ENT_QUOTES, 'UTF-8')?>]'>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif;?>
<!--                                    <div class="col-2">-->
<!--                                        <p class="commission_header">ALT</p>-->
<!--                                        <div class='col-12 input-exchange input-custom-procent'>-->
<!--                                            <input class='commission' value='5' placeholder="" type='text' name='percent[all][alt]'>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-10">
                        <div class="row">
                            <div class="col-6">
                                <button id="add_currency" class="btn-custom-one" style="width: 100%">
                                    <span>Добавить единицу измерения</span>
                                </button>
                            </div>
                            <div class="col-6" style="">
                                <input style="width: 100%" form="settings_form_commission-all" type="submit" class="btn-custom-one" value="Сохранить" name="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--------------------------------------->
                <!--НАСТРОЙКА ОПЕРАЦИЙ-->
                <form class="row" name="settings_commission-operations" id="settings_form_commission-operations" action="" method="post"  enctype="multipart/form-data">
                    <input type="hidden" name="operation_percent" value="true">
                    <?php
                        $operation_percents = rcl_get_option('operation_percent');
                    ?>
                    <div class="col-12 commission_container">
                        <div id="operations_header" class="row">
                            <div class="col-6">
                                <p class="operation_name">Управление операциями</p>
                            </div>
                        </div>
                        <div id="operations" class="row no-gutters">
                            <?php if (isset($operation_percents) && !empty($operation_percents)):?>
                                <?php foreach($operation_percents as $name => $percent): ?>
                                    <div class="col-12 operation_item">
                                        <div class="row no-gutters">
                                            <div class="col-2 operation_header">
                                                <p class="operation_name">
                                                    <?php //$first_asset_name = htmlspecialchars($asset_inputs[0]['asset_name'], ENT_QUOTES, 'UTF-8'); ?>
                                                    <select class="operation_type" name="percent[<?=$name//$first_asset_name?>][type]">
                                                        <?php if ($percent['type'] == 'buy'): ?>
                                                            <option selected value="buy">Покупка</option>
                                                            <option value="sell">Продажа</option>
                                                        <?php elseif ($percent['type'] == 'sell'): ?>
                                                            <option value="buy">Покупка</option>
                                                            <option selected value="sell">Продажа</option>
                                                        <?php endif; ?>
                                                    </select>
<!--                                                    <select class="operation_currency">-->
<!--                                                        --><?php //$rate = ''; ?>
<!--                                                       <option value="PZM">PZM</option>-->
<!--                                                        --><?php
//                                                            foreach($currencies as $currency)
//                                                                if ($currency['asset_name'] == $name)
//                                                                    $rate = $currency['asset_rate_rubles'];
//                                                            ?>
<!--                                                            <option data-rate="--><?//=$rate?><!--" value="--><?//=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?><!--">-->
<!--                                                                --><?//=$name?>
<!--                                                            </option>-->
<!--                                                        --><?php ////endforeach; ?>
<!--                                                    </select>-->
                                                <div class="nested_menu">
                                                    <a class="menu_link">Имущество</a>
                                                </div>
                                                <?php print_nested_assets($currencies); ?>
                                                </p>
                <!--                                <p class="acquiring-percent">комиссия эквайринга</p>-->
                                            </div>

                                            <div class="col-10">
                                                <div class="row no-gutters operation_currencies">
                                                    <?php //print '<pre>' . print_r($percent, true).'</pre>'; ?>
                                                    <div class="col-12 remove_operation">
                                                        <span class="remove_operation_text">Удалить операцию</span>
                                                        <a class="remove_operation_link">×</a>
                                                    </div>
                                                    <?php foreach ($percent as $currency => $value): ?>
                                                        <?php if ($currency !== 'type'): ?>
                                                            <div class="col-2<?php
                                                                                if ($currency != 'acquiring' && $currency != 'site') echo ' currency_percent';
                                                                                elseif ($currency == 'acquiring') echo ' acquiring';
                                                                                elseif ($currency == 'site') echo ' site';?>">
                                                                <?php if ($currency == 'acquiring'): ?>
                                                                    <p class="ruble-sign"><span>комиссия эквайринга</span></p>
                                                                <?php elseif ($currency == 'site'): ?>
                                                                    <div class="commission_header"><span>комиссия сайта</span></div>
                                                                <?php elseif ($currency !== 'slav' || $currency !== 'prizm' || $currency !== 'alt'): ?>
                                                                    <div class="commission_header"><span><?=strtoupper($currency)?></span></div>
                                                                <?php else: ?>
                                                                    <div class="commission_header"><span><?=$currency?></span></div>
                                                                <?php endif; ?>

                                                                <div class='col-12 input-exchange input-custom-procent'>
                                                                    <input class='commission' value='<?=$value?>' type='text' name='percent[<?=$name?>][<?=$currency?>]'>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                    <?php endforeach; ?>

                                                    <!-- Выводим валюты, не имеющие значения в данной операции -->
                                                    <?php foreach($currency_percents as $currency => $value): ?>
                                                        <?php if (!in_array($currency, array_keys($percent))): ?>
                                                            <div class="col-2<?php
                                                            if ($currency != 'acquiring' && $currency != 'site') echo ' currency_percent';
                                                            elseif ($currency == 'acquiring') echo ' acquiring';
                                                            elseif ($currency == 'site') echo ' site';?>">
                                                                <?php if ($currency == 'acquiring'): ?>
                                                                    <p class="ruble-sign"><span>комиссия эквайринга</span></p>
                                                                <?php elseif ($currency == 'site'): ?>
                                                                    <div class="commission_header"><span>комиссия сайта</span></div>
                                                                <?php elseif ($currency !== 'slav' || $currency !== 'prizm' || $currency !== 'alt'): ?>
                                                                    <div class="commission_header"><span><?=strtoupper($currency)?></span></div>
                                                                <?php else: ?>
                                                                    <div class="commission_header"><span><?=$currency?></span></div>
                                                                <?php endif; ?>

                                                                <div class='col-12 input-exchange input-custom-procent'>
                                                                    <input class='commission' value='' type='text' name='percent[<?=$name?>][<?=$currency?>]'>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php //print '<pre>'.print_r(array_keys($percent), true).'</pre>'; ?>
                                                    <?php endforeach; ?>


                                                        <div class="col-3 currency_rate">
                                                            <div class="commission_header"><span>курс</span></div>
                                                            <div class='col-12 input-exchange input-custom-rub'>
                                                                <input disabled class='commission' value='<?=/*rcl_slavia_get_crypto_price('PZM')*/$rate . " RUB"; ?>' placeholder="" type='text'>
                                                            </div>
                                                        </div>

                                                        <div class="col-4 operation_sum">
                                                            <div class="commission_header"><span>Итого</span></div>
                                                            <div class='col-12 input-exchange input-custom-rub'>
                                                                <input disabled class='commission operation_sum' value='' placeholder="" type='text'>
                                                            </div>
                                                        </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-10">
                        <div class="row">
                            <div class="col-6">
                                <button id="add_operation" class="btn-custom-one" style="width: 100%">
                                    <span>Добавить операцию</span>
                                </button>
                            </div>
                            <div class="col-6" style="">
                                <input style="width: 100%" form="settings_form_commission-operations" type="submit" class="btn-custom-one" value="Сохранить" name="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="user_dropdown_template" style="display: none">
    <?php wp_dropdown_users( array( 'role__in' => array('manager', 'customer', 'user', 'not_verified', 'need-confirm', 'director'), 'class' => 'user_dropdown')); ?>
</div>
<style>
    .input-exchange {
        margin-top: 0px;
    }
    .input-exchange span {
        font-size: 18px;
        padding-left: 0;
    }

    .user_dropdown {
        padding-right: 45px;
    }
</style>