<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficiary extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_beneficiary() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email,
            'first_name' => userdata()->first_name,
            'last_name' => userdata()->last_name
        ];
    }


    public function index()
    {
        redirect("/beneficiary/dashboard");
    }


    public function dashboard()
    {
        $current_plan = $this->Plan->get(['id' => userdata()->plan_id]);
        $data = [
            'current_plan' => isset($current_plan) ? $current_plan->name : 'N/A',
            'total_amount' => $this->db->where(['user_id' => userdata()->id])->select_sum('amount_due')->get('records')->row()->amount_due,
            'year_visit' => $this->db->where([
                'user_id' => userdata()->id,
                'date_initiated >=' => gmdate('Y-m-d H:i:s', time() - (86400 * 365))
            ])->count_all_results('records')
        ];
        $this->load->view('beneficiary/dashboard/dashboard', $this->viewdata + $data);
    }

    public function transactions()
    {
        $this->load->view('beneficiary/transactions/transactions', $this->viewdata + []);
    }

    public function settings()
    {
        $this->load->view('beneficiary/settings/settings', $this->viewdata + []);
    }

}
