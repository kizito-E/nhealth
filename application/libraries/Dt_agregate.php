<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dt_agregate {

    private $CI;
    private $table;
    private $list_fields;
    private $columns;
    private $exclude_columns;

    public function __construct()
    {
        $this->CI = & get_instance();
    }


    public function fetch($table, $where = [], $exclude_columns = [])
    {
        $this->table           = $table;
        $this->list_fields     = $this->CI->db->list_fields($this->table);
        $this->columns         = $this->parse_columns();
        $this->exclude_columns = $exclude_columns;

        $this->select();
        $this->where($where);
        $this->limit();
        $this->like();
        $this->order();
        $this->group();
        $result = $this->CI->db->get($table)->result();

        return [
            "error"           => 0,
            "draw"            => $this->CI->input->post('draw'),
            "recordsTotal"    => $this->records_total($where),
            "recordsFiltered" => $this->records_filtered($where),
            "data"            => $this->filter($result)
        ];
    }


    private function parse_columns()
    {
        $out = [];

        foreach ((array) $this->CI->input->post('columns') as $column) {

            if (isset($column['data'])) {

                $arr = explode('|', $column['data']);

                // column name exists
                if (!in_array($arr[0], $this->list_fields)) {
                    continue;
                }

                $out[] = [
                    'name'       => $arr[0],
                    'func'       => isset($arr[1]) && in_array(strtoupper($arr[1]), ['SUM', 'AVG', 'MIN', 'MAX']) //
                    ? strtoupper($arr[1]) //
                    : '',
                    'searchable' => isset($column['searchable']) && $column['searchable'] == 'true' ? true : false
                ];
            }
        }

        return $out;
    }


    private function select()
    {

        if ($this->CI->input->post('group') != "false") {

            foreach ($this->columns as $column) {

                if (in_array($column['name'], $this->exclude_columns)) {
                    continue;
                }

                if ($column['func'] === "SUM") {
                    $this->CI->db->select_sum($column['name'], "{$column['name']}|{$column['func']}");
                } elseif ($column['func'] === "AVG") {
                    $this->CI->db->select_avg($column['name'], "{$column['name']}|{$column['func']}");
                } elseif ($column['func'] === "MAX") {
                    $this->CI->db->select_max($column['name'], "{$column['name']}|{$column['func']}");
                } elseif ($column['func'] === "MIN") {
                    $this->CI->db->select_min($column['name'], "{$column['name']}|{$column['func']}");
                } else {
                    $this->CI->db->select($column['name']);
                }
            }
        }
    }


    private function where($where = [])
    {
        $this->CI->db->where($where);
    }


    private function group()
    {
        $group_columns = $this->CI->input->post('group');

        foreach ((array) $group_columns as $group_column) {

            if (in_array($group_column, $this->list_fields)) {
                $this->CI->db->group_by($group_column);
            }
        }
    }


    private function records_total($where = [])
    {
        $this->select();
        $this->where($where);
        $this->group();
        $this->CI->db->from($this->table);
        return $this->CI->db->count_all_results();
    }


    private function records_filtered($where)
    {
        $this->select();
        $this->where($where);
        $this->group();
        $this->like();
        $this->CI->db->from($this->table);
        return $this->CI->db->count_all_results();
    }


    private function limit()
    {
        $length = $this->CI->input->post('length');
        $start  = $this->CI->input->post('start');

        $this->CI->db->limit($length, $start);
    }


    private function order()
    {
        $index     = $this->CI->input->post('order[0][column]');
        $order_dir = $this->CI->input->post('order[0][dir]');

        $column_name = isset($this->columns[$index]['name']) //
                ? $this->columns[$index]['name']//
                : '';


        if (!empty($this->columns[$index]['func'])) {
            $column_name = $column_name . "|" . $this->columns[$index]['func'];
        }

        if (!in_array($order_dir, ['asc', 'desc'])) {
            $order_dir = 'desc';
        }

        $column_name2 = $this->columns;


        $this->CI->db->order_by($column_name, $order_dir);
    }


    private function like()
    {
        $search_str = $this->CI->input->post('search[value]');
        $iterator   = 0;

        if ($search_str != '') {

            foreach ($this->columns as $column) {

                if ($column['searchable'] === false) {
                    continue;
                }

                if ($iterator == 0) {
                    $this->CI->db->like($column['name'], $search_str);
                } else {
                    $this->CI->db->or_like($column['name'], $search_str);
                }

                $iterator++;
            }
        }
    }


    private function filter($array)
    {
        $search_str = $this->CI->input->post('search[value]');
        $search_str = preg_quote($search_str, '~');

        foreach ($array as &$row_array) {

            if (!preg_grep('~' . $search_str . '~', (array) $row_array)) {
                unset($row_array);
            }
        }

        return $array;
    }


}
