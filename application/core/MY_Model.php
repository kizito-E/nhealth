<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table        = null;
    protected $primary_key  = null;
    protected $status_key   = 'status';
    protected $result_class = null;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('datatables');
    }


    public function add($params)
    {
        if ($this->db->insert($this->table, $params)) {

            return $this->get([
                        $this->primary_key => $this->db->insert_id()
            ]);
        }

        return false;
    }


    public function update($where, $params)
    {
        if ($this->db->update($this->table, $params, $where)) {
            return $this->get($where);
        }

        return false;
    }


    public function count($where = [], $empty_zero = false)
    {
        $this->db->where($where);
        $this->db->from($this->table);
        $count = $this->db->count_all_results();

        if ($empty_zero) {
            return $count ? $count : "";
        }

        return $count;
    }


    public function exists($where = [])
    {
        return (bool) $this->count($where);
    }


    public function get($where = [])
    {
        $this->db->where($where);

        if ($this->result_class) {
            $this->load->model($this->result_class);
            $result_class_name = $this->parse_result_class_name($this->result_class);
            return $this->db->get($this->table)->custom_row_object(0, $result_class_name);
        }

        return $this->db->get($this->table)->row();
    }


    public function search($q, $columns = [], $limit = 10)
    {
        foreach ($columns as $column) {
            $this->db->or_like($column, $q);
        }

        $this->db->limit($limit);

        if ($this->result_class) {
            $this->load->model($this->result_class);
            $result_class_name = $this->parse_result_class_name($this->result_class);
            return $this->db->get($this->table)->custom_result_object($result_class_name);
        }

        return $this->db->get($this->table)->result();
    }


    public function get_random($where = [])
    {
        $this->db->where($where);
        $this->db->order_by($this->primary_key, 'random');

        if ($this->result_class) {
            $this->load->model($this->result_class);
            $result_class_name = $this->parse_result_class_name($this->result_class);
            return $this->db->get($this->table)->custom_row_object(0, $result_class_name);
        }

        return $this->db->get($this->table)->row();
    }


    public function fetch($where = [])
    {
        $this->db->where($where);

        if ($this->result_class) {
            $this->load->model($this->result_class);
            $result_class_name = $this->parse_result_class_name($this->result_class);
            return $this->db->get($this->table)->custom_result_object($result_class_name);
        }

        return $this->db->get($this->table)->result();
    }


    public function fetch_where_in($column = null, $where_in = [], $where = [])
    {
        if ($column && $where_in) {
            $this->db->where_in($column, $where_in);
        }

        $this->db->where($where);

        if ($this->result_class) {
            $this->load->model($this->result_class);
            $result_class_name = $this->parse_result_class_name($this->result_class);
            return $this->db->get($this->table)->custom_result_object($result_class_name);
        }

        return $this->db->get($this->table)->result();
    }


    public function fetch_dt($where = [])
    {
        $columns = $this->db->list_fields($this->table);
        return $this->datatables->fetch($this->table, $this->primary_key, $columns, $where);
    }


    public function delete($ids, $where = [])
    {
        $this->db->where_in($this->primary_key, (array) $ids);
        $this->db->where($where);
        $this->db->delete($this->table);

        return (bool) $this->db->affected_rows();
    }


    public function play($ids, $where = [])
    {
        $this->db->where($where);
        $this->db->where_in($this->primary_key, (array) $ids);

        return (bool) $this->db->update($this->table, [$this->status_key => 1]);
    }


    public function stop($ids, $where = [])
    {
        $this->db->where($where);
        $this->db->where_in($this->primary_key, (array) $ids);

        return (bool) $this->db->update($this->table, [$this->status_key => 0]);
    }


    private function parse_result_class_name($result_class)
    {
        return ltrim(stristr($result_class, "/"), '/') ? ltrim(stristr($result_class, "/"), '/') : $result_class;
    }


}
