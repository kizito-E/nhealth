<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_administrator() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email,
            'name'  => userdata()->business_name
        ];
    }


    public function index()
    {
        redirect("/administrator/dashboard");
    }


    public function dashboard()
    {
        $data = [
            'total_beneficiaries' => $this->db->count_all_results('users'),
            'total_amount' => $this->db->select_sum('amount_due')->get('records')->row()->amount_due,
            'week_service' => $this->db->where([
                'date_initiated >=' => gmdate('Y-m-d H:i:s', time() - (86400 * 7))
            ])->count_all_results('records')
        ];
        $this->load->view('admin/dashboard/dashboard', $this->viewdata + $data);
    }

    public function users()
    {
        $this->load->view('admin/users/users', $this->viewdata + []);
    }

    public function subscriptions()
    {
        $this->load->view('admin/subscriptions/subscriptions', $this->viewdata + []);
    }

    public function settings()
    {
        $this->load->view('admin/settings/settings', $this->viewdata + []);
    }

}
