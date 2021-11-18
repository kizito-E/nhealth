<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payout extends MY_Controller {

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

        $payouts = $this->Payout2->fetch_dt($where);

        foreach ($payouts['data'] as &$payout) {
            $user_obj = $this->User2->get(['id' => $payout['user_id']]);

            $payout['username'] = isset($user_obj->username) ? $user_obj->username : null;
        }

        exit(json_encode(array_merge(['error' => 0], $payouts), JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $payout_obj = $this->Payout2->get([
            'id' => $this->input->post_get('id'),
        ]);

        if (!$payout_obj) {
            exit_json(1, __('Ошибка!'));
        }

        exit_json(0, '', $payout_obj);
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

        $request = $this->Payout2->add([
            'user_id'        => userdata()->id,
            'status'         => "processing",
            'payout_gateway' => get_usersettings('payout_gateway'),
            'payout_account' => get_usersettings('payout_account'),
            'amount'         => $this->input->post('amount'),
            'details'        => "",
            'created_at'     => gmdate("Y-m-d H:i:s"),
        ]);

        if ($request) {
            $this->User2->down_webmaster_balance(userdata()->id, $this->input->post('amount'));
        } else {
            exit_json(1, __('Ошибка!'));
        }

        exit_json(0, __('Запрос на выплату успешно создан!'));
    }


    public function start()
    {
        $where = [
            'id' => $this->input->post_get('id')
        ];

        $params = [
            'status' => 'processing'
        ];

        if (!$this->Payout2->update($where, $params)) {
            exit_json(1, __('Ошибка!'));
        }

        exit_json(0, __('Статус выплаты изменен на "обрабатывается"'));
    }


    public function end_success()
    {
        $where = [
            'id' => $this->input->post_get('id')
        ];

        $params = [
            'status'       => 'success',
            'completed_at' => gmdate('Y-m-d H:i:s'),
            'details' => $this->input->post('details')
        ];

        if (!$this->Payout2->update($where, $params)) {
            exit_json(1, __('Ошибка!'));
        }

        exit_json(0, __('Статус выплаты изменен на "успешный"'));
    }


    public function end_error()
    {
        $where = [
            'id' => $this->input->post_get('id')
        ];

        $params = [
            'status'       => 'error',
            'completed_at' => gmdate('Y-m-d H:i:s'),
            'details' => $this->input->post('details')
        ];

        // выплата не улалась - возвращаем леньги на баланс вебмастера
        if ($this->Payout2->update($where, $params)) {

            $payout = $this->Payout2->get($where);

            if (isset($payout->user_id) && $this->User2->up_webmaster_balance($payout->user_id, $payout->amount)) {
                exit_json(0, __('Статус выплаты изменен на "неудачный". Сумма выплаты возвращена на аккаунт вебмастера.'));
            }
        }

        exit_json(1, __('Ошибка возврата средст на аккаунт вебмастера!'));
    }


}
