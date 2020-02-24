<?php $side_text = get_field('verification_sidetext', 306);
      $video_files = get_field('verification_video', 306);
      $video_text = get_field('verification_modal_text', 306); ?>
<div class="col-lg-12 col-md-12"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12">
            <div class="row">
                <div class="col-lg-2">
                    <!--Изображение профиля--> <!-- /wp-content/uploads/2019/12/profil_index_img.png -->
                    <img src="<?php echo $avatar_url?>" class="profil-index-img">
                </div>
                <div class="col-lg-8">
                    <!--Имя авторизированного пользователя -->
                    <h1 class="profil-user-h1">
                        С возвращением, <?php if (empty($verification) &&
                                               ( !isset($verification['name']) &&
                                                 !isset($verification['last_name'])
                                               ) )
                                                  echo $username;
                                              else
                                                  echo $verification['name'].' '.$verification['last_name'] ?>!
                    </h1>
                    <?php if (isset($is_verified) && $is_verified == 'yes'): ?>
                        <p class="profil-user-verification" style="color: #179F37;">
                            Профиль верифицирован
                        </p>
                    <?php else: ?>
                        <p class="profil-user-verification" style="color: red;">
                            Профиль не верифицирован
                        </p>
                    <?php endif ?>
                </div>
                <div class="col-lg-2" style="margin-top: 5%">
                    <div class="btn-modal">
                        <input type="button" class="btn-custom-two text-center" onclick="document.location.href='<?php echo wp_logout_url('http://vnuk2.ev88.fvds.ru'); ?>';" value="Выход">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-4 input-exchange">
                        <form class="row" name="profile" id="your-profile" action="" method="post"  enctype="multipart/form-data">
                            <div style="width: 100%">
                                <span>Имя пользователя</span>
                                <input id="username_input" value="<?php echo $username ?>" type="text" name="">
                                <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 input-exchange ">
                        <div class="row ">
                            <span class="select-exchange">Email</span>
                            <div class="select-exchange w-100">
<!--                                <input value="example@gmail.com" class="verification-ok" type="email" name="">-->
                                <form class="row" name="profile" id="your-profile" action="" method="post"  enctype="multipart/form-data">
                                    <div style="width: 100%">
                                        <?php echo $user_email ?>
                                        <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange">
                        <form class="row" name="profile" id="your-profile" action="" method="post"  enctype="multipart/form-data">
                            <div style="width: 100%">
                                <span>Телефон</span>
<!--                            <input value="8 (911) 718 25 22" class="verification-ok" type="text" name="">-->
                                <?php echo $user_phone ?>
                                <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                            </div>
                        </form>
                    </div>

<!--                    <div class="col-12" style="text-align: center; margin-top: 30px;">-->
<!--                        <input type="submit" id="cpsubmit" class="btn-custom-two" value="Обновить профиль" onclick="return rcl_check_profile_form();" name="submit_user_profile" />-->
<!--                    </div>-->
                </div>
                <?php //if (isset($_POST)) var_dump($_POST); ?>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Реферальная ссылка</h1>
            <div class="col-lg-4 input-exchange  input-custom-copy">
                <form class="row" name="profile_link" id="your-profile" action="" method="post"  enctype="multipart/form-data">
                    <div style="width: 100%">
                        <?php echo $user_ref_link ?>
                        <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                    </div>
<!--                    <input placeholder="" value="https://slavia.com/5467889" type="text" name="">-->
                </form>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Номер пайщика</h1>
            <div class="col-lg-4 input-exchange  input-custom-copy">
                <form class="row" name="profile_client_num" id="your-profile" action="" method="post"  enctype="multipart/form-data">
                    <div style="width: 100%">
                        <?php echo $client_num ?>
                        <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                    </div>
<!--                    <input placeholder="" value="00073" type="text" name="">-->
                </form>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Ваш адрес Prizm</h1>
            <div class="row">
                <div class="col-lg-6 input-exchange  custom-padding input-custom-copy">
                    <div class="row">
<!--                    <form class="row" name="profile_prizm_address" id="your-profile" action="" method="post"  enctype="multipart/form-data">-->
                        <div style="width: 100%">
                            <span>Адрес PRIZM</span>
                            <input id="prizm_address" form="profile_verification" class="text-field" type="text" required name="verification[prizm_address]"<?php if (isset($verification) && isset($verification['prizm_address'])): ?> value="<?=$verification['prizm_address']?>"<?php endif; ?>>
                            <?php //echo $prizm_address ?>
                            <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                        </div>
<!--                        <input placeholder="" value="00073" type="text" name="">-->
<!--                    </form>-->
                    </div>
                </div>
                <div class="col-lg-6 input-exchange custom-padding  input-custom-copy">
                    <div class="row">
<!--                    <form class="row" name="profile_prizm_publickey" id="your-profile" action="" method="post"  enctype="multipart/form-data">-->
                        <div style="width: 100%">
                            <span>Публичный ключ</span>
                            <input id="prizm_public_key" form="profile_verification" class="text-field" type="text" required name="verification[prizm_public_key]"<?php if (isset($verification) && isset($verification['prizm_public_key'])): ?> value="<?=$verification['prizm_public_key']?>"<?php endif; ?>>
                            <?php //echo $prizm_public_key ?>
                            <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                        </div>
<!--                        <input placeholder="" value="00073" type="text" name="">-->
<!--                    </form>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1">Ваш адрес Slav</h1>
            <div class="col-lg-12 input-exchange  input-custom-copy">
                <div class="row">
<!--                <form class="row" name="profile_waves_address" id="your-profile" action="" method="post"  enctype="multipart/form-data">-->
                    <div style="width: 100%">
                        <span>Адрес Slav</span>
                        <input id="waves_address" form="profile_verification" class="text-field" type="text" required name="verification[waves_address]"<?php if (isset($verification) && isset($verification['waves_address'])): ?> value="<?=$verification['waves_address']?>"<?php endif; ?>>
                        <?php //echo $waves_address ?>
                        <img src="/wp-content/uploads/2019/12/custom-copy.png" class="copy-btn">
                    </div>
<!--                    <input placeholder="" value="00073" type="text" name="">-->
<!--                </form>-->
                </div>
            </div>
        </div>

        <!--VERIFICATION-->
        <div class="coop_maps question-bg col-lg-12">
            <h1 class="coop_maps-h1 ib">Верификация профиля</h1>
            <a id="modal-54506521" href="#modal-container-54506521" role="button" class="" data-toggle="modal"><img src="/wp-content/uploads/2019/12/info.png" class="ib info-href"></a>

            <form class="col-12" name="profile_verification" id="profile_verification" action="" method="post"  enctype='multipart/form-data'>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-4 input-exchange">
                        <div class="row">

                            <input <?php if (isset($verification) && isset($verification['name'])): ?>value="<?=$verification['name']?>"<?php endif; ?>placeholder="Имя" required type="text" name="verification[name]">
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange ">
                        <div class="row ">

                            <div class="select-exchange w-100">
                                <input <?php if (isset($verification) && isset($verification['surname'])): ?>value="<?=$verification['surname']?>" <?php endif; ?>placeholder="Фамилия" required class="" type="text" name="verification[surname]">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange">
                        <div class="row">

                            <input <?php if (isset($verification) && isset($verification['last_name'])): ?>value="<?=$verification['last_name']?>" <?php endif; ?>placeholder="Отчество" required class="" type="text" name="verification[last_name]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-4 input-exchange">
                        <div class="row">
                            <span>Серия и номер паспорта</span>
                            <input <?php if (isset($verification) && isset($verification['passport_number'])): ?>value="<?=$verification['passport_number']?>" <?php endif; ?>placeholder="____-______" required  type="text" name="verification[passport_number]">
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange ">
                        <div class="row ">
                            <span>Дата выдачи</span>
                            <div class="select-exchange w-100">
                                <input <?php if (isset($verification) && isset($verification['passport_date'])): ?>value="<?=$verification['passport_date']?>" <?php endif; ?> placeholder="Дата выдачи" required class="" type="date" name="verification[passport_date]">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange">
                        <div class="row">
                            <span>&nbsp;</span>
                            <input <?php if (isset($verification) && isset($verification['passport_code'])): ?>value="<?=$verification['passport_code']?>" <?php endif; ?> placeholder="Код подразделения" required class="" type="text" name="verification[passport_code]">
                        </div>
                    </div>
                    <div class="col-lg-12 input-exchange">
                        <div class="row">
                            <span>&nbsp;</span>
                            <input <?php if (isset($verification) && isset($verification['passport_who'])): ?>value="<?=$verification['passport_who']?>" <?php endif; ?> placeholder="Кем выдан" required class="" type="text" name="verification[passport_who]">
                        </div>
                    </div>
                    <div class="col-lg-8 input-exchange ">
                        <div class="row ">
                            <span>Место жительства по прописке</span>
                            <div class="select-exchange w-100" style="padding-left: 0 !important;">
                                <input <?php if (isset($verification) && isset($verification['passport_address'])): ?>value="<?=$verification['passport_address']?>" <?php endif; ?> placeholder="Место жительства по прописке" required class="" type="text" name="verification[passport_address]">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 input-exchange">
                        <div class="row">
                            <span>Индекс</span>
                            <input <?php if (isset($verification) && isset($verification['passport_index'])): ?>value="<?=$verification['passport_index']?>" <?php endif; ?> placeholder="Индекс" required class="" type="text" name="verification[passport_index]">
                        </div>
                    </div>
                    <?php if (isset($verification) && isset($passport_photos) && !empty($passport_photos) && !empty($verification)): ?>
                    <div class="col-lg-12 passport-photo">
                        <div class="row">
                            <?php foreach($passport_photos as $key => $value): ?>
                                <div class="col-lg-4 passport-img">
                                    <img src="<?=$value?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <!--PHOTO -->
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="skrepka w-100 text-center">
                                <img src="/wp-content/uploads/2019/12/skrepka.png" style="margin-left: 20%">
                                <input required accept="image/*" data-multiple-caption="{count} файлов выбрано" multiple type="file" name="passport_photos[]" id="passport_photos" class="upload" />
                                <label for="passport_photos">Прикрепить фото</label>
                            </div>

                            <input type="submit" class="btn-custom-one w-100 text-center" id="submit_verification" value="Завершить регистрацию" name="submit_verification" style="margin-top: 30px; height: 42px"/>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <p class="passport-text">
                                <?php if (isset($side_text) && !empty($side_text)) echo $side_text; ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            </form>
        </div>
        <!-- Статистика -->
        <?php if ($is_manager): ?>
        <div class="coop_maps question-bg col-lg-12">
            <div class="row">
                <div class="col-12">
                    <h1 class="coop_maps-h1 ib">Статистика</h1>
                    <div class="ib" style="float:right">
<!--                        <h1 class="coop_maps-h1 ib" style="font-size: 16px;">08.11.19</h1>-->
<!--                        <img src="/wp-content/uploads/2019/12/calendar.png" class="ib" style="">-->
<!--                        <img src="/wp-content/uploads/2019/12/loop.png" class="ib" style="margin-top: 10px;">-->
                        <input placeholder="Для поиска нажмите enter" name="filter" class="search" value="" style="margin-top: 0"/>
                        <img class="search-btn ib" src="/wp-content/uploads/2019/12/loop.png" style="margin-top: 10px;">

                        <img src="/wp-content/uploads/2019/12/donw.png" class="ib download_btn" style="cursor: pointer">
                    </div>
                </div>
            </div>

            <div class="row stats">
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
                <?php if (isset($stats_content) && !empty($stats_content)) echo $stats_content; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>
<!--Модальное окно информации -->
<div class="modal fade profile_video" id="modal-container-54506521" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-left">
            <div class="row">
                <div class="col-10">
                    <h1 class="coop_maps-h1 ib">Верификация профиля</h1>
                </div>
                <div class="col-2">
                    <button type="button" class="close ib " data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

            </div>

<!--            Здесь будет видео-->
            <?php
            if (isset($video_files) && !empty($video_files)) : ?>
                <video controls width="100%" height="459">
                    <?php foreach( $video_files as $video ): ?>
                        <?php if (!empty($video) && $video['type'] == 'video'): ?>
                            <?php $filename = $video['filename'];
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            $url = $video['url'];
                            switch ($ext) {
                                case "mp4":
                                    $mime_type = "video/mp4";
                                    break;
                                case "webm":
                                    $mime_type = "video/webm";
                                    break;
                                case "ogv":
                                    $mime_type = "video/ogg";
                                    break;
                                case "swf":
                                    $mime_type = "application/x-shockwave-flash";
                                    break;
                                case "3gp":
                                    $mime_type = "video/3gpp";
                                    break;
                                case "m1v":
                                    $mime_type = "video/mpeg";
                                    break;
                                case "avi":
                                    $mime_type = "video/x-msvideo";
                                    break;
                            }
                            if (strcmp($ext, "swf") !== 0): ?>
                                <source src="<?php echo $url ?>" type="<?php if (isset($mime_type) && !empty($mime_type)) echo $mime_type ?>">
                            <?php else: ?>
                                <object data="<?php echo $url ?>" type="<?php if (isset($mime_type) && !empty($mime_type)) echo $mime_type ?>"><!-- добавляем видеоконтент для устаревших браузеров, в которых нет поддержки элемента video -->
                                    <param name="movie" value="<?php echo $url ?>">
                                </object>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </video>
            <?php endif; ?>

            <?php if (isset($video_text) && !empty($video_text))
                    echo $video_text; ?>

        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('.search').keyup(function(event){
        var code = (event.keyCode ? event.keyCode : event.which);
        if (code == 13) {
            let el = jQuery(this);
            let search = {
                type: 'word',
                datatype: 'stats',
                val: el.val()
            };
            let output_el = jQuery('.row.stats');
            search_ajax(el, search, search_callback, output_el);
        }
        else {
            event.preventDefault();
            return false;
        }
    });
    jQuery('.search').blur(function(){
        let el = jQuery(this);
        let search = {
            type: 'word',
            datatype: 'stats',
            val: el.val()
        };
        let output_el = jQuery('.row.stats');
        search_ajax(el, search, search_callback, output_el);
    });

    jQuery('.download_btn').click(function(event){
        window.location.replace("/profile?f=download_stats");
        //jQuery('.row.stats');
    });
    function search_callback(response, output_el) {
        output_el.children().not('.table-title').remove();
        output_el.append(response);
    }

</script>