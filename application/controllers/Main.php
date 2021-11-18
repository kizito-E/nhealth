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

    public function dashboard()
    {
        check_auth() OR redirect("/auth/login/");

        if (is_administrator()) {
            redirect("/admin/dashboard");
        } else if (is_hmo()) {
            redirect("/hmo/dashboard");
        } else if (is_sp()) {
            redirect("/serviceprovider/dashboard");
        } else if (is_beneficiary()) {
            redirect("/beneficiary/dashboard");
        }

        redirect("/auth/login/");
    }

}