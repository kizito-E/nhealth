<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event_handlers
{

    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('mailer2_model', 'Mailer');
        $this->CI->load->model('user_model', 'User');
    }


    public function handle()
    {
        //
        $this->CI->event->on('user.register', function ($userdata) {

            $message = "You have successfully registered in the system - nHealth!\n\n";
            $message .= "Login Details:\n";
            $message .= "URL: " . config_item('base_url') . "\n";
            $message .= "Email: " . $userdata->email . "\n";
            $message .= "Password: " . $userdata->plain_password . "\n";

            $this->CI->Mailer->send([
                'to'      => $userdata->email,
                'subject' => "nHealth - successful registration!",
                'message' => $message
            ]);
        });

        //
        $this->CI->event->on('user.forgot_password', function ($data) {

            $reset_link = base_url("auth/reset_password/{$data->reset_token}/");

            $this->CI->Mailer->send([
                'to'      => $data->email,
                'subject' => "nHealth - Password Reset!",
                'message' => "To change your password, click on the link. {$reset_link}"
            ]);
        });

        //
        $this->CI->event->on('user.reset_password', function ($data) {

            $this->CI->Mailer->send([
                'to'      => $data->email,
                'subject' => "nHealth - Password successfully changed!",
                'message' => "New password: {$data->plain_password}"
            ]);
        });


        //
        $this->CI->event->on('payment.add', function ($payment_obj) {
            $user_obj = $this->CI->User->get([
                'id' => $payment_obj->user_id
            ]);

            $this->CI->Mailer->send([
                'to'      => $user_obj->email,
                'subject' => "nHealth - Advertiser balance replenishment.",
                'message' => $payment_obj->description
            ]);
        });

    }

}
