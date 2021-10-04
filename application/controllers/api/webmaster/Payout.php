<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payout extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        is_webmaster() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function fetch()
    {
        $payouts = $this->Payout2->fetch_dt([
            'user_id' => userdata()->id
        ]);

        exit(json_encode(array_merge(['error' => 0], $payouts), JSON_PRETTY_PRINT));
    }


    public function get()
    {

    }


    public function add()
    {
        $webmaster_balance = userdata()->webmaster_balance;
        $min_payout_sum    = config_item('min_payout_sum');

        $this->validation->make([
            'amount' => "required|greater_than_equal_to[{$min_payout_sum}]|less_than_equal_to[{$webmaster_balance}]"
                ], [
            'amount.required'              => __('Укажите сумму для вывода!'),
            'amount.greater_than_equal_to' => __('Сумма для вывода ниже минимальной!'),
            'amount.less_than_equal_to'    => __('На вашем балансе нет такой суммы!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        if (!get_usersettings('payout_account')) {
            exit_json(1, __('Не указан аккаунт для выплат! Укажите аккаунт для выплат в настройках!'));
        }

        if (!get_globalsettings("enable_payouts")) {
            exit_json(1, __('Выплаты на PayPal отключены!'));
        }

        $request = $this->Payout2->add([
            'user_id'        => userdata()->id,
            'status'         => "new",
            'payout_gateway' => get_usersettings('payout_gateway'),
            'payout_account' => get_usersettings('payout_account'),
            'amount'         => $this->input->post('amount'),
            'details'        => "",
            'currency'        => get_globalsettings('current_currency', 'USD'),
            'created_at'     => gmdate("Y-m-d H:i:s"),
        ]);

        if ($request) {
            $this->User2->down_webmaster_balance(userdata()->id, $this->input->post('amount'));
        } else {
            exit_json(1, __('Ошибка!'));
        }

        exit_json(0, __('Запрос на выплату успешно создан!'));
    }


    public function cancel()
    {
        $payout_obj = $this->Payout2->get([
            'id'      => $this->input->post('id'),
            'status'  => 'new',
            'user_id' => userdata()->id
        ]);

        if (!$payout_obj) {
            exit_json(1, __("Платеж не найден или отмена платежа невозможна!"));
        }

        if (!$this->Payout2->delete($payout_obj->id)) {
            exit_json(1, __("Ошибка отмены платежа!"));
        }

        if (!$this->User2->up_webmaster_balance($payout_obj->user_id, $payout_obj->amount)) {
            exit_json(1, __("Ошибка возврата баланса!"));
        }

        exit_json(0, __('Выплата отменена!'));
    }


}
