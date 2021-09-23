<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ping extends REST_Controller {

    /**
     * Constructor
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function index_post(){

        $this->response(['status' => 'success'], self::HTTP_OK);
        
    }

}