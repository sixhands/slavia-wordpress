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

                    <?php if (isset($ref_amount) && !empty($ref_amount)): echo $ref_amount;
                          else: ?>
<!---->
<!--                    <div class="col-lg-4 input-exchange input-custom-procent">-->
<!--                        <div class="row">-->
<!--                            <span>За каждого реферала</span>-->
<!--                            <input value="0.5" type="text" name="ref_amount">-->
<!--                        </div>-->
<!--                    </div>-->

                      <div class="col-lg-4 input-exchange input-custom-procent">
                          <div class="row">
                              <a class="settings_close">&times;</a>
                              <div class="select-exchange w-100">
                                  <span class="select-exchange">Пользователь</span>
                                  <select value="" type="text" name="user1[name]" style="background: #fff">
                                  <input class="bank_value" value="0.5" type="text" name="bank1[value]">
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
                        <input style="width: 100%" form="settings_form_ref" type="submit" class="btn-custom-one" value="Сохранить" name="submit_settings_ref" />
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>