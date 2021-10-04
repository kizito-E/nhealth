<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal {

    public function ipn_validate()
    {
        $req = 'cmd=_notify-validate';

        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req   .= "&$key=$value";
        }

        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, get_globalsettings("paypal_sandbox", 0) ? config_item('paypal_api_url_sandbox') : config_item('paypal_api_url'));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        if (preg_match("/VERIFIED/i", $result)) {
            return true;
        }

        return false;
    }


    public function is_complete_transaction()
    {
        $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : null;
        $mc_currency    = isset($_POST['mc_currency']) ? $_POST['mc_currency'] : null;

        if (strtolower($payment_status) != 'completed') {
            return false;
        }

        if (!in_array(strtoupper($mc_currency), config_item("allowed_payment_currencies"))) {
            return false;
        }

        return true;
    }


    public function is_duplicate_transaction()
    {
        $CI = & get_instance();

        $data = (object) json_decode($CI->input->post('custom'));

        $CI->db->where([
            'user_id'     => isset($data->user_id) ? $data->user_id : null,
            'payment_hid' => isset($data->payment_hid) ? $data->payment_hid : null,
        ]);

        $CI->db->from(config_item('payments_table'));

        return (bool) $CI->db->count_all_results();
    }


    public function payment_data()
    {
        $payment_data = [];

        $post_keys = ['mc_gross', 'protection_eligibility', 'address_status',
            'payer_id', 'address_street', 'payment_date', 'payment_status', 'charset',
            'address_zip', 'first_name', 'mc_fee', 'address_country_code', 'address_name',
            'notify_version', 'payer_status', 'business', 'address_country',
            'address_city', 'quantity', 'verify_sign', 'payer_email', 'txn_id', 'payment_type',
            'last_name', 'address_state', 'receiver_email', 'payment_fee', 'receiver_id',
            'txn_type', 'item_name', 'mc_currency', 'item_number', 'residence_country',
            'test_ipn', 'transaction_subject', 'payment_gross', 'ipn_track_id', 'custom'];

        foreach ($_POST as $key => $value) {
            if (in_array($key, $post_keys)) {
                $payment_data[$key] = $value ? $value : "";
            }
        }

        $payment_data['custom'] = (array) json_decode($payment_data['custom']);

        return $payment_data;
    }


}
