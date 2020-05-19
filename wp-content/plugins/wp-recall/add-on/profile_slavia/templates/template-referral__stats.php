<div class="col-12">
    <div class="table-title w-100" style="height: 55px">
        <div class="row">
            <div class="col-1 text-left">

            </div>
            <div class="col-4 text-left">
                Имя клиента
            </div>
            <div class="col-3 text-left">
                Дата регистрации
            </div>

            <div class="col-4 text-center show_ref_stats">
                Статистика по клиенту
            </div>

        </div>
    </div>

    <?php if(isset($ref_data) && !empty($ref_data)): ?>
        <?php foreach($ref_data as $user_id): ?>
            <?php $user_data = get_userdata($user_id); ?>
            <?php if (!isset($user_data) || empty($user_data))
                continue;
            ?>
            <div class="table-text w-100" data-user-id="<?=$user_id ?>">
                <div class="row">
                    <div class="col-1 text-left">
                        <?php $is_verified = get_user_meta($user_id, 'is_verified', true); ?>

                        <?php if (isset($is_verified) && $is_verified == 'yes'): ?>
                            <img src="/wp-content/uploads/2019/12/verification_ok.png">
                        <?php else: ?>
                            <img src="/wp-content/uploads/2019/12/verification_bad.png">
                        <?php endif; ?>
                    </div>
                    <div class="col-4 text-left host_name">
                        <?=$user_data->display_name ?>
                    </div>
                    <div class="col-3 text-left">
                        <?=$user_data->user_registered ?>
                    </div>

                    <div class="col-4 text-center show_ref_stats">
                        <img src="/wp-content/uploads/2019/12/people_href.png" data-user-id="<?=$user_id ?>">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
