<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends REST_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table       = 'users';
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

        if (!$userdata) return "Incorrect email / password";

        if ($userdata->status != 1) return "User account not active";

        //$this->session->set_userdata((array) $userdata);

        return true;
    }


    public function logout()
    {

        delete_csrf_cookie();

        return (bool) $this->session->sess_destroy();
    }


}
