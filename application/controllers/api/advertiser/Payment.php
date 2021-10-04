<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_advertiser() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }

    public function index()
    {
        exit;
    }


    public function fetch()
    {
        $payments = $this->Payment2->fetch_dt([
            'user_id' => userdata()->id
        ]);

        foreach ($payments['data'] as &$payment) {
            $payment['payment_data'] = null;
        }

        exit(json_encode(array_merge(['error' => 0], $payments), JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $payment_obj = $this->Payment2->get([
            'user_id'    => userdata()->id,
            'payment_id' => $this->input->post_get('payment_id'),
        ]);

        if (!$payment_obj) {
            exit_json(1, __('Платеж не существует!'));
        }

        $payment_obj->username = userdata()->username;
        $payment_obj->email = userdata()->email;
        $payment_obj->payment_data = null;

        exit_json(0, '', $payment_obj);
    }


}
