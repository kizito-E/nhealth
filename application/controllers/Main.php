<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        check_auth() OR redirect("/auth/login/");
    }


    public function index()
    {
        if (is_webmaster()) {
            redirect("/webmaster");
        }

        if (is_advertiser()) {
            redirect("/advertiser");
        }

        if (is_moderator()) {
            redirect("/moderator");
        }

        if (is_administrator()) {
            redirect("/administrator");
        }

        redirect("/auth/login/");
    }


}
