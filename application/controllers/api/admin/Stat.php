<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_administrator() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }

    public function index()
    {
        exit;
    }


    public function days()
    {
        $columns = $this->db->list_fields(config_item('stat_advertisers_table'));
        $result = $this->datatables->fetch(config_item('stat_advertisers_table'), 'id', $columns, []);
        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function webmasters()
    {
        $where = [
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_user_id = $this->input->post('filter_user_id')) {
            $where['user_id'] = $filter_user_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_webmasters_table'), $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function sites()
    {
        $where = [
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_user_id = $this->input->post('filter_user_id')) {
            $where['user_id'] = $filter_user_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_sites_table'), $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function units()
    {
        $where = [
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_user_id = $this->input->post('filter_user_id')) {
            $where['user_id'] = $filter_user_id;
        }

        if ($filter_site_id = $this->input->post('filter_site_id')) {
            $where['site_id'] = $filter_site_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_adunits_table'), $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function advertisers()
    {
        $where = [
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_user_id = $this->input->post('filter_user_id')) {
            $where['user_id'] = $filter_user_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_advertisers_table'), $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function camps()
    {
        $where = [
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_user_id = $this->input->post('filter_user_id')) {
            $where['user_id'] = $filter_user_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_camps_table'), $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function ads()
    {
        $where = [
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_user_id = $this->input->post('filter_user_id')) {
            $where['user_id'] = $filter_user_id;
        }

        if ($filter_camp_id = $this->input->post('filter_camp_id')) {
            $where['camp_id'] = $filter_camp_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_ads_table'), $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


}
