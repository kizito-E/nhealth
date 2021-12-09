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

            $message = "An account has been successfully created for you on nHealth!\n\n";
            $message .= "Login Details:\n";
            $message .= "Email: " . $userdata->email . "\n";
            $message .= "Activation link: " . $userdata->activation_link . "\n";

            $this->CI->Mailer->send([
                'to'      => $userdata->email,
                'subject' => "nHealth - Account activation!",
                'message' => $message
            ]);
        });

        //
        $this->CI->event->on('user.forgot_password', function ($data) {

            $reset_link = base_url("auth/set_password/{$data->reset_token}/");

            $this->CI->Mailer->send([
                'to'      => $data->email,
                'subject' => "nHealth - Password reset",
                'message' => "To change your password, click on the link. {$reset_link}"
            ]);
        });

    }

}
