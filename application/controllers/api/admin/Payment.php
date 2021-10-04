<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_administrator() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }

    public function index()
    {
        exit;
    }


    public function fetch()
    {
        $where = [];

        if ($this->input->post('filter_user_id')) {
            $where['user_id'] = $this->input->post_get('filter_user_id');
        }

        $payments = $this->Payment2->fetch_dt($where);

        foreach ($payments['data'] as &$payment) {

            $user_obj = $this->User2->get(['id' => $payment['user_id']]);

            $payment['username'] = isset($user_obj->username) ? $user_obj->username : '';
        }

        exit(json_encode(array_merge(['error' => 0], $payments), JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $payment_obj = $this->Payment2->get([
            'payment_id' => $this->input->post_get('payment_id'),
        ]);

        if (!$payment_obj) {
            exit_json(1, __('Платеж не существует!'));
        }

        $payment_obj->username = $payment_obj->user()->username;
        $payment_obj->email = $payment_obj->user()->email;
        $payment_obj->payment_data = @unserialize($payment_obj->payment_data);

        exit_json(0, '', $payment_obj);
    }


}
