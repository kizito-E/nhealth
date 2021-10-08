<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->load->view('/landing/home');
    }

    public function auth()
    {
        check_auth() OR redirect("/auth/login/");

        if (is_administrator()) {
            redirect("/administrator");
        }

        redirect("/auth/login/");
    }

}