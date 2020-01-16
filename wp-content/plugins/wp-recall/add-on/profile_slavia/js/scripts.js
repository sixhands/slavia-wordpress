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
    //submit формы по потере фокуса в профиле
    jQuery("#username_input, #rcl-field-user_email, #rcl-field-user_phone, #user_ref_link, #client_num," +
        " #prizm_address, #prizm_public_key, #waves_address").blur(function() {
        jQuery(this).parents("form").submit();
    });
    var bank_inputs = jQuery("#settings_form").find("input");
    //submit формы по потере фокуса в настройках
    bank_inputs.blur(function() {
        // jQuery('#settings_form input[type=hidden]').each(function(el){
        //     jQuery(this).val(jQuery(this).siblings("span").text());
        // })
        jQuery(this).parents("#settings_form").submit();
    });

    //Добавить новый банк
    jQuery("#subtab-settings .coop_maps.question-bg .btn-custom-one").click(function(){
        var banks = jQuery(this).parents(".coop_maps.question-bg").children(".col-12").children(".row").children();
        let new_row_style;
        if (banks.length % 3 === 0)
            new_row_style = "text-align: left";
        else
            new_row_style = "";

        jQuery(this).parents(".coop_maps.question-bg").children(".col-12").children(".row")
            .append("<div class='col-lg-4 input-exchange input-custom-rubl' style='" + new_row_style + "'>" +
                        "<div class='row '>" +
                            //"<span class='select-exchange'>Название банка " + (banks.length + 1) + "</span>" +
                            //"<input type='hidden' name='bank" + (banks.length + 1) + "[name]' value=''>" +
                            "<div class='select-exchange w-100'>" +
                "<input value='Название банка " + (banks.length + 1) + "' type='text' name='bank" + (banks.length + 1) + "[name]' style='background: #fff'>" +
                                "<input value='0.25' type='text' name='bank" + (banks.length + 1) + "[value]'>" +
                            "</div>" +
                        "</div>" +
                    "</div>");
        jQuery("#settings_form .input-exchange:last-child input").blur(function() {
            // jQuery('#settings_form input[type=hidden]').each(function(el){
            //     jQuery(this).val(jQuery(this).siblings("span").text());
            // })
            jQuery(this).parents("#settings_form").submit();
        });
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