<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends REST_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = 'transactions';
        $this->primary_key  = 'id';
        $this->result_class = null;
    }

}