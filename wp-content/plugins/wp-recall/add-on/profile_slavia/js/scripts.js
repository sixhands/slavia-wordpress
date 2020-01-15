function rcl_check_profile_form(){

    var rclFormFactory = new RclForm(jQuery('form#your-profile'));
    
    rclFormFactory.addChekForm('checkPass', {
        
        isValid: function(){
            var valid = true;
            if(this.form.find('#primary_pass').val()){
        
                var user_pass = this.form.find('#primary_pass');
                var repeat_pass = this.form.find('#repeat_pass');

                if(user_pass.val() != repeat_pass.val()){

                    this.shake(user_pass);
                    this.shake(repeat_pass);
                    this.addError('checkPass', Rcl.local.no_repeat_pass);
                    valid = false;

                }else{

                    this.noShake(user_pass);
                    this.noShake(repeat_pass);

                }

            }
            return valid;
        }
        
    });
    
    return rclFormFactory.validate();

}

jQuery(document).ready(function(){
    jQuery("#username_input, #rcl-field-user_email, #rcl-field-user_phone, #user_ref_link, #client_num," +
        " #prizm_address, #prizm_public_key, #waves_address").blur(function() {
        jQuery(this).parents("form").submit();
    });
});

// function rcl_update_field(e)
// {
//     let field = [];
//     if (e.target.id === 'username_input')
//         field['display_name'] = e.target.value;
//     jQuery.ajax({
//         type: "POST",
//         url: "../../index.php",//"/wp-content/plugins/wp-recall/add-on/profile_slavia/index.php?f=profile_update",
//         data: {fields: field},
//         cache: false,
//         processData: false,
//         contentType: false,
//         success: function() {
//             var rclFormFactory = new RclForm(jQuery('form#your-profile'));
//             rclFormFactory.validate();
//             console.log("SUCCESS");
//         },
//         error: function(data) {
//             console.log("ERROR:" + JSON.stringify(data));
//         },
//     });
//
// }