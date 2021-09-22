<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event_handlers
{

    private $CI;
    private $customName;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('mailer2_model', 'Mailer2');
        $this->CI->load->model('user2_model', 'User2');

        $this->customName = get_globalsettings("custom_name", "AdFlex");
    }


    public function handle()
    {
        //
        $this->CI->event->on('user.register', function ($userdata) {

            $message = "You have successfully registered in the system - {$this->customName}!\n\n";
            $message .= "Login Details:\n";
            $message .= "URL: " . config_item('base_url') . "\n";
            $message .= "Email: " . $userdata->email . "\n";
            $message .= "Password: " . $userdata->plain_password . "\n";

            $this->CI->Mailer2->send([
                'to'      => $userdata->email,
                'subject' => "{$this->customName} - successful registration!",
                'message' => $message
            ]);
        });

        //
        $this->CI->event->on('user.forgot_password', function ($data) {

            $reset_link = base_url("auth/reset_password/{$data->reset_token}/");

            $this->CI->Mailer2->send([
                'to'      => $data->email,
                'subject' => "{$this->customName} - Password Reset!",
                'message' => "To change your password, click on the link. {$reset_link}"
            ]);
        });

        //
        $this->CI->event->on('user.reset_password', function ($data) {

            $this->CI->Mailer2->send([
                'to'      => $data->email,
                'subject' => "{$this->customName} - Password successfully changed!",
                'message' => "New password: {$data->plain_password}"
            ]);
        });


        //
        $this->CI->event->on('payment.add', function ($payment_obj) {
            $user_obj = $this->CI->User2->get([
                'id' => $payment_obj->user_id
            ]);

            $this->CI->Mailer2->send([
                'to'      => $user_obj->email,
                'subject' => "{$this->customName} - Advertiser balance replenishment.",
                'message' => $payment_obj->description
            ]);
        });


        //
        $this->CI->event->on('payment.change_webmaster_balance', function ($payment_obj) {
            $user_obj = $this->CI->User2->get([
                'id' => $payment_obj->user_id
            ]);

            $this->CI->Mailer2->send([
                'to'      => $user_obj->email,
                'subject' => "{$this->customName} - Balance change.",
                'message' => $payment_obj->description
            ]);
        });

        //
        $this->CI->event->on('payment.change_advertiser_balance', function ($payment_obj) {
            $user_obj = $this->CI->User2->get([
                'id' => $payment_obj->user_id
            ]);

            $this->CI->Mailer2->send([
                'to'      => $user_obj->email,
                'subject' => "{$this->customName} - Balance change.",
                'message' => $payment_obj->description
            ]);
        });

        //
        $this->CI->event->on('ads.moderate', function ($obj) {

            $ad_status = $obj->status == 1 ? "Approved" : "Rejected";

            $this->CI->Mailer2->send([
                'to'      => $obj->email,
                'subject' => "{$this->customName} - Ad {$ad_status}",
                'message' => "Ad '{$obj->ad_id}' status changed to '{$ad_status}'"
            ]);
        });


        //
        $this->CI->event->on('advertiser.add_banner', function () {
            $this->CI->Mailer2->send([
                'to'      => admindata()->email,
                'subject' => "{$this->customName} - Added new banner.",
                'message' => "Added new banner. Moderation needed."
            ]);
        });

        //
        $this->CI->event->on('webmaster.add_site', function () {
            $this->CI->Mailer2->send([
                'to'      => admindata()->email,
                'subject' => "{$this->customName} - Added new site.",
                'message' => "Added new site. Moderation needed."
            ]);
        });

        //
        $this->CI->event->on('site.moderate', function ($obj) {

            $site_status = $obj->status == 1 ? "Approved" : "Rejected";

            $this->CI->Mailer2->send([
                'to'      => $obj->email,
                'subject' => "{$this->customName} - Site {$site_status}",
                'message' => "Site '{$obj->domain}' status changed to '{$site_status}'"
            ]);
        });


    }


    /*
     *
     * auth.login
     * auth.logout
     *
     * camp.create
     * camp.update
     * camp.delete
     * camp.play
     * camp.stop
     *
     *
     *
     * bannerunits.create
     * bannerunits.update
     * bannerunits.delete
     * bannerunits.play
     * bannerunits.stop
     *
     *
     * ads.add_ad
     * ads.update_ad
     * ads.add_banner
     * ads.update_banner
     * ads.moderate
     * ads.play
     * ads.stop
     * ads.ban
     * ads.unban
     *
     *
     *
     * adunit.create
     * adunit.update
     * adunit.delete
     * adunit.play
     * adunit.stop
     *
     *
     * user.register
     */
}
