<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $viewdata;

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            'auth2_model'                                         => 'Auth2',
            'user_model'                                          => 'User2',
            'mailer2_model'                                       => 'Mailer2',
            'plan_model'                                          => 'Plan',
            'record_model'                                        => 'Record',
            'transaction_model'                                   => 'Transaction',
            'subscription_model'                                  => 'Subscription',
        ]);

        $this->load->library([
            'validation',
            'dt_agregate',
            'datatables'
        ]);

        $this->load->helper([
            'string'
        ]);
    }


}
