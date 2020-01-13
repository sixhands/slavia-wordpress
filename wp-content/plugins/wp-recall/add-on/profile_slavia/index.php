<?php

require_once 'classes/class-rcl-profile-fields.php';

if (is_admin())
    require_once 'admin/index.php';

if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_profile_scripts',10);
endif;

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
    if (!isset(wp_get_current_user()->roles) || !wp_get_current_user()->roles) //Если не назначена роль, не фильтруем табы
        return false;
    $roles = wp_get_current_user()->roles;
    $current_role = array_shift($roles);
    return $current_role;
}

//Удаление таба
function rcl_block_profile_pages_by_role($tab)
{
    if (parse_url($_SERVER['REQUEST_URI'])['path'] == '/profile/') {
        if (!rcl_get_current_role()) //Если не назначена роль, не фильтруем табы
            return $tab;
        $current_role = rcl_get_current_role();

        if ($current_role == 'manager') {
            if ($tab['id'] == 'settings') {
                $tab = array();
            }
        }
        if ($current_role == 'user' || $current_role == 'need-confirm')
        {
            if ($tab['id'] == 'requests' || $tab['id'] == 'people' || $tab['id'] == 'settings') {
                $tab = array();
            }
        }
    }
    return $tab;
}
add_filter('rcl_tab', 'rcl_block_profile_pages_by_role', 10, 1);

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
        'slug' => 'client_num',
        'title' => 'Номер пайщика',
    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'prizm_address',
        'title' => 'Адрес PRIZM',
    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'prizm_public_key',
        'title' => 'Публичный ключ',
    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'waves_address',
        'title' => 'Адрес Waves',
    );

    $fields[] = array(
        'type' => 'text',
        'slug' => 'is_verified',
        'title' => 'Верификация профиля',
        'value' => 'no',
    );
    

    return $fields;
}

//if (isset($_POST)) var_dump($_POST);

add_action('init','rcl_tab_profile');
add_action('init','rcl_tab_operations');
add_action('init','rcl_tab_documents');
add_action('init','rcl_tab_people');
add_action('init','rcl_tab_requests');
add_action('init','rcl_tab_settings');

function rcl_tab_template_content()
{
    global $userdata, $user_ID;
    $profileFields = rcl_get_profile_fields(array('user_id'=>$user_ID));
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
    //'border' => array('table', 'rows')
    //));
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
        if ($field_name != 'is_verified') {
            $field_value = /*$label . */$CF->get_input($field, $value);
            $field_value = apply_filters('profile_options_rcl', $field_value, $userdata);
        }
        else
            $field_value = $field['value'];
        $profile_args += array($field_name => $field_value);
    }
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
    $profile_args = rcl_tab_template_content();
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

    $profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));

    $Table = new Rcl_Table(array(
        'cols' => array(
            array(
                'width' => 30
            ),
            array(
                'width' => 70
            )
        ),
        'zebra' => true,
        //'border' => array('table', 'rows')
    ));

    $content = rcl_get_include_template('template-operations.php', __FILE__);
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
    global $userdata, $user_ID;

    $profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));

    $Table = new Rcl_Table(array(
        'cols' => array(
            array(
                'width' => 30
            ),
            array(
                'width' => 70
            )
        ),
        'zebra' => true,
        //'border' => array('table', 'rows')
    ));

    $content = rcl_get_include_template('template-documents.php', __FILE__);
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

    $profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));

    $Table = new Rcl_Table(array(
        'cols' => array(
            array(
                'width' => 30
            ),
            array(
                'width' => 70
            )
        ),
        'zebra' => true,
        //'border' => array('table', 'rows')
    ));

    $content = rcl_get_include_template('template-people.php', __FILE__);
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

    $profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));

    $Table = new Rcl_Table(array(
        'cols' => array(
            array(
                'width' => 30
            ),
            array(
                'width' => 70
            )
        ),
        'zebra' => true,
        //'border' => array('table', 'rows')
    ));

    $content = rcl_get_include_template('template-requests.php', __FILE__);
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
    global $userdata, $user_ID;

    $profileFields = rcl_get_profile_fields(array('user_id'=>$master_id));

    $Table = new Rcl_Table(array(
        'cols' => array(
            array(
                'width' => 30
            ),
            array(
                'width' => 70
            )
        ),
        'zebra' => true,
        //'border' => array('table', 'rows')
    ));

    $content = rcl_get_include_template('template-settings.php', __FILE__);
    return $content;
}
/******************************/


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

//Обновляем профиль пользователя
add_action('wp', 'rcl_edit_profile', 10);
function rcl_edit_profile(){
    global $user_ID;
    //var_dump($_POST);

    //if( !wp_verify_nonce( $_POST['_wpnonce'], 'update-profile_' . $user_ID ) ) return false;
//    if ( isset( $_POST['submit_user_profile']))
//        rcl_update_profile_fields($user_ID);
    if (isset($_POST) && count($_POST) > 0)
    {
        $profileFields = rcl_get_profile_fields(array('user_id'=>$user_ID));
        $post_first_key = current(array_keys($_POST));
        $field_found = false;
        foreach($profileFields as $field)
        {
            if ($post_first_key == $field['slug']) {
                rcl_update_profile_fields($user_ID, array($field));
                $field_found = true;
                break;
            }
        }
        if (!$field_found)
            return false;
    }
    else
        return false;

    do_action( 'personal_options_update', $user_ID );

    $redirect_url = rcl_get_tab_permalink($user_ID,'profile').'&updated=true';

    wp_redirect( $redirect_url );

    exit;
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

    if(isset($userdata) && $userdata->user_level >= rcl_get_option('consol_access_rcl',7)){
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