<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings2_model extends CI_Model {

    private $table;
    private $user_id;
    private $options;

    public function __construct()
    {
        parent::__construct();

        $this->table = config_item('settings_table');
    }


    public function user($user_id = -1)
    {
        if ($this->user_id == $user_id) {
            return $this;
        }

        $this->user_id = $user_id;
        $this->options = $this->_get_all_user_settings();

        return $this;
    }


    public function system()
    {
        return $this->user('0');
    }


    public function get($key, $default = null)
    {
        return isset($this->options->{$key}) ? $this->options->{$key} : $default;
    }


    public function all()
    {
        return $this->options;
    }


    public function set($key, $value)
    {
        if ($this->exists($key)) {

            $this->db->where([
                'user_id'    => $this->user_id,
                'option_key' => $key,
            ]);

            $this->db->update($this->table, [
                'option_value' => serialize($value),
            ]);
        } else {

            $this->db->insert($this->table, [
                'user_id'      => $this->user_id,
                'option_key'   => $key,
                'option_value' => serialize($value),
            ]);
        }

        $this->options = $this->_get_all_user_settings();
    }


    public function delete($key)
    {
        $this->db->where([
            'user_id'    => $this->user_id,
            'option_key' => $key,
        ]);

        $this->db->delete($this->table);

        $this->options = $this->_get_all_user_settings();
    }


    public function delete_all()
    {
        $this->db->where([
            'user_id' => $this->user_id
        ]);

        $this->db->delete($this->table);

        $this->options = null;
    }


    public function exists($key)
    {
        return isset($this->options->{$key});
    }


    private function _get_all_user_settings()
    {
        $out = [];

        $this->db->where('user_id', $this->user_id);

        foreach ($this->db->get($this->table)->result() as $row) {
            $out[$row->option_key] = @unserialize($row->option_value);
        }

        return (object) $out;
    }


}
