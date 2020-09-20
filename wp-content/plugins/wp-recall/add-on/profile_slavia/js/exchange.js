const DEFAULT_REQUISITE = '3PAM1XRQG4cpvh15evZenJWvXBAcTcC2jjt';

function request_get_user_id(el)
{
    let request_user_id = el.attr('id');
    request_user_id = request_user_id.split('_');
    request_user_id = request_user_id[request_user_id.length - 1];
    request_user_id = parseInt(request_user_id);
    return request_user_id;
}
//Задаем элемент, в котором был произведен ввод и функция делает вывод в соседний input
function other_payments_print_result(input_el)
{
    let output_el;
    let input_sum = input_el.val();
    let percent;
    let output_percent = jQuery('select.other_payments.output_currency option:selected').attr('data-percent');
    let input_percent = jQuery('select.other_payments.input_currency option:selected').attr('data-percent');
    if (output_percent !== '' && output_percent !== undefined)
        percent = output_percent;
    else
    if (input_percent !== '' && input_percent !== undefined)
        percent = input_percent;
    else
        percent = false;

    //console.log(percent);
    //console.log(input_sum);

    if (input_el.hasClass('other_payments_input')) //Введена вносимая сумма
    {
        output_el = input_el.parents('.input-exchange').siblings('.input-exchange.orange-input').find('input.exp_custom');

        // console.log('input_sum: ' + input_sum);
        // console.log(output_el);

        let output_sum = calc_other_payments_output_sum(input_sum/*, percent*/);
        if (output_sum === false)
            return;
        else
            output_el.val(output_sum);

    }
    else
    if (input_el.hasClass('exp_custom')) //Внесена желаемая сумма
    {
        output_el = input_el.parents('.input-exchange.orange-input').siblings('.input-exchange.col-lg-5').find('input.other_payments_input');

        // console.log('input_sum: ' + input_sum);
        // console.log(output_el);

        let output_sum = calc_other_payments_input_sum(input_sum/*, percent*/);
        if (output_sum === false)
            return;
        else
            output_el.val(output_sum);
    }

}
function calc_other_payments_input_sum(output_sum, percent = false)
{
    let currency_rates = get_currency_rates();
    if (!currency_rates)
        return false;
    else {
        //console.log(currency_rates);

        let result = (output_sum * currency_rates.output_rate) / currency_rates.input_rate;

        //console.log("result before: " + result);

        if (percent !== false && typeof percent !== undefined)
            result *= (1 - (percent / 100));

        //console.log("result after: " + result);
        return Math.round(result * 100) / 100;
    }
}
function calc_other_payments_output_sum(input_sum, percent = false)
{
    let currency_rates = get_currency_rates();
    if (!currency_rates)
        return false;
    else {
        let result = (input_sum * currency_rates.input_rate) / currency_rates.output_rate;

        //console.log("result before: " + result);

        if (percent !== false && typeof percent !== undefined)
            result *= (1 - (percent / 100));

        //console.log("result after: " + result);
        return Math.round(result * 100) / 100;
    }
}

function other_payment_input_currency_change(el)
{
    // let data = {
    //     get_currency_percent: true,
    //     type: 'sell',
    //     currency: jQuery(this).find('option:selected').val()
    // };
    // jQuery.post( window.location, data, function(response)
    // {
    //     let response_data = JSON.parse(response);
    //     let currency_options = jQuery('.other_payments.output_currency option');//el.find('option');//el.find('option');
    //     let acquiring = (response_data['acquiring'] !== '' && typeof response_data['acquiring'] !== 'undefined') ? parseFloat(response_data['acquiring']) : 0;
    //     let site = (response_data['site'] !== '' && typeof response_data['site'] !== 'undefined') ? parseFloat(response_data['site']) : 0;
    //     jQuery.each(currency_options, function(index, el)
    //     {
    //         var value = jQuery(this).val();
    //         var percent = parseFloat(0);
    //         for (let key in response_data)
    //             if (key.toLowerCase() === value.toLowerCase()) {
    //                 percent += parseFloat(response_data[key]);
    //                 //jQuery(this).attr('data-percent', response_data[key]);
    //             }
    //         percent += acquiring;
    //         percent += site;
    //         console.log(percent);
    //         jQuery(this).attr('data-percent', percent);
    //
    //         //console.log(value);
    //         // jQuery.each(response_data, function() {
    //         //     var currency = jQuery(this);
    //         //     console.log(currency);
    //         // });
    //     });
    //     jQuery.each(el.find('option'), function() {
    //         jQuery(this).attr('data-percent', '');
    //     });
    //     //console.log(currency_options);
    // });

    other_payments_print_result(el.parents('form.other_payments').find('.other_payments_input'));
}
function other_payment_output_currency_change(el)
{
    let possible_rub_names = ["RUB", "rub", "Rub", "рубль", "Рубль"]; //Возможные названия рубля, учитывая регистр

    let fields_to_show = el.parents('.input-exchange')
        .siblings('#other_payments_card_name, #other_payments_card_num, #other_payments_bank');

    // let data = {
    //     get_currency_percent: true,
    //     type: 'buy',
    //     currency: jQuery(this).find('option:selected').val()
    // };
    // jQuery.post( window.location, data, function(response) {
    //     let response_data = JSON.parse(response);
    //     let currency_options = jQuery('.other_payments.input_currency option');//el.find('option');//el.find('option');
    //     let acquiring = (response_data['acquiring'] !== '' && typeof response_data['acquiring'] !== 'undefined') ? parseFloat(response_data['acquiring']) : 0;
    //     let site = (response_data['site'] !== '' && typeof response_data['site'] !== 'undefined') ? parseFloat(response_data['site']) : 0;
    //     jQuery.each(currency_options, function(index, el) {
    //         var value = jQuery(this).val();
    //         var percent = parseFloat(0);
    //         for (let key in response_data)
    //             if (key.toLowerCase() === value.toLowerCase()) {
    //                 percent += parseFloat(response_data[key]);
    //                 //jQuery(this).attr('data-percent', response_data[key]);
    //             }
    //
    //         percent += acquiring;
    //         percent += site;
    //         console.log(percent);
    //         jQuery(this).attr('data-percent', percent);
    //
    //
    //         //console.log(value);
    //         // jQuery.each(response_data, function() {
    //         //     var currency = jQuery(this);
    //         //     console.log(currency);
    //         // });
    //     });
    //     jQuery.each(el.find('option'), function() {
    //         jQuery(this).attr('data-percent', '');
    //     });
    //     //console.log(currency_options);
    // });

    if (possible_rub_names.includes(el.val() ) )
        fields_to_show.css('display', 'block');
    else
        fields_to_show.css('display', 'none');

    other_payments_print_result(el.parents('form.other_payments').find('.other_payments_input'));
}

function other_payments_is_output_currency(el) {
    let currency_el = el.parents('.menu-list').siblings('input.other_payments');
    let is_output_currency;
    if (currency_el.hasClass('input_currency'))
        is_output_currency = false;
    else
    if (currency_el.hasClass('output_currency'))
        is_output_currency = true;
    return is_output_currency;
}

function change_requisites(currency_el, requisite_el, requisite_val = '')
{
    let requisites = currency_el.attr('data-requisites');
    console.log(requisites);
    if (requisites.length === 0)
        requisites = DEFAULT_REQUISITE;
    if (typeof requisite_el !== 'undefined')
    {
        requisite_el.find('option').not(':first-child').remove();

        if (requisite_val !== 'clear')
            requisite_el.append('<option selected>' +
                requisites +
                '</option>');
    }
}

function open_nested_menu(el)
{
    let menu_el = el.siblings('.menu-list');
    let menu_display = menu_el.css('display');

    jQuery(".menu-list").not(menu_el).slideUp("normal");
    setTimeout(function() {
        if (menu_display === 'none')
            menu_el.slideDown('normal');
        else
        if (menu_display === 'block')
            menu_el.slideUp('normal');
    }, 400, menu_display, menu_el);
}
function click_nested_menu_link(link_el)
{
    link_el.parents('.menu-list').find('a').removeClass('active');
    //jQuery('.menu-list a').removeClass('active');

    let ul_display = link_el.siblings('ul').css('display');
    let ul = link_el.siblings('ul');

    let form_id = link_el.parents('form').attr('id');
    //Условие выбора валюты нижнего уровня вложенности (больше вложенности в данной группе нет)
    if (ul.length === 0 || typeof ul === 'undefined')
    {
        link_el.addClass('active');

        link_el.parents('.menu-list').siblings('.nested_menu').children('.menu_link').text(link_el.attr('data-value'));

        if (form_id === 'other_payments')
        {
            let is_output_currency = other_payments_is_output_currency(link_el);

            //Иные взносы input_currency
            if (!is_output_currency) {
                let input_currency_el = link_el.parents('.menu-list').siblings('input.other_payments.input_currency');
                input_currency_el.val(link_el.attr('data-value'));

                change_requisites(link_el, jQuery('form.other_payments select.other_payments.requisites'));
                other_payment_input_currency_change(link_el);
            }
            //Иные взносы output_currency
            else
            {
                let output_currency_el = link_el.parents('.menu-list').siblings('input.other_payments.output_currency');
                output_currency_el.val(link_el.attr('data-value'));
                other_payment_output_currency_change(link_el);
            }
        }
        else
        if (form_id === 'personal_deposit') {
            let section_el = link_el.parents('.menu-list').siblings('input.other_payments.section');
            section_el.val(link_el.attr('data-value'));
            change_requisites(link_el, jQuery('form#personal_deposit select.personal_deposit.requisites'));
        }
        //настройки
        else
            if (form_id === 'settings_form_commission-all')
            {
                let new_name = link_el.attr('data-value');
                let input_el = link_el.parents('.commission_header').siblings('.input-exchange').children('input.commission');
                change_input_name(input_el, new_name);
            }

        //Целевой взнос input_currency
        // else
        //     if (form_id === 'other_deposit') {
        //         change_requisites(jQuery(this), jQuery('form.other_deposit select.other_deposit.requisites'));
        //         let input_currency_el = jQuery(this).parents('.menu-list').siblings('input.other_payments.input_currency');
        //         input_currency_el.val(jQuery(this).attr('data-value'));
        //     }
    }

    else {
        let currency_el = link_el.parents('.menu-list').siblings('input[type=hidden]');
        if (form_id !== 'personal_deposit') {
            currency_el.val('');
            link_el.parents('.menu-list').siblings('.nested_menu').children('.menu_link').text('Вид вносимого имущества');
        }
        else {
            currency_el.val(link_el.attr('data-value'));
            link_el.parents('.menu-list').siblings('.nested_menu').children('.menu_link').text(currency_el.val());
            change_requisites(link_el, jQuery('form#personal_deposit select.personal_deposit.requisites'));
        }

        if (form_id === 'other_payments') {
            let is_output_currency = other_payments_is_output_currency(link_el);
            if (!is_output_currency)
                change_requisites(link_el, jQuery('form.other_payments select.other_payments.requisites'), 'clear');
        }
        //else
        //if (form_id === 'other_deposit')
        //change_requisites(link_el, jQuery('form.other_deposit select.other_deposit.requisites'), 'clear');
    }

    if (ul_display === 'none') {
        ul.slideDown('normal');
        //link_el.addClass('active');
    }
    else
    if (ul_display === 'block') {
        ul.slideUp('normal');
    }
}