<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Docs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->load->view('/docs/home');
    }

    public function guide()
    {
        $this->load->view('/docs/guide');
    }

    public function api()
    {
        $this->load->view('/docs/api');
    }

    public function faqs()
    {
        $this->load->view('/docs/faqs');
    }
}