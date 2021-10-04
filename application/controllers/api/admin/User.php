<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_administrator() or exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() or exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function get()
    {
        $user_obj = $this->User2->get([
            'id' => $this->input->post_get('id')
        ]);

        exit_json(0, '', $user_obj);
    }


    public function fetch()
    {
        $users = $this->User2->fetch_dt();

        foreach ($users['data'] as &$user) {
            $user['count_sites'] = $this->Site2->count(['user_id' => $user['id']]);
            $user['count_camps'] = $this->Camp2->count(['user_id' => $user['id']]);
            $user['count_ads'] = $this->Ads2->count(['user_id' => $user['id']]);
            $user['count_tickets'] = $this->Ticket2->count(['user_id' => $user['id']]);
            $user['count_payments'] = $this->Payment2->count(['user_id' => $user['id']]);
            $user['count_payouts'] = $this->Payout2->count(['user_id' => $user['id']]);
        }

        exit(json_encode(array_merge(['error' => 0], $users), JSON_PRETTY_PRINT));
    }


    public function add()
    {
        $this->validation->make([
            "username" => "required|is_unique[users.username]",
            "email"    => "required|valid_email|is_unique[users.email]",
            "password" => "required|min_length[8]|max_length[20]",
            "subrole"  => "required|in_list[webmaster,advertiser,moderator]",
        ], [
            "username.required"   => __("Имя пользователя не может быть пустым!"),
            "username.is_unique"  => __("Это имя пользователя уже занято!"),
            "email.required"      => __("Email не может быть пустым!"),
            "email.valid_email"   => __("Некорректный email!"),
            "email.is_unique"     => __("Этот email уже существует в системе!"),
            "password.required"   => __("Пароль не может быть пустым!"),
            "password.min_length" => __("Длина пароля должна быть не менее {param} символов!"),
            "password.max_length" => __("Длина пароля должна быть не более {param} символов!"),
            "role.*"              => __("Некорректная роль!"),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $user_obj = $this->User2->add([
            'username'      => $this->input->post("username"),
            'email'         => $this->input->post("email"),
            'password'      => superhash($this->input->post("password")),
            'role'          => 'user',
            'subrole'       => $this->input->post("subrole"),
            'status'        => 1,
            'register_date' => gmdate('Y-m-d H:i:s'),
        ]);

        if (!$user_obj) {
            exit_json(1, __("Возникла ошибка!"));
        }

        $user_obj->plain_password = $this->input->post("password");

        event("user.register", $user_obj);

        exit_json(0, __('Пользователь успешно добавлен!'));
    }


    public function set_role()
    {
        $this->validation->make([
            "id"      => "required|is_exists[users.id]",
            "subrole" => "required|in_list[webmaster,advertiser,moderator]",
        ], [
            "id.*"      => __("Некорректный ID пользователя!"),
            "subrole.*" => __("Некорректная роль!"),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'id'    => $this->input->post("id"),
            'id !=' => $this->User2->get(['role' => 'administrator'])->id // нельзя менять роль администратора
        ];

        $user_obj = $this->User2->update($where, [
            'subrole' => $this->input->post("subrole"),
        ]);

        if (!$user_obj) {
            exit_json(1, __("Возникла ошибка!"));
        }

        exit_json(0, __('Пользователь успешно изменен!'));
    }


    public function set_balance()
    {
        $allowedCurrencies = implode(',', config_item('allowed_payment_currencies'));

        $this->validation->make([
            'id'                     => "required|trim|is_exists[users.id]",
            'email'                  => "required|trim|is_exists[users.email]",
            'new_webmaster_balance'  => "required|trim|numeric",
            'new_advertiser_balance' => "required|trim|numeric",
            'webmaster_diff'         => "required|trim|numeric",
            'advertiser_diff'        => "required|trim|numeric",
            'currency'               => "required[in_list[{$allowedCurrencies}]]",
        ], [
            'id.*'                     => __("Пользователя с таким ID не существует!"),
            'email.*'                  => __("Пользователя с таким e-mail не существует!"),
            'new_webmaster_balance.*'  => __("Некорректный новый баланс вебмастера!"),
            'new_advertiser_balance.*' => __("Некорректный новый баланс рекламодателя!"),
            'webmaster_diff.*'         => __("Некорректный баланс вебмастера!"),
            'advertiser_diff.*'        => __("Некорректный баланс рекламодателя!"),
            'currency'                 => __("Некорректная валюта!")
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $user_obj = $this->User2->update([
            'id' => $this->input->post('id')
        ], [
            'webmaster_balance'  => $this->input->post('new_webmaster_balance'),
            'advertiser_balance' => $this->input->post('new_advertiser_balance')
        ]);

        if (!$user_obj) {
            exit_json(1, __("Ошибка изменения баланса!"));
        }

        // set webmaster
        if ($this->input->post('webmaster_diff') != 0) {

            $payment_obj = $this->Payment2->add([
                'user_id'      => $this->input->post('id'),
                'amount'       => $this->input->post('webmaster_diff'),
                'gateway'      => 'manual',
                'description'  => "The webmaster's balance has been changed by the administrator.",
                'currency'     => $this->input->post('currency'),
                'payment_data' => null,
                'created_at'   => gmdate('Y-m-d H:i:s')
            ]);

            event('payment.change_webmaster_balance', $payment_obj);
        }

        // set advertiser
        if ($this->input->post('advertiser_diff') != 0) {

            $payment_obj = $this->Payment2->add([
                'user_id'      => $this->input->post('id'),
                'amount'       => $this->input->post('advertiser_diff'),
                'gateway'      => 'manual',
                'description'  => "The advertiser's balance has been changed by the administrator.",
                'currency'     => $this->input->post('currency'),
                'payment_data' => null,
                'created_at'   => gmdate('Y-m-d H:i:s')
            ]);

            event('payment.change_advertiser_balance', $payment_obj);
        }

        exit_json(0, __('Баланс успешно изменен!'));
    }


    public function ban()
    {
        $where = [
            'id'    => $this->input->post("id"),
            'id !=' => $this->User2->get(['role' => 'administrator'])->id // admin not edit
        ];

        $user_obj = $this->User2->update($where, [
            'status'         => 0,
            'status_message' => $this->input->post("message"),
        ]);

        if (!$user_obj) {
            exit_json(1, __("Возникла ошибка!"));
        }

        exit_json(0, __('Пользователь забанен!'));
    }


    public function unban()
    {
        $where = [
            'id'    => $this->input->post("id"),
            'id !=' => $this->User2->get(['role' => 'administrator'])->id // admin not edit
        ];

        $user_obj = $this->User2->update($where, [
            'status'         => 1,
            'status_message' => "",
        ]);

        if (!$user_obj) {
            exit_json(1, __("Возникла ошибка!"));
        }

        exit_json(0, __('Пользователь забанен!'));
    }


    public function search()
    {
        $result = $this->User2->search($this->input->post_get("q"), [
            'id',
            'username',
            'email'
        ]);

        exit_json(0, '', $result);
    }


}
