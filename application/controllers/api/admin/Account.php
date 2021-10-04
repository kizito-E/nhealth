<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function to_user()
    {
        is_administrator() OR exit_json(1, __('Ошибка доступа!'));

        $userId = $this->input->post("userId");

        $userData = (array) $this->User2->get([
            "id" => $userId
        ]);

        if (!$userData) {
            exit_json(1, __("Ошибка перехода в аккаунт пользователя!"));
        }

        $userData["is_admin"] = 1;

        $this->session->set_userdata($userData);

        exit_json(0);
    }

    public function to_admin()
    {
        if (!isset($this->session->is_admin)) {
            exit_json(1, __("Ошибка перехода в аккаунт администратора!"));
        }

        $adminData = (array) $this->User2->get([
            "id" => admindata()->id
        ]);

        $this->session->set_userdata($adminData);

        exit_json(0);
    }

}
