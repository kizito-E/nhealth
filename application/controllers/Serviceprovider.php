<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Serviceprovider extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_sp() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email,
            'name'  => userdata()->business_name
        ];
    }


    public function index()
    {
        redirect("/serviceprovider/dashboard");
    }


    public function dashboard()
    {
        $data = [
            'total_beneficiaries' => $this->db->select('user_id')->where(['sp_id' => userdata()->id])->distinct()->count_all_results('records'),
            'total_amount' => $this->db->where(['sp_id' => userdata()->id])->select_sum('amount_due')->get('records')->row()->amount_due,
            'week_service' => $this->db->where([
                'sp_id' => userdata()->id,
                'date_initiated >=' => gmdate('Y-m-d H:i:s', time() - (86400 * 7))
            ])->count_all_results('records')
        ];
        $this->load->view('service_provider/dashboard/dashboard', $this->viewdata + $data);
    }

    public function settings()
    {
        $this->load->view('service_provider/settings/settings', $this->viewdata + []);
    }

}
