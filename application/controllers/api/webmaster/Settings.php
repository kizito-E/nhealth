<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

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


    public function get()
    {
        exit_json(0, '', [
            'lang'           => get_usersettings('lang', 'en'),
            'timezone'       => get_usersettings('timezone', 'Europe/London'),
            'payout_account' => get_usersettings('payout_account'),
        ]);
    }


    public function set()
    {
        $langs      = implode(',', config_item('interface_langs'));
        $time_zones = implode(',', DateTimeZone::listIdentifiers());

        $this->validation->make([
            'lang'           => "required|in_list[{$langs}]",
            'timezone'       => "required|in_list[{$time_zones}]",
            'payout_account' => "valid_email",
                ], [
            'lang.*'           => __('Некорректный язык интерфейса!'),
            'timezone.*'       => __('Некорректная временная зона!'),
            'payout_account.*' => __('Некорректный платежный аккаунт!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        set_usersettings('lang', $this->input->post('lang'));
        set_usersettings('timezone', $this->input->post('timezone'));
        set_usersettings('payout_account', $this->input->post('payout_account'));
        set_usersettings('payout_gateway', 'paypal');

        if ($this->input->post('old_password') && $this->input->post('new_password')) {
            $this->_set_new_password();
        }

        exit_json(0, __('Настройки обновлены!'));
    }


    public function _set_new_password()
    {
        $this->validation->make([
            'old_password' => "required|callback__check_old_password",
            'new_password' => "required|differs[old_password]|min_length[8]|max_length[20]",
                ], [
            'old_password.required'            => __('Введите старый пароль!'),
            'old_password._check_old_password' => __('Неверный старый пароль!'),
            'new_password.differs'             => __('Новый пароль должен отличаться от старого!'),
            'new_password.min_length'          => __('Пароль слишком короткий!'),
            'new_password.max_length'          => __('Пароль слишком длинный!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $this->User2->set_password(userdata()->id, $this->input->post('new_password'));
    }


    public function _check_old_password($old_password)
    {
        return $this->User2->exists([
                    'id'       => userdata()->id,
                    'password' => superhash($old_password)
        ]);
    }


}
