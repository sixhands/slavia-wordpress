<?php
global $typeform;
if ( ! $typeform || $typeform == 'sign' )
	$f_sign = 'style="display:block;"';
?>

<div class="form-tab-rcl" id="login-form-rcl" <?php echo $f_sign; ?>>

    <div class="form_head" style="display: none">
        <div class="form_auth form_active"><?php _e( 'Authorization', 'wp-recall' ); ?></div>
		<?php if ( rcl_is_register_open() ): ?>
			<div class="form_reg"><?php if ( ! $typeform ) { ?><a href="#" class="link-register-rcl link-tab-rcl "><?php _e( 'Registration', 'wp-recall' ); ?></a><?php } ?></div>
		<?php endif; ?>
    </div>

    <div class="form-block-rcl"><?php rcl_notice_form( 'login' ); ?></div>

	<?php $user_login	 = (isset( $_REQUEST['user_login'] )) ? wp_strip_all_tags( $_REQUEST['user_login'], 0 ) : ''; ?>
	<?php $user_pass	 = (isset( $_REQUEST['user_pass'] )) ? wp_strip_all_tags( $_REQUEST['user_pass'], 0 ) : ''; ?>

    <form action="<?php rcl_form_action( 'login' ); ?>" method="post" class="modal-content text-center">
        <h1 class="modal-h1 text-center">Авторизация в МПК "Славия"</h1>
        <div class="col-md-12 text-center modal-form">
<!--            <div class="col-md-12 form-block-rcl text-center">-->
                <input class="input-modal text-center" required type="text" placeholder="<?php _e( 'Login', 'wp-recall' ); ?>" value="<?php echo $user_login; ?>" name="user_login">
<!--                <i class="rcli fa-user col-md-1"></i>-->
<!--                <span class="required col-md-1">*</span>-->
<!--            </div>-->
<!--            <div class="col-md-12 form-block-rcl text-center">-->
                <input class="input-modal text-center" required type="password" placeholder="<?php _e( 'Password', 'wp-recall' ); ?>" value="<?php echo $user_pass; ?>" name="user_pass">
<!--                <i class="rcli fa-lock col-md-1"></i>-->
<!--                <span class="required col-md-1">*</span>-->
<!--            </div>-->
            <div class="form-block-rcl">
                <?php do_action( 'login_form' ); ?>

                <div class="rcl-field-input type-checkbox-input">
                    <div class="rcl-checkbox-box">
                        <input type="checkbox" id="chck_remember" class="checkbox-custom" value="1" name="rememberme">
                        <label class="block-label" for="chck_remember"><?php _e( 'Remember', 'wp-recall' ); ?></label>
                    </div>
                </div>
            </div>
            <div class="form-block-rcl btn-modal text-center" style="margin-left: 12%">
                <input type="submit" class="btn-custom-one text-center" name="submit-login" value="<?php _e( 'Entry', 'wp-recall' ); ?>">
                <a href="#" class="link-remember-rcl link-tab-rcl "><?php _e( 'Lost your Password', 'wp-recall' ); // Забыли пароль   ?>?</a>
                <?php echo wp_nonce_field( 'login-key-rcl', 'login_wpnonce', true, false ); ?>
                <input type="hidden" name="redirect_to" value="<?php rcl_referer_url( 'login' ); ?>">
            </div>
        </div>
    </form>
</div>
