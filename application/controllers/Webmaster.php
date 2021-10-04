<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webmaster extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_webmaster() OR redirect('/');

        $this->viewdata = [
            'username'              => userdata()->username,
            'email'                 => userdata()->email,
            'balance'               => round(userdata()->webmaster_balance, 2),
            'count_unread_messages' => $this->count_unread_messages()
        ];
    }


    public function index()
    {
        redirect("/webmaster/dashboard");
    }


    public function dashboard()
    {
        $this->load->view('webmaster/dashboard/dashboard', $this->viewdata + [
                'today_views'        => $this->WebmasterDashboardStat->today()->views,
                'today_clicks'       => $this->WebmasterDashboardStat->today()->clicks,
                'today_ctr'          => $this->WebmasterDashboardStat->today()->ctr,
                'today_profit'       => $this->WebmasterDashboardStat->today()->profit,
                'views_clicks_chart' => $this->WebmasterDashboardStat->views_clicks_chart(),
                'ctr_chart'          => $this->WebmasterDashboardStat->ctr_chart(),
                'profit_chart'       => $this->WebmasterDashboardStat->profit_chart(),
            ]);
    }


    public function sites()
    {
        $this->load->view('webmaster/sites/sites', $this->viewdata);
    }


    public function units($site_id = null)
    {
        $site_obj = $this->Site2->get([
            'site_id' => $site_id,
            'user_id' => userdata()->id
        ]);

        if (!$site_obj) {
            show_404();
        }

        $this->load->view('webmaster/units/units', $this->viewdata + [
                'site'          => ucfirst(strtolower($site_obj->domain)),
                'site_id'       => $site_obj->site_id,
                'site_isolated' => $site_obj->isolated,
                'config'        => [
                    "min_cpc" => config_item("min_cpc"),
                    "max_cpc" => config_item("max_cpc"),
                    "min_cpv" => config_item("min_cpv"),
                    "max_cpv" => config_item("max_cpv")
                ]
            ]);
    }


    public function statistics($stat_by = null)
    {
        if ($stat_by == 'days') {
            $this->load->view('webmaster/statistics/stat_days', $this->viewdata);
        } //
        elseif ($stat_by == 'sites') {
            $this->load->view('webmaster/statistics/stat_sites', $this->viewdata);
        } //
        elseif ($stat_by == 'units') {

            $filter_site_id = $this->input->get('site_id');
            $site_obj = $this->Site2->get(['site_id' => $filter_site_id]);

            $this->load->view('webmaster/statistics/stat_units', $this->viewdata + [
                    'filter_site_id' => $filter_site_id,
                    'domain'         => isset($site_obj->domain) ? $site_obj->domain : null
                ]);
        } //
        else {
            redirect('/webmaster/statistics/days');
        }
    }


    public function payouts()
    {
        $this->load->view('webmaster/payouts/payouts', $this->viewdata);
    }


    public function support()
    {
        if (is_administrator() === true) {
            show_404();
        }

        $this->load->view('webmaster/support/support', $this->viewdata);
    }


    public function settings()
    {
        $this->load->view('webmaster/settings/settings', $this->viewdata);
    }


    public function faq()
    {
        show_404();

        //$this->load->view('webmaster/faq/faq', $this->wiewdata + []);
    }


    private function count_unread_messages()
    {
        $count = 0;

        foreach ($this->Ticket2->fetch(['user_id' => userdata()->id]) as $ticket_obj) {
            $count += $ticket_obj->count_unread_messages(userdata()->id);
        }

        return $count ? $count : "";
    }


}
