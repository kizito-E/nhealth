<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table       = config_item('users_table');
        $this->primary_key = 'id';
        $this->load->library('session');
    }


    public function is_logged()
    {
        return isset($this->session->id);
    }


    public function login($email, $password)
    {
        $userdata = $this->get([
            'email'    => $email,
            'password' => superhash($password),
        ]);

        if (!$userdata) {
            throw new Exception(__("Неверный Логин / Пароль"));
        }

        if ($userdata->status != 1) {
            throw new Exception(__("Аккаунт заблокирован!"));
        }

        $this->session->set_userdata((array) $userdata);

        event('auth.login', ['user_id' => $userdata]);

        return true;
    }


    public function logout()
    {
        event('auth.logout', ['user_id' => $this->session]);

        delete_csrf_cookie();

        return (bool) $this->session->sess_destroy();
    }


}
