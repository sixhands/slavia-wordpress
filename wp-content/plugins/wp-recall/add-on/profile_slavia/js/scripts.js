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

function change_requisites(currency_el, requisite_el, requisite_val = '')
{
    if (typeof requisite_el !== 'undefined')
    {
        requisite_el.find('option').not(':first-child').remove();

        if (requisite_val !== 'clear')
            requisite_el.append('<option selected>' +
                                currency_el.attr('data-requisites') +
                                '</option>');
    }
}

function settings_add_currency_percent()
{
    let currency_name_template = jQuery('div.settings-commission .currency-template select');
    let currency_first_name = currency_name_template.find('option:first-child').val();

    jQuery('#all-operations .operation_currencies').append(
        '<div class="col-2">' +
            '<p class="commission_header" style="margin-top: -8%;">' +
                '<a class="settings_close">×</a>' +
                currency_name_template.clone().prop('outerHTML') +
            '</p>' +
            '<div class="col-12 input-exchange input-custom-procent">' +
                '<input class="commission" value="0" placeholder="" type="text" name="currency_percent[' + currency_first_name + ']">' +
            '</div>' +
        '</div>');

    let last_select = jQuery('form#settings_form_commission-all .operation_currencies > div:last-child .commission_header select');
    let all_currencies =
        jQuery('form#settings_form_commission-all .operation_currencies > div:not(:last-child) .commission_header select, ' +
                'form#settings_form_commission-all .operation_currencies > div .commission_header');
    all_currencies.each(function() {
        let cur_val;
        if (jQuery(this).hasClass('currencies'))
            cur_val = jQuery(this).val();
        else
            cur_val = jQuery(this).text();
        last_select.find('option').each(function() {
            //console.log(jQuery(this));
           if (jQuery(this).val().toLowerCase() === cur_val.toLowerCase()) {
               jQuery(this).remove();
           }
        });
    });

    jQuery('form#settings_form_commission-all .operation_currencies > div:last-child .commission_header select').change(function() {
        //console.log(jQuery(this));
        let select_val = jQuery(this).val();
        let input = jQuery(this).parents('.commission_header').siblings('.input-exchange').children('input.commission');
        let input_name = input.attr('name');

        let name_split_right = input_name.split(']');
        let name_split_left = name_split_right[name_split_right.length - 2].split('[');
        name_split_left[name_split_left.length - 1] = select_val;
        name_split_right[name_split_right.length - 2] = name_split_left.join('[');
        input.attr('name', name_split_right.join(']'));
        //input.attr('name', input_name.replace(/\[(.*?)\]/g, '[' + select_val + ']'));
    });

    jQuery('form#settings_form_commission-all .operation_currencies > div:last-child a.settings_close').click(function() {
        jQuery(this).parents('.commission_header').parent().remove();
    });
}
function settings_add_operation()
{
    //let currency_name_template = jQuery('div.settings-commission .currency-template select');
    let currency_input_template = jQuery('.input_currency_template select.input_currencies');
    let currency_first_name = currency_input_template.find('option:first-child').val();

    let operation_item_content = jQuery('.operation_item:first-child .operation_currencies');

    jQuery('form#settings_form_commission-operations #operations').append(
       '<div class="col-12 operation_item">' +
        '<div class="row no-gutters">' +
            '<div class="col-2 operation_header">' +
                '<p class="operation_name">' +
                    '<select class="operation_type" name="percent[' + currency_first_name + '][type]">' +
                        '<option value="buy">Покупка</option>' +
                        '<option selected value="sell">Продажа</option>' +
                    '</select>' +
                    '<select class="operation_currency">' +
                        currency_input_template.clone().prop('innerHTML') +
                    '</select>' +
                    //currency_name_template.clone().prop('outerHTML') +
                '</p>' +
        '<!--                                <p class="acquiring-percent">комиссия эквайринга</p>-->' +
            '</div>' +
        
            '<div class="col-10">' +

                 '<div class="row no-gutters operation_currencies">' +
                    operation_item_content.clone().prop('innerHTML') +
                //     '<div class="col-2">' +
                //         '<p class="ruble-sign">комиссия эквайринга</p><!--₽-->' +
                //         '<div class="col-12 input-exchange input-custom-procent">' +
                //             '<input class="commission" value="2.5" type="text" name="percent[normal][acquiring]">' +
                //         '</div>' +
                //     '</div>' +
                //     '<div class="col-2">' +
                //         '<p class="commission_header">комиссия сайта</p>' +
                //         '<div class="col-12 input-exchange input-custom-procent">' +
                //             '<input class="commission" value="" placeholder="" type="text" name="percent[normal][site]">' +
                //         '</div>' +
                //     '</div>' +
                //     '<div class="col-2">' +
                //         '<p class="commission_header">SLAV</p>' +
                //         '<div class="col-12 input-exchange input-custom-procent">' +
                //             '<input class="commission" value="2" placeholder="" type="text" name="percent[normal][slav]">' +
                //         '</div>' +
                //     '</div>' +
                //     '<div class="col-2">' +
                //         '<p class="commission_header">PZM</p>' +
                //         '<div class="col-12 input-exchange input-custom-procent">' +
                //             '<input class="commission" value="3" placeholder="" type="text" name="percent[normal][prizm]">' +
                //         '</div>' +
                //     '</div>' +
                //     '<div class="col-2">' +
                //         '<p class="commission_header">ALT</p>' +
                //         '<div class="col-12 input-exchange input-custom-procent">' +
                //             '<input class="commission" value="5" placeholder="" type="text" name="percent[PZM][alt]">' +
                //         '</div>' +
                //     '</div>' +
                //     '<div class="col-3 currency_rate">' +
                //         '<p class="commission_header">курс</p>' +
                //         '<div class="col-12 input-exchange input-custom-rub">' +
                //             '<input disabled class="commission" value="" placeholder="" type="text">' +
                //         '</div>' +
                //     '</div>' +
                 '</div>' +
            '</div>' +
        '</div>' +
        '</div>');
    jQuery('form#settings_form_commission-operations .operation_item:last-child select.operation_type').change(function() {
        settings_change_operation_type(jQuery(this));

        let currency_input = jQuery(this).siblings('select.operation_currency');
        let rate = currency_input.find('option:first-child').attr('data-rate');
        currency_input.parents('.operation_header').next('div').find('div.currency_rate input.commission').val(rate);


        let currency_inputs = jQuery(this).parents('.operation_item')
            .find('.operation_currencies > div:not(.currency_rate):not(.operation_sum) input');
        // console.log(currency_inputs);
        // console.log(currency_input.find('option:first-child'));
        change_currency_input_names(currency_inputs, currency_input.find('option:first-child').val());

        change_input_single_name(jQuery(this), currency_input.find('option:first-child').val());
    });

    jQuery('form#settings_form_commission-operations .operation_item:last-child select.operation_currency').change(function() {
        let rate = jQuery(this).find('option:selected').attr('data-rate');
        jQuery(this).parents('.operation_header').next('div').find('div.currency_rate input.commission').val(rate);

        //Меняем name у каждого input currency

        let currency_inputs = jQuery(this).parents('.operation_item')
            .find('.operation_currencies > div:not(.currency_rate):not(.operation_sum) input');

        change_currency_input_names(currency_inputs, jQuery(this).val());

        let type_input = jQuery(this).siblings('select.operation_type');
        let type_name = type_input.attr('name');

        change_input_single_name(type_input, jQuery(this).val());

        //console.log(currency_inputs);
    });

    //remove operation
    jQuery('form#settings_form_commission-operations .operation_item:last-child .operation_currencies > div.remove_operation').click(function() {
        jQuery(this).parents('.operation_item').remove();
    });
}
function change_input_single_name(input, name)
{
    let cur_name = input.attr('name');
    let name_split_right_bracket = cur_name.split(']');
    let name_split_left_bracket = name_split_right_bracket[0].split('[');

    name_split_left_bracket[name_split_left_bracket.length - 1] = name;

    name_split_right_bracket[0] = name_split_left_bracket.join('[');

    let new_name = name_split_right_bracket.join(']');

    input.attr('name', new_name);
}

function change_currency_input_names(inputs, new_currency)
{
    inputs.each(function(index, item) {
        let input_name = jQuery(this).attr('name');

        if (typeof input_name !== "undefined" && input_name.length > 0)
        {

            let name_split_right_bracket = input_name.split(']');
            let name_split_left_bracket = name_split_right_bracket[0].split('[');

            name_split_left_bracket[name_split_left_bracket.length - 1] = new_currency;

            name_split_right_bracket[0] = name_split_left_bracket.join('[');

            let new_name = name_split_right_bracket.join(']');

            jQuery(this).attr('name', new_name);

            //let name_split_left = name_split_right_bracket[name_split_right_bracket.length - 2].split('[');
            // name_split_left[name_split_left.length - 1] = select_val;
            // name_split_right[name_split_right.length - 2] = name_split_left.join('[');
            // input.attr('name', name_split_right.join(']'));
            console.log(new_name);
        }
    });
}

function calc_operation(container_el)
{
    let rate = container_el.find('.currency_rate .input-custom-rub input').val();
    rate = rate.split(' ')[0];
    let percent_inputs = container_el.children(':not(.currency_rate):not(.operation_sum)').find('input.commission');

    var percent_sum = 0;

    jQuery.each(percent_inputs, function() {
        let val = jQuery(this).val();
        let parent = jQuery(this).parents('.input-exchange').parent();

        if (val.length > 0 && !isNaN(parseFloat(val)) && (parent.hasClass('active') || parent.hasClass('acquiring') || parent.hasClass('site') ) )
        {
            percent_sum += parseFloat(val);
        }
    });

    let sum = rate * (1 - (percent_sum / 100));
    sum = +sum.toFixed(3);
    console.log('percent: ' + percent_sum);
    console.log('rate: ' + rate);
    container_el.find('input.operation_sum').val(sum + ' RUB');
}

function settings_change_operation_type(el)
{
    let operation_type = el.val();
    let operation_currency_input = el.siblings('select.operation_currency');
    operation_currency_input.empty();
    switch (operation_type) {
        case 'buy':
            jQuery('.output_currency_template .output_currencies option').clone().appendTo(operation_currency_input);
            break;
        case 'sell':
            jQuery('.input_currency_template .input_currencies option').clone().appendTo(operation_currency_input);
            break;
    }
    //currency_name_template.clone().prop('outerHTML')
    //console.log(operation_currency_input);
}

var tooltip, // global variables oh my! Refactor when deploying!
    hidetooltiptimer;

function save_verification_form()
{
    let prizm_address = jQuery('input#prizm_address').val();
    let prizm_key = jQuery('input#prizm_public_key').val();
    let waves_address = jQuery('input#waves_address').val();
    let form = jQuery('form#profile_verification');

    let form_obj = {};

    form.find('input:not("#submit_verification")').each((index, val) => {
        let el = jQuery(val);
        if (el.attr('id') !== 'passport_photos')
            form_obj[el.attr('name')] = el.val();
        else
        {
            return true;//continue loop //form_obj[el.attr('name')] = /*JSON.stringify(*/el.prop('files')/*)*/;
            //console.log(el.prop('files'));
        }
    });

    //console.log(form_obj);
    sessionStorage.setItem("prizm_address", prizm_address);
    sessionStorage.setItem("prizm_key", prizm_key);
    sessionStorage.setItem("waves_address", waves_address);
    sessionStorage.setItem("form", JSON.stringify(form_obj));

    //sessionStorage.setItem("passport_photos", JSON.stringify(jQuery('input#passport_photos').prop('files')));


    //console.log(jQuery('input#passport_photos'));
}

function get_verification_form()
{
    // If values are not blank, restore them to the fields
    var prizm_address = sessionStorage.getItem('prizm_address');
    if (prizm_address !== null) jQuery('#prizm_address').val(prizm_address);

    var prizm_key = sessionStorage.getItem('prizm_key');
    if (prizm_key !== null) jQuery('#prizm_public_key').val(prizm_key);

    var waves_address= sessionStorage.getItem('waves_address');
    if (waves_address!== null) jQuery('#waves_address').val(waves_address);

    var form= sessionStorage.getItem('form');
    if (form!== null && form !== 'undefined')
    {
        let form_el = jQuery('form#profile_verification');
        let form_data = JSON.parse(form);
        Object.keys(form_data).forEach(function(property)
        {
            if (form_data[property] !== '') {
                if (property.indexOf('passport_photos') === -1)
                    form_el.find('input[name="' + property + '"]').val(form_data[property]);
                else {
                    return true; //continue loop
                    // let files = form_data[property];
                    // console.log(files);
                    // try {
                    //     var o = JSON.parse(files);
                    //     if (o && typeof o === "object") {
                    //         form_el.find('input[name="' + property + '"]').prop('files', o);
                    //     }
                    // }
                    // catch (e) {
                    //
                    // }
                }
            }
        });
    }

    // var photos = sessionStorage.getItem('passport_photos');
    // if (photos!== null && photos !== 'undefined' && typeof photos === 'object')
    // {
    //     jQuery('input#passport_photos')[0].files = photos;
    // }
    // console.log(photos);
}

function createtooltip(){ // call this function ONCE at the end of page to create tool tip object
    tooltip = document.createElement('div')
    tooltip.style.cssText =
        'position:absolute; background:black; color:white; padding:4px;z-index:10000;'
        + 'border-radius:2px; font-size:12px;box-shadow:3px 3px 3px rgba(0,0,0,.4);'
        + 'opacity:0;transition:opacity 0.3s'
    tooltip.innerHTML = 'Скопировано!'
    document.body.appendChild(tooltip)
}

function showtooltip(e){
    var evt = e || event
    clearTimeout(hidetooltiptimer)
    tooltip.style.left = evt.pageX - 10 + 'px'
    tooltip.style.top = evt.pageY + 15 + 'px'
    tooltip.style.opacity = 1
    hidetooltiptimer = setTimeout(function(){
        tooltip.style.opacity = 0
    }, 500)
}

function search_ajax(el, search_data, callback, output_el)
{
    let data = {
        search: search_data
    };
    jQuery.post( window.location, data, function(response) {
        callback(response, output_el)
    });
}
function remove_ref_user(element)
{
    var parent = element.parents('.select-exchange');
    var el = element.parents(".input-exchange");
    var nextSiblings = el.nextAll();
    //Разрешаем во всех последующих select выбор опции из удаляемого select
    var allow_value = el.find('select').val();
    var allow_option = el.find('select').find('option').filter(function(){return this.value==allow_value});
    if (nextSiblings.length > 0)
    {
        //при удалении пользователя смещаем все индексы на 1 влево
        jQuery.each(nextSiblings, function(){
            var item = jQuery(this);
            let select = item.find('select');
            let input = item.find('input.ref_value');

            //Получаем индекс данного элемента
            let split_id = select.attr('id').split("_");
            let ref_index = split_id[split_id.length - 1];

            split_id[split_id.length - 1] = ref_index - 1;
            let new_id = split_id.join('_');

            select.attr('id', new_id);

            var select_name = select.attr('name');
            var arr = select_name.split('');
            var removed = arr.splice(
                select_name.indexOf('[') + 1,
                select_name.indexOf(']') - select_name.indexOf('[') - 1,
                ref_index - 1); // arr is modified
            select_name = arr.join('');

            select.attr('name', select_name);

            var input_name = input.attr('name');
            arr = input_name.split('');
            removed = arr.splice(
                input_name.indexOf('[') + 1,
                input_name.indexOf(']') - input_name.indexOf('[') - 1,
                ref_index - 1); // arr is modified
            input_name = arr.join('');

            input.attr('name', input_name);

            //Добавляем в каждый из последующих select выбранную опцию из удаляемого select
            select.append('<option value="' + allow_value + '">' + allow_option.text() + '</option>');

        });
    }
    el.remove();
}
// function get_users()
// {
//     let data = {
//         get_users: 'true'
//     };
//     jQuery.post( window.location, data, function(response) {
//         console.log(response);
//         if (response) {
//             let users = JSON.parse(response);
//             for (var key in users)
//             {
//                 console.log(users[key]);
//             }
//             window.users = users;
//         }
//     });
// }
function init_ref_buttons()
{
    //Удалить операцию
    jQuery('.ref_unpaid .remove_operation, .ref_paid .remove_operation').click(function(){
        let date = jQuery(this).parent().siblings('.ref_date').text();
        let host_name = jQuery(this).parent().siblings('.host_name').text();
        let ref_name = jQuery(this).parent().siblings('.ref_name').text();
        let award_sum = jQuery(this).parent().siblings('.ref_sum').text();
        let split_sum = award_sum.split(' ');
        //Сумма - все перед первым пробелом
        let sum = split_sum.shift();
        //console.log("sum: ",sum);
        let currency = split_sum.join(' ');
        //console.log("currency: ", currency);
        //console.log('sum: ', 0);
        //let host_id = jQuery(this).parents('.table-text').attr('data-user-id');
        var data = {
            ref_remove: 'true',
            ref_data: {
                //host_id: host_id,
                date: date,
                host_name: host_name,
                ref_name: ref_name,
                award_sum: sum,
                award_currency: currency
            }
        };
        // console.log("data:");
        // console.log(data);
        var el = jQuery(this);

        if (confirm("Удалить данную операцию?") == true) {
            jQuery.post(window.location, data, function (response) {
                console.log(response);
                if (response == 'true') {
                    el.parents('.table-text').remove();
                }
            });
        }
        else
            return;
    });

    //По клику получить exchange_requests и stats для этого пользователя
    jQuery('.ref-tab__content .host_name').click(function(){
        let el = jQuery(this);
        let modal = jQuery('#modal-container-54506522');
        let request_user_id = el.parents('.table-text').attr('data-user-id');

        var data = {
            request_user_id: request_user_id,
            get_user_operations: 'true',
            get_user_stats: 'true'
        };
        jQuery.post( window.location, data, function(response) {
            if (response) {
                let user_data = JSON.parse(response);
                if (response.exchange_content !== '') {
                    modal.find('.modal-content > #exchange_content .table-text').remove();
                    modal.find('.modal-content > #exchange_content').append(user_data.exchange_content);
                }
                if (response.stats_content !== '') {
                    modal.find('.modal-content > #stats_content .table-text').remove();
                    modal.find('.modal-content > #stats_content').append(user_data.stats_content);
                }
                if (response.verification_content !== '')
                {
                    if (user_data.verification_content !== 'false') {
                        modal.find('.modal-content > #verification_content').children().not('#no_verification').css('display', 'block');
                        modal.find('.modal-content > #verification_content #no_verification').css('display', 'none');
                        let verification_data = user_data.verification_content;

                        jQuery.each(verification_data, function (item) {
                            if (item !== 'passport_photos')
                                if (modal.find('.verification_' + item).length > 0)
                                    modal.find('.verification_' + item).val(verification_data[item]);
                        });
                        //Очищаем место для фотографий
                        modal.find('.passport-photo').children('.row').empty();

                        jQuery.each(verification_data['passport_photos'], function (photo) {
                            modal.find('.passport-photo').children('.row')
                                .append('<div class="col-lg-4">' +
                                    '<div class="row">' +
                                    '<img src="' + verification_data['passport_photos'][photo] + '">' +
                                    '</div>' +
                                    '</div>');
                            //console.log(verification_data['passport_photos'][photo]);
                        });
                        //jQuery('#modal-54506521').trigger('click');
                    }
                    else
                    {
                        modal.find('.modal-content > #verification_content').children().css('display', 'none');
                        modal.find('.modal-content > #verification_content #no_verification').css('display', 'block');
                    }
                    //console.log('Нет верификации для этого пользователя');
                }
                if (response.userdata_content !== '')
                {
                    let userdataContent = user_data.userdata_content;
                    let userdata_inputs = modal.find('#userdata_content input');
                    jQuery.each(userdataContent, function (item) {
                        if (modal.find('#userdata_content input.' + item).length > 0) {
                            if (item === 'is_verified') {
                                if (userdataContent[item] === '')
                                    modal.find('#userdata_content input.' + item).val('Нет');
                                else
                                    modal.find('#userdata_content input.' + item).val('Да');
                            }
                            else
                                modal.find('#userdata_content input.' + item).val(userdataContent[item]);
                        }
                    });
                }
                jQuery('#modal-54506522').trigger('click');

            }
        });
    });

    jQuery('.ref_unpaid .btn-ref').click(function(){
        let date = jQuery(this).parent().siblings('.ref_date').text();
        let host_name = jQuery(this).parent().siblings('.host_name').text();
        let ref_name = jQuery(this).parent().siblings('.ref_name').text();
        let award_sum = jQuery(this).parent().siblings('.ref_sum').text();
        let split_sum = award_sum.split(' ');
        //Сумма - все перед первым пробелом
        let sum = split_sum.shift();
        //console.log("sum: ",sum);
        let currency = split_sum.join(' ');
        //console.log("currency: ", currency);
        //console.log('sum: ', 0);
        var data = {
            ref_approve: 'true',
            ref_data: {
                date: date,
                host_name: host_name,
                ref_name: ref_name,
                award_sum: sum,
                award_currency: currency
            }
        };
        // console.log("data:");
        // console.log(data);
        var el = jQuery(this);

        jQuery.post( window.location, data, function(response) {
            // console.log("response: ");
            // console.log(response);
            if (response == 'true') {
                el.parents('.table-text').remove();
            }
        });
    });
}

jQuery(document).ready(function(){
    // jQuery('#login-form-rcl .link-remember-rcl').click(function() {
    //     console.log("aaa");
    //     rcl_show_login_form_tab('remember');
    // })
    tab_config();
});

window.onload = function() {
    //Если вкладка профиля
    if (jQuery('form#profile_verification').length > 0 && jQuery('div#tab-profile').length > 0)
        get_verification_form();
};
window.addEventListener('beforeunload', function (e) {
    //Если вкладка профиля
    if (jQuery('form#profile_verification').length > 0 && jQuery('div#tab-profile').length > 0)
        save_verification_form();
    delete e['returnValue'];
});

rcl_add_action('rcl_upload_tab','tab_config');
function tab_config()
{
    //Сохранение адресов prizm, slav и публичного ключа
    //jQuery('input#waves_address, input#prizm_address, input#prizm_public_key').blur(function() {
        //if (e.which == 13) {
            //jQuery('form#profile_verification').submit();
        //}
    //});

    jQuery('form#personal_deposit').submit(function() {
       console.log("personal submit");
    });

    jQuery('#other_payments_is_reserve input[type=checkbox]').change(function() {
        if (jQuery(this).is(':checked')) {
            jQuery('#other_payments_reserve_id').css('visibility', 'visible');
            jQuery('#other_payments_reserve_id select').attr('required', 'required');

            jQuery('#other_payments_is_public input[type=checkbox]').attr('disabled', 'disabled');
        }
        else {
            jQuery('#other_payments_reserve_id').css('visibility', 'hidden');
            jQuery('#other_payments_reserve_id select').removeAttr('required');

            jQuery('#other_payments_is_public input[type=checkbox], #other_payments_is_save input[type=checkbox]').removeAttr('disabled');
        }
    });
    jQuery('#other_payments_is_public input[type=checkbox]').change(function() {
        if (jQuery(this).is(':checked')) {
            jQuery('#other_payments_is_reserve input[type=checkbox]').attr('disabled', 'disabled');
        }
        else {
            jQuery('#other_payments_is_reserve input[type=checkbox]').removeAttr('disabled');
        }
    });
    jQuery('#personal_deposit_reserve_id').change(function() {
        jQuery('#other_payments_is_public input[type=checkbox], #other_payments_is_save input[type=checkbox]').attr('disabled', 'disabled');
    });
    //selectize for search in assets in exchange
    /*jQuery('.other_payments.input_currency').selectize({
        onInitialize: function () {
            var s = this;
            this.revertSettings.$children.each(function () {
                jQuery.extend(s.options[this.value], jQuery(this).data());
            });
        },
        onChange: function (value) {
            var option = this.options[value];
            jQuery('select.other_payments.input_currency option:selected').attr('data-requisites', option.requisites).attr('data-rate', option.rate);
            //console.log(this);
            //alert('requisites: ' + option.rate);
            //jQuery(this).attr('data-rate', option.rate).attr('data-requisites', option.requisites);
        },
        sortField: 'text'
    });
    jQuery('.other_payments.output_currency').selectize({
        onInitialize: function () {
            var s = this;
            this.revertSettings.$children.each(function () {
                jQuery.extend(s.options[this.value], jQuery(this).data());
            });
        },
        onChange: function (value) {
            var option = this.options[value];
            jQuery('select.other_payments.output_currency option:selected').attr('data-requisites', option.requisites).attr('data-rate', option.rate);
            //console.log(this);
            //alert('requisites: ' + option.rate);
            //jQuery(this).attr('data-rate', option.rate).attr('data-requisites', option.requisites);
        },
        sortField: 'text'
    });

    jQuery('.other_deposit.input_currency').selectize({
        onInitialize: function () {
            var s = this;
            this.revertSettings.$children.each(function () {
                jQuery.extend(s.options[this.value], jQuery(this).data());
            });
        },
        onChange: function (value) {
            var option = this.options[value];
            jQuery('select.other_deposit.input_currency option:selected').attr('data-requisites', option.requisites).attr('data-rate', option.rate);
            //console.log(this);
            //alert('requisites: ' + option.rate);
            //jQuery(this).attr('data-rate', option.rate).attr('data-requisites', option.requisites);
        },
        sortField: 'text'
    });*/

    //close nested menu when click outside
    jQuery(document).on("click", function(event) {

        if (!jQuery(event.target).closest(".menu-list").length && !jQuery(event.target).closest(".nested_menu").length) {

            jQuery(".menu-list").slideUp("normal");
        }
    });

    //remove currency
    jQuery('form#settings_form_commission-all .operation_currencies a.settings_close').click(function() {
        jQuery(this).parents('.commission_header').parent().remove();
    });

    //remove operation
    jQuery('form#settings_form_commission-operations .operation_currencies .remove_operation').click(function() {
        jQuery(this).parents('.operation_item').remove();
    });

    //selecting currency for calculation
    jQuery('form#settings_form_commission-operations .operation_currencies > div.currency_percent').click(function() {
        jQuery(this).parents('.operation_currencies').children().removeClass('active');
        jQuery(this).addClass('active');

        calc_operation(jQuery(this).parents('.operation_currencies'));
    });
    //calc operation sum
    jQuery('form#settings_form_commission-operations .operation_item').each(function() {
        let currencies = jQuery(this).find('.operation_currencies');

        calc_operation(currencies);

    });


    jQuery('form#settings_form_commission-all + div #add_currency').click(function() {
        settings_add_currency_percent();
    });

    jQuery('form#settings_form_commission-operations + div #add_operation').click(() => {
        settings_add_operation();
    });

    jQuery('form#settings_form_commission-operations select.operation_type').change(function() {
        settings_change_operation_type(jQuery(this));
        //console.log("yes");
        let currency_input = jQuery(this).siblings('select.operation_currency');
        let rate = currency_input.find('option:first-child').attr('data-rate');
        currency_input.parents('.operation_header').next('div').find('div.currency_rate input.commission').val(rate);

        let currency_inputs = jQuery(this).parents('.operation_item')
            .find('.operation_currencies > div:not(.currency_rate):not(.operation_sum) input');
        // console.log(currency_inputs);
        // console.log(currency_input.find('option:first-child'));
        change_currency_input_names(currency_inputs, currency_input.find('option:first-child').val());

        change_input_single_name(jQuery(this), currency_input.find('option:first-child').val());

        calc_operation(jQuery(this).parents('.operation_item').find('.operation_currencies'));
    });

    jQuery('form#settings_form_commission-operations select.operation_currency').change(function() {
        let rate = jQuery(this).find('option:selected').attr('data-rate');
        jQuery(this).parents('.operation_header').next('div').find('div.currency_rate input.commission').val(rate);

        //Меняем name у каждого input currency

        let currency_inputs = jQuery(this).parents('.operation_item')
            .find('.operation_currencies > div:not(.currency_rate):not(.operation_sum) input');
        change_currency_input_names(currency_inputs, jQuery(this).val());

        let type_input = jQuery(this).siblings('select.operation_type');
        //let type_name = type_input.attr('name');

        change_input_single_name(type_input, jQuery(this).val());

        //console.log(jQuery(this).parents('.operation_item').find('.operation_currencies'));
        calc_operation(jQuery(this).parents('.operation_item').find('.operation_currencies'));
        //console.log(currency_inputs);
    });

    // jQuery('.verification_title .verification_video_link').click((e) => {
    //     jQuery(this).trigger('click');
    // });

    jQuery('.verification_title').click(function(event) {

        if (jQuery(event.target).hasClass('info-href') || jQuery(event.target).hasClass('verification_video_link')) {
            jQuery(event.target).trigger('click');
            return false;
        }
        let form = jQuery(this).siblings('form#profile_verification');
        let img = jQuery(this).find('img.verification_close-btn');
        let display = form.css('display');
        if (display === 'none')
        {
            form.slideDown("slow");
            img.attr('src', '/wp-content/uploads/2019/12/open.png');
        }
        else
        {
            form.slideUp("slow");
            img.attr('src', '/wp-content/uploads/2019/12/close.png');
        }
    });

    jQuery('#exchange_waves_btn').click(() => {
        window.open('https://waves.exchange/', '_blank');
    });

    jQuery('#exchange_chat_btn').click(() => {
        Tawk_API.toggle();
    });

    jQuery('.ref-tab__content.' + jQuery('.referral-tabs__item.active').attr('id') ).css('display', 'block');

    jQuery('.referral-tabs__item').click(function() {
        jQuery('.referral-tabs__item').removeClass('active');
        jQuery(this).addClass('active');

        let cur_id = jQuery(this).attr('id');
        jQuery('.ref-tab__content').css('display', 'none');

        let new_content_tab = jQuery('.ref-tab__content.' + cur_id);

        let ref_user_id = new_content_tab.attr('data-user_id');
        let operation_type = cur_id.split('_')[1];

        if (operation_type == 'paid' || operation_type == 'unpaid') {

            var data = {
                ref_user_id: ref_user_id,
                get_ref_operations: 'true',
                operation_type: operation_type
            };

            jQuery.post(window.location, data, function (response) {
                //console.log(response);
                if (response) {
                    let response_data = JSON.parse(response);
                    let operations = response_data.operations;
                    let is_manager = response_data.is_manager;

                    let operations_container = new_content_tab.children(':first');
                    operations_container.children('.table-title ~ .table-text').remove();

                    if (operations !== false) {
                        operations.forEach(function (operation) {
                            let operation_status = '';
                            switch (operation["status"]) {
                                case "processing":
                                    operation_status = 'В обработке';
                                    break;
                                case "paid":
                                    operation_status = 'Выплачено';
                                    break;
                            }
                            let template = '<div class="table-text w-100" data-user-id="' + operation['host_id'] + '">' +
                                '<div class="row">' +
                                '<div class="col-2 text-left ref_date">' + operation['date'] + '</div>' +
                                '<div class="col-2 text-left host_name">' + operation['host_name'] + '</div>' +
                                '<div class="col-2 text-left ref_name">' + operation['ref_name'] + '</div>' +
                                '<div class="col-2 text-left ref_sum">' + (+operation["award_sum"].toFixed(2)) + ' ' + operation["award_currency"] + '</div>' +
                                '<div class="col-3 text-center">' +
                                '<p>' + operation_status + '</p>';

                            if (is_manager == true && operation['status'] == 'processing')
                                template += '<div class="btn-custom-one btn-ref">' +
                                    'Выплатить' +
                                    '</div>';

                            template += '</div>' +
                                '<div class="col-1 text-left">' +
                                '<a class="remove_operation">×</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            operations_container.append(template);
                        });
                        init_ref_buttons();
                        new_content_tab.css('display', 'block');
                    }
                }

            });
        }
        else
            new_content_tab.css('display', 'block');

    });
    //jQuery("#username_input, #rcl-field-user_email, #rcl-field-user_phone, #prizm_address, #prizm_public_key, #waves_address").blur(function() {
        //     jQuery(this).parents("form").submit();
        // });
        jQuery("#rcl-field-user_phone").change(function() {
                 jQuery(this).parents("form").submit();
             });
    // //submit формы по потере фокуса в профиле
    // jQuery("#username_input, #rcl-field-user_email, #rcl-field-user_phone, #prizm_address, #prizm_public_key, #waves_address").blur(function() {
    //     jQuery(this).parents("form").submit();
    // });

    jQuery("#user_ref_link, #client_num").prop("disabled", true); //#prizm_address, #prizm_public_key, #waves_address
    //var bank_inputs = jQuery("#settings_form").find("input");
    //submit формы по потере фокуса в настройках
    // bank_inputs.blur(function() {
    //     // jQuery('#settings_form input[type=hidden]').each(function(el){
    //     //     jQuery(this).val(jQuery(this).siblings("span").text());
    //     // })
    //     jQuery(this).parents("#settings_form").submit();
    // });

    //Открывать ссылки в новой вкладке
    jQuery('div.passport-text a').attr('target', '_blank');

    //Добавить новый банк
    jQuery("#add_bank").click(function(){
        var banks = jQuery(this).parents(".coop_maps.question-bg").children(".col-12").children("form.row").children();
        let new_row_style;
        if (banks.length % 3 === 0)
            new_row_style = "text-align: left";
        else
            new_row_style = "";

        jQuery(this).parents(".coop_maps.question-bg").children(".col-12").children("form.row")
            .append("<div class='col-lg-4 input-exchange input-custom-rubl' style='" + new_row_style + "'>" +
                        "<div class='row '>" +
                            "<a class='settings_close'>&times;</a>" +
                            //"<span class='select-exchange'>Название банка " + (banks.length + 1) + "</span>" +
                            //"<input type='hidden' name='bank" + (banks.length + 1) + "[name]' value=''>" +
                            "<div class='select-exchange w-100'>" +
                "<input value='Название банка " + (banks.length + 1) + "' type='text' name='bank" + (banks.length + 1) + "[name]' style='background: #fff'>" +
                                "<input value='0.25' type='text' name='bank" + (banks.length + 1) + "[value]'>" +
                            "</div>" +
                        "</div>" +
                    "</div>");

        jQuery("#settings_form_banks .input-exchange:last-child").mouseover(function() {
            jQuery(this).find(".settings_close").css('visibility', 'visible');
        });
        jQuery("#settings_form_banks .input-exchange:last-child").mouseout(function() {
            jQuery(this).find(".settings_close").css('visibility', 'hidden');
        });

        jQuery('#settings_form_banks .input-exchange:last-child .settings_close').click(function(){
            jQuery(this).parents(".input-exchange").remove();
        });
    });

    //Добавить процент по рефералке для нового пользователя
    jQuery("#add_ref_user").click(function(){
        var users = jQuery(this).parents(".coop_maps.question-bg").children(".col-12").children("form.row").children();
        // let new_row_style;
        // if (users.length % 3 === 0)
        //     new_row_style = "text-align: left";
        // else
        //     new_row_style = "";
        var user_dropdown = jQuery('#user_dropdown_template').find('select');
        var user_dropdown_innerHTML = jQuery('#user_dropdown_template')[0].innerHTML;

        var ref_count = jQuery('#settings_form_ref').children().length;
        var user_dropdown_name = 'ref_user[' + ref_count + '][id]';
        var input_name = 'ref_user[' + ref_count + '][value]';
        //user_dropdown.attr('name', user_dropdown_name);
        //user_dropdown.attr('id', 'ref_user_' + ref_count);

        //Назначаем всех разрешенных для добавления пользователей
        var dropdown_banned_users = jQuery(user_dropdown_innerHTML);
        jQuery(this).parents(".coop_maps.question-bg").children(".col-12").children("form.row").children().each(function(index, el){
            let banned_value = jQuery(el).find('select').val();
            dropdown_banned_users.find('option').filter(function(){return this.value==banned_value}).remove();
            //dropdown_banned_users.find('option[value="' + banned_value + '"]').remove();
        });

        dropdown_banned_users.attr('id', 'ref_user_' + ref_count);
        dropdown_banned_users.attr('name', user_dropdown_name);


        jQuery(this).parents(".coop_maps.question-bg").children(".col-12").children("form.row")
             .append("<div class='col-lg-4 input-exchange input-custom-procent'>" +
                        "<div class='row' style='height: 100%; padding-top: 30px'>" +
                            "<div class='select-exchange w-100'>" +
                                "<div class='row'>" +
                                    "<div class='col-8'>" +
                                        "<span class='select-exchange' style='display: inline-block'>Пользователь</span>" +
                                    "</div>" +
                                    "<div class='col-4'>" +
                                        "<a class='settings_close' style='display: inline-block; margin-left: -20px; margin-top: -5px'>&times;</a>" +
                                    "</div>" +
                                "</div>" +
                                dropdown_banned_users[0].outerHTML + //user_dropdown[0].outerHTML +
                                "<input class='ref_value' value='0.5' type='text' name='" + input_name + "'>" +
                            "</div>" +
                        "</div>" +
                      "</div>");   //jQuery('#user_dropdown_template').find('select')[0].outerHTML);

        jQuery("#settings_form_ref .input-exchange:last-child").mouseover(function() {
            jQuery(this).find(".settings_close").css('visibility', 'visible');
        });
        jQuery("#settings_form_ref .input-exchange:last-child").mouseout(function() {
            jQuery(this).find(".settings_close").css('visibility', 'hidden');
        });

        jQuery('#settings_form_ref .input-exchange:last-child .settings_close').click(function(){
            remove_ref_user(jQuery(this));
        });
    });


    //Вывод кнопки удаления банка
    jQuery('.input-exchange').mouseover(function() {
        jQuery(this).find(".settings_close").css('visibility', 'visible');
    });
    jQuery('.input-exchange').mouseout(function() {
        jQuery(this).find(".settings_close").css('visibility', 'hidden');
    });

    jQuery('#settings_form_banks .settings_close').click(function(){
        jQuery(this).parents(".input-exchange").remove();
    });

    jQuery('#settings_form_ref .settings_close').click(function(){
        remove_ref_user(jQuery(this));
    });

    //exchange
    //open and close mobile form exchange
    jQuery('.ex-header').click(function(e){
        //let forbid_tags = ['BUTTON', 'INPUT', 'SELECT', 'OPTION'];
        // if ( forbid_tags.includes(jQuery(e.target).prop("tagName")) || //Запрещаем закрытие на мобиле при нажатии на определенные теги
        //     jQuery(e.target).hasClass('btn-custom-one') ||
        //     jQuery(e.target).hasClass('btn-custom-two') )
        // {
        //     return false;
        // }

        var id = jQuery(this).parent().attr('id');
        var block = jQuery('#'+id+ ' .tab-ex').css('display');
        if (block == 'none')
        {
            jQuery('#' + id + ' .tab-ex').slideDown("slow");
            jQuery('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/open.png')
        }
        else
        {
            jQuery('#' + id + ' .tab-ex').slideUp("slow");
            jQuery('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/close.png')
        }
    });
    

    //Кастомный вывод фотографий паспорта

    jQuery( '#passport_photos' ).each( function()
    {
        var $input	 = jQuery( this ),
            $label	 = $input.next( 'label' ),
            labelVal = $label.html(),
            photo_container = jQuery(this).parents('.skrepka').siblings('.passport_photos_container');

        $input.on( 'change', function( e )
        {
            var fileName = '';

            if( this.files && this.files.length > 1 ) {
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            }
            else if( e.target.value ) {
                fileName = e.target.value.split('\\').pop();
            }

            photo_container.empty();

            for (let i = 0; i < this.files.length; i++) {
                var fileReader = new FileReader();
                fileReader.readAsDataURL(this.files[i]);

                fileReader.onload = function (e) {
                    let img_url = e.target.result;
                    photo_container.append('<img src="' + img_url + '">');
                };
            }

            if( fileName )
                $label.html( fileName );
            else
                $label.html( labelVal );
        });

        // Firefox bug fix
        $input
            .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
            .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
    });

    jQuery('.profile_video button.close.ib').click(function(){
        let video = jQuery(this).parents('.modal-content').find('video');
        if (video.length > 0)
            video.trigger('pause');
    });

    //Фильтрация

    jQuery('.search-btn').click(function(){
        let search_bar = jQuery(this).siblings('.search');
        if (search_bar.css('display') === 'none')
            search_bar.show();
        else
            search_bar.hide();
    });

    jQuery(".datepicker").datepicker({
        onSelect: function(d,obj){
            if(d !== obj.lastVal){
                jQuery(this).change();
            }
        },
        constrainInput: true,
        showOn: 'button',
        buttonText: '',
        buttonImage: "/wp-content/uploads/2019/12/calendar.png"
    });

    //Блокируем ненужные символы
    //Где блокировать все кроме цифр
    var number_fields =
        [
            '.prizm_to_rubles', '.rubles_to_prizm', '.rubles_to_waves', '#exp', '.other_payments_input',
            '.exp_custom', 'input.other_deposit', '.personal_deposit_input:not(.currency_name)', //Поля страницы обмена
            '.bank_value', '.ref_value', //Поля страницы настроек
            '#rcl-field-user_phone', 'input[name="verification[passport_number]"]',
            'input[name="verification[passport_code]"]' //Страница профиля
        ];

    var exchange_inputs =
        [
            '.prizm_to_rubles',
            '.rubles_to_prizm',
            '.rubles_to_waves',
            '#exp',
            '.other_payments_input',
            '.exp_custom',
            'input.other_deposit',
            '.personal_deposit_input:not(.currency_name)'
        ];
    var exchange_selector = exchange_inputs.join(', ');

    //Защита от подделки данных на фронте*****************
    jQuery(exchange_selector).prop('unselectable', 'on').on('selectstart', false);

    jQuery(exchange_selector).prop('autocomplete', 'off');

    //Выставляем атрибуты при каждом клике мыши, если не выставлены
    jQuery(exchange_selector).mousedown(function(){
        let unselectable = jQuery(this).prop('unselectable');
        let autocomplete = jQuery(this).prop('autocomplete');

       if (unselectable === 'undefined' || unselectable !== 'on')
           jQuery(this).prop('unselectable', 'on');

        if (autocomplete === 'undefined' || autocomplete !== 'off')
            jQuery(this).prop('autocomplete', 'off');
    });
    jQuery(exchange_selector).bind('cut copy paste', function (e) {
        e.preventDefault();
    });

    //Disable mouse right click
    jQuery(exchange_selector).on("contextmenu",function(e){
        return false;
    });
    /**********************************************************************************/

    jQuery(number_fields.join(', ')).keydown(function(event) {
        var code = (event.keyCode ? event.keyCode : event.which);

        //console.log(!((code == 190 || code == 110) && jQuery(this).val().indexOf('.') != -1));
        //Проверяем на допустимые символы
        var is_allowed = ( ( (code >= 48 && code <= 57) || (code >= 96 && code <=105)) //96 to 105 - numpad
            || ((code == 190 || code == 110) //numbers || period
            && !((code == 190 || code == 110) && jQuery(this).val().indexOf('.') != -1)) //уже есть точка (110 - numpad dot)
            || code == 8 || code == 13 || code == 9 || code == 144 //144 - numlock
            || code == 37 || code == 39); //37-left arrow, 39 - right arrow
        //user_phone, verification inputs
        if ((jQuery(this).attr('id') === 'rcl-field-user_phone' ||
        jQuery(this).attr('name') === 'verification[passport_number]' ||
        jQuery(this).attr('name') === 'verification[passport_code]') && (code == 190 || code == 110))
            is_allowed = false;
        else
            if ((jQuery(this).attr('id') === 'rcl-field-user_phone' ||
                jQuery(this).attr('name') === 'verification[passport_number]' ||
                jQuery(this).attr('name') === 'verification[passport_code]') && (code == 32 || code == 109 || code == 173) )
                    is_allowed = true;
        if (!is_allowed) {
            event.preventDefault();
            return false;
        }
    });
    // jQuery(number_fields.join(', ')).on('input',function(event) {
    //     let value = jQuery(this);
        // if(parseFloat(value.val()) == ''){
        //     value.val('');
        // }
        // if(value.val().match(/./g).length > 1){
        //     console.log('yep');
        // }
        // if(value.val().indexOf('.')){
        //     console.log(value.val().indexOf('.'))
        // }
        //console.log(value.val());
        // if(value.val().indexOf('.') == -1 && parseFloat(value.val())){
        //     value.val(parseFloat(value.val()));
        // }

        // if((/\D/).test(value.val()) ){
        //     value.val(parseFloat(value.val()));
        // }
        // if(!parseFloat(value.val()) ){
        //     value.val('0');
        // }else {

        // }


        // if(!value.val()){
        //     value.val('0');
        // } else {
        //     value.val(parseInt(value.val()));
        // }
        // if (!is_allowed) {
        //     event.preventDefault();
        //     return false;
        // }
    //})

    jQuery('.copy-btn').click(function(e){
        var inputCopy = jQuery(this).prev()[0];
        console.log(inputCopy);
        var disabled = inputCopy.disabled;
        var type = inputCopy.type;
        if (disabled)
            inputCopy.disabled = false;
        if (type === 'email' || type === 'url')
            inputCopy.type = 'text';
        inputCopy.focus();
        inputCopy.select();
        inputCopy.setSelectionRange(0, inputCopy.value.length);
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Copying text command was ' + msg);
            if (disabled)
                inputCopy.disabled = true;
            if (type === 'email' || type === 'url')
                inputCopy.type = type;
            showtooltip(e);
        }
        catch (err) {
            console.error('Oops, unable to copy', err);
        }
    });

    createtooltip();


    // jQuery('#profile_verification').on('submit', function(e) {
    //     e.preventDefault();
    //     var fileInput = jQuery('#passport_photos');
    //     console.log(fileInput);
    //     var files = fileInput[0].files;
    //     var verification_form = document.getElementById('profile_verification');
    //      var form_data = new FormData(verification_form);
    //      //form_data.delete("verification[photos]");
    //     //var index = 1;
    //     for(var i=0; i<files.length; i++) {
    //         //let field_name = 'verification[photo' + (i + 1) + ']';
    //         var today = new Date();
    //         var dd = String(today.getDate()).padStart(2, '0');
    //         var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    //         var yyyy = today.getFullYear();
    //         var h = today.getHours();
    //         var m = today.getMinutes();
    //         var s = today.getSeconds();
    //         today = yyyy + '-' + mm + '-' + dd;
    //         let file_name = 'passport_photo_' + today + '-' + h + m + s;
    //
    //         var blob = files[i].slice(0, files[i].size, 'image/*');
    //         newFile = new File([blob], file_name, {type: blob.type});
    //         console.log(newFile);
    //         fileInput[0].files[i] = newFile;
    //         //form_data.set(field_name, files[i], file_name);
    //     }
    //     verification_form.submit();
    // });

};
