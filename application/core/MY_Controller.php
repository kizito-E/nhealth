<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $viewdata;

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            'auth2_model'                                         => 'Auth2',
            'user2_model'                                         => 'User2',
            'site2_model'                                         => 'Site2',
            'unit2_model'                                         => 'Unit2',
            'ticket2_model'                                       => 'Ticket2',
            'payout2_model'                                       => 'Payout2',
            'message2_model'                                      => 'Message2',
            'mailer2_model'                                       => 'Mailer2',
            'settings2_model'                                     => 'Settings2',
            'camp2_model'                                         => 'Camp2',
            'bl_sites_model'                                      => 'BlSites',
            'ads2_model'                                          => 'Ads2',
            'payment2_model'                                      => 'Payment2',
            //
            'get_stat/webmaster/webmaster_dashboard_stat_model'   => 'WebmasterDashboardStat',
            'get_stat/advertiser/advertiser_dashboard_stat_model' => 'AdvertiserDashboardStat',
            'get_stat/admin/admin_dashboard_stat_model'           => 'AdminDashboardStat',
        ]);

        $this->load->library([
            'validation',
            'request',
            'paypal',
            'dt_agregate',
            'datatables'
        ]);

        $this->load->helper([
            'string'
        ]);
    }


}
