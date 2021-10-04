<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

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


    public function fetch()
    {
        $sites = $this->Site2->fetch_dt([
            'user_id' => userdata()->id
        ]);

        foreach ($sites['data'] as &$site) {
            $site['count_units'] = $this->Unit2->count([
                'site_id' => $site['site_id']
            ]);
        }

        exit(json_encode(array_merge(['error' => 0], $sites), JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $site_obj = $this->Site2->get([
            'user_id' => userdata()->id,
            'site_id' => $this->input->post_get('site_id')
        ]);

        exit_json(0, '', $site_obj);
    }


    public function add()
    {
        $themes_list = implode(",", config_item('themes'));

        $this->validation->make([
            'isolated'              => "required|in_list[0,1]",
            'theme'                 => "required|in_list[{$themes_list}]",
            'allowed_camp_themes[]' => "required|in_list[{$themes_list}]",
            'domain'                => "required|is_unique[sites.domain]|is_valid_domain",
            'stat_url'              => "prep_url|valid_url"
                ], [
            'isolated.*'                     => __('Некорректный тип сайта!'),
            'theme.required'                 => __('Укажите тематику сайта!'),
            'theme.in_list'                  => __('Некорректная тематика сайта!'),
            'allowed_camp_themes[].required' => __('Укажите доступные к показу тематики обьявлений!'),
            'allowed_camp_themes[].in_list'  => __('Некорректные тематики обьявлений!'),
            'domain.required'                => __('Укажите сайт!'),
            'domain.is_valid_domain'         => __('Некорректный домен!'),
            'domain.is_unique'               => __('Такой сайт уже добавлен в систему!'),
            'stat_url.required'              => __('Укажите URL статистики сайта!'),
            'stat_url.valid_url'             => __('Некорректный URL статистики сайта!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $site_params = [
            'user_id'             => userdata()->id,
            'theme'               => $this->input->post('theme'),
            'allowed_camp_themes' => $this->prep_allowed_camp_themes($this->input->post('theme'), $this->input->post('allowed_camp_themes')),
            'isolated'            => is_administrator() ? $this->input->post('isolated') : 0,
            'status'              => is_administrator() ? 1 : -1,
            'domain'              => $this->input->post('domain'),
            'stat_url'            => $this->input->post('stat_url'),
            'stat_login'          => $this->input->post('stat_login'),
            'stat_password'       => $this->input->post('stat_password'),
            'created_at'          => gmdate('Y-m-d H:i:s'),
        ];

        if ($site_obj = $this->Site2->add($site_params)) {

            event('webmaster.add_site');

            exit_json(0, __('Сайт успешно добавлен!'));
        }

        exit_json(1, __('При добавлении сайта возникла ошибка!'));
    }


    public function update()
    {
        $themes_list = implode(",", config_item('themes'));

        $this->validation->make([
            'isolated'              => "required|in_list[0,1]",
            'site_id'               => "required|is_exists[sites.site_id]|callback__is_user_site",
            'theme'                 => "required|in_list[{$themes_list}]",
            'allowed_camp_themes[]' => "required|in_list[{$themes_list}]",
            'stat_url'              => "required|prep_url|valid_url"
                ], [
            'isolated.*'                     => __('Некорректный тип сайта!'),
            'site_id.*'                      => __('Некорректный ID сайта!'),
            'theme.required'                 => __('Укажите тематику сайта!'),
            'theme.in_list'                  => __('Некорректная тематика сайта!'),
            'allowed_camp_themes[].required' => __('Укажите доступные к показу тематики обьявлений!'),
            'allowed_camp_themes[].in_list'  => __('Некорректные тематики обьявлений!'),
            'stat_url.required'              => __('Укажите URL статистики сайта!'),
            'stat_url.valid_url'             => __('Некорректный URL статистики сайта!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'user_id' => userdata()->id,
            'site_id' => $this->input->post('site_id'),
        ];

        $update = [
            'isolated'            => is_administrator() ? $this->input->post('isolated') : 0,
            'theme'               => $this->input->post('theme'),
            'allowed_camp_themes' => $this->prep_allowed_camp_themes($this->input->post('theme'), $this->input->post('allowed_camp_themes')),
            'stat_url'            => $this->input->post('stat_url'),
            'stat_login'          => $this->input->post('stat_login'),
            'stat_password'       => $this->input->post('stat_password'),
            'updated_at'          => gmdate('Y-m-d H:i:s'),
        ];

        // если изменилась тематика сайта - повторная модерация
        if (is_administrator() === false && $this->input->post('theme') != $this->db->get_where(config_item('sites_table'), $where)->row('theme')) {
            $update['status'] = -1;
        }

        if ($site_obj = $this->Site2->update($where, $update)) {

            event('site.update', $site_obj);

            exit_json(0, __('Настройки успешно сохранены!'));
        }

        exit_json(1, __('Ошибка редактирования сайта!'));
    }


    public function play()
    {
        $site_id = $this->input->post_get('site_id');

        $where = [
            'user_id'   => userdata()->id,
            'status >=' => 0
        ];

        if ($this->Site2->play($site_id, $where)) {
            exit_json(0, __('Сайт успешно запущен.'));
        }

        exit_json(1, __('Не удалось изменить статус сайта!'));
    }


    public function stop()
    {
        $site_id = $this->input->post_get('site_id');

        $where = [
            'user_id'   => userdata()->id,
            'status >=' => 0
        ];

        if ($this->Site2->stop($site_id, $where)) {
            exit_json(0, __('Сайт успешно остановлен.'));
        }

        exit_json(1, __('Не удалось изменить статус сайта!'));
    }


    public function delete()
    {
        $site_id = $this->input->post_get('site_id');

        $where = [
            'user_id' => userdata()->id
        ];

        if ($this->Site2->delete($site_id, $where)) {
            exit_json(0, __('Сайт успешно удален.'));
        }

        exit_json(1, __('Не удалось удалить сайт!'));
    }


    private function prep_allowed_camp_themes($site_theme, $allowed_camp_themes)
    {
        // тематика сайта в любом случае должна присутствовать в разрешенных к показу тематиках обьявлений
        $array = array_unique(array_merge((array) $site_theme, $allowed_camp_themes));

        return implode(',', $array);
    }


    public function _is_user_site($site_id)
    {
        return $this->Site2->exists([
                    'site_id' => $site_id,
                    'user_id' => userdata()->id
        ]);
    }


}
