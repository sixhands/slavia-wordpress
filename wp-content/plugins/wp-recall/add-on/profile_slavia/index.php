<?php

require_once 'classes/class-rcl-profile-fields.php';
require_once 'classes/class-slavia-ref-awards.php';

use Dompdf\Dompdf;
//use Ref_Awards;

if (is_admin()) {
    require_once 'admin/index.php';
}

if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_profile_scripts',10);
endif;

function exchange_doc_template($args)
{
    return rcl_get_include_template('document-template.php', __FILE__, $args);
    //$doc_num, $day, $month, $year, $client_num, $client_fio, $currency, $amount, $currency_rate, $sum, $public_key, $currency_address = null
}

function download_stats()
{
    if ( function_exists( 'wp_get_current_user' ) )
        $userID = wp_get_current_user()->ID;
    else
        $userID = 0;
    if (!empty($userID) && $userID != 0)
        $filename = "stats_user_".$userID;//.".pdf";
    else
        $filename = "stats_user";
    //$stat_file = fopen(get_temp_dir().$filename, 'w');
    //$temp_filename = @tempnam(get_temp_dir(), 'tmp');//tmpfile();

    //$stat_file = fopen($temp_filename, "w");
    //$stats = rcl_get_option('user_stats');
    $stats_content = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
    $stats_content .= '<style>
                        body { font-family: DejaVu Sans, sans-serif; }
                        table, th, td {border: 1px solid black; }
                    </style>';
    $stats_content .= '</head><body>';
    //$stats_content .= '<div class="coop_maps question-bg col-lg-12"><div class="row stats">';

    $stats_content .= '<table style="table-layout:fixed; width: 700px">';

    $stats_content .= show_stats_header(true);

    $stats_content .= show_all_stats(true);

    $stats_content .= '</table></body></html>';
    //$pdf = generate_pdf($stats_content);
    //$log->insert_log("file:".print_r($stat_file, true));
    //file_put_contents($filename, $pdf);
    //fwrite($stat_file, $pdf);
    //header("Content-disposition: attachment;filename=" . $filename);
    //header("Content-type: " . mime_content_type($filename));
    //readfile($filename);
    //fclose($filename);
    //unlink($filename);
    $dompdf = new Dompdf();
    $dompdf->loadHtml($stats_content);

//    $dompdf->loadHtml(exchange_doc_template(array('doc_num' => 1, 'day' => 9, 'month' => 'мая', 'year' => 2020, 'hour' => 16,
//        'minute' => 53, 'client_num' => 5, 'client_fio' => 'Петров Иван Иваныч', 'currency' => 'PRIZM', 'amount' => 1000,
//        'currency_rate' => 16.7, 'sum' => 1000*16.7, 'public_key' => 'fgokdhodg363563higfjhiw43',
//        'currency_address' => 'PRIZMgisjfgsfjiw5i5w7', 'doc_type' => 'output'
//        /*'deposit_type' => 'Имущество на паях'*/)));

// (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
    $dompdf->render();

// Output the generated PDF to Browser
    $dompdf->stream($filename);
    exit;
}
function download_stats_call()
{
    if (isset($_GET['f']) && $_GET['f'] == 'download_stats')
        download_stats();
}
add_action('init','download_stats_call');

/**************ПОДТВЕРЖДЕНИЕ ПОЧТЫ*************************************/
//подтверждаем регистрацию пользователя по ссылке
function rcl_confirm_user_registration() {
    global $wpdb;

    if ( $confirmdata = urldecode( $_GET['rcl-confirmdata'] ) ) {

        $confirmdata = json_decode( base64_decode( $confirmdata ) );

        if ( $user = get_user_by( 'login', $confirmdata[0] ) ) {

            if ( md5( $user->ID ) != $confirmdata[1] )
                return false;

//            if ( ! rcl_is_user_role( $user->ID, 'need-confirm' ) )
//                return false;

//            $defaultRole = get_option( 'default_role' );
//            if ( $defaultRole == 'need-confirm' ) {
//                update_option( 'default_role', 'author' );
//                $defaultRole = 'author';
//            }

            //wp_update_user( array( 'ID' => $user->ID, 'role' => $defaultRole ) );

//            $log = new Rcl_Log();
//            $log->insert_log("user_id: ".$user->ID);
            //Обновляем поле профиля
            $profile_fields = rcl_get_profile_fields(array('user_id' => $user->ID));
            if (isset($profile_fields) && !empty($profile_fields)) {
                foreach ($profile_fields as $field) {
                    if ($field['slug'] == 'is_email_verified') {
                        if (isset($field['value']))
                            $field['value'] = 'yes';
                        else
                            $field += array('value' => 'yes');

                        rcl_update_profile_fields($user->ID, array($field));
                        break;
                    }
                }
            }
            /*********************************************/

            if ( ! rcl_get_time_user_action( $user->ID ) )
                $wpdb->insert( RCL_PREF . 'user_action', array( 'user' => $user->ID, 'time_action' => current_time( 'mysql' ) ) );

            do_action( 'rcl_confirm_registration', $user->ID );

            if ( rcl_get_option( 'login_form_recall' ) == 2 ) {
                wp_safe_redirect( /*wp_login_url()*/'/profile/' . '?success=checkemail' );
            } else {
                wp_redirect( get_bloginfo( 'wpurl' ) . '/profile/' . '?action-rcl=login&success=checkemail' );
            }
            exit;
        }
    }

    if ( rcl_get_option( 'login_form_recall' ) == 2 ) {
        wp_safe_redirect( /*wp_login_url()*/'/profile/' . '?checkemail=confirm' );
    } else {
        wp_redirect( get_bloginfo( 'wpurl' ) . '/profile/' . '?action-rcl=login&login=checkemail' );
    }
    exit;
}

//принимаем данные для подтверждения регистрации
add_action( 'init', 'rcl_confirm_user_resistration_activate' );
function rcl_confirm_user_resistration_activate() {

    if ( ! isset( $_GET['rcl-confirmdata'] ) )
        return false;

    if ( rcl_get_option( 'confirm_register_recall' ) )
        //add_action( 'wp', 'rcl_confirm_user_registration' );
        add_action('wp', 'rcl_confirm_user_registration');
}
/******************************************************************/

function rcl_profile_scripts(){
    global $user_ID;
    if(rcl_is_office($user_ID)){
        rcl_enqueue_style( 'rcl-profile', rcl_addon_url('style.css', __FILE__) );
        rcl_enqueue_script( 'rcl-profile-scripts', rcl_addon_url('js/scripts.js', __FILE__) );
        //wp_enqueue_script( 'rcl-profile-scripts', rcl_addon_url('js/scripts.js', __FILE__), array('my_jquery'), '1.0', true );
    }
}

add_filter('rcl_init_js_variables','rcl_init_js_profile_variables',10);
function rcl_init_js_profile_variables($data){
    $data['local']['no_repeat_pass'] = __('Repeated password not correct!','wp-recall');
    return $data;
}

//Получить текущую роль
function rcl_get_current_role()
{
    if (!isset(wp_get_current_user()->roles) || empty(wp_get_current_user()->roles)) //Если не назначена роль, не фильтруем табы
        return false;
    $roles = wp_get_current_user()->roles;
    $current_role = array_shift($roles);
    //var_dump($current_role);
    return $current_role;
}

//Удаление таба
function rcl_block_profile_pages_by_role($tab)
{
    if (parse_url($_SERVER['REQUEST_URI'])['path'] == '/profile/') {
        $current_role = rcl_get_current_role();
        //if (!isset($current_role) || empty($current_role)) //Если не назначена роль, не фильтруем табы
            //return $tab;

        if ($current_role == 'manager') {
            if ($tab['id'] == 'settings') {
                $tab = array();
            }
        }
        if ($current_role == 'user' || !isset($current_role) || empty($current_role) )
        {
            if ($tab['id'] == 'requests' || $tab['id'] == 'people' || $tab['id'] == 'settings')
            {
                $tab = array();
            }
        }
        if ($current_role == 'need-confirm' || $current_role == 'not_verified')
        {
            if ($tab['id'] != 'profile')
                $tab = array();
        }
    }
    return $tab;
}
add_filter('rcl_tab', 'rcl_block_profile_pages_by_role', 5, 1);

//Фильтр дефолтных полей профиля
add_filter('rcl_default_profile_fields', 'change_default_profile_fields', 10, 1);
function change_default_profile_fields($fields){
    global $userdata;
    foreach ($fields as $field)
    {
        if ($field['slug'] == 'user_email')
            $field += array('value' => $userdata->user_email);
    }
    return $fields;

}
//Фильтр ВСЕХ полей лк
add_filter('rcl_profile_fields', 'add_profile_fields', 10);
//add_filter('rcl_public_form_fields', 'add_profile_fields', 10);
function add_profile_fields($fields){

    $fields[] = array(
        'type' => 'tel',
        'slug' => 'user_phone',
        'title' => 'Телефон',
    );

    $fields[] = array(
        'type' => 'url',
        'slug' => 'user_ref_link',
        'title' => 'Реферальная ссылка',
    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'ref_host',
        'title' => 'Пригласивший пользователь',
    );

    $fields[] = array(
        'type' => 'custom',
        'slug' => 'refs',
        'title' => 'Приглашенные рефералы',
        'content' => '',
    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'client_num',
        'title' => 'Номер пайщика',
    );

//    $fields[] = array(
//        'type' => 'text',
//        'slug' => 'prizm_address',
//        'title' => 'Адрес PRIZM',
//    );
//
//    $fields[] = array(
//        'type' => 'text',
//        'slug' => 'prizm_public_key',
//        'title' => 'Публичный ключ',
//    );
//
//    $fields[] = array(
//        'type' => 'text',
//        'slug' => 'waves_address',
//        'title' => 'Адрес Waves',
//    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'is_verified',
        'title' => 'Верификация профиля',
    );
    //Верификация
    $fields[] = array(
        'type' => 'custom',
        'slug' => 'verification',
        'title' => 'Данные верификации',
        'content' => '',
    );
    //Фото паспорта
    $fields[] = array(
        'type' => 'custom',
        'slug' => 'passport_photos',
        'title' => 'Фото паспорта',
        'content' => '',
    );
    $fields[] = array(
        'type' => 'custom',
        'slug' => 'user_documents',
        'title' => 'Документы пользователя',
        'content' => '',
    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'ref_percent',
        'title' => 'Вознаграждение по реферальной программе',
    );
    $fields[] = array(
        'type' => 'text',
        'slug' => 'is_email_verified',
        'title' => 'Подтверждение email',
    );
    $fields[] = array(
        'type' => 'text',
        'slug' => 'is_privileged',
        'title' => 'Привелигированный пользователь',
    );

    return $fields;
}

//Генерация документов пользователя
function generate_pdf($text, $load_from_file = false)
{
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    if (!$load_from_file)
        $dompdf->loadHtml($text);
    else
        $dompdf->loadHtmlFile($text);

// (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
    $dompdf->render();

// Output the generated PDF to Browser
    return $dompdf->output();
}
//Создание документов
function get_new_document_field($user_id, $text = null, $filename = null)
{
    if (!$text)
        $text = current_time( 'm-d-H-i-s' );
    $pdf = generate_pdf($text);
    //Загружаем файлы
    if ( ! function_exists( 'wp_handle_sideload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
    }
    $temp_filename = @tempnam(get_temp_dir(), 'tmp');//tmpfile();

    $temp_file =  fopen($temp_filename, "w");
    fwrite($temp_file, $pdf);

    $log = new Rcl_Log();

    $filename_to_upload = '';

    $client_num = get_user_meta($user_id, 'client_num', true);
    $user_verification = get_user_meta($user_id, 'verification', true);
    $user_full_name = '';
    if (isset($user_verification) && !empty($user_verification))
    {
        $user_full_name = $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'];
    }
    //$display_name = get_userdata($user_id)->display_name;

    if (!isset($filename) || empty($filename))
        $filename_to_upload = 'payment_receipt-'.'Пайщик №'.$client_num.' '.$user_full_name.'-'.current_time( 'd-m-H-i' ).'.pdf';
    else
        $filename_to_upload = $filename.'- '.'Пайщик №'.$client_num.' '.$user_full_name.'-'.current_time( 'd-m-H-i' ).'.pdf';
    //$log->insert_log("filename:".$filename_to_upload);
    // Array based on $_FILE as seen in PHP file uploads
    $file_to_upload = array(
        'name'     => $filename_to_upload, // ex: wp-header-logo.png
        'type'     => 'application/pdf',
        'tmp_name' => $temp_filename,
        'error'    => 0,
        'size'     => filesize($temp_filename),
    );

    $overrides = array(
        // Tells WordPress to not look for the POST form
        // fields that would normally be present
        'test_form' => false,
    );

    $result_field = null;

    $file = wp_handle_sideload( $file_to_upload, $overrides );

    if ($file && !isset( $file['error'] )) {
        if ($file['url']) {
            $filepath = $file['file']; // Full path to the file
            $local_url = $file['url'];  // URL to the file in the uploads dir
            $type = $file['type']; // MIME type of the file

            $attachment = array(
                'post_mime_type' => $file['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
                'post_name' => 'payment_receipt' . '-' . $user_id . '-' . 0,
                'post_content' => '',
                'guid' => $file['url'],
                'post_parent' => 0,
                'post_author' => $user_id,
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $file['file'], 0);
            $attach_data = wp_generate_attachment_metadata($attach_id, $file['file']);

            wp_update_attachment_metadata($attach_id, $attach_data);


            $filename = pathinfo($filepath);
            $filename = $filename['filename'].'.'.$filename['extension'];

            date_default_timezone_set('Europe/Moscow');

            $result_field = array('date' => date('d.m.y H:i:s'), 'filename' => $filename, 'url' => $local_url);

            //array('date' => '08.11.19', 'filename' => 'document1.docx', 'url' => '/wp-content/uploads/2019/12/don.png');
        }
    }
    elseif (isset($file['error']))
    {
        $log->insert_log("error: ".print_r($file['error'], true));
    }
    fclose($temp_file);
    return !empty($result_field) ? $result_field : false;
}

function get_alternate_currency_rate($currency_name, $type = 'in')
{
    $i = 0;
    if ($type == 'in')
        $field_name = 'asset_input_';
    elseif ($type == 'out')
        $field_name = 'asset_output_';

    while (!empty(get_field($field_name.($i+1), 306)) && count(get_field($field_name.($i+1), 306)) > 0)
    {
        $cur_field = get_field($field_name . ($i + 1), 306);
        if ($cur_field['asset_name'] == $currency_name) {
            $log = new Rcl_Log();
            $log->insert_log("asset_rate: ".$cur_field['asset_rate_rubles']);
            return $cur_field['asset_rate_rubles'];
        }
        ++$i;
    }
    return false;

}
function get_doc_fields($data)
{
    $request = $data["request"];
    $userid = $data["user_id"];

    $doc_num = get_user_meta($userid, 'user_documents', true);
    //$log->insert_log("doc_num:".print_r($doc_num, true));
    if (!isset($doc_num) || empty($doc_num))
        $doc_num = 0;
    else
        $doc_num = count($doc_num);
    /***********************ПОЛЯ***********************/
    date_default_timezone_set('Europe/Moscow');

    $day = date('j');
    $month = date('n');
    $month = get_russian_month($month);
    $year = date('Y');
    $hour = date('H');
    $minute = date('i');

    $client_num = get_user_meta($userid, 'client_num', true);

    //Если обычный обмен
    if (!isset($request['requisites']))
        $bank_commission = get_bank_commission($request['bank']);
    $prizm_price = rcl_slavia_get_crypto_price('PZM'); //Курс призма
    $waves_price = rcl_slavia_get_crypto_price('WAVES'); //Курс waves

    $user_verification = get_user_meta($userid, 'verification', true);
    $user_full_name = '';
    if (isset($user_verification) && !empty($user_verification))
    {
        $user_full_name = $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'];
    }

    //Если депозит или иной паевой взнос без второй валюты
    if (isset($request['deposit_type']) || (!is_var($request['output_sum']) && !is_var($request['output_currency']) ) )
        $is_deposit = true;
    else
        $is_deposit = false;

    $input_doc_fields =
        array(
            'doc_num' => ($doc_num+1),
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'hour' => $hour,
            'minute' => $minute,
            'client_num' => $client_num,
            'client_fio' => $user_full_name,
            'currency' => stripslashes($request['input_currency']),
            'other_currency' => stripslashes($request['output_currency']), //Противоположная валюта, для вывода стоимости данной валюты в других валютах (иной паевой взнос)
            'amount' => $request['input_sum'],
            'currency_rate' => 0,
            'sum' => 0,
            'public_key' => $user_verification['prizm_public_key'],
            'doc_type' => ($is_deposit && isset($request['deposit_type']) ) ? 'deposit' : 'input'
        );
    //Если целевой взнос, добавляем тип целевой программы
    if ($is_deposit && isset($request['deposit_type']))
        $input_doc_fields += array('deposit_type' => stripslashes($request['deposit_type']));

    if (isset($user_verification['prizm_address']) && !empty($user_verification['prizm_address']))
        $input_doc_fields += array('prizm_address' => $user_verification['prizm_address']);

    if (isset($user_verification['waves_address']) && !empty($user_verification['waves_address']))
        $input_doc_fields += array('slav_address' => $user_verification['waves_address']);
    ////////////////////////////////////

    if (strcasecmp($input_doc_fields['currency'], 'prizm') == 0)
    {
        //$input_doc_fields += array('currency_address' => $user_verification['prizm_address']);

        $input_doc_fields['currency_rate'] = $prizm_price * (1 - ($bank_commission / 100));

        //$input_doc_fields['sum'] = $request['output_sum'];
    }
    elseif (strcasecmp($input_doc_fields['currency'], 'slav') == 0)
    {
        $input_doc_fields['currency_rate'] = /*$waves_price*/ 1 * (1 - ($bank_commission / 100));

        //$input_doc_fields['sum'] = $request['output_sum'];
    }
    elseif (strcasecmp($input_doc_fields['currency'], 'RUB') == 0)
    {
        $input_doc_fields['currency_rate'] = 1;//(1-$bank_commission);

        //$input_doc_fields['sum'] = $request['input_sum'];
    }
    //Другие валюты
    elseif (isset($request['requisites']) && !empty($request['requisites']))
    {
        $this_currency_rate = get_alternate_currency_rate($input_doc_fields['currency'], 'in');
        //if (isset($input_doc_fields['other_currency']) && !empty($input_doc_fields['other_currency']))
        //{
            //$other_currency_rate = get_alternate_currency_rate($input_doc_fields['other_currency'], 'out');

            $rate = $this_currency_rate;// / $other_currency_rate;

            //$input_doc_fields['sum'] = $request['output_sum'];
       // }
        //else {
          //  $rate = $this_currency_rate;
          //  $input_doc_fields['sum'] = $input_doc_fields['amount'] * $rate;
        //}

        $input_doc_fields['currency_rate'] = round($rate, 2);

//        $log = new Rcl_Log();
//        $log->insert_log("input_doc_fields: ".print_r($input_doc_fields, true));
    }

    $input_doc_fields['sum'] = $input_doc_fields['amount'] * $input_doc_fields['currency_rate'];

    if (!$is_deposit)
    {
        $output_doc_fields =
            array(
                'doc_num' => ($doc_num + 2),
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'hour' => $hour,
                'minute' => $minute,
                'client_num' => $client_num,
                'client_fio' => $user_full_name,
                'currency' => stripslashes($request['output_currency']),
                'other_currency' => stripslashes($request['input_currency']),
                'amount' => $request['output_sum'],
                'currency_rate' => 0,
                'sum' => 0,
                'public_key' => $user_verification['prizm_public_key'],
                'doc_type' => 'output'
            );

        if (isset($user_verification['prizm_address']) && !empty($user_verification['prizm_address']))
            $output_doc_fields += array('prizm_address' => $user_verification['prizm_address']);

        if (isset($user_verification['waves_address']) && !empty($user_verification['waves_address']))
            $output_doc_fields += array('slav_address' => $user_verification['waves_address']);

        //Т.к. получаем криптовалюту и отдаем рубли, за сумму берем input_sum (сумма в рублях)
        if (strcasecmp($output_doc_fields['currency'], 'prizm') == 0) {

            $output_doc_fields['currency_rate'] = $prizm_price * (1);// - ($bank_commission / 100));
            //$output_doc_fields['sum'] = $request['input_sum'];
        }
        elseif (strcasecmp($output_doc_fields['currency'], 'slav') == 0) {
            $output_doc_fields['currency_rate'] = /*$waves_price * (*/1;// - ($bank_commission / 100));
            //$output_doc_fields['sum'] = $request['input_sum'];
        }
        elseif (strcasecmp($output_doc_fields['currency'], 'RUB') == 0) {
            $output_doc_fields['currency_rate'] = (1);// - ($bank_commission / 100));
            //$output_doc_fields['sum'] = $request['output_sum'];
        }
        //Другие валюты
        elseif (isset($request['requisites']) && !empty($request['requisites']))
        {
            $this_currency_rate = get_alternate_currency_rate($output_doc_fields['currency'], 'out');
            //$other_currency_rate = get_alternate_currency_rate($output_doc_fields['other_currency'], 'in');

            $rate = $this_currency_rate;// / $other_currency_rate;

            $output_doc_fields['currency_rate'] = round($rate, 2);
            //$output_doc_fields['sum'] = $request['input_sum'];
        }

        $output_doc_fields['sum'] = $output_doc_fields['amount'] * $output_doc_fields['currency_rate'];
    }
    $result = array("input_fields" => $input_doc_fields);
    if (!$is_deposit)
        $result += array("output_fields" => $output_doc_fields, "is_deposit" => false);
    else
        $result += array("is_deposit" => true);

//    $log = new Rcl_Log();
//    $log->insert_log("result: ".print_r($result, true));
    return $result;
}

//Добавление документов для данного пользователя
//add_filter('rcl_profile_fields', 'add_user_documents', 10);
//Добавить все параметры документа из сгенерированного документа (название, число и ссылку на загрузку)

function hide_nav_menu_items()
{
    $current_role = rcl_get_current_role();
    if (!is_user_logged_in() || $current_role == 'need-confirm' || $current_role == 'not_verified')
        rcl_enqueue_style( 'hide_menu', rcl_addon_url('hide_menu.css', __FILE__) );
    else
        wp_dequeue_style('hide_menu');
}
add_action('init','hide_nav_menu_items');
add_action('wp_logout', 'hide_nav_menu_items');
add_action('wp_login','hide_nav_menu_items');


add_action('init','rcl_tab_profile');
add_action('init','rcl_tab_exchange');
add_action('init','rcl_tab_operations');
add_action('init','rcl_tab_documents');
add_action('init','rcl_tab_people');
add_action('init','rcl_tab_requests');
add_action('init','rcl_tab_settings');
add_action('init', 'rcl_tab_referral');

function rcl_tab_template_content()
{
    global $userdata, $user_ID;

    $profileFields = rcl_get_profile_fields(array('user_id'=>$user_ID));

    $CF = new Rcl_Custom_Fields();

    $profileFields = stripslashes_deep($profileFields);

    $hiddens = array();

    $profile_args = array();

    $profileFields = apply_filters('rcl_default_profile_fields', $profileFields);

    foreach($profileFields as $field) {

        $field = apply_filters('custom_field_profile', $field);

        $slug = isset($field['name']) ? $field['name'] : $field['slug'];

        if (!$field || !$slug) continue;

        if ($field['type'] == 'hidden') {
            $hiddens[] = $field;
            continue;
        }

        $value = (isset($userdata->$slug)) ? $userdata->$slug : false;

        if ($slug == 'email')
            $value = $userdata->user_email;//get_the_author_meta('email', $user_ID);
        //$field['value'] = $value;

        $label = sprintf('<label>%s:</label>',$CF->get_title($field));

//        if($field['slug'] != 'show_admin_bar_front' && !isset($field['value_in_key']) )
//            $field['value_in_key'] = true;
        //$star = (isset($field['required'])&&$field['required']==1)? ' <span class="required">*</span> ': '';

        $field_name = $slug;//$CF->get_slug($field);
        $field_value = null;
        if ($field_name == 'user_ref_link' && (empty($value) || $value == false))
        {
            $value = base64_encode($user_ID);
            update_user_meta($user_ID, 'user_ref_link', $value);
        }
        if ($field_name != 'is_verified' && $field_name != 'verification' && $field_name != 'passport_photos' &&
            $field_name != 'user_documents' && $field_name != 'refs' && $field_name != 'is_email_verified' &&
            $field_name != 'is_privileged') {
            $field_value = /*$label . */$CF->get_input($field, $value);
            $field_value = apply_filters('profile_options_rcl', $field_value, $userdata);
        }
        else {
            if ($field_name == 'verification' || $field_name == 'passport_photos' || $field_name == 'is_verified' ||
                $field_name == 'user_documents' || $field_name == 'refs' || $field_name == 'is_email_verified' ||
                $field_name == 'is_privileged')
            {
                $field_value = $value;
                if ($field_name == 'refs' && !empty($field_value))
                {
                    foreach ($field_value as $key => $value)
                    {
                        //Если такого пользователя нет, то удаляем его из поля рефералов
                        if (!get_user_by('ID', $value))
                        {
                            unset($field_value[$key]);

                            $field += array('value' => $field_value);

                            rcl_update_profile_fields($user_ID, array($field));
                        }
                    }
                }
                if ($field_name == 'user_documents' && !empty($field_value))
                {
                    clearstatcache(); //Очищаем кэш операций с файлами
                    //Если данного файла нет, удаляем поле
                    foreach ($field_value as $key => $document)
                    {
                        $filepath = parse_url($document['url'], PHP_URL_PATH);
                        $filepath = $_SERVER['DOCUMENT_ROOT'].$filepath;
                        $log = new Rcl_Log();
                        if (!file_exists($filepath))
                        {
                            //$log->insert_log("file ".$filepath." doesnt exist");
                            unset($field_value[$key]);

                            $field += array('value' => $field_value);

                            rcl_update_profile_fields($user_ID, array($field));
                        }
                    }
                }
            }
        }
        $profile_args += array($field_name => $field_value);
    } //foreach

    //$profile_args += array('user_id' => $user_ID);
    //Является ли менеджером
    if (rcl_get_current_role() == 'manager' || rcl_get_current_role() == 'administrator' || rcl_get_current_role() == 'director')
        $profile_args += array('is_manager' => true);
    else
        $profile_args += array('is_manager' => false);

    //Имя/фамилия пользователя
    $profile_args += array('username' => $userdata->display_name);

    //Аватар
    $profile_args += array('avatar_url' => get_avatar_url( $user_ID ));
    return $profile_args;
}

//PROFILE TAB
function rcl_tab_profile(){

    rcl_tab(
        array(
            'id'=>'profile',
            'name'=>'Профиль',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=>'/wp-content/uploads/2019/12/home_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_profile_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_profile_content($master_id)
{
    global $user_ID;
    //get_new_document_field($user_ID);
    //global $side_text, $video_files, $video_text;
    $profile_args = rcl_tab_template_content();
//    $stats = rcl_get_option('user_stats');
//    if (isset($stats) && !empty($stats))
//    {
//        //var_dump($stats);
//        $stats_content = '';
//        $currencies = array('RUB', 'PRIZM', 'WAVES');
//        foreach ($stats as $user => $user_stats)
//        {
//            if (isset($user_stats) && !empty($user_stats))
//            {
//                $user_verification = get_user_meta($user, 'verification', true);
//
//                if (isset($user_verification) && !empty($user_verification))
//                {
//                    //Обнуляем значения для валюты, если статистика для данной валюты отсутствует
//                    foreach ($currencies as $currency)
//                    {
//                        if (!isset($user_stats[$currency]))
//                            $user_stats += array($currency => array('input_sum' => 0, 'output_sum' => 0,'exchange_num' => 0));
//                    }
//                    $stats_content .= '<div class="table-text w-100">
//                                        <div class="row">
//                                            <div class="col-2 text-center stats_col" style="padding-left: 25px;">'.
//                            $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
//                                            '</div>
//                                            <div class="col-2 text-center stats_col">' .
//                                                get_user_meta($user, 'client_num', true) .
//                                            '</div>'.
//                                            //RUB
//                                            '<div class="col-2 text-center stats_col">'.
//                                                $user_stats['RUB']['input_sum']. ' RUB'.
//                                            '</div>
//                                            <div class="col-1 text-center stats_col">'.
//                                                $user_stats['RUB']['exchange_num'].
//                                            '</div>'.
//                                            //PRIZM
//                                            '<div class="col-2 text-center stats_col">'.
//                                                $user_stats['PRIZM']['input_sum'].' PRIZM'.
//                                            '</div>
//                                            <div class="col-1 text-center stats_col">'.
//                                                $user_stats['PRIZM']['exchange_num'].
//                                            '</div>'.
//                                            //WAVES
//                                            '<div class="col-1 text-center stats_col">'.
//                                                $user_stats['WAVES']['input_sum']. ' WAVES'.
//                                            '</div>
//                                            <div class="col-1 text-center stats_col">'.
//                                                $user_stats['WAVES']['exchange_num'].
//                                            '</div>'.'
//                                        </div>
//                                    </div>';
//                }
//            }
//        } //foreach
//        $profile_args += array("stats_content" => $stats_content);
//    } //if stats
    $profile_args += array("stats_content" => show_all_stats());
//    $side_text = get_field('verification_sidetext');
//    $video_files = get_field('verification_video');
//    $video_text = get_field('verification_modal_text');
//    $profile_args += array('side_text' => $side_text);
//    $profile_args += array('video_files' => $video_files);
//    $profile_args += array('video_text' => $video_text);


    //$profile_args += array('pdf' => generate_user_documents());
    $content = rcl_get_include_template('template-profile.php', __FILE__, $profile_args);

//    $content = '<h3>'.__('User profile','wp-recall').' '.$userdata->display_name.'</h3>
//    <form name="profile" id="your-profile" action="" method="post"  enctype="multipart/form-data">';
//
//    $CF = new Rcl_Custom_Fields();
//
//    $profileFields = stripslashes_deep($profileFields);
//
//    $hiddens = array();
//    foreach($profileFields as $field){
//
//        $field = apply_filters('custom_field_profile',$field);
//
//        $slug = isset($field['name'])? $field['name']: $field['slug'];
//
//        if(!$field || !$slug) continue;
//
//        if($field['type'] == 'hidden'){
//            $hiddens[] = $field; continue;
//        }
//
//        $value = (isset($userdata->$slug))? $userdata->$slug: false;
//
//        if($slug == 'email')
//            $value = get_the_author_meta('email',$user_ID);
//
//        if($field['slug'] != 'show_admin_bar_front' && !isset($field['value_in_key']) )
//            $field['value_in_key'] = true;
//
//        $star = (isset($field['required'])&&$field['required']==1)? ' <span class="required">*</span> ': '';
//
//        $label = sprintf('<label>%s%s:</label>',$CF->get_title($field),$star);
//
//        $content.=$label;
//        //$Table->add_row(array($label, $CF->get_input($field, $value)), array('id'=>array('profile-field-'.$slug)));
//        $content.=$CF->get_input($field, $value);
//
//    }
//
//    //$content .= $Table->get_table();
//
//    foreach($hiddens as $field){
//        $content .= $CF->get_input($field, $value = (isset($userdata->$slug))? $userdata->$slug: false);
//    }
//
//    $content .= "<script>
//                jQuery(function(){
//                    jQuery('#your-profile').find('.required-checkbox').each(function(){
//                        var name = jQuery(this).attr('name');
//                        var chekval = jQuery('#your-profile input[name=\"'+name+'\"]:checked').val();
//                        if(chekval) jQuery('#your-profile input[name=\"'+name+'\"]').attr('required',false);
//                        else jQuery('#your-profile input[name=\"'+name+'\"]').attr('required',true);
//                    });"
//                . "});"
//            . "</script>";
//
//    $content = apply_filters('profile_options_rcl',$content,$userdata);
//
//    $content .= wp_nonce_field( 'update-profile_' . $user_ID,'_wpnonce',true,false ).'
//        <div style="text-align:right;">'
//            . '<input type="submit" id="cpsubmit" class="recall-button" value="'.__('Update profile','wp-recall').'" onclick="return rcl_check_profile_form();" name="submit_user_profile" />
//        </div>
//    </form>';
//
//    if(rcl_get_option('delete_user_account')){
//        $content .= '
//        <form method="post" action="" name="delete_account" onsubmit="return confirm(\''.__('Are you sure? It can’t be restaured!','wp-recall').'\');">
//        '.wp_nonce_field('delete-user-'.$user_ID,'_wpnonce',true,false).'
//        <input type="submit" id="delete_acc" class="recall-button"  value="'.__('Delete your profile','wp-recall').'" name="rcl_delete_user_account"/>
//        </form>';
    //}

    return $content;
}
/**********************/

//PROFILE TAB
function rcl_tab_exchange(){

    rcl_tab(
        array(
            'id'=>'exchange',
            'name'=>'Обмен паями',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=>'/wp-content/uploads/2020/01/exchange_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_exchange_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_exchange_content($master_id)
{
    $profile_args = rcl_tab_template_content();

    $bank_options = rcl_get_option('banks');

//    $log = new Rcl_Log();
//    $log->insert_log("banks: ".print_r($bank_options, true));
    if (isset($bank_options) && !empty($bank_options))
    {
        $profile_args += array('banks' => $bank_options);
    }

    $prizm_price = rcl_slavia_get_crypto_price();
    if (isset($prizm_price) && !empty($prizm_price))
        $profile_args += array('prizm_price' => $prizm_price);

    $content = rcl_get_include_template('template-exchange.php', __FILE__, $profile_args);

//    $content = '<h3>'.__('User profile','wp-recall').' '.$userdata->display_name.'</h3>
//    <form name="profile" id="your-profile" action="" method="post"  enctype="multipart/form-data">';
//
//    $CF = new Rcl_Custom_Fields();
//
//    $profileFields = stripslashes_deep($profileFields);
//
//    $hiddens = array();
//    foreach($profileFields as $field){
//
//        $field = apply_filters('custom_field_profile',$field);
//
//        $slug = isset($field['name'])? $field['name']: $field['slug'];
//
//        if(!$field || !$slug) continue;
//
//        if($field['type'] == 'hidden'){
//            $hiddens[] = $field; continue;
//        }
//
//        $value = (isset($userdata->$slug))? $userdata->$slug: false;
//
//        if($slug == 'email')
//            $value = get_the_author_meta('email',$user_ID);
//
//        if($field['slug'] != 'show_admin_bar_front' && !isset($field['value_in_key']) )
//            $field['value_in_key'] = true;
//
//        $star = (isset($field['required'])&&$field['required']==1)? ' <span class="required">*</span> ': '';
//
//        $label = sprintf('<label>%s%s:</label>',$CF->get_title($field),$star);
//
//        $content.=$label;
//        //$Table->add_row(array($label, $CF->get_input($field, $value)), array('id'=>array('profile-field-'.$slug)));
//        $content.=$CF->get_input($field, $value);
//
//    }
//
//    //$content .= $Table->get_table();
//
//    foreach($hiddens as $field){
//        $content .= $CF->get_input($field, $value = (isset($userdata->$slug))? $userdata->$slug: false);
//    }
//
//    $content .= "<script>
//                jQuery(function(){
//                    jQuery('#your-profile').find('.required-checkbox').each(function(){
//                        var name = jQuery(this).attr('name');
//                        var chekval = jQuery('#your-profile input[name=\"'+name+'\"]:checked').val();
//                        if(chekval) jQuery('#your-profile input[name=\"'+name+'\"]').attr('required',false);
//                        else jQuery('#your-profile input[name=\"'+name+'\"]').attr('required',true);
//                    });"
//                . "});"
//            . "</script>";
//
//    $content = apply_filters('profile_options_rcl',$content,$userdata);
//
//    $content .= wp_nonce_field( 'update-profile_' . $user_ID,'_wpnonce',true,false ).'
//        <div style="text-align:right;">'
//            . '<input type="submit" id="cpsubmit" class="recall-button" value="'.__('Update profile','wp-recall').'" onclick="return rcl_check_profile_form();" name="submit_user_profile" />
//        </div>
//    </form>';
//
//    if(rcl_get_option('delete_user_account')){
//        $content .= '
//        <form method="post" action="" name="delete_account" onsubmit="return confirm(\''.__('Are you sure? It can’t be restaured!','wp-recall').'\');">
//        '.wp_nonce_field('delete-user-'.$user_ID,'_wpnonce',true,false).'
//        <input type="submit" id="delete_acc" class="recall-button"  value="'.__('Delete your profile','wp-recall').'" name="rcl_delete_user_account"/>
//        </form>';
    //}

    return $content;
}
/**********************/

//OPERATIONS TAB
function rcl_tab_operations(){

    rcl_tab(
        array(
            'id'=>'operations',
            'name'=>'Операции',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=>'/wp-content/uploads/2019/12/operation_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_operations_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_operations_content($master_id)
{
    global $userdata, $user_ID;

    //$profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));

    $profile_args = rcl_tab_template_content();

    $exchange_requests = rcl_get_option('exchange_requests');
    $exchange_content = '';
    $client_num = get_user_meta($user_ID, 'client_num', true);
    if (isset($exchange_requests) && !empty($exchange_requests) && isset($exchange_requests[$user_ID]) && !empty($exchange_requests[$user_ID]))
    {
        foreach ($exchange_requests[$user_ID] as $key => $value)
        {
            $output_sum_to_print = !empty($value['output_sum']) ? $value['output_sum'] : $value['input_sum'];
            $output_currency_to_print = !empty($value['output_currency']) ? $value['output_currency'] : $value['input_currency'];
            $exchange_content .= '<div class="table-text w-100">
                                    <div class="row">
                                        <div class="col-2 text-center">'.
                                            $value['date'].
                                        '</div>
                                        
                                        <div class="col-2 text-center">'.
                                            $value['input_sum'].' '.$value['input_currency'].
                                        '</div>
                                        
                                        <div class="col-2 text-center">'.
                                            $value['output_currency'].
                                        '</div>
                                        
                                        <div class="col-2 text-center">'.
                                            $output_sum_to_print.' '.$output_currency_to_print.
                                        '</div>';
                                        
//                                        <div class="col-2 text-center" style="visibility: hidden">
//                                            0.9188 PZM
//                                        </div>';
            if ($value['status'] == 'paid')
                $exchange_content .= '<div class="col-3 text-center" style="font-size: 15px; color: #EF701B">
                                       Ожидает подтверждения
                                        </div>';
//                                    </div>
//                                </div>';
            //Одобренная менеджером заявка
            elseif ($value['status'] == 'awaiting_payment') {
                if ($value['input_currency'] == 'RUB')
                    $exchange_content .= '<div class="col-3 text-center">' .
                        //                                        <div class="col-12">
                        //                                            <p style="font-size: 15px; color: green">Операция одобрена. Произвести оплату:</p>
                        //                                        </div>
                        //                                        <div class="col-12">
                        '<a onclick="ipayCheckout({
                                                    amount:' . $value['input_sum'] . ',
                                                    currency:\'RUB\',
                                                    order_number:\'\',
                                                    description: \'Паевой взнос от пайщика №'.$client_num.'\'
                                                    },
                                                    function(order) { successCallback(order, event, ' . $user_ID . ', ' . $key . ') },
                                                    function(order) { failureCallback(order, event, ' . $user_ID . ', ' . $key . ') })"
                                                     
                                                class="btn-custom-one" style="display: inline-block;">Оплатить
                                                </a>' .
                        //                                        </div>
                        '</div>';
//                                        </div>
//                                    </div>';
                else
                    $exchange_content .= '<div class="col-3 text-center" style="font-size: 15px; color: #EF701B">
                                       Ожидает подтверждения
                                        </div>';
//                                    </div>
//                                </div>';
            }
            //Целевой взнос
            elseif ($value['status'] == 'deposit_other')
            {
                if ($value['input_currency'] == 'RUB')
                    $exchange_content .= '<div class="col-3 text-center">' .
                        '<a onclick="ipayCheckout({
                            amount:' . $value['input_sum'] . ',
                            currency:\'RUB\',
                            order_number:\'\',
                            description: \'Целевой взнос ' . $value['deposit_type'] . ' от пайщика №'.$client_num.'\'
                            },
                            function(order) { successCallback(order, event, ' . $user_ID . ', ' . $key . ') },
                            function(order) { failureCallback(order, event, ' . $user_ID . ', ' . $key . ') })"
                             
                            class="btn-custom-one" style="display: inline-block;">Оплатить
                        </a>' .
                        '</div>';
                else
                    $exchange_content .= '<div class="col-3 text-center" style="font-size: 15px; color: #EF701B">
                                       Ожидает подтверждения
                                        </div>';
            }

            elseif ($value['status'] == 'completed')
                $exchange_content .= '<div class="col-3 text-center" style="font-size: 15px; color: green">
                                       Завершена
                                        </div>';
//                                    </div>
//                                </div>';
//            else
//                $exchange_content .= '</div></div>';

            //Кнопка удаления
            $exchange_content .= '<div class="col-1 text-left">
                                       <a class="remove_operation" data-user_id="'.$user_ID.'" data-request_num="'.$key.'">&times;</a>
                                  </div>
                                </div>
                            </div>';
        }
        $profile_args += array("exchange_content" => $exchange_content);

    }

    $content = rcl_get_include_template('template-operations.php', __FILE__, $profile_args);
    return $content;
}
/********************************/

//DOCUMENTS TAB
function rcl_tab_documents(){

    rcl_tab(
        array(
            'id'=>'documents',
            'name'=>'Документы',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=>'/wp-content/uploads/2019/12/document_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_documents_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_documents_content($master_id)
{
    global $user_ID;
    $profile_args = rcl_tab_template_content();

//    $fields[] = array(
//        'type' => 'custom',
//        'slug' => 'user_documents',
//        'title' => 'Документы пользователя',
//        'values' => array(
//            array('date' => '08.11.19', 'filename' => 'document1.docx', 'url' => '/wp-content/uploads/2019/12/don.png'),
//            array('date' => '09.12.19', 'filename' => 'document2.docx', 'url' => '/wp-content/uploads/2019/12/operation_dis.png')
//        ),
//    );
//    $content = '';
//    foreach ($fields[count($fields) - 1]['values'] as $value)
//    {
//        $content .= '<div class="table-text w-100">' .
//            '<div class="row">' .
//            '<div class="col-2 text-center">' . $value['date'] . '</div>' .
//            '<div class="col-8 text-left">' . $value['filename'] . '</div>' .
//            '<div class="col-2 text-center">
//                <a href="' . $value['url'] . '" download>
//                    <img src="/wp-content/uploads/2019/12/don.png">
//                </a>
//            </div>
//            </div>
//            </div>';
//    }
//    $fields[count($fields) - 1] += array("content" => $content);
//    //var_dump($fields[count($fields) - 1]);
//
//    return $fields;

    $content = rcl_get_include_template('template-documents.php', __FILE__, $profile_args);
    return $content;
}
/******************************/

//PEOPLE LIST TAB
function rcl_tab_people(){

    rcl_tab(
        array(
            'id'=>'people',
            'name'=>'Люди',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=>'/wp-content/uploads/2019/12/people_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_people_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_people_content($master_id)
{
    global $userdata, $user_ID;

//    $args = array(
//        'shortcode' => do_shortcode(
//            "[userlist template='slavia' inpage='10' data='user_registered,profile_fields' orderby='user_registered' exclude='30']"
//        ),
//        'is_sort' => false
//    );
    $args = array(
        'people' => get_people('user_registered', 'DESC')
    );

    $content = rcl_get_include_template('template-people.php', __FILE__, $args);
    return $content;
}
/******************************/

//MANAGER REQUESTS TAB
function rcl_tab_requests(){

    rcl_tab(
        array(
            'id'=>'requests',
            'name'=>'Заявки',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=>'/wp-content/uploads/2019/12/zayavki_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_requests_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_requests_content($master_id)
{
    global $userdata, $user_ID;
//
//    $profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));

    $profile_args = rcl_tab_template_content();

    $verification_requests = rcl_get_option('verification_requests');
    $verification_content = '';
    if (isset($verification_requests) && !empty($verification_requests))
    {
        $i = 0;
        foreach ($verification_requests as $key => $value)
        {
            $i++;
            $verification_content .= '<div class="table-text w-100">'.
                                        '<div class="row">'.
                                            '<div class="col-2 text-left" style="padding-left: 42px;">'.
                                               $value['name'].' '.$value['surname'].' '.$value['last_name'].
                                            '</div>'.
                                            '<div class="col-2 text-left">'.
                                                get_user_meta( $key, 'client_num', true ). //Возвращает client_num по id пользователя
                                            '</div>'.
                                            '<div class="col-2 text-left">'.
                                            '</div>
                                            <div class="col-2 text-right">
                                                <img src="/wp-content/uploads/2019/12/info.png" class="info-zayavki">
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="btn-custom-one btn-zayavki" id="request_approve_'.$key.'">
                            Одобрить
                                                </div>
                                            </div>
                                            <div class="col-1 text-left">
                                               <a class="remove_operation" data-user_id="'.$key.'">&times;</a>
                                            </div>
                                        </div>
                                    </div>';
        }
        $profile_args += array("verification_content" => $verification_content);
        //$profile_args += array("verification_requests" => $verification_requests);
    }

    $exchange_requests = rcl_get_option('exchange_requests');
    $exchange_content = '';

    if (isset($exchange_requests) && !empty($exchange_requests))
    {
        foreach ($exchange_requests as $user => $requests) //Все пользователи с запросами на обмен, $user- id пользователя
        {
            $user_verification = get_user_meta($user, 'verification', true);

            if (isset($user_verification) && !empty($user_verification))
            {
                foreach ($requests as $request_num => $request_value) //Все запросы на обмен данного пользователя
                {
                    $currency_to_print = empty($request_value['output_currency']) ? $request_value['input_currency'] : $request_value['output_currency'];
                    $sum_to_print = empty($request_value['output_sum']) ? $request_value['input_sum'] : $request_value['output_sum'];

                    if ($request_value['status'] == 'awaiting_payment' || $request_value['status'] == 'paid' || $request_value['status'] == 'deposit' || $request_value['status'] == 'deposit_other')
                    {
                        $exchange_content .= '<div class="table-text w-100">
                                                <div class="row">
                                                    <div class="col-2 text-left" style="padding-left: 42px;">' .
                                                        $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
                                                    '</div>
                                                    
                                                    <div class="col-2 text-left">' .
                                                        get_user_meta($user, 'client_num', true) .
                                                    '</div>
                                                    
                                                    <div class="col-2 text-left">' .
                                                        $currency_to_print .
                                                    '</div>
                                                    
                                                    <div class="col-2 text-left">' .
                                                        $sum_to_print .
                                                        '<img src="/wp-content/uploads/2019/12/info.png" class="info-zayavki">
                                                    </div>';
                        if ($request_value['status'] == 'paid')
                            $exchange_content .= '<div class="col-3 text-center">
                                                        <p>Оплачено пользователем</p>
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="'.$request_num.'" id="request_approve_'.$user.'">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';
//                                                </div>
//                                            </div>';
                        elseif ($request_value['status'] == 'awaiting_payment')
                            $exchange_content .= '<div class="col-3 text-center">
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="'.$request_num.'" id="request_approve_'.$user.'">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';
//                                                </div>
//                                            </div>';
                        elseif ($request_value['status'] == 'deposit')
                            $exchange_content .= '<div class="col-3 text-center">
                                                        <p>Имущественный взнос</p>
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="'.$request_num.'" id="request_approve_'.$user.'">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';
                        elseif ($request_value['status'] == 'deposit_other')
                            $exchange_content .= '<div class="col-3 text-center">
                                                        <p>Целевой взнос</p>
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="'.$request_num.'" id="request_approve_'.$user.'">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';
//                                                </div>
//                                            </div>';
                        $exchange_content .= '<div class="col-1 text-left">
                                                   <a class="remove_operation" data-user_id="'.$user.'" data-request_num="'.$request_num.'">&times;</a>
                                              </div>
                                            </div>
                                         </div>';

                    } elseif ($request_value['status'] == 'completed')
                        continue;
                }
            }
            //Если нет верификации
            else
                continue;
        } //foreach внешний

        $profile_args += array("exchange_content" => $exchange_content);

    } //if exchange requests

    $content = rcl_get_include_template('template-requests.php', __FILE__, $profile_args);
    return $content;
}
/******************************/

//ADMIN SETTINGS TAB
function rcl_tab_settings(){

    rcl_tab(
        array(
            'id'=>'settings',
            'name'=>'Настройки',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=>'/wp-content/uploads/2019/12/settings_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_settings_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_settings_content($master_id)
{
//    global $userdata, $user_ID;
//
//    $profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));
//
//    $Table = new Rcl_Table(array(
//        'cols' => array(
//            array(
//                'width' => 30
//            ),
//            array(
//                'width' => 70
//            )
//        ),
//        'zebra' => true,
//        //'border' => array('table', 'rows')
//    ));
    $profile_args = rcl_tab_template_content();

    $bank_options = rcl_get_option('banks');

    $bank_content = '';
    if (isset($bank_options) && !empty($bank_options))
    {
        $i = 0;
        foreach ($bank_options as $bank)
        {
            $i++;
            $bank_content .= '<div class="col-lg-4 input-exchange input-custom-procent">'.
                                '<div class="row">'.
                                    '<a class="settings_close">&times;</a>'.
                                    '<div class="select-exchange w-100">' .
                                        '<input value="' . $bank['name'] . '" type="text" name="bank' . $i . '[name]" style="background: #fff">'.
                                        '<input class="bank_value" value="' . $bank['value'] . '" type="text" name="bank' . $i . '[value]">'.
                                    '</div>'.
                                '</div>'.
                            '</div>';
        }
        $profile_args += array("banks" => $bank_content);
    }

    //$ref_amount = rcl_get_option('ref_amount');
    $all_users = get_users( array( 'role__in' => array('manager', 'customer', 'user', 'not_verified', 'need-confirm'), 'fields' => array( 'ID', 'display_name' ) ) );

    $ref_content = '';

    if (isset($all_users) && !empty($all_users))
    {
        $index = 0;
        foreach ($all_users as $user)
        {
            $is_privileged = get_user_meta($user->ID, 'is_privileged', true);
            $ref_percent = get_user_meta($user->ID, 'ref_percent', true);

            if (isset($is_privileged) && $is_privileged == 'yes' && isset($ref_percent) && !empty($ref_percent))
            {
                $ref_content .= "<div class='col-lg-4 input-exchange input-custom-procent'>
                                    <div class='row' style='height: 100%; padding-top: 30px'>
                                        <div class='select-exchange w-100'>
                                            <div class='row'>
                                                <div class='col-8'>
                                                    <span class='select-exchange' style='display: inline-block'>Пользователь</span>
                                                </div>
                                                <div class='col-4'>
                                                    <a class='settings_close' style='display: inline-block; margin-left: -20px; margin-top: -5px'>&times;</a>
                                                </div>
                                            </div>
                                            <select name='ref_user[".$index."][id]' id='ref_user_".$index."' class='user_dropdown'>
	                                            <option value='". $user->ID ."'>". $user->display_name . "</option>
	                                        </select>
                                            <input class='ref_value' value='". $ref_percent . "' type='text' name='ref_user[". $index . "][value]'>
                                        </div>
                                    </div>
                                </div>";

                ++$index;
            }
        }
//        $ref_content .= '<div class="col-lg-4 input-exchange input-custom-procent">' .
//                        '<div class="row">' .
//                            '<span>За каждого реферала</span>' .
//                            '<input value="' . $ref_amount . '" type="text" name="ref_amount">' .
//                        '</div>' .
//                    '</div>';

        $profile_args += array('ref_content' => $ref_content);
    }

    $content = rcl_get_include_template('template-settings.php', __FILE__, $profile_args);
    return $content;
}
/******************************/

//REFERRAL SYSTEM TAB
//PEOPLE LIST TAB
function rcl_tab_referral(){

    rcl_tab(
        array(
            'id'=>'referral',
            'name'=>'Реферальная система',
            'supports'=>array('ajax'),
            'public'=>0,
            'icon'=> '/wp-content/uploads/2020/04/refer_dis.png',//'/wp-content/uploads/2019/12/people_dis.png',
            'content'=>array(
                array(
                    'callback' => array(
                        'name'=>'rcl_tab_referral_content'
                    )
                )
            )
        )
    );

}
function rcl_tab_referral_content($master_id)
{
    global $userdata, $user_ID;

    $profile_args = rcl_tab_template_content();

    $ref_awards = new Ref_Awards();

    //$ref_awards->clear_all();

    if (rcl_get_current_role() == 'manager' || rcl_get_current_role() == 'administrator' || rcl_get_current_role() == 'director')
    {
        $ref_all = array(
            "unpaid" => $ref_awards->get_operations_by(array("status" => "processing")),
            "paid" => $ref_awards->get_operations_by(array("status" => "paid")),
            "user_ids" => $ref_awards->get_all_ref_users()
        );

        $profile_args += array("ref_all" => $ref_all);
    }
    else
    {
        $ref_cur_user = array(
            "unpaid" => $ref_awards->get_operations_by(array(
                "status" => "processing",
                "host_id" => $user_ID
            )),
            "paid" => $ref_awards->get_operations_by(array(
                "status" => "paid",
                "host_id" => $user_ID
            )),
            "user_ids" => array($user_ID), //id пользователей для статистики
            "ref_ids" => $ref_awards->get_user_refs($user_ID) //id рефералов данного пользователя

        );
        //$log = new Rcl_Log();
        //$log->insert_log("cur_user_ref: ".print_r($ref_cur_user, true));

        $profile_args += array("ref_cur_user" => $ref_cur_user);
    }

    $content = rcl_get_include_template('template-referral.php', __FILE__, $profile_args);
    return $content;
}
/************************************/


add_action('rcl_bar_setup','rcl_bar_add_profile_link',10);
function rcl_bar_add_profile_link(){
    global $user_ID;

    if(!is_user_logged_in()) return false;

    rcl_bar_add_menu_item('profile-link',
        array(
            'url'=> rcl_get_tab_permalink($user_ID,'profile'),
            'icon'=>'fa-user-secret',
            'label'=>__('Profile settings','wp-recall')
        )
    );

}

add_action('init','rcl_add_block_show_profile_fields');
function rcl_add_block_show_profile_fields(){
    rcl_block('details','rcl_show_custom_fields_profile',array('id'=>'pf-block','order'=>20,'public'=>1));
}

function rcl_show_custom_fields_profile($master_id){

    $get_fields = rcl_get_profile_fields();

    $show_custom_field = '';

    if($get_fields){

        $get_fields = stripslashes_deep($get_fields);

        $cf = new Rcl_Custom_Fields();

        foreach((array)$get_fields as $custom_field){
            $custom_field = apply_filters('custom_field_profile',$custom_field);
            if(!$custom_field) continue;
            $slug = isset($custom_field['name'])? $custom_field['name']: $custom_field['slug'];
            if(isset($custom_field['req'])&&$custom_field['req']==1){
                $meta = get_the_author_meta($slug,$master_id);
                $show_custom_field .= $cf->get_field_value($custom_field,$meta);
            }
        }
    }

    if(!$show_custom_field) return false;

    return '<div class="show-profile-fields">'.$show_custom_field.'</div>';
}

if(!is_admin()) add_action('wp','rcl_update_profile_notice');
function rcl_update_profile_notice(){
    if (isset($_GET['updated']))
        rcl_notice_text(__('Your profile has been updated','wp-recall'),'success');
}

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

function sort_assoc(&$arr, $sort_field, $order)
{
    $arg_array = array("sort_field" => $sort_field, "order" => $order);
    //uasort
    usort($arr, function($a, $b) use ($arg_array) {
        $sort_field = $arg_array["sort_field"];
        $order = $arg_array["order"];

        //$log = new Rcl_Log();

        $var1 = $a[$sort_field];
        $var2 = $b[$sort_field];

        if ($order == 'ASC')
            $multiplicator = 1;
        elseif ($order == 'DESC')
            $multiplicator = -1;

//        if ($sort_field == 'client_num')
//        {
        //Сравнение с пустыми, чтобы незаполненные оказались в конце сортировки
        if ($order == 'ASC') {
            //assume var1>var2 (var1 to the end)
            if (empty($var1) && !empty($var2))
                return $multiplicator * 1;
            //assume var2>va1
            if (!empty($var1) && empty($var2))
                return $multiplicator * (-1);
        }
        if ($order == 'DESC') {
            //assume var1<var2
            if (empty($var1) && !empty($var2))
                return $multiplicator * (-1);
            //assume var2<var1
            if (!empty($var1) && empty($var2))
                return $multiplicator * 1;
        }
        if (empty($var1) && empty($var2))
            return 0;
        //}

        //$log->insert_log("var1=".$var1."; var2=".$var2);

        if ($var1 == $var2) {
            return 0;
        }

        return ($var1 < $var2) ? ($multiplicator * (-1)) : $multiplicator * 1;
    });
}

function get_people($sort_field, $order = 'DESC')
{
    $users = get_users(
        array(
            'fields' => array('ID', 'display_name', 'user_registered'),
            'exclude' => 30,
            //'order_by' => 'user_registered',
            //'order' => 'DESC'
        )
    );
    $user_arr = array();
    foreach ($users as $user)
    {
        $client_num = get_user_meta($user->ID, 'client_num', true);
        $is_verified = get_user_meta($user->ID, 'is_verified', true);

        array_push($user_arr, array(
            'id' => $user->ID,
            'display_name' => $user->display_name,
            'user_registered' => $user->user_registered,
            'client_num' => $client_num,
            'is_verified' => $is_verified
        ));
//        $user_arr += array(
//            $user->ID =>
//            )
//        );
    }

    $log = new Rcl_Log();
    //$log->insert_log("sort_field: ".$sort_field);

    sort_assoc($user_arr, $sort_field, $order);

    //$log->insert_log("arr: ".print_r($user_arr, true));
    return $user_arr;

}

function save_exchange_request($input_currency, $input_sum, $output_currency = false, $output_sum = false, $bank = false, $card_num = false, $card_name = false)
{
    global $user_ID;
    $exchange_requests = rcl_get_option('exchange_requests');
    //var_dump($exchange_requests);
    $exchange_fields = array();
    $exchange_fields += array('input_currency' => stripslashes($input_currency));
    $exchange_fields += array('output_currency' => stripslashes($output_currency));
    $exchange_fields += array('input_sum' => $input_sum);
    $exchange_fields += array('output_sum' => $output_sum);

    $exchange_fields += array('bank' => $bank);

    $exchange_fields += array('card_num' => stripslashes($card_num));
    $exchange_fields += array('card_name' => stripslashes($card_name));

    date_default_timezone_set('Europe/Moscow');

    $exchange_fields += array('date' => date('d.m.y H:i:s'));

    if ($output_currency == false && $output_sum == false && $bank == false)
        $exchange_fields += array('status' => 'deposit');
    else
        $exchange_fields += array('status' => 'awaiting_payment');

    if (isset($exchange_requests) && !empty($exchange_requests))
    {
        if (isset($exchange_requests[$user_ID]) && !empty($exchange_requests[$user_ID]))
        {
            /*$new_request = array();*///array(count($exchange_requests[$user_ID]) => $exchange_fields);
            //array_push($new_request, $exchange_fields);

            array_push($exchange_requests[$user_ID], $exchange_fields);
            //$exchange_requests[$user_ID] = $new_request;
        }
        elseif (!isset($exchange_requests[$user_ID]))
        {
            $new_request = array(0 => $exchange_fields);
            //array_push($new_request, $exchange_fields);

            $exchange_requests += array($user_ID => $new_request); //Если еще нет запросов для этого пользователя, добавляем ключ id этого пользователя
        }
        elseif (empty($exchange_requests[$user_ID]))
        {
            //$new_request = array(0 => $exchange_fields);

            //array_push($new_request, $exchange_fields);

            array_push($exchange_requests[$user_ID], $exchange_fields);
            //$exchange_requests[$user_ID] = $new_request;
        }
    }
    //Если еще нету запросов на обмен
    else
    {
        $new_request = array(0 => $exchange_fields);

        $exchange_requests = array($user_ID => $new_request);
    }

    //$log = new Rcl_Log();
//    $log->insert_log("exchange normal:".print_r($exchange_fields, true));

    rcl_update_option('exchange_requests', $exchange_requests);

    //$log->insert_log("host:".$_SERVER['HTTP_HOST']);
    //var_dump($_SERVER['HTTP_HOST']);
}
function save_exchange_request_other(
    $input_currency, $input_sum, $requisites, $deposit_type = false, $output_sum = false,
    $output_currency = false, $bank = false, $card_num = false, $card_name = false)
{

    global $user_ID;
    $exchange_requests = rcl_get_option('exchange_requests');

    $exchange_fields = array();
    $exchange_fields += array('input_sum' => $input_sum);
    $exchange_fields += array('input_currency' => stripslashes($input_currency));
    $exchange_fields += array('output_sum' => $output_sum);
    $exchange_fields += array('output_currency' => stripslashes($output_currency));

    $exchange_fields += array('bank' => $bank);
    $exchange_fields += array('card_num' => $card_num);
    $exchange_fields += array('card_name' => stripslashes($card_name));

    $exchange_fields += array('requisites' => $requisites);

    date_default_timezone_set('Europe/Moscow');

    $exchange_fields += array('date' => date('d.m.y H:i:s'));

    if ($deposit_type === false)
        $exchange_fields += array('status' => 'awaiting_payment');
    else {
        $exchange_fields += array('deposit_type' => $deposit_type);
        $exchange_fields += array('status' => 'deposit_other');
    }

    if (isset($exchange_requests) && !empty($exchange_requests))
    {
        if (isset($exchange_requests[$user_ID]) && !empty($exchange_requests[$user_ID]))
        {
            /*$new_request = array();*///array(count($exchange_requests[$user_ID]) => $exchange_fields);
            //array_push($new_request, $exchange_fields);

            array_push($exchange_requests[$user_ID], $exchange_fields);
            //$exchange_requests[$user_ID] = $new_request;
        }
        elseif (!isset($exchange_requests[$user_ID]))
        {
            $new_request = array(0 => $exchange_fields);
            //array_push($new_request, $exchange_fields);

            $exchange_requests += array($user_ID => $new_request); //Если еще нет запросов для этого пользователя, добавляем ключ id этого пользователя
        }
        elseif (empty($exchange_requests[$user_ID]))
        {
            //$new_request = array(0 => $exchange_fields);

            //array_push($new_request, $exchange_fields);

            array_push($exchange_requests[$user_ID], $exchange_fields);
            //$exchange_requests[$user_ID] = $new_request;
        }
    }
    //Если еще нету запросов на обмен
    else
    {
        $new_request = array(0 => $exchange_fields);

        $exchange_requests = array($user_ID => $new_request);
    }

    $log = new Rcl_Log();
    //$log->insert_log("currency: ".$input_currency);
//    $log->insert_log("exchange other:".print_r($exchange_fields, true));

    rcl_update_option('exchange_requests', $exchange_requests);
}

function get_russian_month($month_num)
{
    switch ($month_num) {
        case 1:
            return 'января';
        case 2:
            return 'февраля';
        case 3:
            return 'марта';
        case 4:
            return 'апреля';
        case 5:
            return 'мая';
        case 6:
            return 'июня';
        case 7:
            return 'июля';
        case 8:
            return 'августа';
        case 9:
            return 'сентября';
        case 10:
            return 'октября';
        case 11:
            return 'ноября';
        case 12:
            return 'декабря';
    }
}

function get_bank_commission($bank)
{
    $bank_options = rcl_get_option('banks');
    if (isset($bank_options) && !empty($bank_options))
    {
        return $bank_options[$bank]['value'];
    }
    else
        return false;
}

/////////////////////////
function sort_people_tab_data($data){
    if($data['id']!='people') return $data;
    $data['content'][0]['callback'] = array(
        'name' => 'sort_people',
        'args' => array(true, 'client_num')
    );
    $log = new Rcl_Log();
    $log->insert_log("data: ".print_r($data, true));
    return $data;
}

function unsort_people_tab_data($data){
    if($data['id']!='people') return $data;
    $data['content'][0]['callback'] = array(
        'name' => 'sort_people',
        'args' => array(false, 'client_num')
    );
    $log = new Rcl_Log();
    $log->insert_log("data: ".print_r($data, true));
    return $data;
}

function sort_people($is_sort, $sort_field){
    $args = array();
    if ($is_sort) {
        $args += array(
            'shortcode' => do_shortcode("[userlist template='slavia' inpage='10' data='user_registered,profile_fields' orderby='" .
                $sort_field . "' order='DESC' exclude='30']"),
            'is_sort' => true
        );
    }
    else
    {
        $args += array(
            'shortcode' => do_shortcode(
                "[userlist template='slavia' inpage='10' data='user_registered,profile_fields' orderby='user_registered' exclude='30']"
            ),
            'is_sort' => false
        );
    }
    $content = rcl_get_include_template('template-people.php', __FILE__, $args);
    return $content;
}
///////////////////////////////////

//Обновляем профиль пользователя
add_action('wp', 'rcl_edit_profile', 10);
function rcl_edit_profile(){
    global $user_ID, $userdata;

    //if( !wp_verify_nonce( $_POST['_wpnonce'], 'update-profile_' . $user_ID ) ) return false;
//    if ( isset( $_POST['submit_user_profile']))
//        rcl_update_profile_fields($user_ID);
    if (isset($_POST) && count($_POST) > 0)
    {
        $log = new Rcl_Log();
        //var_dump($_POST);
        //$log->insert_log("post: ".print_r($_POST, true));
        //Если добавление банков
        if (strpos(array_key_first($_POST), 'bank') !== false )
        {
            $new_banks = array();
            foreach ($_POST as $key => $value)
            {
                if (strpos($key, 'submit_settings_banks') !== false)
                    continue;
                else
                {
                    $new_banks += array($key => $value);
                }
            }
            rcl_update_option('banks', $new_banks);

            $redirect_url = rcl_get_tab_permalink($user_ID, 'settings') . '&updated=true';

            wp_redirect($redirect_url);

            exit;
        }
        elseif (in_array('ref_normal_users', array_keys($_POST) ) && !in_array('ref_user_id', array_keys($_POST) ))
        {
//            $ref_amount = 0;
//            foreach ($_POST as $key => $value)
//            {
//                if (strpos($key, 'ref_amount') !== false)
//                    $ref_amount = $value;
//                else
//                    continue;
//            }
//            rcl_update_option('ref_amount', $ref_amount);
//            if (!empty($_POST['ref_user']))
//            {
            rcl_update_option('ref_percent_normal', $_POST['ref_normal_users']['value']);

            $all_users = get_users( array( 'role__in' => array('manager', 'customer', 'user', 'not_verified', 'need-confirm'), 'fields' => array( 'ID' ) ) );

            foreach ($all_users as $user)
            {
                $user_found = false;
                $ref_percent = get_user_meta($user->ID, 'ref_percent', true);

                foreach ($_POST['ref_user'] as $index => $userdata)
                {
                    if ($user->ID == $userdata['id'])
                    {
                        $user_found = true;
                        $profileFields = rcl_get_profile_fields(array('user_id' => $userdata['id']));
                        foreach ($profileFields as $field) {
                            if ($field['slug'] == 'ref_percent') {
                                if (isset($field['value']))
                                    $field['value'] = $userdata['value'];
                                else
                                    $field += array('value' => $userdata['value']);

                                rcl_update_profile_fields($userdata['id'], array($field));
                                continue;
                            }
                            if ($field['slug'] == 'is_privileged')
                            {
                                if (isset($field['value']))
                                    $field['value'] = 'yes';
                                else
                                    $field += array('value' => 'yes');

                                rcl_update_profile_fields($userdata['id'], array($field));
                                break;
                            }
                        }

                    }
                } //foreach POST['ref_user']
                //Если пользователя нету в POST, то зануляем у него реферальный процент
                if (!$user_found/* && !empty($ref_percent)*/) {
                    update_user_meta($user->ID, 'ref_percent', $_POST['ref_normal_users']['value']);
                    update_user_meta($user->ID, 'is_privileged', 'no');
                }

            }
            //}
            //var_dump($_POST);

            $redirect_url = rcl_get_tab_permalink($user_ID, 'settings') . '&updated=true';

            wp_redirect($redirect_url);

            exit;
        }
        //Если верификация
        elseif (strpos(array_key_first($_POST), 'verification') !== false )
        {
            //var_dump($_POST);
            /*****************Сохраняем в запросы на верификацию******************/
            $verification_requests = rcl_get_option('verification_requests');

            $verification_exists = false;
            if (isset($verification_requests) && !empty($verification_requests))
            {
                foreach ($verification_requests as $key => $value)
                {
                    if ($key == $user_ID) {
                        $verification_exists = true;
                        break;
                    }
                }
            }
            $verification_fields = array();
            foreach ($_POST['verification'] as $key => $value) {
                if (strpos($key, 'submit') !== false)
                    continue;
                else {
                    $verification_fields += array($key => $value);
                }
            }
            $verification_fields += array('date' => date('d.m.y'));
            if (isset($verification_requests) && !empty($verification_requests)) {
                //Если нету заявок от этого же пользователя на верификацию
                if (!$verification_exists)
                    $verification_requests += array($user_ID => $verification_fields);
                //Если есть верификация от этого пользователя, перезаписываем ее
                else
                    $verification_requests[$user_ID] = $verification_fields;
            }
            else
                $verification_requests = array($user_ID => $verification_fields); //Если нет запросов, добавляем новый

            rcl_update_option('verification_requests', $verification_requests);

            /**********************************************************************/

            /*************Сохраняем верификацию в поля профиля*******************************/

            $profileFields = rcl_get_profile_fields(array('user_id' => $user_ID));

            //$post_first_key = current(array_keys($_POST));
            $field_found = false;
            foreach ($profileFields as $field)
            {
                if ($field['slug'] == 'verification') {
                    $field += array('value' => $verification_fields);

                    rcl_update_profile_fields($user_ID, array($field));
                    $field_found = true;
                    continue;
                    //break;
                }
                if ($field['slug'] == 'passport_photos' && isset($_FILES) && !empty($_FILES)) {
                    //Загружаем файлы
                    if ( ! function_exists( 'wp_handle_upload' ) ) {
                        require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    }
                    $field += array('value' => array());
                    for ($i=0; $i < count($_FILES['passport_photos']['name']); $i++)
                    {
                        $filetype	 = wp_check_filetype_and_ext( $_FILES['passport_photos']['tmp_name'][$i], $_FILES['passport_photos']['name'][$i] );

                        if (! in_array( $filetype['ext'], array('jpeg', 'gif', 'bmp', 'png', 'webp','JPEG', 'GIF', 'BMP', 'PNG', 'WEBP', 'jpg', 'JPG'))) {
                            wp_die(__('Prohibited file type!', 'wp-recall'));
                            exit;
                        }
                        $maxsize = 5;
                        if ( $_FILES['passport_photos']['size'][$i] > $maxsize * 1024 * 1024 ) {
                            wp_die(__('File size exceedes maximum!', 'wp-recall'));
                            exit;
                        }

                        $info = pathinfo( $_FILES['passport_photos']['name'][$i] );
                        if( ! empty( $info['extension'] ) )
                            $_FILES['passport_photos']['name'][$i]  = sprintf( 'passport_photo_%s.%s', current_time( 'm-d-H-i-s' ), $info['extension'] );

                        $uploadedfile = array(
                            'name'     => $_FILES['passport_photos']['name'][$i],
                            'type'     => $_FILES['passport_photos']['type'][$i],
                            'tmp_name' => $_FILES['passport_photos']['tmp_name'][$i],
                            'error'    => $_FILES['passport_photos']['error'][$i],
                            'size'     => $_FILES['passport_photos']['size'][$i]
                        );

                        $file = wp_handle_upload( $uploadedfile, array( 'test_form' => FALSE ) );

                        if ($file && !isset( $file['error'] ))
                            if ( $file['url'] ) {
                                $attachment = array(
                                    'post_mime_type' => $file['type'],
                                    'post_title'	 => preg_replace( '/\.[^.]+$/', '', basename( $file['file'] ) ),
                                    'post_name'		 => 'passport_photos' . '-' . $user_ID . '-' . 0,
                                    'post_content'	 => '',
                                    'guid'			 => $file['url'],
                                    'post_parent'	 => 0,
                                    'post_author'	 => $user_ID,
                                    'post_status'	 => 'inherit'
                                );

                                $attach_id	 = wp_insert_attachment( $attachment, $file['file'], 0);
                                $attach_data = wp_generate_attachment_metadata( $attach_id, $file['file'] );

                                wp_update_attachment_metadata( $attach_id, $attach_data );
                                $field['value'][] = $file['url'];
                                continue;
                            }
                        else
                        {
                            wp_die($file['error']);
                            exit;
                        }
                    }
                    //Добавляем ссылки на файлы в verification_requests
                    $verification_requests = rcl_get_option('verification_requests');
                    foreach ($verification_requests as $key => $value)
                    {
                        if ($key == $user_ID) {
                            $verification_requests[$key] += array('passport_photos' => $field['value']);
                            break;
                        }
                    }
                    rcl_update_option('verification_requests', $verification_requests);

                    //$field += array('value' => $verification_fields);
                    rcl_update_profile_fields($user_ID, array($field));
                    $field_found = true;
                    continue;
                }

                if ($field['slug'] == 'is_verified') {
                    if (isset($field['value']))
                        $field['value'] = 'waiting';
                    else
                        $field += array('value' => 'waiting');

                    rcl_update_profile_fields($user_ID, array($field));
                    //$field_found = true;
                    continue;
                    //break;
                }
            }

//            $log->insert_log(print_r(rcl_get_profile_fields(array('user_id' => $user_ID)), true));
            if (!$field_found)
                return false;

            /********************************************************************/

            $redirect_url = rcl_get_tab_permalink($user_ID, 'profile') . '&updated=true';

            wp_redirect($redirect_url);
            exit;
        }

        //Запрос на user_id из manager_requests
        elseif (isset($_POST['request_user_id']) && !empty($_POST['request_user_id'])) {
            if (isset($_POST['is_exchange']) && $_POST['is_exchange'] == 'false') {
                $verification_requests = rcl_get_option('verification_requests');

                if (isset($verification_requests) && !empty($verification_requests)) {
                    //Одобрение заявки на верификацию
                    if (isset($_POST['approve_request']) && $_POST['approve_request'] == 'true') {
                        //Обновить is_verified на true
                        $profileFields = rcl_get_profile_fields(array('user_id' => $_POST['request_user_id']));
                        foreach ($profileFields as $field)
                            if ($field['slug'] == 'is_verified') {
                                if (isset($field['value']))
                                    $field['value'] = 'yes';
                                else
                                    $field += array('value' => 'yes');
                                rcl_update_profile_fields($_POST['request_user_id'], array($field));
                                break;
                            }
                        //update_user_meta($_POST['request_user_id'], 'is_verified', 'yes');
                        foreach ($verification_requests as $key => $value) {
                            if ($key == $_POST['request_user_id']) {
                                unset($verification_requests[$key]);
                                rcl_update_option('verification_requests', $verification_requests);
                                //echo print_r(rcl_get_option('verification_requests'), true);
                                break;
                            }
                        }
                        //Меняем роль пользователя
                        $userRoles = get_userdata($_POST['request_user_id'])->roles;
                        if (!in_array("manager", $userRoles) && !in_array("director", $userRoles) && !in_array("administrator", $userRoles))
                            wp_update_user(array('ID' => $_POST['request_user_id'], 'role' => 'user'));

                        //Отправка письма об успешной верификации данному пользователю
                        $subject = 'Ваш профиль был верифицирован!';
                        $textmail = '<p>Ваш профиль был успешно верифицирован и теперь вы сможете совершать операции по обмену.</p>'.
                                    '<p>Перейдите на сайт '. $_SERVER['HTTP_HOST'] . ', чтобы начать совершать операции.</p>';
                        $user_info = get_userdata($_POST['request_user_id']);
                        $user_email = $user_info->user_email;
                        //echo $user_email;
                        rcl_mail( $user_email, $subject, $textmail );
                        echo 'true';
                        exit;
                    }
                    else //Получаем верификационные данные для вкладки "заявки"
                        {
                        foreach ($verification_requests as $key => $value) {
                            if ($key == $_POST['request_user_id']) {
                                echo json_encode($value);
                                break;
                            }
                        }
                        exit;
                    }
                }
            }
            elseif (isset($_POST['is_exchange']) && $_POST['is_exchange'] == 'true')
            {
                $user_verification = get_user_meta($_POST['request_user_id'], 'verification', true);
                //$user_passport_photos = get_user_meta($_POST['request_user_id'], 'passport_photos', true);
//                if (!empty($user_passport_photos))
//                    $user_verification += array('passport_photos' => $user_passport_photos);
                $exchange_requests = rcl_get_option('exchange_requests');

                if (isset($exchange_requests) && !empty($exchange_requests))
                {
                    if (isset($_POST['request_num'])) {
                        $request_num = $_POST['request_num'];
                        $userid = $_POST['request_user_id'];
                        $request = $exchange_requests[$userid][$request_num];

                        $input_currency = $request['input_currency'];
                        $output_currency = $request['output_currency'];
                        $input_sum = $request['input_sum'];
                        $output_sum = $request['output_sum'];
                        $date = $request['date'];
//                        $bank = $request['bank'];
//                        $card_num = $request['card_num'];
//                        $card_name = $request['card_name'];

                        //Прибавляем поля запроса на обмен к user_verification, потому что так удобнее и там уже получены все поля верификации
                        if (isset($input_currency))
                            $user_verification += array('input_sum' => $input_sum.' '.$input_currency);
                        if (isset($output_currency))
                            $user_verification += array('output_sum' => $output_sum.' '.$output_currency);
                        if (isset($date))
                            $user_verification += array('exchange_date' => $date);

                        if (isset($request['bank']) && !empty($request['bank']))
                        {
                            //Возвращаем название банка из бд из таблицы опций wordpress
                            $banks = rcl_get_option('banks');
                            $bank_name = $banks[$request['bank']]['name'];

                            if (isset($bank_name) && !empty($bank_name))
                                $user_verification += array('bank' => $bank_name);
                        }
                        if (isset($request['card_num']))
                            $user_verification += array('card_num' => $request['card_num']);
                        if (isset($request['card_name']))
                            $user_verification += array('card_name' => $request['card_name']);

//                        $log->insert_log("date: ".print_r($user_verification, true));
                    }
                }
                if (!empty($user_verification))
                    echo json_encode($user_verification);
                else
                    echo 'false';
                exit;
            }
            //Одобрение запроса на обмен
            elseif (isset($_POST['approve_exchange']) && $_POST['approve_exchange'] == 'true')
            {
                $exchange_requests = rcl_get_option('exchange_requests');

                if (isset($exchange_requests) && !empty($exchange_requests))
                {
                    if (isset($_POST['request_num']))
                    {

                        $request_num = $_POST['request_num'];
                        $userid = $_POST['request_user_id'];
                        $ref_host = get_user_meta($userid, 'ref_host', true);

                        $input_currency = $exchange_requests[$userid][$request_num]['input_currency'];
                        $output_currency = $exchange_requests[$userid][$request_num]['output_currency'];
                        $input_sum = $exchange_requests[$userid][$request_num]['input_sum'];
                        $output_sum = $exchange_requests[$userid][$request_num]['output_sum'];

                        //Добавляем в статистику
                        add_stats($userid, $input_currency, $input_sum, $output_currency, $output_sum);
                        /*****************/

                        $exchange_requests[$userid][$request_num]['status'] = 'completed';
                        rcl_update_option('exchange_requests', $exchange_requests);

                        $profileFields = rcl_get_profile_fields(array('user_id' => $userid));


                        //Если есть пригласивший
                        if (!empty($ref_host) && !isset($exchange_requests[$userid][$request_num]['deposit_type']) &&
                            !empty($exchange_requests[$userid][$request_num]['output_sum']) && !empty($exchange_requests[$userid][$request_num]['output_currency']))
                        {
                            $ref_host_name = get_userdata($ref_host);
                            $ref_host_name = $ref_host_name->display_name;
                            $current_user_id = $userid;
                            $current_user_name = get_userdata($userid);
                            $current_user_name = $current_user_name->display_name;
                            $ref_amount = get_user_meta($ref_host, 'ref_percent', true);//rcl_get_option('ref_amount');
                            if (!isset($ref_amount) || empty($ref_amount))
                                $ref_amount = 0;
                            $award = $exchange_requests[$userid][$request_num]['input_sum'] * ($ref_amount /100);
                            $award_currency = $exchange_requests[$userid][$request_num]['input_currency'];
                            $award_currency = stripslashes($award_currency);

                            $host_client_num = get_user_meta($ref_host, 'client_num', true);

                            $ref_awards = new Ref_Awards();

                            date_default_timezone_set('Europe/Moscow');
                            $ref_data = array(
                                "date" => date('d.m.y H:i:s'),
                                "host_name" => $ref_host_name,
                                "host_id" => $ref_host,
                                'host_client_num' => $host_client_num,
                                "ref_name" => $current_user_name,
                                "ref_id" => $current_user_id,
                                "award_sum" => $award,
                                "award_currency" => $award_currency,
                                "status" => "processing");

                            //$log->insert_log("ref_awards: " . print_r($ref_awards, true));
                            $ref_awards->add($ref_host, $ref_data);

                            //Меняем массив данных для передачи в функцию operation_notify

                            unset($ref_data['date']);
                            unset($ref_data['status']);

                            $ref_awards->operation_notify($ref_data, true, true);
                        }

                        //Генерируем документ
                        foreach ($profileFields as $field) {
                            if ($field['slug'] == 'user_documents') {

                                $request = $exchange_requests[$userid][$request_num];

                                $doc_fields = get_doc_fields(array(
                                    "request" => $request,
                                    "user_id" => $userid
                                    )
                                );
                                $is_deposit = $doc_fields['is_deposit'];
                                $input_doc_fields = $doc_fields['input_fields'];

                                //$log->insert_log("doc_fields: ".print_r($doc_fields, true));

                                //$log->insert_log("request: ".print_r($request, true));
                                if (!$is_deposit)
                                    $output_doc_fields = $doc_fields['output_fields'];

//                                $log->insert_log("input_doc_fields: ".print_r($input_doc_fields, true));
//                                $log->insert_log("output_doc_fields: ".print_r($output_doc_fields, true));
                                //$log->insert_log("is_deposit: ".$is_deposit);
                                //Взнос на целевую программу
                                if ($is_deposit && isset($request['deposit_type']) && !empty($request['deposit_type'])) {
                                    $filename1 = 'Акт внесение целевого взноса'.$input_doc_fields['currency'];
                                    $new_doc1 = get_new_document_field($userid, exchange_doc_template($input_doc_fields), $filename1);
                                }
                                //Иной паевой взнос без второй валюты
                                elseif ($is_deposit && !isset($request['deposit_type']) && empty($request['output_currency']) )
                                {
                                    $filename1 = 'Акт приема ' . $input_doc_fields['currency'];
                                    $new_doc1 = get_new_document_field($userid, exchange_doc_template($input_doc_fields), $filename1);
                                }
                                elseif (!$is_deposit)
                                {
                                    $filename1 = 'Акт приема ' . $input_doc_fields['currency'];
                                    $filename2 = 'Акт возврата паевого взноса ' . $output_doc_fields['currency'];
                                    $new_doc1 = get_new_document_field($userid, exchange_doc_template($input_doc_fields), $filename1);
                                    $new_doc2 = get_new_document_field($userid, exchange_doc_template($output_doc_fields), $filename2);
                                }

                                $log->insert_log("doc_1: ".print_r($new_doc1, true));
                                //$log->insert_log("doc_2: ".print_r($new_doc2, true));
                                if (($is_deposit && !empty($new_doc1)) || (!$is_deposit && !empty($new_doc1) && !empty($new_doc2)))
                                {

                                    if (!isset($field['value']))
                                        $field += array('value' => array());

                                    $field_value = get_user_meta($userid, 'user_documents', true);

                                    if (empty($field_value) || count($field_value) == 0) {
                                        if ($is_deposit)
                                            $field['value'] = array('0' => $new_doc1);
                                        else
                                            $field['value'] = array('0' => $new_doc1, '1' => $new_doc2);
                                    }
                                    else //user documents not empty
                                    {
                                        $field['value'] = $field_value;
                                        if ($is_deposit)
                                            array_push($field['value'], $new_doc1);
                                            //$field['value'] += array(count($field['value']) => $new_doc1);
                                        else
                                            {
                                            //array_push($field['value'], $new_doc1)
                                            array_push($field['value'], $new_doc1);
                                            array_push($field['value'], $new_doc2);
                                            //$field['value'] += array(count($field['value']) => $new_doc1, (count($field['value']) + 1) => $new_doc2);
                                        }
                                    }

                                    //$log->insert_log("field: ".print_r($field, true));
                                    rcl_update_profile_fields($_POST['request_user_id'], array($field));
                                }
                                break;
                            }
                        }
                        //}
                        echo 'true';
                    }
                    else
                        echo 'false';
                    exit;
                }
            }

            //Модальное окно пользователя на странице люди
            elseif (isset($_POST['get_user_operations']) && $_POST['get_user_operations'] == 'true')
            {
                if (isset($_POST['get_user_stats']) && $_POST['get_user_stats'] == 'true')
                {
                    //Получаем запросы на обмен для данного пользователя
                    $user_id = $_POST['request_user_id'];
                    $exchange_requests = rcl_get_option('exchange_requests');
                    $exchange_content = '';
                    $response = array();
                    if (isset($exchange_requests) && !empty($exchange_requests) &&
                        isset($exchange_requests[$user_id]) && !empty($exchange_requests[$user_id]))
                    {
                        foreach ($exchange_requests[$user_id] as $key => $value) {
                            $exchange_content .= '<div class="table-text w-100">
                                                    <div class="row">
                                                        <div class="col-2 text-center">' .
                                                $value['date'] .
                                                '</div>
                                        
                                                        <div class="col-2 text-center">' .
                                                $value['input_currency'] .
                                                '</div>
                                                        
                                                        <div class="col-2 text-center">' .
                                                $value['output_currency'] .
                                                '</div>
                                                        
                                                        <div class="col-2 text-center">' .
                                                $value['output_sum'] . ' ' . $value['output_currency'] .
                                                '</div>';

//                                        <div class="col-2 text-center" style="visibility: hidden">
//                                            0.9188 PZM
//                                        </div>';
                            if ($value['status'] == 'awaiting_payment')
                                $exchange_content .= '<div class="col-4 text-center" style="font-size: 15px; color: #EF701B">
                                       Ожидает оплаты
                                        </div>
                                    </div>
                                </div>';
                            //Оплаченная пользователем заявка
                            elseif ($value['status'] == 'paid' && $value['input_currency'] == 'RUB')
                                $exchange_content .= '<div class="col-4 text-center" style="font-size: 15px; color: #EF701B">
                                                        Ожидает подтверждения
                                                    </div>
                                                </div>
                                            </div>';

                            elseif ($value['status'] == 'completed')
                                $exchange_content .= '<div class="col-4 text-center" style="font-size: 15px; color: green">
                                       Завершена
                                        </div>
                                    </div>
                                </div>';
                            else
                                $exchange_content .= '</div></div>';
                        } //foreach

                    } //if exchange_requests
                    else //Если для данного пользователя нет операций
                    {
                        $exchange_content .= '<div class="table-text w-100">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        Данный пользователь еще не совершал операций.
                                                    </div>
                                                </div>
                                              </div>';
                    }
                    $response += array('exchange_content' => $exchange_content);

//                    $stats = rcl_get_option('user_stats');
//                    $stats_content = '';
//                    $currencies = array('RUB', 'PRIZM', 'WAVES');
//                    if (isset($stats[$user_id]) && !empty($stats[$user_id]))
//                    {
//                        $user_verification = get_user_meta($user_id, 'verification', true);
//
//                        if (isset($user_verification) && !empty($user_verification))
//                        {
//                            $user_stats = $stats[$user_id];
//                            foreach ($currencies as $currency)
//                            {
//                                if (!isset($user_stats[$currency]))
//                                    $user_stats += array($currency => array('input_sum' => 0, 'output_sum' => 0,'exchange_num' => 0));
//                            }
//                            $stats_content .= '<div class="table-text w-100">
//                                                    <div class="row">
//                                                        <div class="col-2 text-center stats_col" style="padding-left: 25px;">'.
//                                                            $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
//                                                        '</div>
//                                                         <div class="col-2 text-center stats_col">' .
//                                                            get_user_meta($user_id, 'client_num', true) .
//                                                        '</div>'.
//                                                        //RUB
//                                                        '<div class="col-2 text-center stats_col">'.
//                                                            $user_stats['RUB']['input_sum']. ' RUB'.
//                                                        '</div>
//                                                        <div class="col-1 text-center stats_col">'.
//                                                            $user_stats['RUB']['exchange_num'].
//                                                        '</div>'.
//                                                        //PRIZM
//                                                        '<div class="col-2 text-center stats_col">'.
//                                                            $user_stats['PRIZM']['input_sum'].' PRIZM'.
//                                                        '</div>
//                                                        <div class="col-1 text-center stats_col">'.
//                                                            $user_stats['PRIZM']['exchange_num'].
//                                                        '</div>'.
//                                                        //WAVES
//                                                        '<div class="col-1 text-center stats_col">'.
//                                                            $user_stats['WAVES']['input_sum']. ' WAVES'.
//                                                        '</div>
//                                                        <div class="col-1 text-center stats_col">'.
//                                                            $user_stats['WAVES']['exchange_num'].
//                                                        '</div>'.'
//                                                    </div>
//                                               </div>';
////                            $stats_content .= '<div class="table-text w-100">
//                                                <div class="row">
//                                                        <div class="col-4 text-left" style="padding-left: 42px;">'.
//                                                    $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
//                                                    '</div>
//                                                        <div class="col-3 text-left">' .
//                                                    get_user_meta($user_id, 'client_num', true) .
//                                                    '</div>
//
//                                                        <div class="col-2 text-left">'.
//                                                    $stats[$user_id]['exchange_num'].
//                                                    '</div>
//                                                        <div class="col-3 text-left">'.
//                                                    $stats[$user_id]['exchange_sum'].' RUB'.
//                                                    '</div>
//                                                </div>
//                                            </div>';
//                        }
//                    }
//                    else
//                    {
//                        $stats_content .= '<div class="table-text w-100">
//                                                <div class="row">
//                                                    <div class="col-12 text-center">
//                                                        Статистика для данного пользователя не найдена.
//                                                    </div>
//                                                </div>
//                                              </div>';
//                    }
                    //Статистика
                    $response += array('stats_content' => show_user_stats($user_id));//$stats_content);

                    //Данные верификации
                    $user_verification = get_user_meta($user_id, 'verification', true);
                    $user_passport_photos = get_user_meta($user_id, 'passport_photos', true);
                    if (!empty($user_passport_photos))
                        $user_verification += array('passport_photos' => $user_passport_photos);
                    if (!empty($user_verification))
                        $response += array('verification_content' => $user_verification);
                    else //Если данный пользователь не верифицирован
                    {
                        $response += array('verification_content' => 'false'/*'<div class="table-text w-100">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        Для данного пользователя не найдены верификационные данные.
                                                    </div>
                                                </div>
                                              </div>'*/);
                    }

                    //Данные самого пользователя (email, логин и тп)
                    $user = get_userdata($user_id);
                    $username = $user->display_name;
                    $user_email = $user->user_email;
                    $user_phone = get_user_meta($user_id, 'user_phone', true);
                    $client_num = get_user_meta($user_id, 'client_num', true);
                    $is_verified = get_user_meta($user_id, 'is_verified', true);
                    $user_ref_link = get_user_meta($user_id, 'user_ref_link', true);

                    $user_data = array(
                        'username' => $username,
                        'user_email' => $user_email,
                        'user_phone' => $user_phone,
                        'client_num' => $client_num,
                        'is_verified' => $is_verified,
                        'user_ref_link' => $user_ref_link
                    );

                    $response += array('userdata_content' => $user_data);

                    echo json_encode($response);
                    exit;


                } //if get_user_stats
            }

            elseif (isset($_POST['save_client_num']) && $_POST['save_client_num'] == 'true')
            {
                if (isset($_POST['client_num']) && !empty($_POST['client_num']))
                {
                    $user_id = $_POST['request_user_id'];
                    $client_num = explode('=', $_POST['client_num'])[1];

                    $is_success = update_user_meta($user_id, 'client_num', $client_num);
                    if ($is_success)
                        echo $client_num;
                    else
                        echo 'false';
                }
                //$log->insert_log('client_num: '.print_r($_POST['client_num'], true));
                exit;
            }
            //Сбербанк
            elseif (isset($_POST['is_sberbank']) && $_POST['is_sberbank'] == 'true')
            {
                if (isset($_POST['order_data']) && !empty($_POST['order_data'])) {
                    $order = $_POST['order_data'];
                    //Если checksum совпадают
                    if (sberbank_verify_checksum($order))
                    {
                        if (isset($_POST['request_num'])) {

                            //Меняем статус данного запроса на обмен на completed
                            $exchange_requests = rcl_get_option('exchange_requests');

                            if ($_POST['order_data']['formattedAmount'] ==
                                $exchange_requests[$_POST['request_user_id']][$_POST['request_num']]['input_sum'])
                            {

                                if (isset($exchange_requests) && !empty($exchange_requests)) {
                                    //echo print_r($exchange_requests[$_POST['request_user_id']][$_POST['request_num']], true);
                                    $exchange_requests[$_POST['request_user_id']][$_POST['request_num']]['status'] = 'paid';
                                    rcl_update_option('exchange_requests', $exchange_requests);
                                }

                                //Генерируем документ
//                                $profileFields = rcl_get_profile_fields(array('user_id' => $_POST['request_user_id']));
//                                foreach ($profileFields as $field) {
//                                    if ($field['slug'] == 'user_documents') {
//                                        $new_doc = get_new_document_field($_POST['request_user_id'], 'RUB');
//                                        if ($new_doc) {
//                                            if (!isset($field['value']))
//                                                $field += array('value' => array());
//                                            $log = new Rcl_Log();
//                                            $field_value = get_user_meta($_POST['request_user_id'], 'user_documents', true);
//
//                                            if (empty($field_value) || count($field_value) == 0) {
//                                                $field['value'] = array('0' => $new_doc);
//                                            } else //user documents not empty
//                                            {
//                                                $field['value'] = $field_value;
//                                                $field['value'] += array(count($field['value']) => $new_doc);
//                                            }
//                                            //$log->insert_log("field:".print_r($field, true));
//
//                                            rcl_update_profile_fields($_POST['request_user_id'], array($field));
//                                        }
//                                        break;
//                                    }
                                //}
                                echo 'true';
                                exit;
                            }
                            else
                                echo 'false';
//                            echo print_r($stats, true).'\n'.
//                                 print_r($exchange_requests[$_POST['request_user_id']][$_POST['request_num']], true);
                        }
                    }
//                    $exchange_requests = rcl_get_option('exchange_requests');
//
//                    if (isset($exchange_requests) && !empty($exchange_requests)) {
//                        //echo print_r($exchange_requests[$_POST['request_user_id']][$_POST['request_num']], true);
//                        $exchange_requests[$_POST['request_user_id']][$_POST['request_num']]['status'] = 'yes';
//                        rcl_update_option('exchange_requests', $exchange_requests);
//                        echo 'true';
//                        exit;
//                    }
                }
            }

        } //if request_user_id

        //Выплата реферального вознаграждения
        elseif (isset($_POST['ref_approve']) && $_POST['ref_approve'] == 'true') {
            if (isset($_POST['ref_data']) && !empty($_POST['ref_data']))
            {
                $ref_awards = new Ref_Awards();
                $fields = $_POST['ref_data'];

                //Изменяем статус операции с полями fields
                $result = $ref_awards->get_operations_by($fields, true, "paid", false);
                //$log->insert_log("result: ".print_r($result, true));
                if ($result == true)
                    echo "true";
                else
                    echo "false";
                exit;
            }
        }

        elseif (isset($_POST['ref_remove']) && $_POST['ref_remove'] == 'true')
        {
            $ref_awards = new Ref_Awards();
            $fields = $_POST['ref_data'];

            //Удаляем операцию
            $result = $ref_awards->get_operations_by($fields, false, "", true);
            if ($result == true)
                echo "true";
            else
                echo "false";
            exit;
        }

        elseif (isset($_POST['get_ref_stats']) && $_POST['get_ref_stats'] == 'true')
        {
            if (isset($_POST['ref_user_id']) && !empty($_POST['ref_user_id']))
            {
                $ref_awards = new Ref_Awards();
                if (isset($_POST['is_ref_list']) && $_POST['is_ref_list'] == 'true')
                {
                    $result_arr = array(
                        "paid_sum" => $ref_awards->get_sum("paid", $user_ID, $_POST['ref_user_id']),
                        "unpaid_sum" => $ref_awards->get_sum("unpaid", $user_ID, $_POST['ref_user_id'])
                    );
                    //$log->insert_log("result_arr: ".print_r($result_arr, true));
                }
                else
                {
                    $result_arr = array(
                        "paid_sum" => $ref_awards->get_sum("paid", $_POST['ref_user_id']),
                        "unpaid_sum" => $ref_awards->get_sum("unpaid", $_POST['ref_user_id'])
                    );
                }
                //$log->insert_log("result_arr: ".print_r($result_arr, true));
                echo json_encode($result_arr);
                exit;
            }
            else {
                echo 'false';
                exit;
            }

        }

        elseif (isset($_POST['get_ref_operations']) && $_POST['get_ref_operations'] == 'true')
        {
            if (isset($_POST['operation_type']) && !empty($_POST['operation_type']) &&
                isset($_POST['ref_user_id']) && !empty($_POST['ref_user_id']))
            {
                $operation_type = $_POST['operation_type'];
                $ref_user_id = $_POST['ref_user_id'];
                $status = $operation_type == 'unpaid' ? 'processing' : 'paid';

                $ref_awards = new Ref_Awards();
                $options_array = array();
                $options_array += array("status" => $status);
                if ($ref_user_id != 'all')
                    $options_array += array("host_id" => $ref_user_id);
                $result_arr = array("operations" => $ref_awards->get_operations_by($options_array));

                if (rcl_get_current_role() == 'manager' || rcl_get_current_role() == 'administrator' || rcl_get_current_role() == 'director')
                    $is_manager = true;
                else
                    $is_manager = false;

                $result_arr += array("is_manager" => $is_manager);
                echo json_encode($result_arr);
                exit;
            }
            else
            {
                echo 'false';
                exit;
            }
        }

        elseif (isset($_POST['remove_request']) && $_POST['remove_request'] == 'true') {
            if ($_POST['request_type'] == 'exchange_request')
            {
                $exchange_requests = rcl_get_option('exchange_requests');

                if (isset($exchange_requests) && !empty($exchange_requests)) {
                    if (isset($_POST['request_num']) && isset($_POST['user_id']))
                    {
                        $request_num = $_POST['request_num'];
                        $userid = $_POST['user_id'];
                        unset($exchange_requests[$userid][$request_num]);

                        rcl_update_option('exchange_requests', $exchange_requests);
                        echo 'true';
                    } else
                        echo 'false';

                    exit;
                }
            }
            elseif ($_POST['request_type'] == 'verification_request')
            {
                $verification_requests = rcl_get_option('verification_requests');
                if (isset($verification_requests) && !empty($verification_requests))
                {
                    if (isset($_POST['user_id']))
                    {
                        $userid = $_POST['user_id'];

                        /*****Отправляем уведомление пользователю о неуспешной верификации**********/
                        $user = get_user_by('id', $userid);
                        $user_email = $user->user_email;
                        $username = $user->display_name;

                        $subject = 'SLAVIA: Ваш запрос на верификацию был отклонен.';
                        $textmail = "<p>Здравствуйте, $username. К сожалению, ваш запрос на верификацию был отклонен. " .
                            "Вы можете попробовать отправить новый запрос на верификацию в любой момент, либо связаться с " .
                            "нашим менеджером с помощью контактных данных, указанных на сайте " . $_SERVER['HTTP_HOST'] . ".</p>";
                        rcl_mail( $user_email, $subject, $textmail );
                        /****************************************************************************/

                        /****************Обновляем поле пользователя is_verified*********************/
                        $profileFields = rcl_get_profile_fields(array('user_id' => $userid));
                        foreach ($profileFields as $field)
                            if ($field['slug'] == 'is_verified') {
                                if (isset($field['value']))
                                    $field['value'] = 'no';
                                else
                                    $field += array('value' => 'no');
                                rcl_update_profile_fields($userid, array($field));
                                break;
                            }
                        /*************************************************************************/

                        unset($verification_requests[$userid]);

//                        $log->insert_log('verification_requests new:'.print_r($verification_requests, true));
                        rcl_update_option('verification_requests', $verification_requests);
                        echo 'true';
                    } else
                        echo 'false';
                    exit;
                }
            }
        }

//        elseif (isset($_POST['get_users']) && $_POST['get_users'] == 'true')
//        {
//            $users = get_users(
//                    array(
//                        'fields' => array('ID', 'display_name'),
//                        'role__not_in' => array('director', 'administrator')
//                    )
//            );
//
//            if (!empty($users))
//            {
//                $response = array();
//                foreach ($users as $user) {
//                    $user_verification = get_user_meta($user->ID, 'verification', true);
//
//                    if (isset($user_verification) && !empty($user_verification)) {
//                        $user_full_name = $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'];
//                    }
//                    else
//                        $user_full_name = $user->display_name;
//
//                    $response += array($user->ID => $user_full_name);
//                }
//
//                echo json_encode($response, JSON_UNESCAPED_UNICODE);
//                exit;
//            }
//            else
//                echo 'false';
//        }
        elseif (isset($_POST['people_sort']) && !empty($_POST['people_sort']) &&
                isset($_POST['sort_field']) && !empty($_POST['sort_field']))
        {
            $is_sort = $_POST['people_sort'];

            if ($is_sort == 'true') {
           // elseif (isset($_POST['get_users']) && $_POST['get_users'] == 'true')
//        {
//            $users = get_users(
//                    array(
//                        'fields' => array('ID', 'display_name'),
//                        'role__not_in' => array('director', 'administrator')
//                    )
//            );
//
//            if (!empty($users))
//            {
//                $response = array();
//                foreach ($users as $user) {
//                    $user_verification = get_user_meta($user->ID, 'verification', true);
//
//                    if (isset($user_verification) && !empty($user_verification)) {
//                        $user_full_name = $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'];
//                    }
//                    else
//                        $user_full_name = $user->display_name;
//
//                    $response += array($user->ID => $user_full_name);
//                }
//*****************************************************
//                global $rcl_tabs;
//                $rcl_tabs['people']['content'][0]['callback']['name'] = 'sort_people';
//                $rcl_tabs['people']['content'][0]['callback']['args'] = array(true, 'client_num');
                //add_filter('rcl_tab','sort_people_tab_data', 10, 1);

//                $redirect_url = rcl_get_tab_permalink($user_ID, 'people') . '&updated=true';
//
//                wp_redirect($redirect_url);

                //apply_filters('rcl_tab');
                //$log->insert_log("tabs: ".print_r($rcl_tabs, true));
                //apply_filters('rcl_tab');//, true, $_POST['sort_field']);

                //Кэширование ответа для уменьшения нагрузки на сервер и на бд
                if (get_transient('people_sorted_data'))
                    $response = get_transient('people_sorted_data');
                else {
                    $response =  get_people('client_num', 'ASC');
                    set_transient('people_sorted_data', $response, 10 * MINUTE_IN_SECONDS);
//                    $response = array();
//                    foreach ($people as $user)
//                    {
//                        array_push($response, $user);
//                    }
//                    $response = do_shortcode("[userlist template='slavia' inpage='10' data='user_registered,profile_fields' orderby='".
//                        $_POST['sort_field'] . "' order='DESC' exclude='30']");

                    //set_transient('people_sorted_data', $response, 10 * MINUTE_IN_SECONDS);
                }
            }
            elseif ($is_sort == 'false') {
                if (get_transient('people_unsorted_data'))
                    $response = get_transient('people_unsorted_data');
                else {
                    $response =  get_people('user_registered', 'DESC');
                    set_transient('people_unsorted_data', $response, 10 * MINUTE_IN_SECONDS);
//                    $response = array();
//                    foreach ($people as $user)
//                    {
//                        array_push($response, $user);
//                    }
                }
//                    $response = do_shortcode("[userlist template='slavia' inpage='10' data='user_registered,profile_fields' orderby='".
//                        'user_registered' . "' order='DESC' exclude='30']");
//
//
//                }
            }
            //$log->insert_log(json_encode($response));

            echo json_encode($response);
            exit;
        }

        elseif (isset($_POST['ref_sort']) && !empty($_POST['ref_sort'])) {
            $is_sort = $_POST['ref_sort'];
            $is_paid = $_POST['is_paid'];
            $ref_awards = new Ref_Awards();
            if (rcl_get_current_role() == 'manager' || rcl_get_current_role() == 'administrator' || rcl_get_current_role() == 'director')
                $is_manager = true;
            else
                $is_manager = false;

            if ($is_sort == 'true') {
                $response = $ref_awards->sort_all('host_client_num', 'ASC', $is_manager, $is_paid);
            }
            elseif ($is_sort == 'false') {
                $response = $ref_awards->sort_all('date', 'DESC', $is_manager, $is_paid);
            }
            array_push($response, array("is_manager" => $is_manager));
            //$response += array("is_manager" => $is_manager);
            echo json_encode($response);
            exit;
        }

        elseif (isset($_POST['search']) && !empty($_POST['search']))
        {
            $search_data = $_POST['search'];
            echo filter_data($search_data['type'], $search_data['datatype'], $search_data['val']);
            exit;
        }

        elseif (isset($_POST['currency_percent']) && $_POST['currency_percent'])
        {
            $currency_percent = $_POST['currency_percent'];
            $result = array();
            foreach($currency_percent as $currency => $percent)
                if (!empty($currency) && !empty($percent))
                    $result += array($currency => $percent);
                    //array_push($result, array($currency => $percent));

            rcl_update_option('currency_percent', $result);

            //$log->insert_log('post: '.print_r($result, true));
        }
        elseif (isset($_POST['operation_percent']) && $_POST['operation_percent'])
        {
            $operation_percents = $_POST['percent'];

            rcl_update_option('operation_percent', $operation_percents);

            //$log->insert_log('post: '.print_r(rcl_get_option('operation_percent'), true));
        }

        elseif (isset($_POST['get_currency_percent']) && $_POST['get_currency_percent'])
        {
            $currency_percents = rcl_get_option('currency_percent');
            $operation_percents = rcl_get_option('operation_percent');
            if (isset($_POST['currency']) && !empty($_POST['currency']) &&
                isset($_POST['type']) && !empty($_POST['type']))
            {
                $post_currency = urldecode($_POST['currency']);
                $post_type = urldecode($_POST['type']);
                $result = array();
                foreach ($operation_percents as $currency => $operation)
                {
                    if (strtolower($currency) == strtolower($post_currency) && $operation['type'] = $post_type)
                        foreach ($operation as $key => $value)
                            if ($key != 'type')
                                $result += array($key => $value);
                }
                if (empty($result))
                    $result = $currency_percents;
                $log->insert_log("result: ".print_r($result, true));
                echo json_encode($result);
                exit;
            }
        }

        /*****************Сохраняем в запросы на обмен******************/
        elseif (isset($_POST['exchange']) && !empty($_POST['exchange']) )
            /*strpos(array_key_first($_POST), 'get_rubles') !== false ||
                strpos(array_key_first($_POST), 'get_prizm') !== false ||
                strpos(array_key_first($_POST), 'get_waves') !== false)*/
        {
            //Обмен только для верифицированных
            if (get_user_meta($user_ID, 'is_verified', true) == 'yes' &&
                !empty(get_user_meta($user_ID, 'verification', true) ) &&
                count(get_user_meta($user_ID, 'verification', true)) > 0)
            {
                $exchange = $_POST['exchange'];

                if (isset($exchange['requisites'])) {
                    //other deposit
                    if (isset($exchange['deposit_type']))
                        save_exchange_request_other($exchange['input_currency'], $exchange['input_sum'], $exchange['requisites'],
                            $exchange['deposit_type']);
                    //other payment with output sum
                    elseif (isset($exchange['output_sum']) && isset($exchange['output_currency'])) {

                        if (isset($exchange['card_num']) && isset($exchange['card_name']))
                            save_exchange_request_other($exchange['input_currency'], $exchange['input_sum'], $exchange['requisites'],
                                false, $exchange['output_sum'], $exchange['output_currency'], $exchange['bank'],
                                $exchange['card_num'], $exchange['card_name']);
                        else
                            save_exchange_request_other($exchange['input_currency'], $exchange['input_sum'], $exchange['requisites'],
                                false, $exchange['output_sum'], $exchange['output_currency']);
                    }
                    //Иной паевой взнос без получения
                    else
                        save_exchange_request_other($exchange['input_currency'], $exchange['input_sum'], $exchange['requisites']);
                }

                //просто взнос без получения
                elseif (!isset($exchange['output_currency']) && !isset($exchange['output_sum']) && !isset($exchange['bank']))
                    save_exchange_request($exchange['input_currency'], $exchange['input_sum']);
                else
                {
                    if (isset($exchange['card_num']) && isset($exchange['card_name']))
                        save_exchange_request($exchange['input_currency'], $exchange['input_sum'],
                            $exchange['output_currency'], $exchange['output_sum'],
                            $exchange['bank'], $exchange['card_num'], $exchange['card_name']);
                    else
                        save_exchange_request($exchange['input_currency'], $exchange['input_sum'],
                            $exchange['output_currency'], $exchange['output_sum'],
                            $exchange['bank']);
                }
//                if (strpos(array_key_first($_POST), 'get_rubles') !== false) {
//                    save_exchange_request('PRIZM', 'RUB',
//                        $_POST['get_rubles']['prizm'], $_POST['get_rubles']['rubles'],
//                        $_POST['get_rubles']['bank']);//, $_POST['get_rubles']['card_num'],
//                        //$_POST['get_rubles']['card_name']);
//                }
//
//                if (strpos(array_key_first($_POST), 'get_prizm') !== false) {
//
//                    save_exchange_request('RUB', 'PRIZM',
//                        $_POST['get_prizm']['rubles'], $_POST['get_prizm']['prizm'],
//                        $_POST['get_prizm']['bank']);//, $_POST['get_prizm']['card_num'],
//                        //$_POST['get_prizm']['card_name']);
//                }
//
//                if (strpos(array_key_first($_POST), 'get_waves') !== false) {
//
//                    save_exchange_request('RUB', 'SLAV',
//                        $_POST['get_waves']['rubles'], $_POST['get_waves']['waves'],
//                        $_POST['get_waves']['bank']);//, $_POST['get_waves']['card_num'],
//                        //$_POST['get_waves']['card_name']);
//                }

                $redirect_url = rcl_get_tab_permalink($user_ID, 'operations') . '&updated=true';

                wp_redirect($redirect_url);

                exit;
            }
            elseif (get_user_meta($user_ID, 'is_verified', true) == 'no') {
                //echo '<script type="text/javascript">alert("Ваш профиль не верифицирован!")</script>';
                exit;
            }
        }

        else {
            $profileFields = rcl_get_profile_fields(array('user_id' => $user_ID));
            $post_first_key = current(array_keys($_POST));
            $field_found = false;
            foreach ($profileFields as $field) {
                if ($post_first_key == $field['slug']) {
                    rcl_update_profile_fields($user_ID, array($field));
                    $field_found = true;
                    break;
                }
            }
            if (!$field_found)
                return false;
        }
    }
    else
        return false;

    do_action('personal_options_update', $user_ID);

    if (!(isset($_POST['currency_percent']) && $_POST['currency_percent']) &&
        !(isset($_POST['operation_percent']) && $_POST['operation_percent'])
        )
    {
        $redirect_url = rcl_get_tab_permalink($user_ID, 'profile') . '&updated=true';
        wp_redirect($redirect_url);
        exit;
    }

}

//function rcl_custom_edit_profile(){
//    global $user_ID;
//
//    if (isset($_POST) && !empty($_POST)) {
//        var_dump(1);
//        rcl_update_profile_fields($user_ID, $_POST['fields']);
//    }
//
//}

add_filter('rcl_profile_fields','rcl_add_office_profile_fields',10);
function rcl_add_office_profile_fields($fields){
    global $userdata;

    $profileFields = array();

    if(isset($userdata) && !empty($userdata) &&
        isset($userdata->user_level) && $userdata->user_level >= rcl_get_option('consol_access_rcl',7)){
        $profileFields[] = array(
            'slug' => 'show_admin_bar_front',
            'title' => __('Admin toolbar','wp-recall'),
            'type' => 'select',
            'values' => array(
                'false' => __('Disabled','wp-recall'),
                'true' => __('Enabled','wp-recall')
            )
        );
    }

    $profileFields[] = array(
        'slug' => 'user_email',
        'title' => __('E-mail','wp-recall'),
        'type' => 'email',
        'required' => 1
    );

    $profileFields[] = array(
        'slug' => 'primary_pass',
        'title' => __('New password','wp-recall'),
        'type' => 'password',
        'required' => 0,
        'notice' => __('If you want to change your password - enter a new one','wp-recall')
    );

    $profileFields[] = array(
        'slug' => 'repeat_pass',
        'title' => __('Repeat password','wp-recall'),
        'type' => 'password',
        'required' => 0,
        'notice' => __('Repeat the new password','wp-recall')
    );

    $fields = ($fields)? array_merge($profileFields, $fields): $profileFields;

    return $fields;

}

//Выводим возможность синхронизации соц.аккаунтов в его личном кабинете
//при активированном плагине Ulogin
if(function_exists('ulogin_profile_personal_options')){
    function get_ulogin_profile_options($profile_block,$userdata){
        ob_start();
        ulogin_profile_personal_options($userdata);
	$profile_block .= ob_get_contents();
	ob_end_clean();
	return $profile_block;
    }
    add_filter('profile_options_rcl','get_ulogin_profile_options',10,2);
}

add_action('init', 'rcl_delete_user_account_activate');
function rcl_delete_user_account_activate ( ) {
  if ( isset( $_POST['rcl_delete_user_account'] ) ) {
    add_action( 'wp', 'rcl_delete_user_account' );
  }
}

//Удаляем аккаунт пользователя
function rcl_delete_user_account(){
    global $user_ID,$wpdb;
    if( !wp_verify_nonce( $_POST['_wpnonce'], 'delete-user-' . $user_ID ) ) return false;

    require_once(ABSPATH.'wp-admin/includes/user.php' );

    $wpdb->query($wpdb->prepare("DELETE FROM ".RCL_PREF."user_action WHERE user ='%d'",$user_ID));

    $delete = wp_delete_user( $user_ID );

    if($delete){
        wp_die(__('We are very sorry but your account has been deleted!','wp-recall'));
        echo '<a href="/">'.__('Back to main page','wp-recall').'</a>';
    }else{
        wp_die(__('Account deletion failed! Go back and try again.','wp-recall'));
    }
}

//Подгрузка курса prizm
function rcl_slavia_get_crypto_price($currency = 'PZM')
{

    if ($currency == 'PZM' && get_transient('prizm_price'))
        return get_transient('prizm_price');
    else
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/tools/price-conversion';
        $parameters = [
            'symbol' => $currency,
            'amount' => '1',
            'convert' => 'RUB'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 8225d03d-6029-4dad-8c1f-ca029644b3da'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
// Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        curl_close($curl); // Close request

        $rub_price = json_decode($response);
        $rounded_price = round($rub_price->data->quote->RUB->price, 2);

        if ($currency == 'PZM') {
            set_transient('prizm_price', $rounded_price, 5 * MINUTE_IN_SECONDS);
        }

        return $rounded_price; // print json decoded response
    }
//    $log = new Rcl_Log();
//    $log->insert_log(print_r(json_decode($response), true));
}

//Генерация checksum для сбербанка
function sberbank_verify_checksum($order)
{
    $log = new Rcl_Log();
    $log->insert_log("sberbank_digest:".$order['digest']);

    $key = 'r88jh7s9cecbt9o6af6813ojdb';//'uaihtrgiuira6q765uh71222j8';
    $checksum = $order['status'].$order['formattedAmount'].$order['currency'].$order['approvalCode'].$order['orderNumber'].
                $order['panMasked'].$order['refNum'].$order['paymentDate'].$order['formattedFeeAmount'].$key.';';

    $hmac = hash_hmac ( 'sha256' , $checksum , $key);
    $hmac = strtoupper($hmac);

    $log->insert_log("hmac_sha256 hash: ".$hmac);

    if ($hmac == $order['digest'])
        $log->insert_log("checksum is equal");
    else
        $log->insert_log("checksum is NOT equal");
    $log->insert_log("_________________________________");

    return $hmac == $order['digest'];
}

function filter_data($filter_type, $datatype, $filter_val)
{
    global $user_ID;
    switch ($datatype) {
        case 'exchange_requests':
            $exchange_requests = rcl_get_option('exchange_requests');
            $exchange_content = '';
            if (isset($exchange_requests) && !empty($exchange_requests))
            {
                foreach ($exchange_requests as $user => $requests) //Все пользователи с запросами на обмен, $user- id пользователя
                {
                    $user_verification = get_user_meta($user, 'verification', true);

                    if (isset($user_verification) && !empty($user_verification))
                    {
                        $user_full_name = $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'];

                        if (($filter_type == 'word') && (!empty($filter_val) && strpos($user_full_name, $filter_val) === false))
                            continue;
                        elseif ((empty($filter_val)) ||
                                ($filter_type == 'word' && !empty($filter_val) && strpos($user_full_name, $filter_val) !== false) || ($filter_type == 'date') )
                        {
                            foreach ($requests as $request_num => $request_value) //Все запросы на обмен данного пользователя
                            {
                                $currency_to_print = empty($request_value['output_currency']) ? $request_value['input_currency'] : $request_value['output_currency'];
                                $sum_to_print = empty($request_value['output_sum']) ? $request_value['input_sum'] : $request_value['output_sum'];
                                if ($filter_type == 'date')
                                {
                                    $time = strtotime($filter_val);

                                    $newfilter = date('d.m.y',$time);

                                    //Берем первую часть выведенной даты - число,месяц,год и сравниваем с фильтром
                                    $current_date = explode(' ', $request_value['date']);
                                    $current_date = explode('.', $current_date[0]);
                                    $day = $current_date[0];
                                    $month = $current_date[1];
                                    $year = $current_date[2];
                                    //$current_date[0] = str_replace('.', '-', $current_date[0]);
                                    $current_time = strtotime($month.'/'.$day.'/'.$year);
                                    $new_date = date('d.m.y', $current_time);

                                    //$log = new Rcl_Log();
                                    //$log->insert_log("request: ".print_r($request_value, true));
                                    //$log->insert_log("$new_date==$newfilter: ".$new_date == $newfilter);
//                                    $log = new Rcl_Log();
//                                    $log->insert_log("new_filter:".$newfilter);
//                                    $log->insert_log("date_value:".$request_value['date']);
//                                    $log->insert_log("------------------------------");
                                    //$date_value = str_replace('.', '/', $request_value['date']);
                                    if (!isset($request_value['date']) || !isset($new_date) || $new_date != $newfilter)
                                        continue;
                                }
                                if ($request_value['status'] == 'awaiting_payment' || $request_value['status'] == 'paid' || $request_value['status'] == 'deposit' || $request_value['status'] == 'deposit_other')
                                {
                                    $exchange_content .= '<div class="table-text w-100">
                                                <div class="row">
                                                    <div class="col-2 text-left" style="padding-left: 42px;">' .
                                        $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
                                        '</div>
                                                    
                                                    <div class="col-2 text-left">' .
                                        get_user_meta($user, 'client_num', true) .
                                        '</div>
                                                    
                                                    <div class="col-2 text-left">' .
                                        $currency_to_print .
                                        '</div>
                                                    
                                                    <div class="col-2 text-left">' .
                                        $sum_to_print .
                                        '<img src="/wp-content/uploads/2019/12/info.png" class="info-zayavki">
                                                    </div>';
                                    if ($request_value['status'] == 'paid')
                                        $exchange_content .= '<div class="col-3 text-center">
                                                        <p>Оплачено пользователем</p>
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="'.$request_num.'" id="request_approve_'.$user.'">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';
//                                                </div>
//                                            </div>';
                                    elseif ($request_value['status'] == 'deposit')
                                        $exchange_content .= '<div class="col-3 text-center">
                                                        <p>Имущественный взнос</p>
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="'.$request_num.'" id="request_approve_'.$user.'">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';
//                                                </div>
//                                            </div>';
                                    elseif ($request_value['status'] == 'deposit_other')
                                        $exchange_content .= '<div class="col-3 text-center">
                                                        <p>Целевой взнос</p>
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="'.$request_num.'" id="request_approve_'.$user.'">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';

                                    elseif ($request_value['status'] == 'awaiting_payment')
                                        $exchange_content .= '<div class="col-3 text-center">
                                                        <div class="btn-custom-one btn-zayavki" data-request_num="' . $request_num . '" id="request_approve_' . $user . '">
                                                            Закрыть сделку
                                                        </div>
                                                    </div>';
//                                                </div>
//                                            </div>';
                                    $exchange_content .= '<div class="col-1 text-left">
                                                            <a class="remove_operation" data-user_id="'.$user.'" data-request_num="'.$request_num.'">&times;</a>
                                                        </div>
                                            </div>
                                         </div>';
                                } elseif ($request_value['status'] == 'completed')
                                    continue;
                            } //inner foreach
                        } //filter comparison
                    } //Если нет верификации
                    else
                        continue;
                } //foreach внешний
            } //if exchange requests

            return $exchange_content;
            //break;
        case 'verification_requests':
            $verification_requests = rcl_get_option('verification_requests');
            $verification_content = '';
            if (isset($verification_requests) && !empty($verification_requests))
            {
                $i = 0;
                foreach ($verification_requests as $key => $value)
                {
                    $i++;
                    $user_full_name = $value['name'] . ' ' . $value['surname'] . ' ' . $value['last_name'];

                    if (($filter_type == 'word') && (!empty($filter_val) && strpos($user_full_name, $filter_val) === false))
                        continue;
                    elseif (empty($filter_val) ||
                        ($filter_type == 'word' && !empty($filter_val) && strpos($user_full_name, $filter_val) !== false) ||
                        $filter_type == 'date')
                    {
                        if ($filter_type == 'date') {
                            $time = strtotime($filter_val);

                            $newfilter = date('d.m.y', $time);

                            if (!isset($value['date']) || $value['date'] != $newfilter)
                                continue;
                        }
                        $verification_content .= '<div class="table-text w-100">' .
                            '<div class="row">' .
                            '<div class="col-2 text-left" style="padding-left: 42px;">' .
                            $value['name'] . ' ' . $value['surname'] . ' ' . $value['last_name'] .
                            '</div>' .
                            '<div class="col-2 text-left">' .
                            get_user_meta($key, 'client_num', true) . //Возвращает client_num по id пользователя
                            '</div>' .
                            '<div class="col-2 text-left">' .
                            '</div>
                                            <div class="col-2 text-right">
                                                <img src="/wp-content/uploads/2019/12/info.png" class="info-zayavki">
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="btn-custom-one btn-zayavki" id="request_approve_' . $key . '">
                            Одобрить
                                                </div>
                                            </div>
                                            <div class="col-1 text-left">
                                               <a class="remove_operation" data-user_id="'.$key.'">&times;</a>
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
            }
            return $verification_content;

        case 'operations':
            $exchange_requests = rcl_get_option('exchange_requests');
            $exchange_content = '';
            $client_num = get_user_meta($user_ID, 'client_num', true);
            if (isset($exchange_requests) && !empty($exchange_requests) &&
                isset($exchange_requests[$user_ID]) && !empty($exchange_requests[$user_ID]))
            {
                foreach ($exchange_requests[$user_ID] as $key => $value) {
                    if ($filter_type == 'date') {
                        $time = strtotime($filter_val);

                        $newfilter = date('d.m.y', $time);

                        //Берем первую часть выведенной даты - число,месяц,год и сравниваем с фильтром
                        $current_date = explode(' ', $value['date']);
                        $current_date = explode('.', $current_date[0]);
                        $day = $current_date[0];
                        $month = $current_date[1];
                        $year = $current_date[2];
                        //$current_date[0] = str_replace('.', '-', $current_date[0]);
                        $current_time = strtotime($month.'/'.$day.'/'.$year);
                        $new_date = date('d.m.y', $current_time);

                        if (!isset($value['date']) || !isset($new_date) || $new_date != $newfilter)
                            continue;
                    }
                    $output_sum_to_print = !empty($value['output_sum']) ? $value['output_sum'] : $value['input_sum'];
                    $output_currency_to_print = !empty($value['output_currency']) ? $value['output_currency'] : $value['input_currency'];
                    $exchange_content .= '<div class="table-text w-100">
                                    <div class="row">
                                        <div class="col-2 text-center">' .
                        $value['date'] .
                        '</div>
                                        
                                        <div class="col-2 text-center">' .
                        $value['input_sum'].' '.$value['input_currency'] .
                        '</div>
                                        
                                        <div class="col-2 text-center">' .
                        $value['output_currency'] .
                        '</div>
                                        
                                        <div class="col-2 text-center">' .
                        $output_sum_to_print . ' ' . $output_currency_to_print .
                        '</div>';

//                                        <div class="col-2 text-center" style="visibility: hidden">
//                                            0.9188 PZM
//                                        </div>';
                    if ($value['status'] == 'paid')
                        $exchange_content .= '<div class="col-3 text-center" style="font-size: 15px; color: #EF701B">
                                       Ожидает проверки
                                        </div>';
//                                    </div>
//                                </div>';
                    //Одобренная менеджером заявка
                    elseif ($value['status'] == 'awaiting_payment' && $value['input_currency'] == 'RUB')
                        $exchange_content .= '<div class="col-3 text-center">' .
//                                        <div class="col-12">
//                                            <p style="font-size: 15px; color: green">Операция одобрена. Произвести оплату:</p>
//                                        </div>
//                                        <div class="col-12">
                            '<a onclick="ipayCheckout({
                                                amount:' . $value['input_sum'] . ',
                                                currency:\'RUB\',
                                                order_number:\'\',
                                                description: \'Паевой взнос от пайщика №'.$client_num.'\'
                                                },
                                                function(order) { successCallback(order, event, ' . $user_ID . ', ' . $key . ') },
                                                function(order) { failureCallback(order, event, ' . $user_ID . ', ' . $key . ') })"
                                                 
                                            class="btn-custom-one" style="display: inline-block;">Оплатить
                                            </a>' .
//                                        </div>
                            '</div>';
//                                    </div>
//                                </div>';

                    //Целевой взнос
                    elseif ($value['status'] == 'deposit_other')
                    {
                        if ($value['input_currency'] == 'RUB')
                            $exchange_content .= '<div class="col-3 text-center">' .
                                                    '<a onclick="ipayCheckout({
                                                        amount:' . $value['input_sum'] . ',
                                                        currency:\'RUB\',
                                                        order_number:\'\',
                                                        description: \'Целевой взнос ' . $value['deposit_type'] . ' от пайщика №'.$client_num.'\'
                                                        },
                                                        function(order) { successCallback(order, event, ' . $user_ID . ', ' . $key . ') },
                                                        function(order) { failureCallback(order, event, ' . $user_ID . ', ' . $key . ') })"
                                                         
                                                        class="btn-custom-one" style="display: inline-block;">Оплатить
                                                    </a>' .
                                                '</div>';
                        else
                            $exchange_content .= '<div class="col-3 text-center" style="font-size: 15px; color: #EF701B">
                                       Ожидает подтверждения
                                        </div>';
                    }
                    elseif ($value['status'] == 'completed')
                        $exchange_content .= '<div class="col-3 text-center" style="font-size: 15px; color: green">
                                       Завершена
                                        </div>';
//                                    </div>
//                                </div>';
//                    else
//                        $exchange_content .= '</div></div>';

                    //Кнопка удаления
                    $exchange_content .= '<div class="col-1 text-left">
                                            <a class="remove_operation" data-request_num="'.$key.'">&times;</a>
                                        </div>
                                    </div>
                            </div>';
                }
            }
            return $exchange_content;

        case 'stats':
            return show_all_stats(false, $filter_type, $filter_val);//$stats_content;

        case 'documents':
            $docs = get_user_meta($user_ID, 'user_documents', true);
            $document_content = '';
            if (isset($docs) && !empty($docs))
            {
                foreach ($docs as $key => $document)
                {
                    if ($filter_type == 'date') {
                        /*$time = strtotime($filter_val);

                        $newfilter = date('d.m.y', $time);

                        if (!isset($document['date']) || $document['date'] != $newfilter)
                            continue;*/
                        $time = strtotime($filter_val);

                        $newfilter = date('d.m.y', $time);

                        //Берем первую часть выведенной даты - число,месяц,год и сравниваем с фильтром
                        $current_date = explode(' ', $document['date']);
                        $current_date = explode('.', $current_date[0]);
                        $day = $current_date[0];
                        $month = $current_date[1];
                        $year = $current_date[2];
                        //$current_date[0] = str_replace('.', '-', $current_date[0]);
                        $current_time = strtotime($month.'/'.$day.'/'.$year);
                        $new_date = date('d.m.y', $current_time);


                        if (!isset($document['date']) || !isset($new_date) || $new_date != $newfilter)
                            continue;
                    }
                    $document_content .= '<div class="table-text w-100">
                                            <div class="row">
                                                <div class="col-2 text-center">'.$document['date'].'</div>
                
                                                <div class="col-8 text-left">'.$document['filename'].'</div>
                                                
                                                <div class="col-2 text-center">
                                                    <a href="'. $document['url'] .'" download>
                                                        <img src="/wp-content/uploads/2019/12/don.png">
                                                    </a>
                                                </div>
                                                
                                            </div>
                                          </div>';
                } //foreach
            }
            return $document_content;
    }

}

function show_all_stats($is_table = false, $filter_type = null, $filter_val = null)
{
    $stats = rcl_get_option('user_stats');
    $stats_content = '';
    if (isset($stats) && !empty($stats))
    {
        //var_dump($stats);
        $currencies = array('RUB', 'PRIZM', 'SLAV');
        foreach ($stats as $user => $user_stats)
        {
            if (isset($user_stats) && !empty($user_stats))
            {
                $user_verification = get_user_meta($user, 'verification', true);
                $client_num = get_user_meta($user, 'client_num', true);

//                $log = new Rcl_Log();
//                $log->insert_log("client_num: ".$client_num);

                if (isset($user_verification) && !empty($user_verification))
                {
                    $user_full_name = $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'];
                    if ((isset($filter_type) && isset($filter_val)) && ($filter_type == 'word') && (!empty($client_num) && !empty($filter_val) && strpos($client_num/*$user_full_name*/, $filter_val) === false))
                        continue;
                    elseif ( (!isset($filter_type) && !isset($filter_val) ) || (empty($filter_val) ||
                            ($filter_type == 'word' && !empty($filter_val) && strpos($client_num/*$user_full_name*/, $filter_val) !== false) ||
                            $filter_type == 'date'))
                    {
                        //Обнуляем значения для валюты, если статистика для данной валюты отсутствует
                        foreach ($currencies as $currency) {
                            if (!isset($user_stats[$currency]))
                                $user_stats += array($currency => array('input_sum' => 0, 'output_sum' => 0, 'exchange_num' => 0));
                        }
                        if (!$is_table) {
                            $stats_content .= '<div class="table-text w-100">
                                        <div class="row">
                                            <div class="col-2 text-center stats_col" style="padding-left: 25px;">' .
                                $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
                                '</div>
                                            <div class="col-2 text-center stats_col">' .
                                get_user_meta($user, 'client_num', true) .
                                '</div>' .
                                //RUB
                                '<div class="col-2 text-center stats_col">' .
                                $user_stats['RUB']['input_sum'] . ' RUB' .
                                '</div>
                                            <div class="col-1 text-center stats_col">' .
                                $user_stats['RUB']['exchange_num'] .
                                '</div>' .
                                //PRIZM
                                '<div class="col-2 text-center stats_col">' .
                                $user_stats['PRIZM']['input_sum'] . ' PRIZM' .
                                '</div>
                                            <div class="col-1 text-center stats_col">' .
                                $user_stats['PRIZM']['exchange_num'] .
                                '</div>' .
                                //WAVES
                                '<div class="col-1 text-center stats_col">' .
                                $user_stats['SLAV']['input_sum'] . ' SLAV' .
                                '</div>
                                            <div class="col-1 text-center stats_col">' .
                                $user_stats['SLAV']['exchange_num'] .
                                '</div>' . '
                                        </div>
                                    </div>';
                        }
                        else
                        {
                            $stats_content .= '<tr>
                                         <td>' .
                                $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
                                        '</td>
                                        <td>' .
                                            get_user_meta($user, 'client_num', true) .
                                        '</td>' .
                                        //RUB
                                        '<td>' .
                                            $user_stats['RUB']['input_sum'] . ' RUB' .
                                        '</td>
                                        <td>' .
                                            $user_stats['RUB']['exchange_num'] .
                                        '</td>' .
                                        //PRIZM
                                        '<td>' .
                                            $user_stats['PRIZM']['input_sum'] . ' PRIZM' .
                                        '</td>
                                        <td>' .
                                            $user_stats['PRIZM']['exchange_num'] .
                                        '</td>' .
                                        //WAVES
                                        '<td>' .
                                            $user_stats['SLAV']['input_sum'] . ' SLAV' .
                                        '</td>
                                        <td>' .
                                            $user_stats['SLAV']['exchange_num'] .
                                        '</td>' . '
                                                </tr>';
                        }
                    }
                }
            }
        } //foreach
    }
    return $stats_content;
}

function show_user_stats($userID)
{
    $stats = rcl_get_option('user_stats');
    $stats_content = '';
    $currencies = array('RUB', 'PRIZM', 'SLAV');
    if (isset($stats[$userID]) && !empty($stats[$userID]))
    {
        $user_verification = get_user_meta($userID, 'verification', true);

        if (isset($user_verification) && !empty($user_verification))
        {
            $user_stats = $stats[$userID];
            foreach ($currencies as $currency)
            {
                if (!isset($user_stats[$currency]))
                    $user_stats += array($currency => array('input_sum' => 0, 'output_sum' => 0,'exchange_num' => 0));
            }
            $stats_content .= '<div class="table-text w-100">
                                <div class="row">
                                    <div class="col-2 text-center stats_col" style="padding-left: 25px;">'.
                                    $user_verification['name'] . ' ' . $user_verification['surname'] . ' ' . $user_verification['last_name'] .
                                 '</div>
                 <div class="col-2 text-center stats_col">' .
                get_user_meta($userID, 'client_num', true) .
                '</div>'.
                //RUB
                '<div class="col-2 text-center stats_col">'.
                $user_stats['RUB']['input_sum']. ' RUB'.
                '</div>
                <div class="col-1 text-center stats_col">'.
                $user_stats['RUB']['exchange_num'].
                '</div>'.
                //PRIZM
                '<div class="col-2 text-center stats_col">'.
                $user_stats['PRIZM']['input_sum'].' PRIZM'.
                '</div>
                <div class="col-1 text-center stats_col">'.
                $user_stats['PRIZM']['exchange_num'].
                '</div>'.
                //WAVES
                '<div class="col-1 text-center stats_col">'.
                $user_stats['SLAV']['input_sum']. ' SLAV'.
                '</div>
                <div class="col-1 text-center stats_col">'.
                $user_stats['SLAV']['exchange_num'].
                '</div>'.'
                </div>
           </div>';
        }
    }
    else
    {
        $stats_content .= '<div class="table-text w-100">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        Статистика для данного пользователя не найдена.
                                    </div>
                                </div>
                              </div>';
    }
    return $stats_content;
}

function show_stats_header($is_table = false)
{
    if (!$is_table) {
        $stats_header = '<div class="table-title w-100">
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
                </div>';
    }
    else
    {
        $stats_header = '<tr>
                        <th>
                            <p>Имя клиента</p>
                        </th>
                        <th>
                            Номер пайщика
                        </th>
                        <th>
                            RUB сумма
                        </th>
                        <th>
                            RUB обменов
                        </th>
                        <th>
                            PRIZM сумма
                        </th>
                        <th>
                            PRIZM обменов
                        </th>
                        <th>
                            SLAV сумма
                        </th>
                        <th>
                            SLAV обменов
                        </th>
                    </tr>';
    }
    return $stats_header;
}

function is_var($var)
{
    if (isset($var) && !empty($var))
        return true;
    else
        return false;
}

function add_stats($userid, $input_currency, $input_sum, $output_currency, $output_sum) {
    //Добавляем в статистику
    $stats = rcl_get_option('user_stats');

    if (isset($stats) && !empty($stats)) {
        //Если статистика на этого пользователя есть, то прибавляем к ней
        if (isset($stats[$userid]) && !empty($stats[$userid])) {

            $user_stat = $stats[$userid];

            if (!isset($user_stat[$input_currency]))
                $user_stat += array($input_currency =>
                    array('input_sum' => 0, 'output_sum' => 0, 'exchange_num' => 0));
            if (!isset($user_stat[$output_currency]))
                $user_stat += array($output_currency =>
                    array('input_sum' => 0, 'output_sum' => 0, 'exchange_num' => 0));

            //Прибавляем сумму по потраченной и получаемой валюте
            $user_stat[$input_currency]['input_sum'] += $input_sum;
            $user_stat[$output_currency]['output_sum'] += $output_sum;

            $user_stat[$input_currency]['exchange_num'] += 1;
            //$user_stat[$output_currency]['exchange_num'] += 1;

//                                $user_stat['exchange_num'] += 1;
//                                $user_stat['exchange_sum'] += $exchange_requests[$userid][$request_num]['input_sum'];

            $stats[$userid] = $user_stat;

            $stat_exists = true;

            //Если статистики для этого пользователя нет, добавляем статистику со значениями текущей операции
        } else {
            $stats +=
                array($userid =>
                    array(
                        $input_currency => array('input_sum' => $input_sum, 'output_sum' => 0, 'exchange_num' => 1),
                        $output_currency => array('input_sum' => 0, 'output_sum' => $output_sum, 'exchange_num' => 0)
                    )
                );
            $stat_exists = false;

        }
    } //Если статистика полностью пустая
    else {
        $stats =
            array($userid =>
                array(
                    $input_currency => array('input_sum' => $input_sum, 'output_sum' => 0, 'exchange_num' => 1),
                    $output_currency => array('input_sum' => 0, 'output_sum' => $output_sum, 'exchange_num' => 0)
                )
            );
        $stat_exists = false;

    }
    //$stats = array();
    rcl_update_option('user_stats', $stats);
}

function get_input_currencies()
{
    $slav_address = get_field('slav_address', 306);
    $prizm_address = get_field('prizm_address', 306);
    $prizm_price = rcl_slavia_get_crypto_price();

    $asset_inputs = array();
    for ($i = 1, $asset_input = get_field('asset_input_'.$i, 306);
         $i <= 10;
         $i++, $asset_input = get_field('asset_input_'.$i, 306)
    )
    {
        if (empty($asset_input) || count($asset_input) == 0)
            continue;

        if (!empty($asset_input['asset_name']) && !empty($asset_input['asset_requisites']) && !empty($asset_input['asset_rate_rubles']))
            $asset_inputs[] = $asset_input;
        //Условия для добавления prizm и slav в иной паевой взнос/целевой взнос
        elseif (strcasecmp($asset_input['asset_name'], 'prizm') == 0)
        {
            $asset_input['asset_requisites'] = $prizm_address;//'PRIZM-AWTX-HDBX-ADDH-7SMM7';
            $asset_input['asset_rate_rubles'] = $prizm_price;

            $asset_inputs[] = $asset_input;
        }
        elseif (strcasecmp($asset_input['asset_name'], 'slav') == 0)
        {
            $asset_input['asset_requisites'] = $slav_address;
            $asset_input['asset_rate_rubles'] = 1;

            $asset_inputs[] = $asset_input;
        }
    }
    return $asset_inputs;
}
function get_output_currencies()
{
    $asset_outputs = array();
    $prizm_price = rcl_slavia_get_crypto_price();

    for ($i = 1, $asset_output = get_field('asset_output_'.$i, 306);
         $i <= 10;
         $i++, $asset_output = get_field('asset_output_'.$i, 306)
    )
    {
        if (empty($asset_output) || count($asset_output) == 0)
            continue;
        if (!empty($asset_output['asset_name']) && !empty($asset_output['asset_rate_rubles']))
            $asset_outputs[] = $asset_output;
        //Условия для добавления prizm и slav в иной паевой взнос/целевой взнос
        elseif (strcasecmp($asset_output['asset_name'], 'prizm') == 0)
        {
            $asset_output['asset_rate_rubles'] = $prizm_price;

            $asset_outputs[] = $asset_output;
        }
        elseif (strcasecmp($asset_output['asset_name'], 'slav') == 0)
        {
            $asset_output['asset_rate_rubles'] = 1;

            $asset_outputs[] = $asset_output;
        }
    }
    return $asset_outputs;
}
