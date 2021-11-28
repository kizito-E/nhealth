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

    public function providers()
    {
        $this->load->view('hmo/providers/providers', $this->viewdata + []);
    }

    public function sp_report($id = null)
    {
        if (!isset($id) || !is_numeric($id)) show_404();

        $date = gmdate('Y-m-d H:i:s', time() - (86400 * 30));
        $total_cost = $this->db->where(['hmo_id' => userdata()->id, 'sp_id' => $id, 'date_initiated >=' => $date, 'status' => 'completed'])->select_sum('cost')->get('records')->row()->cost;
        $amount_due = $this->db->where(['hmo_id' => userdata()->id, 'sp_id' => $id, 'date_initiated >=' => $date, 'status' => 'completed'])->select_sum('amount_due')->get('records')->row()->amount_due;
        $records    = $this->Record->fetch(['hmo_id' => userdata()->id, 'sp_id' => $id, 'date_initiated >=' => $date, 'status' => 'completed']);
        foreach ($records as $record_obj) {
            
            $bf = $this->User->get(['id' => $record_obj->user_id]);
            $record_obj->beneficiary = $bf->first_name . ' ' . $bf->last_name;
        }

        $sp = $this->User->get(['id' => $id]);
        $data = [
            'sp_id'    => $sp->id,
            'sp_name'  => $sp->business_name,
            'sp_email' => $sp->email,
            'records'   => $records,
            'total_cost'    => $total_cost,
            'out_of_pocket' => $total_cost - $amount_due,
            'amount_due'    => $amount_due
        ];

        $this->load->view('hmo/providers/report', $this->viewdata + $data);
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
