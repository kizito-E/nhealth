<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_administrator() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email,
            'name'  => userdata()->business_name
        ];
    }


    public function index()
    {
        redirect("/administrator/dashboard");
    }


    public function dashboard()
    {
        $this->load->view('admin/dashboard/dashboard', $this->viewdata + []);
    }

    public function accounts()
    {
        $this->load->view('admin/users/users', $this->viewdata + []);
    }

    public function subscriptions()
    {
        $this->load->view('admin/subscriptions/subscriptions', $this->viewdata + []);
    }

    public function settings()
    {
        $this->load->view('admin/settings/settings', $this->viewdata + []);
    }

}
