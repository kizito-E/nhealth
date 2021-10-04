<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        is_moderator() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function fetch()
    {
        // модератор не должен видеть обьявления админа
        $where = [
            "user_id !=" => admindata()->id
        ];

        if ($this->input->post('filter_user_id')) {
            $where['user_id'] = $this->input->post('filter_user_id');
        }

        $ads = $this->Ads2->fetch_dt($where);

        foreach ($ads['data'] as &$ad) {

            $camp_obj = $this->Camp2->get([
                'id' => $ad['camp_id']
            ]);

            $user_obj = $this->User2->get([
                'id' => $ad['user_id']
            ]);

            $ad['img_url']    = $ad['filename'] ? image($ad['filename'])->url : "";
            $ad['username']   = isset($user_obj->username) ? $user_obj->username : '';
            $ad['email']      = isset($user_obj->email) ? $user_obj->email : '';
            $ad['camp_name']  = isset($camp_obj->name) ? $camp_obj->name : '';
            $ad['camp_theme'] = isset($camp_obj->theme) ? $camp_obj->theme : '';
        }

        exit(json_encode(array_merge(['error' => 0], $ads), JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $ad_obj = $this->Ads2->get([
            'ad_id' => $this->input->post_get('ad_id')
        ]);

        if (isset($ad_obj->filename)) {

            $ad_obj->img_url    = $ad_obj->filename ? image($ad_obj->filename)->url : "";
            $ad_obj->camp_theme = $ad_obj->camp()->theme;

            exit_json(0, '', $ad_obj);
        }

        exit_json(1, __("Обьявление не существует!"));
    }


    public function get_unmoderate_ad()
    {
        $ad_obj = $this->Ads2->get_random([
            'ad_id !=' => $this->input->post_get('ad_id'),
            'status'   => -1,
        ]);

        if (isset($ad_obj->filename)) {

            $ad_obj->img_url    = image($ad_obj->filename)->url;
            $ad_obj->camp_theme = $ad_obj->camp()->theme;

            exit_json(0, '', $ad_obj);
        }

        exit_json(1, __("Нет обьявлений для модерации!"));
    }


    public function play()
    {
        if (!$this->Ads2->play($this->input->post_get('ad_id'))) {
            exit_json(1, __('Не удалось изменить статус обьявления!'));
        }

        exit_json(0, __('Обьявление запущено.'));
    }


    public function stop()
    {
        if (!$this->Ads2->stop($this->input->post_get('ad_id'))) {
            exit_json(1, __('Не удалось изменить статус обьявления!'));
        }

        exit_json(0, __('Обьявление остановлено.'));
    }


    public function ban()
    {
        if (!$this->Ads2->update([
                    'ad_id' => $this->input->post('ad_id')
                        ], [
                    'status'         => -2,
                    'status_message' => $this->input->post('status_message'),
                ])) {

            exit_json(1, __('Не удалось изменить статус обьявления!'));
        }

        exit_json(0, __('Обьявление забанено.'));
    }


    public function unban()
    {
        if (!$this->Ads2->update([
                    'ad_id' => $this->input->post('ad_id')
                        ], [
                    'status'         => 1,
                    'status_message' => "",
                ])) {

            exit_json(1, __('Не удалось изменить статус обьявления!'));
        }

        exit_json(0, __('Обьявление разбанено.'));
    }


    public function moderate()
    {
        $this->validation->make([
            'ad_id'  => "required|is_exists[ads.ad_id]",
            'status' => "required|in_list[-2,-1,0,1]",
                ], [
            'ad_id.*'  => __('Обьявление с таким ID не существует!'),
            'status.*' => __('Некорректный статус обьявления!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        if (!$this->Ads2->update([
                    'ad_id' => $this->input->post('ad_id')
                        ], [
                    'status'         => $this->input->post('status'),
                    'status_message' => $this->input->post('status_message'),
                ])) {

            exit_json(1, __('Не удалось изменить статус обьявления!'));
        }

        exit_json(0, __('Готово!'));
    }


}
