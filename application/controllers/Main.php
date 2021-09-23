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
        header("404 Not Found / Unauthorized Access", true, 404);
        exit();
    }


}
