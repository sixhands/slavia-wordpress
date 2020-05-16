//Блокируем изменение полей в админке, которые не нужно изменять
jQuery(document).ready(function() {
    var admin_blocked_fields =
        ['#user_ref_link', '#ref_host', '#is_verified', '#is_email_verified', '#is_privileged'];
    console.log(admin_blocked_fields.join(', ') );
    jQuery(admin_blocked_fields.join(', ') ).prop('disabled', 'disabled');
});