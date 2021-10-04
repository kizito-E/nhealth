<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer2_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('email');
    }


    public function send($to, $subject = null, $message = null)
    {
        if (is_array($to) && isset($to['to']) && isset($to['subject']) && isset($to['message'])) {
            $this->email->to($to['to']);
            $this->email->subject($to['subject']);
            $this->email->message($to['message']);
        } else {
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
        }

        $this->email->from("mailer@{$this->input->server('HTTP_HOST')}");

        return $this->email->send();
    }


}
