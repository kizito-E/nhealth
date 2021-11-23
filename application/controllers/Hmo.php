<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hmo extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_hmo() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email
        ];
    }


    public function index()
    {
        redirect("/hmo/dashboard");
    }


    public function dashboard()
    {
        $this->load->view('hmo/dashboard/dashboard', $this->viewdata + []);
    }

    public function settings()
    {
        $this->load->view('hmo/settings/settings', $this->viewdata + []);
    }

}
