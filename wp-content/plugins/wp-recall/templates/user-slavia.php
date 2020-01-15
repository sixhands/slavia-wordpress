<?php global $rcl_user,$rcl_users_set; ?>
<?php //var_dump($rcl_users_set); ?>
<div class="table-text w-100 user-single" data-user-id="<?php echo $rcl_user->ID; ?>">
    <div class="row">
        <div class="col-lg-1 text-center">
            <img src="/wp-content/uploads/2019/12/verification_ok.png">
        </div>
        <div class="col-3 text-left">
            <?php rcl_user_name(); ?>
        </div>
        <div class="col-2 text-left">
            <?php rcl_user_client_num(); ?>
        </div>
        <div class="col-3 text-left">
            <?php echo $rcl_user->user_registered; ?>
        </div>
        <div class="col-2 text-left">
            0
        </div>
        <div class="col-1 text-center">
            <img src="/wp-content/uploads/2019/12/people_href.png">
        </div>
    </div>
</div>