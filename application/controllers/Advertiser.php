<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Advertiser extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_advertiser() OR redirect('/');

        $this->viewdata = [
            'username' => userdata()->username,
            'email'    => userdata()->email,
            'balance'  => number_format(userdata()->advertiser_balance, 2),
        ];
    }


    public function index()
    {
        redirect("/advertiser/dashboard");
    }


    public function dashboard()
    {
        $this->load->view('advertiser/dashboard/dashboard', $this->viewdata + [
                'today_views'        => $this->AdvertiserDashboardStat->today()->views,
                'today_clicks'       => $this->AdvertiserDashboardStat->today()->clicks,
                'today_ctr'          => $this->AdvertiserDashboardStat->today()->ctr,
                'today_costs'        => $this->AdvertiserDashboardStat->today()->costs,
                'views_clicks_chart' => $this->AdvertiserDashboardStat->views_clicks_chart(),
                'ctr_chart'          => $this->AdvertiserDashboardStat->ctr_chart(),
                'costs_chart'        => $this->AdvertiserDashboardStat->costs_chart(),
            ]);
    }


    public function campaigns()
    {
        $this->load->view('advertiser/campaigns/campaigns', $this->viewdata + []);
    }


    public function dsalist($camp_id = null)
    {
        $camp_obj = $this->Camp2->get([
            'id'      => $camp_id,
            'user_id' => userdata()->id
        ]);

        if (!$camp_obj) {
            show_404();
        }

        $this->load->view('advertiser/dsalist/dsalist', $this->viewdata + [
                'camp_name'     => $camp_obj->name,
                'camp_id'       => $camp_obj->id,
                'camp_status'   => $camp_obj->status,
                'camp_isolated' => $camp_obj->isolated,
            ]);
    }


    public function bannerlist($camp_id = null)
    {
        $camp_obj = $this->Camp2->get([
            'id'      => $camp_id,
            'user_id' => userdata()->id
        ]);

        if (!$camp_obj) {
            show_404();
        }

        $this->load->view('advertiser/bannerlist/bannerlist', $this->viewdata + [
                'camp_name'     => $camp_obj->name,
                'camp_id'       => $camp_obj->id,
                'camp_status'   => $camp_obj->status,
                'camp_isolated' => $camp_obj->isolated,
            ]);
    }


    public function statistics($stat_by = null)
    {
        if ($stat_by == 'days') {
            $this->load->view('advertiser/statistics/stat_days', $this->viewdata + []);
        } //
        elseif ($stat_by == 'camps') {
            $this->load->view('advertiser/statistics/stat_camps', $this->viewdata + []);
        } //
        elseif ($stat_by == 'ads') {

            $filter_camp_id = $this->input->get('camp_id');
            $camp_obj = $this->Camp2->get(['id' => $filter_camp_id]);

            $this->load->view('advertiser/statistics/stat_ads', $this->viewdata + [
                    'filter_camp_id' => $filter_camp_id,
                    'camp_name'      => isset($camp_obj->name) ? $camp_obj->name : null
                ]);
        } //
        else {
            redirect('/advertiser/statistics/days');
        }
    }


    public function payments()
    {
        $this->load->view('advertiser/payments/payments', $this->viewdata + [
                "paypal_api_url" => get_globalsettings('paypal_sandbox', 0)
                    ? config_item("paypal_api_url_sandbox")
                    : config_item("paypal_api_url")
            ]);
    }


    public function faq()
    {
        show_404();

        //$this->load->view('advertiser/faq/faq', $this->viewdata + []);
    }


}
