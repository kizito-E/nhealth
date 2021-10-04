<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_webmaster() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function days()
    {
        $where = [
            'user_id' => userdata()->id
        ];

        $columns = $this->db->list_fields(config_item('stat_webmasters_table'));
        $result = $this->datatables->fetch(config_item('stat_webmasters_table'), 'id', $columns, $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function sites()
    {
        $where = [
            'user_id' => userdata()->id,
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        $result = $this->dt_agregate->fetch(config_item('stat_sites_table'), $where);

        foreach ($result['data'] as &$value) {

            $site_obj = $this->Site2->get(['site_id' => $value->site_id]);
            $value->domain = isset($site_obj->domain) ? $site_obj->domain : null;
        }

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function units()
    {
        $where = [
            'user_id' => userdata()->id,
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_site_id = $this->input->post('filter_site_id')) {
            $where['site_id'] = $filter_site_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_adunits_table'), $where);

        foreach ($result['data'] as &$value) {

            $site_obj = $this->Site2->get(['site_id' => $value->site_id]);
            $unit_obj = $this->Unit2->get(['unit_id' => $value->unit_id]);

            $value->domain = isset($site_obj->domain) ? $site_obj->domain : null;
            $value->unit_obj = isset($unit_obj) ? $unit_obj : null;
        }

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


}
