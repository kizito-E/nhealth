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

    public function managers()
    {
        $this->load->view('admin/managers/managers', $this->viewdata + []);
    }

    public function hmo_report($id = null)
    {
        if (!isset($id) || !is_numeric($id)) show_404();

        $date = gmdate('Y-m-d H:i:s', time() - (86400 * 30));
        $total_cost = $this->db->where(['hmo_id' => $id, 'date_initiated >=' => $date, 'status' => 'completed'])->select_sum('cost')->get('records')->row()->cost;
        $amount_due = $this->db->where(['hmo_id' => $id, 'date_initiated >=' => $date, 'status' => 'completed'])->select_sum('amount_due')->get('records')->row()->amount_due;
        $records    = $this->Record->fetch(['hmo_id' => $id, 'date_initiated >=' => $date, 'status' => 'completed']);
        foreach ($records as $record_obj) {
            
            $bf = $this->User->get(['id' => $record_obj->user_id]);
            $record_obj->beneficiary = $bf->first_name . ' ' . $bf->last_name;
            $record_obj->sp = $this->User->get(['id' => $record_obj->sp_id])->business_name;
        }

        $hmo = $this->User->get(['id' => $id]);
        $data = [
            'hmo_id'    => $hmo->id,
            'hmo_name'  => $hmo->business_name,
            'hmo_email' => $hmo->email,
            'records'   => $records,
            'total_cost'    => $total_cost,
            'out_of_pocket' => $total_cost - $amount_due,
            'amount_due'    => $amount_due
        ];

        $this->load->view('admin/managers/report', $this->viewdata + $data);
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
