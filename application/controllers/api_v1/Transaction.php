<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends REST_Controller {

    /**
     * Constructor
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function new_post(){

        $res = [
            'status'    => 'Failed',
        ];
        $this->response($res, $http_code = 500);

    }

}