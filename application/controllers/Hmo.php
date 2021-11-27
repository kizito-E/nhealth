<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hmo extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_hmo() OR redirect('/');

        $this->viewdata = [
            'email' => userdata()->email,
            'name'  => userdata()->business_name
        ];
    }


    public function index()
    {
        redirect("/hmo/dashboard");
    }


    public function dashboard()
    {
        $data = [
            'total_beneficiaries' => $this->db->where(['hmo_id' => userdata()->id])->count_all_results('users'),
            'total_amount' => $this->db->where(['hmo_id' => userdata()->id])->select_sum('amount_due')->get('records')->row()->amount_due,
            'week_service' => $this->db->where([
                'hmo_id' => userdata()->id,
                'date_initiated >=' => gmdate('Y-m-d H:i:s', time() - (86400 * 7))
            ])->count_all_results('records')
        ];
        $this->load->view('hmo/dashboard/dashboard', $this->viewdata + $data);
    }

    public function users()
    {
        $this->load->view('hmo/users/users', $this->viewdata + []);
    }

    public function subscriptions()
    {
        $this->load->view('hmo/subscriptions/subscriptions', $this->viewdata + []);
    }

    public function settings()
    {
        $this->load->view('hmo/settings/settings', $this->viewdata + []);
    }

}
