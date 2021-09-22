<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User2_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table        = config_item('users_table');
        $this->primary_key  = 'id';
        $this->result_class = 'results/user_result';
    }


    public function set_subrole($user_id, $subrole)
    {
        $where = [
            'id' => $user_id
        ];

        $update = [
            'subrole' => $subrole
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


    public function up_advertiser_balance($user_id, $amount)
    {
        $amount = round($amount, 5);

        $this->db->where("id", $user_id);
        $this->db->set("advertiser_balance", "advertiser_balance + {$amount}", false);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }


    public function down_advertiser_balance($user_id, $amount)
    {
        $amount = round($amount, 5);

        $this->db->where("id", $user_id);
        $this->db->set("advertiser_balance", "advertiser_balance - {$amount}", false);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }


    public function up_webmaster_balance($user_id, $amount)
    {
        $amount = round($amount, 5);

        $this->db->where("id", $user_id);
        $this->db->set("webmaster_balance", "webmaster_balance + {$amount}", false);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }


    public function down_webmaster_balance($user_id, $amount)
    {
        $amount = round($amount, 5);

        $this->db->where("id", $user_id);
        $this->db->set("webmaster_balance", "webmaster_balance - {$amount}", false);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }


    public function transfer_balance($user_id, $amount)
    {
//        $balances = $this->get_user_balances($user_id);
//        $amount   = floatval($amount);
//
//        // проверить есть ли достаточная сумма
//        if ($balances->webmaster < $amount) {
//            throw new Exception(__('На балансе вебмастера недостаточно денег!'));
//        }
//
//        // снять с вебмастера
//        $this->change_webmaster_balance($user_id, $amount, 'TRANSFER', null, __('Списание средств с аккаунта вебмастера.'));
//        // пополнить рекла
//        $this->change_advertiser_balance($user_id, $amount, 'TRANSFER', null, __('Зачисление средств на аккаунт рекламодателя.'));
    }


    public function ban($user, $message = '')
    {
        $this->db->where('id', $user);
        $this->db->or_where('username', $user);
        $this->db->or_where('email', $user);
        $this->db->set('status', '0');
        $this->db->set('status_message', $message);

        return $this->db->update($this->table);
    }


    public function unban($user)
    {
        $this->db->where('id', $user);
        $this->db->or_where('username', $user);
        $this->db->or_where('email', $user);
        $this->db->set('status', 1);
        $this->db->set('status_message', '');

        return $this->db->update($this->table);
    }


}
