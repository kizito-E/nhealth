<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Camp extends MY_Controller
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
        // собственные кампании администратора, не отображаются в меню всех кампаний
        $where = [
            "user_id !=" => admindata()->id
        ];

        if ($this->input->post('filter_user_id')) {
            $where['user_id'] = $this->input->post_get('filter_user_id');
        }

        $camps = $this->Camp2->fetch_dt($where);

        foreach ($camps['data'] as &$camp) {

            $user_obj = $this->User2->get([
                'id' => $camp['user_id']
            ]);

            $camp['username'] = isset($user_obj->username) ? $user_obj->username : '';
            $camp['email'] = isset($user_obj->email) ? $user_obj->email : '';
            $camp['sites_bl'] = $this->BlSites->get_bl($camp['id']);
            $camp['count_items'] = $this->Ads2->count(['camp_id' => $camp['id']]);
        }

        exit(json_encode(array_merge(['error' => 0], $camps), JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $camp_obj = $this->Camp2->get([
            'id' => $this->input->post_get('camp_id')
        ]);

        if (isset($camp_obj->id)) {
            $camp_obj->sites_bl = $this->BlSites->get_bl($camp_obj->id);
        }

        exit_json(0, '', $camp_obj);
    }


    public function get_camp_template()
    {
        exit_json(0, '', [
            'name'                => 'Campaign - ' . rand(10000, 1000000),
            'type'                => '',
            'start_date'          => gmdate("Y-m-d"),
            'end_date'            => gmdate("Y-m-d", time() + 86400 * 365),
            'theme'               => '',
            'allowed_site_themes' => config_item('themes'),
            'hours'               => config_item('hours'),
            'days'                => config_item('days'),
            'geos'                => config_item('geo_alfa2'),
            'devs'                => config_item('devs'),
            'platforms'           => config_item('platforms'),
            'browsers'            => config_item('browsers'),
            'sites_bl'            => [],
        ]);
    }


    public function add()
    {
        $allowed_themes = implode(',', config_item('themes'));
        $allowed_days = implode(',', config_item('days'));
        $allowed_hours = implode(',', config_item('hours'));
        $allowed_geos = implode(',', config_item('geo_alfa2'));
        $allowed_devs = implode(',', config_item('devs'));
        $allowed_platforms = implode(',', config_item('platforms'));
        $allowed_browsers = implode(',', config_item('browsers'));

        $count_geos = count(config_item('geo_alfa2'));
        $count_devs = count(config_item('devs'));
        $count_platforms = count(config_item('platforms'));
        $count_browsers = count(config_item('browsers'));

        $this->validation->make([
            'user_id'               => "required|is_exists[users.id]",
            'name'                  => "required|max_length[50]",
            'type'                  => "required|in_list[banners]",
            'theme'                 => "required|in_list[{$allowed_themes}]",
            'allowed_site_themes[]' => "required|in_list[{$allowed_themes}]",
            'start_date'            => "required|regex_match[/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/]",
            'end_date'              => "required|regex_match[/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/]|differs[start_date]",
            'days[]'                => "required|in_list[{$allowed_days}]|max_array_length[days,7]|is_unique_array_items[days]",
            'hours[]'               => "required|in_list[{$allowed_hours}]|max_array_length[hours,24]|is_unique_array_items[hours]",
            'geos[]'                => "required|in_list[{$allowed_geos}]|max_array_length[geos,{$count_geos}]|is_unique_array_items[geos]",
            'devs[]'                => "required|in_list[{$allowed_devs}]|max_array_length[devs,{$count_devs}]|is_unique_array_items[devs]",
            'platforms[]'           => "required|in_list[{$allowed_platforms}]|max_array_length[platforms,{$count_platforms}]|is_unique_array_items[platforms]",
            'browsers[]'            => "required|in_list[{$allowed_browsers}]|max_array_length[browsers,{$count_browsers}]|is_unique_array_items[browsers]",
            'sites_bl[]'            => "",
            'status'                => "in_list[0,1]",
            'isolated'              => "in_list[0,1]",
        ], [
            'user_id.*'               => __('Некорректный ID пользователя!'),
            'name.*'                  => __('Некорректное имя кампании!'),
            'type.*'                  => __('Некорректный тип кампании!'),
            'theme.*'                 => __('Некорректная тематика кампании!'),
            'allowed_site_themes[].*' => __('Некорректные разрешенные к показу тематики сайтов!'),
            'start_date.*'            => __('Некорректная дата старта кампании!'),
            'end_date.*'              => __('Некорректная дата остановки кампании!'),
            'days[].*'                => __('Некорректные дни показа кампании!'),
            'hours[].*'               => __('Некорректные часы показа кампании!'),
            'geos[].*'                => __('Некорректные настройки геотаргетинга!'),
            'devs[].*'                => __('Некорректные настройки таргетинга по устройствам!'),
            'platforms[].*'           => __('Некорректные настройки таргетинга по платформам!'),
            'browsers[].*'            => __('Некорректные настройки таргетинга по браузерам!'),
            'status.*'                => __('Некорректный статус!'),
            'isolated.*'              => __('Ошибка!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $camp_params = [
            'user_id'             => $this->input->post('user_id'),
            'name'                => $this->input->post('name'),
            'type'                => $this->input->post('type'),
            'theme'               => $this->input->post('theme'),
            'start_date'          => $this->input->post('start_date'),
            'end_date'            => $this->input->post('end_date'),
            'allowed_site_themes' => $this->prep_allowed_site_themes($this->input->post('theme'), $this->input->post('allowed_site_themes')),
            'days'                => implode(",", $this->input->post('days')),
            'hours'               => implode(",", $this->input->post('hours')),
            'geos'                => implode(",", $this->input->post('geos')),
            'devs'                => implode(",", $this->input->post('devs')),
            'platforms'           => implode(",", $this->input->post('platforms')),
            'browsers'            => implode(",", $this->input->post('browsers')),
            'status'              => 1,
            'isolated'            => 0,
            'created_at'          => gmdate('Y-m-d H:i:s')
        ];

        if ($camp_obj = $this->Camp2->add($camp_params)) {
            $this->BlSites->set_bl($camp_obj->id, $this->input->post('sites_bl'));

            event('camp.create', $camp_obj);

            exit_json(0, __('Кампания успешно добавлена!'));
        }

        exit_json(1, __('При создании кампании возникла ошибка!'));
    }


    public function update()
    {
        $allowed_themes = implode(',', config_item('themes'));
        $allowed_days = implode(',', config_item('days'));
        $allowed_hours = implode(',', config_item('hours'));
        $allowed_geos = implode(',', config_item('geo_alfa2'));
        $allowed_devs = implode(',', config_item('devs'));
        $allowed_platforms = implode(',', config_item('platforms'));
        $allowed_browsers = implode(',', config_item('browsers'));

        $count_geos = count(config_item('geo_alfa2'));
        $count_devs = count(config_item('devs'));
        $count_platforms = count(config_item('platforms'));
        $count_browsers = count(config_item('browsers'));

        $this->validation->make([
            'id'                    => "required|is_exists[camps.id]",
            'user_id'               => "required|is_exists[users.id]",
            'name'                  => "required|max_length[50]",
            'type'                  => "required|in_list[banners,ads]",
            'theme'                 => "required|in_list[{$allowed_themes}]",
            'allowed_site_themes[]' => "required|in_list[{$allowed_themes}]",
            'start_date'            => "required|regex_match[/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/]",
            'end_date'              => "required|regex_match[/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/]|differs[start_date]",
            'days[]'                => "required|in_list[{$allowed_days}]|max_array_length[days,7]|is_unique_array_items[days]",
            'hours[]'               => "required|in_list[{$allowed_hours}]|max_array_length[hours,24]|is_unique_array_items[hours]",
            'geos[]'                => "required|in_list[{$allowed_geos}]|max_array_length[geos,{$count_geos}]|is_unique_array_items[geos]",
            'devs[]'                => "required|in_list[{$allowed_devs}]|max_array_length[devs,{$count_devs}]|is_unique_array_items[devs]",
            'platforms[]'           => "required|in_list[{$allowed_platforms}]|max_array_length[platforms,{$count_platforms}]|is_unique_array_items[platforms]",
            'browsers[]'            => "required|in_list[{$allowed_browsers}]|max_array_length[browsers,{$count_browsers}]|is_unique_array_items[browsers]",
            'sites_bl[]'            => "",
            'status'                => "in_list[0,1]",
            'isolated'              => "in_list[0,1]",
        ], [
            'id.*'                    => __('Некорректный ID кампании!'),
            'user_id.*'               => __('Некорректный ID пользователя!'),
            'name.*'                  => __('Некорректное имя кампании!'),
            'type.*'                  => __('Некорректный тип кампании!'),
            'theme.*'                 => __('Некорректная тематика кампании!'),
            'allowed_site_themes[].*' => __('Некорректные разрешенные к показу тематики сайтов!'),
            'start_date.*'            => __('Некорректная дата старта кампании!'),
            'end_date.*'              => __('Некорректная дата остановки кампании!'),
            'days[].*'                => __('Некорректные дни показа кампании!'),
            'hours[].*'               => __('Некорректные часы показа кампании!'),
            'geos[].*'                => __('Некорректные настройки геотаргетинга!'),
            'devs[].*'                => __('Некорректные настройки таргетинга по устройствам!'),
            'platforms[].*'           => __('Некорректные настройки таргетинга по платформам!'),
            'browsers[].*'            => __('Некорректные настройки таргетинга по браузерам!'),
            'status.*'                => __('Некорректный статус!'),
            'isolated.*'              => __('Ошибка!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'id' => $this->input->post('id')
        ];

        $camp_params = [
            'name'                => $this->input->post('name'),
            'start_date'          => $this->input->post('start_date'),
            'end_date'            => $this->input->post('end_date'),
            'allowed_site_themes' => $this->prep_allowed_site_themes($this->input->post('theme'), $this->input->post('allowed_site_themes')),
            'days'                => implode(",", $this->input->post('days')),
            'hours'               => implode(",", $this->input->post('hours')),
            'geos'                => implode(",", $this->input->post('geos')),
            'devs'                => implode(",", $this->input->post('devs')),
            'platforms'           => implode(",", $this->input->post('platforms')),
            'browsers'            => implode(",", $this->input->post('browsers')),
            'updated_at'          => gmdate('Y-m-d H:i:s')
        ];

        if ($camp_obj = $this->Camp2->update($where, $camp_params)) {

            $this->BlSites->set_bl($camp_obj->id, $this->input->post('sites_bl'));

            event('camp.update', $camp_obj);

            exit_json(0, __('Настройки кампании обновлены!'));
        }

        exit_json(1, __('При обновлении настроек кампании произошла ошибка!'));
    }


    public function play()
    {
        if (!$this->Camp2->play($this->input->post_get('camp_id'))) {
            exit_json(1, __('Не удалось изменить статус кампании!'));
        }

        exit_json(0, __('Кампания запущена.'));
    }


    public function stop()
    {
        if (!$this->Camp2->stop($this->input->post_get('camp_id'))) {
            exit_json(1, __('Не удалось изменить статус кампании!'));
        }

        exit_json(0, __('Кампания остановлена.'));
    }


    public function delete()
    {
        // get camp data
        $camp_obj = $this->Camp2->get([
            'id' => $this->input->post_get('camp_id')
        ]);

        // get camp ads
        foreach ($camp_obj->ads() as $ad) {

            // delete camp ad image
            @unlink(image($ad->filename)->path);
        }

        // delete camp
        if (!$this->Camp2->delete($this->input->post_get('camp_id'))) {
            exit_json(1, __('Ошибка удаления!'));
        }

        exit_json(0, __('Кампания удалена.'));
    }


    private function prep_allowed_site_themes($camp_theme, $allowed_site_themes)
    {
        // тематика кампании в любом случае должна присутствовать в разрешенных к показу тематиках сайтов
        $array = array_unique(array_merge((array)$camp_theme, $allowed_site_themes));

        return implode(',', $array);
    }


}
