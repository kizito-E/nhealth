<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_advertiser() OR exit_json(1, __('Ошибка доступа!'));
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

        $columns = $this->db->list_fields(config_item('stat_advertisers_table'));

        $result = $this->datatables->fetch(config_item('stat_advertisers_table'), 'id', $columns, $where);

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function camps()
    {
        $where = [
            'user_id' => userdata()->id,
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        $result = $this->dt_agregate->fetch(config_item('stat_camps_table'), $where);

        foreach ($result['data'] as &$value) {

            $camp_obj = $this->Camp2->get(['id' => $value->camp_id]);

            $value->camp_name = isset($camp_obj->name) ? $camp_obj->name : null;
        }

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


    public function ads()
    {
        $where = [
            'user_id' => userdata()->id,
            'date <=' => $this->input->post('end_date'),
            'date >=' => $this->input->post('start_date'),
        ];

        if ($filter_camp_id = $this->input->post('filter_camp_id')) {
            $where['camp_id'] = $filter_camp_id;
        }

        $result = $this->dt_agregate->fetch(config_item('stat_ads_table'), $where);

        foreach ($result['data'] as &$value) {

            $camp_obj = $this->Camp2->get(['id' => $value->camp_id]);
            $ad_obj = $this->Ads2->get(['ad_id' => $value->ad_id]);

            $value->camp_name = isset($camp_obj->name) ? $camp_obj->name : null;
            $value->ad_obj = isset($ad_obj) ? $ad_obj : null;
        }

        exit(json_encode($result, JSON_PRETTY_PRINT));
    }


}
