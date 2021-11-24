<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficiary extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_beneficiary() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email,
            'first_name' => userdata()->first_name,
            'last_name' => userdata()->last_name
        ];
    }


    public function index()
    {
        redirect("/beneficiary/dashboard");
    }


    public function dashboard()
    {
        $this->load->view('beneficiary/dashboard/dashboard', $this->viewdata + []);
    }

    public function transactions()
    {
        $this->load->view('beneficiary/transactions/transactions', $this->viewdata + []);
    }

    public function settings()
    {
        $this->load->view('beneficiary/settings/settings', $this->viewdata + []);
    }

}
