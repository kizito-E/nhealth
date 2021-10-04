<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_administrator() OR redirect('/');

        $this->viewdata = [
            'username'               => userdata()->username,
            'email'                  => userdata()->email,
            'count_unread_messages'  => $this->Message2->count(['read_at' => null, 'user_id !=' => userdata()->id], true),
            'count_sites_moderation' => $this->Site2->count(['status' => -1], true),
            'count_ads_moderation'   => $this->Ads2->count(['status' => -1], true),
            'count_payouts'          => $this->Payout2->count(['status' => 'new'], true),
            //
            'count_users'            => $this->User2->count(),
            'count_sites'            => $this->Site2->count(),
            'count_camps'            => $this->Camp2->count(),
            'count_ads'              => $this->Ads2->count(),
            //
            'today_views'            => (int) $this->db->select_sum('views')->where('date', gmdate('Y-m-d'))->get(config_item('stat_advertisers_table'))->row('views'),
            'today_clicks'           => (int) $this->db->select_sum('clicks')->where('date', gmdate('Y-m-d'))->get(config_item('stat_advertisers_table'))->row('clicks'),
            'today_ctr'              => $this->db->select_avg('ctr')->where('date', gmdate('Y-m-d'))->get(config_item('stat_advertisers_table'))->row('ctr'),
            'today_sites'            => $this->Site2->count(['created_at >' => gmdate('Y-m-d H:i:s', time() - 86400)]),
            'today_camps'            => $this->Camp2->count(['created_at >' => gmdate('Y-m-d H:i:s', time() - 86400)]),
            'today_ads'              => $this->Ads2->count(['created_at >' => gmdate('Y-m-d H:i:s', time() - 86400)]),
            //
            'payments_chart'         => $this->AdminDashboardStat->payments_chart(),
            'payouts_chart'          => $this->AdminDashboardStat->payouts_chart(),
            'views_chart'            => $this->AdminDashboardStat->views_chart(),
            'clicks_chart'           => $this->AdminDashboardStat->clicks_chart(),
            'ctr_chart'              => $this->AdminDashboardStat->ctr_chart(),
        ];
    }


    public function index()
    {
        redirect("/administrator/dashboard");
    }


    public function dashboard()
    {
        $this->load->view('admin/dashboard/dashboard', $this->viewdata + []);
    }


    public function users()
    {
        $this->load->view('admin/users/users', $this->viewdata + []);
    }


    public function sites()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('admin/sites/sites', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function campaigns()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('admin/campaigns/campaigns', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function ads()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('admin/ads/ads', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function statistics($stat_by = null)
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        if ($stat_by == 'days' || $stat_by == null) {
            $this->load->view('admin/statistics/statistics', $this->viewdata + []);
        } //
        elseif ($stat_by == 'webmasters') {

            $this->load->view('admin/statistics/webmasters', $this->viewdata + [
                    "filter_user_id" => absint($this->input->get('user_id')),
                ]);
        } //
        elseif ($stat_by == 'sites') {

            $this->load->view('admin/statistics/sites', $this->viewdata + [
                    "filter_user_id" => absint($this->input->get('user_id')),
                ]);
        } //
        elseif ($stat_by == 'units') {

            $this->load->view('admin/statistics/units', $this->viewdata + [
                    "filter_user_id" => absint($this->input->get('user_id')),
                    "filter_site_id" => absint($this->input->get('site_id')),
                ]);
        } //
        elseif ($stat_by == 'advertisers') {

            $this->load->view('admin/statistics/advertisers', $this->viewdata + [
                    "filter_user_id" => absint($this->input->get('user_id')),
                ]);
        } //
        elseif ($stat_by == 'camps') {

            $this->load->view('admin/statistics/camps', $this->viewdata + [
                    "filter_user_id" => absint($this->input->get('user_id')),
                ]);
        } //
        elseif ($stat_by == 'ads') {

            $this->load->view('admin/statistics/ads', $this->viewdata + [
                    "filter_user_id" => absint($this->input->get('user_id')),
                    "filter_camp_id" => absint($this->input->get('camp_id')),
                ]);
        }
    }


    public function payments()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('admin/payments/payments', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function payouts()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('admin/payouts/payouts', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function support()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('admin/support/support', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function settings()
    {
        $this->load->view('admin/settings/settings', $this->viewdata + []);
    }


    public function eventlog()
    {
        show_404();
        //$this->load->view('admin/eventlog/eventlog', $this->viewdata + []);
    }


    public function faq()
    {
        $this->load->view('admin/faq/faq', $this->viewdata + []);
    }


}
