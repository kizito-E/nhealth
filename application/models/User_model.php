<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = 'users';
        $this->primary_key  = 'id';
        $this->result_class = null;  //'results/user_result'
    }


    public function set_role($user_id, $role)
    {
        $where = [
            'id' => $user_id
        ];

        $update = [
            'role' => $role
        ];

        $this->update($where, $update);
    }


    public function set_password($user_id, $new_password)
    {
        $where = [
            'id' => $user_id
        ];

        $update = [
            'password' => superhash($new_password)
        ];

        $this->update($where, $update);
    }


    public function generate_reset_password_token($where)
    {
        $reset_token = random_hash();

        $this->db->where($where);
        $this->db->set('reset_pass_token', $reset_token);
        $this->db->update($this->table);

        if ($this->db->affected_rows()) {
            return $reset_token;
        }

        return false;
    }


    public function credit_user_balance($user_id, $amount)
    {
        $amount = round($amount, 5);

        $this->db->where("id", $user_id);
        $this->db->set("advertiser_balance", "advertiser_balance + {$amount}", false);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }


    public function debit_user_balance($user_id, $amount)
    {
        $amount = round($amount, 5);

        $this->db->where("id", $user_id);
        $this->db->set("advertiser_balance", "advertiser_balance - {$amount}", false);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

}