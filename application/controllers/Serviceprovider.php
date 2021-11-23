<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Serviceprovider extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_sp() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email
        ];
    }


    public function index()
    {
        redirect("/serviceprovider/dashboard");
    }


    public function dashboard()
    {
        $this->load->view('service_provider/dashboard/dashboard', $this->viewdata + []);
    }

    public function settings()
    {
        $this->load->view('service_provider/settings/settings', $this->viewdata + []);
    }

}
