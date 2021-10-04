<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = 'subscriptions';
        $this->primary_key  = 'id';
        $this->result_class = null;
    }

}