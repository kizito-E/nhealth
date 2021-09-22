<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('image')) {

    /**
     * Image URL and PATH. Does not check file for existence!
     * @param string $filename
     * @return object
     */
    function image($filename)
    {
        return (object) [
            'url'  => str_replace(['http://', 'https://'], '//', base_url(config_item('images_dir') . '/' . $filename)),
            'path' => FCPATH . config_item('images_dir') . DIRECTORY_SEPARATOR . $filename
        ];
    }


}


// ------------------------------------------------------------------------

if (!function_exists('with_commission')) {

    /**
     * Возвращает сумму за вычетом комиссии системы
     */
    function with_commission($amount, $percent = null)
    {
        $commission = $percent ? $percent : get_globalsettings('comission', 20);

        $per = ($amount / 100) * $commission;

        return round($amount + $per, 5);
    }


}
// ------------------------------------------------------------------------

if (!function_exists('deduct_commission')) {

    /**
     * Возвращает сумму за вычетом комиссии системы
     */
    function deduct_commission($amount, $percent = null)
    {
        $commission = $percent ? $percent : get_globalsettings('comission', 20);

        return round($amount * (100 - $commission) / 100, 5);
    }


}
// ------------------------------------------------------------------------

if (!function_exists('event')) {


    function event($name, $params = null)
    {
        $CI = &get_instance();
        $CI->load->library('event');
        $CI->event->trigger($name, $params);
    }


}

// ------------------------------------------------------------------------

if (!function_exists('superhash')) {


    function superhash($str)
    {
        $pefix_salt  = sha1(md5($str));
        $suffix_salt = md5(sha1($str));

        return sha1($pefix_salt . $str . $suffix_salt);
    }


}

// ------------------------------------------------------------------------

if (!function_exists('big_random_string')) {


    function big_random_string($length = 256)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-`~';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}

// ------------------------------------------------------------------------

if (!function_exists('random_hash')) {


    function random_hash()
    {
        return superhash(big_random_string());
    }


}

// ------------------------------------------------------------------------

if (!function_exists('is_ssl')) {


    function is_ssl()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }


}

// ------------------------------------------------------------------------

if (!function_exists('sanitize_input_text')) {


    function sanitize_input_text($str = '', $length = 100)
    {
        $str = htmlspecialchars_decode($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = str_replace(['&', '"', '\'', '>', '<'], '', $str);
        $str = preg_replace('/[\s]{2,}/', ' ', $str);
        $str = trim($str);

        return mb_substr($str, 0, $length);
    }


}

// ------------------------------------------------------------------------

if (!function_exists('csrf_token')) {


    function csrf_token($name = 'csrf', $echo = true)
    {
        $token = isset($_COOKIE[$name]) ? $_COOKIE[$name] : '';

        if (preg_match("/^[a-f0-9]{32}$/", $token)) {
            if ($echo) {
                echo $token;
            } else {
                return $token;
            }
        } else {

            $token = md5(md5(rand(0, 1000000000)) . md5(microtime()));

            $c = array(
                'name'     => $name,
                'value'    => $token,
                'expire'   => 0,
                'path'     => '/',
                'domain'   => '',
                'secure'   => false,
                'httponly' => true
            );

            setcookie($c['name'], $c['value'], $c['expire'], $c['path'], $c['domain'], $c['secure'], $c['httponly']);

            if ($echo) {
                echo $token;
            } else {
                return $token;
            }
        }
    }


}

// ------------------------------------------------------------------------

if (!function_exists('csrf_input')) {


    function csrf_input($name = 'csrf')
    {
        echo '<input type="hidden" name="' . $name . '" value="' . csrf_token($name, false) . '">';
    }


}

// ------------------------------------------------------------------------

if (!function_exists('validate_csrf_token')) {


    function check_csrf_token($name = 'csrf')
    {
        $cookie_csrf_token = isset($_COOKIE[$name]) ? $_COOKIE[$name] : '';
        $input_csrf_token  = isset($_POST[$name]) ? $_POST[$name] : (isset($_GET[$name]) ? $_GET[$name] : '');

        if (!$cookie_csrf_token || !$input_csrf_token) {
            return false;
        }

        if ($cookie_csrf_token != $input_csrf_token) {
            return false;
        }

        return true;
    }


}

// ------------------------------------------------------------------------

if (!function_exists('delete_csrf_cookie')) {


    function delete_csrf_cookie($name = 'csrf')
    {
        setcookie($name, '', -1, '/');
    }


}

// ------------------------------------------------------------------------

if (!function_exists('__')) {


    function __($string = "")
    {
        $CI = &get_instance();
        $CI->load->library('session');

        if (!$CI->session->userdata('id')) {
            $lang = config_item('default_interface_lang');
        } else {
            $lang = get_usersettings('lang', 'en');
        }

        $locale_file = APPPATH . "language/locales/{$lang}.php";

        if (!file_exists($locale_file)) {
            return $string;
        }

        $translator = new \Gettext\Translator();
        $translator->loadTranslations($locale_file);

        return $translator->gettext($string);
    }


}

// ------------------------------------------------------------------------

if (!function_exists('_e')) {


    function _e($string = "")
    {
        $CI = &get_instance();
        $CI->load->library('session');

        if (!$CI->session->userdata('id')) {
            $lang = config_item('default_interface_lang');
        } else {
            $lang = get_usersettings('lang', 'en');
        }

        $locale_file = APPPATH . "language/locales/{$lang}.php";

        if (!file_exists($locale_file)) {
            echo $string;
        } //
        else {

            $translator = new \Gettext\Translator();
            $translator->loadTranslations($locale_file);

            echo $translator->gettext($string);
        }
    }


}

// ------------------------------------------------------------------------

if (!function_exists('compile_translations')) {


    function compile_translations()
    {
        foreach (glob(APPPATH . "language/locales/*.po") as $value) {

            $translations = \Gettext\Translations::fromPoFile($value);
            $lang         = basename($value, '.po') . '.php';
            $translations->toPhpArrayFile(dirname($value) . DIRECTORY_SEPARATOR . $lang);
        }
    }


}

// ------------------------------------------------------------------------

if (!function_exists('in_array_array')) {


    function in_array_array($needle_array, $haystack_array)
    {
        if (empty($needle_array)) {
            return false;
        }

        if (count(array_diff($needle_array, $haystack_array)) == 0) {
            return true;
        }
        return false;
    }


}


// ------------------------------------------------------------------------

if (!function_exists('create_expiration_token')) {


    function create_expiration_token($data = "", $expiration = 100)
    {
        return md5($data . (time() + $expiration));
    }


}

// ------------------------------------------------------------------------

if (!function_exists('validate_expiration_token')) {


    function validate_expiration_token($token, $data = "", $expiration = 100)
    {
        $time     = time();
        $time_end = $time + $expiration;

        for ($i = $time_end; $i > $time; $i--) {

            if ($token == md5($data . $i)) {
                return $i - time();
            }
        }

        return false;
    }


}

// ------------------------------------------------------------------------

if (!function_exists('calculate_ctr')) {

    function calculate_ctr($views, $clicks)
    {
        $views = max(1, $views);

        $ctr = ($clicks / $views) * 100;

        return round($ctr, 2);
    }


}


// ------------------------------------------------------------------------

if (!function_exists('calculate_cpm')) {

    function calculate_cpm($costs, $views)
    {
        if ($costs == 0 || $views == 0) {
            return 0;
        }

        return round(($costs / $views) * 1000, 4);
    }


}


// ------------------------------------------------------------------------

if (!function_exists('print_js_var')) {

    function print_js_var($var_name, $var_value = null, $flags = null)
    {
        $var_name = (string) $var_name;

        if (empty($var_name) || !ctype_alpha($var_name[0])) {
            return;
        }

        if (is_string($var_value)) {
            echo "<script>var {$var_name} = '" . addslashes($var_value) . "';</script>" . PHP_EOL;
        } //
        else {
            echo "<script>var {$var_name} = " . json_encode($var_value, $flags) . ";</script>" . PHP_EOL;
        }
    }


}

// ------------------------------------------------------------------------

if (!function_exists('is_post_request')) {

    function is_post_request()
    {
        $request = $_SERVER['REQUEST_METHOD'] ? $_SERVER['REQUEST_METHOD'] : '';
        return (bool) ($request === 'POST');
    }


}


// ------------------------------------------------------------------------

if (!function_exists('selected')) {

    function selected($a, $b, $echo = true)
    {
        if (!$echo) {
            return ($a == $b) ? 'selected' : '';
        }

        echo ($a == $b) ? 'selected' : '';
    }


}

// ------------------------------------------------------------------------

if (!function_exists('checked')) {

    function checked($a, $b, $echo = true)
    {
        if (!$echo) {
            return ($a == $b) ? 'checked' : '';
        }

        echo ($a == $b) ? 'checked' : '';
    }


}

// ------------------------------------------------------------------------

if (!function_exists('hiddenclass')) {

    function hiddenclass($expression, $echo = true)
    {
        if (!$echo) {
            return !$expression ? 'hidden ' : '';
        }

        echo !$expression ? 'hidden ' : '';
    }


}


// ------------------------------------------------------------------------

if (!function_exists('exit_json')) {

    function exit_json($error = 0, $message = "", $data = "")
    {
        exit(json_encode(array('error' => $error, 'message' => $message, 'data' => $data), JSON_PRETTY_PRINT));
    }


}


// ------------------------------------------------------------------------

if (!function_exists('menu_item')) {

    function menu_item($patterns, $adding_class = '', $only_classes = false)
    {
        $CI = &get_instance();

        foreach ((array) $patterns as $pattern) {
            if (preg_match("/{$pattern}/i", $CI->uri->uri_string())) {

                if ($only_classes) {
                    echo 'active ' . $adding_class;
                } else {
                    echo 'class="active ' . $adding_class . '"';
                }


                break;
            }
        }
    }


}

//---------------------------------------------------------------

if (!function_exists('get_globalsettings')) {


    function get_globalsettings($key = null, $default = null)
    {
        $CI = &get_instance();

        if (!isset($CI->settings2_model)) {
            $CI->load->model('settings2_model');
        }

        if (is_null($key)) {
            return $CI->settings2_model->system()->all();
        } else {
            return $CI->settings2_model->system()->get($key, $default);
        }
    }


}

if (!function_exists('set_globalsettings')) {


    function set_globalsettings($key, $value)
    {
        $CI = &get_instance();

        if (!isset($CI->settings2_model)) {
            $CI->load->model('settings2_model');
        }

        return $CI->settings2_model->system()->set($key, $value);
    }


}

if (!function_exists('get_usersettings')) {


    function get_usersettings($key = "", $default = null)
    {
        $CI = &get_instance();

        $user_id = isset(userdata()->id) ? userdata()->id : null;

        if (!isset($CI->settings2_model)) {
            $CI->load->model('settings2_model');
        }

        if (!$key) {
            return $CI->settings2_model->user($user_id)->all();
        } else {
            return $CI->settings2_model->user($user_id)->get($key, $default);
        }
    }


}

if (!function_exists('set_usersettings')) {


    function set_usersettings($key, $value)
    {
        $CI = &get_instance();

        $user_id = userdata()->id;

        if (!isset($CI->settings2_model)) {
            $CI->load->model('settings2_model');
        }

        return $CI->settings2_model->user($user_id)->set($key, $value);
    }


}

if (!function_exists('check_auth')) {


    function check_auth()
    {
        $CI = &get_instance();

        if (!isset($CI->session)) {
            $CI->load->library('session');
        }

        return isset($CI->session->id);
    }


}

if (!function_exists('userdata')) {


    // не используй эту функцию в любом конструкторе!!!
    function userdata()
    {
        $CI = &get_instance();

        if (!isset($CI->session)) {
            $CI->load->library('session');
        }

        if (!isset($CI->session->id)) {
            return null;
        }

        static $ret = null;

        if (!$ret) {
            $ret = $CI->db->get_where(config_item('users_table'), ['id' => $CI->session->id])->row();
        }

        return $ret;
    }


}

if (!function_exists('admindata')) {


    // не используй эту функцию в любом конструкторе!!!
    function admindata()
    {
        $CI = &get_instance();

        if (!isset($CI->session)) {
            $CI->load->library('session');
        }

        static $ret = null;

        if (!$ret) {
            $ret = $CI->db->get_where(config_item('users_table'), ['role' => 'administrator'])->row(1);
        }

        return $ret;
    }


}


if (!function_exists('is_administrator')) {


    function is_administrator()
    {
        return isset(userdata()->role) && userdata()->role == 'administrator';
    }


}

if (!function_exists('is_webmaster')) {


    function is_webmaster()
    {
        return isset(userdata()->subrole) && userdata()->subrole == 'webmaster';
    }


}

if (!function_exists('is_advertiser')) {


    function is_advertiser()
    {
        return isset(userdata()->subrole) && userdata()->subrole == 'advertiser';
    }


}

if (!function_exists('is_moderator')) {


    function is_moderator()
    {
        return isset(userdata()->subrole) && userdata()->subrole == 'moderator';
    }


}

// ------------------------------------------------------------------------

if (!function_exists('absint')) {


    function absint($val)
    {
        return abs(intval($val));
    }


}
