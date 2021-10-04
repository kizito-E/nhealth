<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_exists')) {

    function is_exists($str, $field)
    {
        $ci = &get_instance();
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($ci->db) ? ($ci->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 1) : false;
    }


}

if (!function_exists('is_hex')) {

    function is_hex($color)
    {
        return (bool) preg_match("/#([a-fA-F0-9]{6})\b/", $color);
    }


}

if (!function_exists('is_valid_url')) {

    function is_valid_url($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        return false;
    }


}

//if (!function_exists('is_valid_domain')) {
//
//    function is_valid_domain($domain)
//    {
//        $domain = preg_replace("(^https?://)", "", $domain);
//
//        if (!$domain || !filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)) {
//            return false;
//        }
//
//        return true;
//    }
//
//
//}


if (!function_exists('clear_domain')) {

    function clear_domain($domain)
    {
        return trim(str_replace(['http://www.', 'https://www.', 'http://', 'https://'], '', $domain));
    }


}
if (!function_exists('is_valid_domain')) {

    function is_valid_domain($domain_name)
    {
        if (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name)
            && preg_match("/^.{1,253}$/", $domain_name)
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)
            && filter_var(gethostbyname($domain_name), FILTER_VALIDATE_IP)) {
            return $domain_name;
        }
        return false;
    }

}

if (!function_exists('max_array_length')) {

    function max_array_length()
    {
        list($array_field_name, $array_max_length) = explode(",", func_get_arg(1));

        return !(count(get_instance()->input->post_get($array_field_name)) > $array_max_length);
    }


}


if (!function_exists('is_unique_array_items')) {

    function is_unique_array_items()
    {
        $array_field_name = func_get_arg(1);
        $array = get_instance()->input->post_get($array_field_name);

        return count($array) == count(array_unique($array));
    }


}
