<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends MY_Controller {

    /**
     * Constructor
     */

    public function __construct()
    {
        parent::__construct();

        check_csrf_token() OR exit_json(1, "Invalid CSRF Token!");
    }

    public function index()
    {
        exit;
    }

}