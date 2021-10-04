<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends MY_Controller
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


    public function fetch()
    {
        $ads = $this->Ads2->fetch_dt([
            'user_id' => userdata()->id,
            'camp_id' => $this->input->post_get('camp_id')
        ]);

        foreach ($ads['data'] as &$ad) {

            $user_obj = $this->User2->get(['id' => $ad['user_id']]);
            $camp_obj = $this->Camp2->get(['id' => $ad['camp_id']]);

            $ad['camp_theme'] = isset($camp_obj->theme) ? $camp_obj->theme : '';
            $ad['username']   = isset($user_obj->username) ? $user_obj->username : '';
            $ad['email']      = isset($user_obj->email) ? $user_obj->email : '';
            $ad['img_url']    = $ad['filename'] ? image($ad['filename'])->url : "";
        }

        exit(json_encode(array_merge(['error' => 0], $ads), JSON_PRETTY_PRINT));
    }


    public function add_banner()
    {
        $min_cpc       = config_item('min_cpc');
        $max_cpc       = config_item('max_cpc');
        $min_cpv       = config_item('min_cpv');
        $max_cpv       = config_item('max_cpv');
        $max_title_len = config_item('max_title_len');

        $this->validation->make([
            'camp_id'      => "required|callback__is_user_camp",
            'title'        => "required|min_length[3]|max_length[{$max_title_len}]",
            'ad_url'       => "required|trim|is_valid_url",
            'payment_mode' => "required|trim|in_list[cpc,cpv]",
            'cpc'          => "required|trim|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'cpv'          => "required|trim|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
        ], [
            'camp_id.*'      => __('Некорректный ID кампании!'),
            'title.*'        => __('Некорректный заголовок баннера!'),
            'ad_url.*'       => __('Некорректная рекламный URL!'),
            'payment_mode.*' => __('Некорректный режим оплаты!'),
            'cpc.*'          => __('Некорректная цена за клик!'),
            'cpv.*'          => __('Некорректная цена за 1000 показов!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $upload_image = $this->Ads2->upload_image('img_file'); // $_FILES['img_file']

        if (!$upload_image || !in_array($upload_image['wh'], config_item('banners_sizes'))) {
            exit_json(1, __('Некорректный размер баннера!'));
        }

        $banner_params = [
            'user_id'      => userdata()->id,
            'hash_id'      => 'b' . sha1(uniqid('', true)),
            'camp_id'      => $this->input->post('camp_id'),
            'title'        => $this->input->post('title'),
            'ad_url'       => $this->input->post('ad_url'),
            'payment_mode' => $this->input->post('payment_mode'),
            'cpc'          => $this->input->post('cpc'),
            'cpv'          => $this->input->post('cpv'),
            'status'       => is_administrator() ? 1 : -1,
            'type'         => 'banner',
            'filename'     => $upload_image['filename'],
            'img_width'    => $upload_image['width'],
            'img_height'   => $upload_image['height'],
            'img_wh'       => $upload_image['wh'],
            'created_at'   => gmdate("Y-m-d H:i:s")
        ];

        if (!$this->Ads2->add($banner_params)) {
            exit_json(1, __('Ошибка!'));
        }

        event('advertiser.add_banner');

        exit_json(0, __('Баннер успешно добавлен!'));
    }


    public function update_banner()
    {
        $min_cpc       = config_item('min_cpc');
        $max_cpc       = config_item('max_cpc');
        $min_cpv       = config_item('min_cpv');
        $max_cpv       = config_item('max_cpv');
        $max_title_len = config_item('max_title_len');

        $this->validation->make([
            'ad_id'        => "required|callback__is_user_ad",
            'camp_id'      => "required|callback__is_user_camp",
            'title'        => "required|min_length[3]|max_length[{$max_title_len}]",
            'ad_url'       => "required|trim|is_valid_url",
            'payment_mode' => "required|trim|in_list[cpc,cpv]",
            'cpc'          => "required|trim|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'cpv'          => "required|trim|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
        ], [
            'camp_id.*'      => __('Некорректный ID обьявления!'),
            'camp_id.*'      => __('Некорректный ID кампании!'),
            'title.*'        => __('Некорректный заголовок баннера!'),
            'ad_url.*'       => __('Некорректная рекламный URL!'),
            'payment_mode.*' => __('Некорректный режим оплаты!'),
            'cpc.*'          => __('Некорректная цена за клик!'),
            'cpv.*'          => __('Некорректная цена за 1000 показов!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'ad_id'   => $this->input->post('ad_id'),
            'camp_id' => $this->input->post('camp_id'),
            'user_id' => userdata()->id
        ];

        $banner_params = [
            'title'        => $this->input->post('title'),
            'ad_url'       => $this->input->post('ad_url'),
            'payment_mode' => $this->input->post('payment_mode'),
            'cpc'          => $this->input->post('cpc'),
            'cpv'          => $this->input->post('cpv'),
            'updated_at'   => gmdate("Y-m-d H:i:s")
        ];

        // if change ad_url - remoderate banner
        if (!is_administrator() && $banner_params['ad_url'] != $this->Ads2->get($where)->ad_url) {
            $banner_params['status'] = -1;
        }


        if (!$this->Ads2->update($where, $banner_params)) {
            exit_json(1, __('Ошибка!'));
        }

        exit_json(0, __('Настройки баннера обновлены!'));
    }


    public function add_ads()
    {
        $min_cpc       = config_item('min_cpc');
        $max_cpc       = config_item('max_cpc');
        $min_cpv       = config_item('min_cpv');
        $max_cpv       = config_item('max_cpv');
        $max_title_len = config_item('max_title_len');
        $max_descr_len = config_item('max_descr_len');

        $this->validation->make([
            'camp_id'      => "required|callback__is_user_camp",
            'title'        => "required|min_length[3]|max_length[{$max_title_len}]",
            'description'  => "required|min_length[3]|max_length[{$max_descr_len}]",
            'ad_url'       => "required|trim|is_valid_url",
            'payment_mode' => "required|trim|in_list[cpc,cpv]",
            'cpc'          => "required|trim|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'cpv'          => "required|trim|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'action_text'  => "trim|max_length[20]",
        ], [
            'camp_id.*'      => __('Некорректный ID кампании!'),
            'title.*'        => __('Некорректный заголовок обьявления!'),
            'description.*'  => __('Некорректное описание обьявления!'),
            'ad_url.*'       => __('Некорректная рекламный URL!'),
            'payment_mode.*' => __('Некорректный режим оплаты!'),
            'cpc.*'          => __('Некорректная цена за клик!'),
            'cpv.*'          => __('Некорректная цена за 1000 показов!'),
            'action_text.*'  => __('Некорректный текст призыва к действию. Допустимо до 20 символов!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $upload_image = $this->Ads2->upload_image('img_file', true); // $_FILES['img_file']

        $ad_params = [
            'user_id'      => userdata()->id,
            'hash_id'      => 'a' . sha1(uniqid('', true)),
            'camp_id'      => $this->input->post('camp_id'),
            'title'        => $this->input->post('title'),
            'description'  => $this->input->post('description'),
            'ad_url'       => $this->input->post('ad_url'),
            'action_text'  => $this->input->post('action_text'),
            'payment_mode' => $this->input->post('payment_mode'),
            'cpc'          => $this->input->post('cpc'),
            'cpv'          => $this->input->post('cpv'),
            'status'       => is_administrator() ? 1 : -1,
            'type'         => 'ad',
            'filename'     => $upload_image['filename'] ?? "",
            'img_width'    => $upload_image['width'] ?? "",
            'img_height'   => $upload_image['height'] ?? "",
            'img_wh'       => $upload_image['wh'] ?? "",
            'created_at'   => gmdate("Y-m-d H:i:s")
        ];

        if (!$this->Ads2->add($ad_params)) {
            exit_json(1, __('Ошибка!'));
        }

        event('advertiser.add_ad');

        exit_json(0, __('Обьявление успешно добавлено!'));
    }


    public function update_ads()
    {
        $min_cpc       = config_item('min_cpc');
        $max_cpc       = config_item('max_cpc');
        $min_cpv       = config_item('min_cpv');
        $max_cpv       = config_item('max_cpv');
        $max_title_len = config_item('max_title_len');
        $max_descr_len = config_item('max_descr_len');

        $this->validation->make([
            'ad_id'        => "required|callback__is_user_ad",
            'camp_id'      => "required|callback__is_user_camp",
            'title'        => "required|min_length[3]|max_length[{$max_title_len}]",
            'description'  => "required|min_length[3]|max_length[{$max_descr_len}]",
            'ad_url'       => "required|trim|is_valid_url",
            'payment_mode' => "required|trim|in_list[cpc,cpv]",
            'cpc'          => "required|trim|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'cpv'          => "required|trim|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'action_text'  => "trim|max_length[20]",
        ], [
            'camp_id.*'      => __('Некорректный ID обьявления!'),
            'camp_id.*'      => __('Некорректный ID кампании!'),
            'title.*'        => __('Некорректный заголовок обьявления!'),
            'description.*'  => __('Некорректное описание обьявления!'),
            'ad_url.*'       => __('Некорректная рекламный URL!'),
            'payment_mode.*' => __('Некорректный режим оплаты!'),
            'cpc.*'          => __('Некорректная цена за клик!'),
            'cpv.*'          => __('Некорректная цена за 1000 показов!'),
            'action_text.*'  => __('Некорректный текст призыва к действию. Допустимо до 20 символов!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'ad_id'   => $this->input->post('ad_id'),
            'camp_id' => $this->input->post('camp_id'),
            'user_id' => userdata()->id
        ];

        $ad_params = [
            'title'        => $this->input->post('title'),
            'description'  => $this->input->post('description'),
            'ad_url'       => $this->input->post('ad_url'),
            'action_text'  => $this->input->post('action_text'),
            'payment_mode' => $this->input->post('payment_mode'),
            'cpc'          => $this->input->post('cpc'),
            'cpv'          => $this->input->post('cpv'),
            'updated_at'   => gmdate("Y-m-d H:i:s")
        ];


        if (!is_administrator()) {

            // if change title - remoderate ad
            if ($ad_params['title'] != $this->Ads2->get($where)->title) {
                $ad_params['status'] = -1;
            }

            // if change description - remoderate ad
            if ($ad_params['description'] != $this->Ads2->get($where)->description) {
                $ad_params['status'] = -1;
            }

            // if change ad_url - remoderate ad
            if ($ad_params['ad_url'] != $this->Ads2->get($where)->ad_url) {
                $ad_params['status'] = -1;
            }

            // if change action_text - remoderate ad
            if ($ad_params['action_text'] != $this->Ads2->get($where)->action_text) {
                $ad_params['status'] = -1;
            }
        }

        if (!$this->Ads2->update($where, $ad_params)) {
            exit_json(1, __('Ошибка!'));
        }

        exit_json(0, __('Настройки обьявления обновлены!'));
    }


    public function get()
    {
        $ad_obj = $this->Ads2->get([
            'user_id' => userdata()->id,
            'ad_id'   => $this->input->post_get('ad_id')
        ]);

        if (!$ad_obj) {
            exit_json(1, __('Баннер не существует!'));
        }

        $ad_obj->img_url = $ad_obj->filename ? image($ad_obj->filename)->url : "";

        exit_json(0, '', $ad_obj);
    }


    public function play()
    {
        $ret = $this->Ads2->play($this->input->post_get('ad_id'), [
            'user_id'   => userdata()->id,
            'status >=' => 0
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось изменить статус обьявления!'));
        }

        exit_json(0, __('Запущено!'));
    }


    public function stop()
    {
        $ret = $this->Ads2->stop($this->input->post_get('ad_id'), [
            'user_id'   => userdata()->id,
            'status >=' => 0
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось изменить статус обьявления!'));
        }

        exit_json(0, __('Остановлено!'));
    }


    public function delete()
    {
        $ret = $this->Ads2->delete($this->input->post_get('ad_id'), [
            'user_id' => userdata()->id
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось удалить обьявления!'));
        }

        exit_json(0, __('Обьявление удалено!'));
    }


    public function _is_user_camp($camp_id)
    {
        return $this->Camp2->exists([
            'id'      => $camp_id,
            'user_id' => userdata()->id,
        ]);
    }


    public function _is_user_ad($ad_id)
    {
        return $this->Ads2->exists([
            'ad_id'   => $ad_id,
            'camp_id' => $this->input->post('camp_id'),
            'user_id' => userdata()->id,
        ]);
    }


    public function get_banner_properties()
    {
        exit_json(0, '', [
            'allowed_sizes' => config_item('banners_sizes'),
            'min_cpc'       => config_item('min_cpc'),
            'min_cpv'       => config_item('min_cpv'),
        ]);
    }

}
