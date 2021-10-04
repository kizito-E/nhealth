<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Moderator extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_moderator() OR redirect('/');

        $this->viewdata = [
            'username'               => userdata()->username,
            'email'                  => userdata()->email,
            'count_sites_moderation' => $this->Site2->count(['status' => -1], true),
            'count_ads_moderation'   => $this->Ads2->count(['status' => -1], true),
            'count_payouts'          => $this->Payout2->count(['status' => 'processing'], true),
            'count_unread_messages'  => $this->Message2->count([
                'read_at'    => null,
                'user_id !=' => userdata()->id
            ], true),
        ];


    }


    public function index()
    {
        redirect("/moderator/sites");
    }


    public function sites()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('moderator/sites/sites', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function campaigns()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('moderator/campaigns/campaigns', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function ads()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('moderator/ads/ads', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function support()
    {
        $userdata = $this->User2->get([
            'id' => $this->input->get('user_id')
        ]);

        $this->load->view('moderator/support/support', $this->viewdata + [
                'filter_username' => isset($userdata->username) ? $userdata->username : null,
                'filter_user_id'  => isset($userdata->id) ? $userdata->id : null,
            ]);
    }


    public function settings()
    {
        $this->load->view('moderator/settings/settings', $this->viewdata + []);
    }


    public function faq()
    {
        show_404();
        // $this->load->view('moderator/faq/faq', $this->viewdata + []);
    }


}
