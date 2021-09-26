<?php

defined('BASEPATH') OR exit('No direct script access allowed');


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
            $ret = $CI->db->get_where('users', ['id' => $CI->session->id])->row();
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
            $ret = $CI->db->get_where('users', ['role' => 'administrator'])->row(1);
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

// ------------------------------------------------------------------------

if (!function_exists('absint')) {


    function absint($val)
    {
        return abs(intval($val));
    }


}