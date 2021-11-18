<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller
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


    public function fetch()
    {
        // собственные сайты администратора, не отображаются в меню всех сайтов
        $where = [
            "user_id !=" => admindata()->id
        ];

        if ($this->input->post('filter_user_id')) {
            $where['user_id'] = $this->input->post_get('filter_user_id');
        }

        $sites = $this->Site2->fetch_dt($where);

        foreach ($sites['data'] as &$site) {

            $user_obj = $this->User2->get(['id' => $site['user_id']]);

            $site['username'] = isset($user_obj->username) ? $user_obj->username : '';
            $site['email'] = isset($user_obj->email) ? $user_obj->email : '';
        }

        exit(json_encode(array_merge(['error' => 0], $sites), JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $site_obj = $this->Site2->get([
            'site_id' => $this->input->post_get('site_id')
        ]);

        exit_json(0, '', $site_obj);
    }


    public function add()
    {
        $themes_list = implode(",", config_item('themes'));

        $this->validation->make([
            'user_id'               => "required|is_exists[users.id]",
            'isolated'              => "required|in_list[0,1]",
            'theme'                 => "required|in_list[{$themes_list}]",
            'allowed_camp_themes[]' => "required|in_list[{$themes_list}]",
            'domain'                => "required|clear_domain|is_valid_domain|is_unique[sites.domain]",
            'stat_url'              => "prep_url|valid_url"
        ], [
            'user_id.*'                      => __('Пользователь с таким ID не существует!'),
            'isolated.*'                     => __('Некорректный тип сайта!'),
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
            'user_id'             => $this->input->post('user_id'),
            'theme'               => $this->input->post('theme'),
            'allowed_camp_themes' => $this->prep_allowed_camp_themes($this->input->post('theme'), $this->input->post('allowed_camp_themes')),
            'isolated'            => $this->input->post('isolated'),
            'status'              => 1,
            'domain'              => $this->input->post('domain'),
            'stat_url'            => $this->input->post('stat_url'),
            'stat_login'          => $this->input->post('stat_login'),
            'stat_password'       => $this->input->post('stat_password'),
            'created_at'          => gmdate('Y-m-d H:i:s'),
        ];

        if ($site_obj = $this->Site2->add($site_params)) {

            event('site.add', $site_obj);

            exit_json(0, __('Сайт успешно добавлен!'));
        }

        exit_json(1, __('При добавлении сайта возникла ошибка!'));
    }


    public function update()
    {
        $themes_list = implode(",", config_item('themes'));

        $this->validation->make([
            'isolated'              => "required|in_list[0,1]",
            'site_id'               => "required|is_exists[sites.site_id]",
            'theme'                 => "required|in_list[{$themes_list}]",
            'allowed_camp_themes[]' => "required|in_list[{$themes_list}]",
            'stat_url'              => "prep_url|valid_url"
        ], [
            'isolated.*'                     => __('Некорректный тип сайта!'),
            'site_id.*'                      => __('Некорректный ID сайта!'),
            'theme.required'                 => __('Укажите тематику сайта!'),
            'theme.in_list'                  => __('Некорректная тематика сайта!'),
            'allowed_camp_themes[].required' => __('Укажите доступные к показу тематики обьявлений!'),
            'allowed_camp_themes[].in_list'  => __('Некорректные тематики обьявлений!'),
            'stat_url.valid_url'             => __('Некорректный URL статистики сайта!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'site_id' => $this->input->post('site_id'),
        ];

        $update = [
            'isolated'            => $this->input->post('isolated'),
            'theme'               => $this->input->post('theme'),
            'allowed_camp_themes' => $this->prep_allowed_camp_themes($this->input->post('theme'), $this->input->post('allowed_camp_themes')),
            'stat_url'            => $this->input->post('stat_url'),
            'stat_login'          => $this->input->post('stat_login'),
            'stat_password'       => $this->input->post('stat_password'),
            'updated_at'          => gmdate('Y-m-d H:i:s'),
        ];

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

        if ($this->Site2->delete($site_id)) {
            exit_json(0, __('Сайт успешно удален.'));
        }

        exit_json(1, __('Не удалось удалить сайт!'));
    }


    public function ban()
    {
        $site_id = $this->input->post_get('site_id');
        $ban_message = $this->input->post('ban_message');

        if ($this->Site2->ban($site_id, $ban_message)) {

            $site_data = $this->Site2->get([
                'site_id' => $this->input->post('site_id')
            ]);

            event("site.moderate", (object)[
                'email'   => $site_data->user()->email,
                'site_id' => $this->input->post('site_id'),
                'domain'  => $site_data->domain,
                'status'  => -2,
            ]);

            exit_json(0, __('Сайт забанен.'));
        }

        exit_json(1, __('Ошибка!'));
    }


    public function unban()
    {
        $site_id = $this->input->post_get('site_id');

        if ($this->Site2->unban($site_id)) {

            $site_data = $this->Site2->get([
                'site_id' => $this->input->post('site_id')
            ]);

            event("site.moderate", (object)[
                'email'   => $site_data->user()->email,
                'site_id' => $this->input->post('site_id'),
                'domain'  => $site_data->domain,
                'status'  => 1,
            ]);

            exit_json(0, __('Сайт разбанен.'));
        }

        exit_json(1, __('Ошибка!'));
    }


    public function moderate()
    {
        $themes_list = implode(",", config_item('themes'));

        $this->validation->make([
            'site_id'               => "required|is_exists[sites.site_id]",
            'theme'                 => "required|in_list[{$themes_list}]",
            'allowed_camp_themes[]' => "required|in_list[{$themes_list}]",
            'status'                => "required|in_list[-2,1]",
        ], [
            'site_id.*'               => __('Некорректный ID сайта!'),
            'theme.*'                 => __('Некорректная тематика сайта!'),
            'allowed_camp_themes[].*' => __('Некорректные разрешенные тематики!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'site_id' => $this->input->post('site_id')
        ];

        $data = [
            'theme'               => $this->input->post('theme'),
            'status'              => $this->input->post('status'),
            'status_message'      => $this->input->post('status_message'),
            'allowed_camp_themes' => $this->prep_allowed_camp_themes($this->input->post('theme'), $this->input->post('allowed_camp_themes'))
        ];

        if (!$this->Site2->moderate($data, $where)) {
            exit_json(1, __('Ошибка!'));
        }

        $site_data = $this->Site2->get([
            'site_id' => $this->input->post('site_id')
        ]);

        event("site.moderate", (object)[
            'email'   => $site_data->user()->email,
            'site_id' => $this->input->post('site_id'),
            'domain' => $site_data->domain,
            'status'  => $this->input->post('status'),
        ]);

        exit_json(0, __('Статус сайта успешно изменен!'));
    }


    private function prep_allowed_camp_themes($site_theme, $allowed_camp_themes)
    {
        // тематика сайта в любом случае должна присутствовать в разрешенных к показу тематиках обьявлений
        $array = array_unique(array_merge((array)$site_theme, $allowed_camp_themes));

        return implode(',', $array);
    }


}
