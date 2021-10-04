<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        is_moderator() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
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
