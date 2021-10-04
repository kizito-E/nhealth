<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends MY_Controller
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


    public function add_bannerunit()
    {
        $min_cpc = config_item('min_cpc');
        $max_cpc = config_item('max_cpc');
        $min_cpv = config_item('min_cpv');
        $max_cpv = config_item('max_cpv');
        $third_party_len = config_item('adunit_max_third_party_code_strlen');
        $allowed_banner_sizes = implode(',', config_item('banners_sizes'));

        $this->validation->make([
            'site_id'                    => "required|is_exists[sites.site_id]|callback__is_user_site",
            'name'                       => "required|min_length[1]",
            'banner_size'                => "required|in_list[{$allowed_banner_sizes}]",
            'min_cpc'                    => "required|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'min_cpv'                    => "required|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'params[third_party_status]' => "required|in_list[0,1]",
            'params[third_party_code]'   => "max_length[{$third_party_len}]",
            'allowed_payments[]'         => "required|in_list[cpc,cpv]",
        ], [
            "site_id.*"                    => __("Некорректный ID сайта!"),
            'name.*'                       => __("Некорректное имя блока!"),
            'banner_size.*'                => __("Некорректный размер баннера!"),
            'min_cpc.*'                    => __("Ошибка цены клика!"),
            'min_cpv.*'                    => __("Ошибка цены показа!"),
            'params[third_party_status].*' => __("Ошибка кода заглушки!"),
            'params[third_party_code].*'   => __("Длина кода должна быть не более {param} символов!"),
            'allowed_payments[].*'         => __("Установите тип оплаты блока."),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $unit_params = [
            'hash_id'          => 'b' . md5(uniqid('', true)),
            'user_id'          => userdata()->id,
            'site_id'          => $this->input->post('site_id'),
            'name'             => $this->input->post('name'),
            'status'           => 1,
            'type'             => 'banner',
            'banner_size'      => $this->input->post('banner_size'),
            'min_cpc'          => round($this->input->post('min_cpc'), 2),
            'min_cpv'          => round($this->input->post('min_cpv'), 2),
            'params'           => json_encode($this->input->post('params')),
            'allowed_payments' => implode(',', $this->input->post('allowed_payments')),
            'created_at'       => gmdate('Y-m-d H:i:s'),
        ];

        if ($unit_id = $this->Unit2->add($unit_params)) {
            exit_json(0, __('Рекламный блок успешно создан!'), ['unit_id' => $unit_id]);
        }

        exit_json(1, __('Ошибка!'));
    }


    public function update_bannerunit()
    {
        $min_cpc = config_item('min_cpc');
        $max_cpc = config_item('max_cpc');
        $min_cpv = config_item('min_cpv');
        $max_cpv = config_item('max_cpv');
        $third_party_len = config_item('adunit_max_third_party_code_strlen');
        $allowed_banner_sizes = implode(',', config_item('banners_sizes'));

        $this->validation->make([
            'site_id'                    => "required|is_exists[sites.site_id]|callback__is_user_site",
            'unit_id'                    => "required|is_exists[adunits.unit_id]",
            'name'                       => "required|min_length[1]",
            'banner_size'                => "required|in_list[{$allowed_banner_sizes}]",
            'min_cpc'                    => "required|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'min_cpv'                    => "required|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'params[third_party_status]' => "required|in_list[0,1]",
            'params[third_party_code]'   => "max_length[{$third_party_len}]",
            'allowed_payments[]'         => "required|in_list[cpc,cpv]",
        ], [
            "site_id.*"                    => __("Некорректный ID сайта!"),
            "unit_id.*"                    => __("Некорректный ID блока!"),
            'name.*'                       => __("Некорректное имя блока!"),
            'banner_size.*'                => __("Некорректный размер баннера!"),
            'min_cpc.*'                    => __("Ошибка цены клика!"),
            'min_cpv.*'                    => __("Ошибка цены показа!"),
            'params[third_party_status].*' => __("Ошибка кода заглушки!"),
            'params[third_party_code].*'   => __("Длина кода должна быть не более {param} символов!"),
            'allowed_payments[].*'         => __("Установите тип оплаты блока."),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $unit_params = [
            'name'             => $this->input->post('name'),
            'banner_size'      => $this->input->post('banner_size'),
            'min_cpc'          => round($this->input->post('min_cpc'), 2),
            'min_cpv'          => round($this->input->post('min_cpv'), 2),
            'params'           => json_encode($this->input->post('params')),
            'allowed_payments' => implode(',', $this->input->post('allowed_payments')),
            'updated_at'       => gmdate('Y-m-d H:i:s'),
        ];

        $where = [
            'user_id' => userdata()->id,
            'site_id' => $this->input->post('site_id'),
            'unit_id' => $this->input->post('unit_id')
        ];

        if ($this->Unit2->update($where, $unit_params)) {
            exit_json(0, __('Настройки блока обновлены!'));
        }

        exit_json(1, __('Ошибка!'));
    }


    public function add_ad_unit()
    {
        $min_cpc = config_item('min_cpc');
        $max_cpc = config_item('max_cpc');
        $min_cpv = config_item('min_cpv');
        $max_cpv = config_item('max_cpv');
        $third_party_len = config_item('adunit_max_third_party_code_strlen');

        $allowed_fonts = [
            "Arial, Helvetica, sans-serif",
            "Tahoma, Geneva, sans-serif",
            "Verdana, Geneva, sans-serif",
            "Georgia, Times New Roman, Times, serif",
            "Courier New, Courier, monospace",
            "Trebuchet MS, Helvetica, sans-serif",
            "Lucida Console, Monaco, monospace",
            "Palatino Linotype, Book Antiqua, Palatino, serif",
            "Times New Roman, Times, serif",
            "inherit"
        ];

        if (!in_array($this->input->post("unit_visual_params[fontFamily]"), $allowed_fonts)) {
            exit_json(1, $this->validation->first_error());
        }

        $this->validation->make([
            'site_id'                                 => "required|is_exists[sites.site_id]|callback__is_user_site",
            'unit_params[name]'                       => "required|min_length[1]",
            'unit_params[min_cpc]'                    => "required|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'unit_params[min_cpv]'                    => "required|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'unit_params[params][third_party_status]' => "required|in_list[0,1]",
            'unit_params[params][third_party_code]'   => "max_length[{$third_party_len}]",
            'unit_params[allowed_payments][]'         => "required|in_list[cpc,cpv]",
            //
            'unit_visual_params[buttonBgColor]'       => "required|is_hex",
            'unit_visual_params[buttonBorderColor]'   => "required|is_hex",
            'unit_visual_params[buttonColor]'         => "required|is_hex",
            'unit_visual_params[descriptionColor]'    => "required|is_hex",
            'unit_visual_params[titleColor]'          => "required|is_hex",
            'unit_visual_params[unitBgColor]'         => "required|is_hex",
            'unit_visual_params[unitBorderColor]'     => "required|is_hex",
        ], [
            "site_id.*"                                 => __("Некорректный ID сайта!"),
            'unit_params[name].*'                       => __("Некорректное имя блока!"),
            'unit_params[min_cpc].*'                    => __("Ошибка цены клика!"),
            'unit_params[min_cpv].*'                    => __("Ошибка цены показа!"),
            'unit_params[params][third_party_status].*' => __("Ошибка кода заглушки!"),
            'unit_params[params][third_party_code].*'   => __("Длина кода должна быть не более {param} символов!"),
            'unit_params[allowed_payments][].*'         => __("Установите тип оплаты блока."),
            //
            'unit_visual_params[buttonBgColor].*'       => __("Некорректный параметр цвет заливки кнопки."),
            'unit_visual_params[buttonBorderColor].*'   => __("Некорректный параметр цвет обводки кнопки."),
            'unit_visual_params[buttonColor].*'         => __("Некорректный параметр цвет кнопки."),
            'unit_visual_params[descriptionColor].*'    => __("Некорректный параметр цвет описания."),
            'unit_visual_params[titleColor].*'          => __("Некорректный параметр цвет заголовка."),
            'unit_visual_params[unitBgColor].*'         => __("Некорректный параметр цвет заливки блока."),
            'unit_visual_params[unitBorderColor].*'     => __("Некорректный параметр цвет обводки блока."),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $unit_params = [
            'hash_id' => 'a' . md5(uniqid('', true)),
            'user_id' => userdata()->id,
            'site_id' => $this->input->post('site_id'),
            'name'    => $this->input->post('unit_params[name]'),
            'status'  => 1,
            'type'    => 'ad',
            'min_cpc' => round($this->input->post('unit_params[min_cpc]'), 2),
            'min_cpv' => round($this->input->post('unit_params[min_cpv]'), 2),
            'params'  => json_encode(array_merge(
                $this->input->post('unit_params[params]'),
                $this->input->post('unit_visual_params')
            )),

            'allowed_payments' => implode(',', $this->input->post('unit_params[allowed_payments]')),
            'created_at'       => gmdate('Y-m-d H:i:s'),
        ];

        if ($unit_id = $this->Unit2->add($unit_params)) {
            exit_json(0, __('Рекламный блок успешно создан!'), ['unit_id' => $unit_id]);
        }

        exit_json(1, __('Ошибка!'));
    }


    public function update_ad_unit()
    {
        $min_cpc = config_item('min_cpc');
        $max_cpc = config_item('max_cpc');
        $min_cpv = config_item('min_cpv');
        $max_cpv = config_item('max_cpv');
        $third_party_len = config_item('adunit_max_third_party_code_strlen');

        $allowed_fonts = [
            "Arial, Helvetica, sans-serif",
            "Tahoma, Geneva, sans-serif",
            "Verdana, Geneva, sans-serif",
            "Georgia, Times New Roman, Times, serif",
            "Courier New, Courier, monospace",
            "Trebuchet MS, Helvetica, sans-serif",
            "Lucida Console, Monaco, monospace",
            "Palatino Linotype, Book Antiqua, Palatino, serif",
            "Times New Roman, Times, serif",
            "inherit"
        ];

        if (!in_array($this->input->post("unit_visual_params[fontFamily]"), $allowed_fonts)) {
            exit_json(1, $this->validation->first_error());
        }

        $this->validation->make([
            'site_id'                                 => "required|is_exists[sites.site_id]|callback__is_user_site",
            'unit_id'                                 => "required|is_exists[adunits.unit_id]",
            'unit_params[name]'                       => "required|min_length[1]",
            'unit_params[min_cpc]'                    => "required|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'unit_params[min_cpv]'                    => "required|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'unit_params[params][third_party_status]' => "required|in_list[0,1]",
            'unit_params[params][third_party_code]'   => "max_length[{$third_party_len}]",
            'unit_params[allowed_payments][]'         => "required|in_list[cpc,cpv]",
            //
            'unit_visual_params[buttonBgColor]'       => "required|is_hex",
            'unit_visual_params[buttonBorderColor]'   => "required|is_hex",
            'unit_visual_params[buttonColor]'         => "required|is_hex",
            'unit_visual_params[descriptionColor]'    => "required|is_hex",
            'unit_visual_params[titleColor]'          => "required|is_hex",
            'unit_visual_params[unitBgColor]'         => "required|is_hex",
            'unit_visual_params[unitBorderColor]'     => "required|is_hex",
        ], [
            "site_id.*"                                 => __("Некорректный ID сайта!"),
            "unit_id.*"                                 => __("Некорректный ID блока!"),
            'unit_params[name].*'                       => __("Некорректное имя блока!"),
            'unit_params[min_cpc].*'                    => __("Ошибка цены клика!"),
            'unit_params[min_cpv].*'                    => __("Ошибка цены показа!"),
            'unit_params[params][third_party_status].*' => __("Ошибка кода заглушки!"),
            'unit_params[params][third_party_code].*'   => __("Длина кода должна быть не более {param} символов!"),
            'unit_params[allowed_payments][].*'         => __("Установите тип оплаты блока."),
            //
            'unit_visual_params[buttonBgColor].*'       => __("Некорректный параметр цвет заливки кнопки."),
            'unit_visual_params[buttonBorderColor].*'   => __("Некорректный параметр цвет обводки кнопки."),
            'unit_visual_params[buttonColor].*'         => __("Некорректный параметр цвет кнопки."),
            'unit_visual_params[descriptionColor].*'    => __("Некорректный параметр цвет описания."),
            'unit_visual_params[titleColor].*'          => __("Некорректный параметр цвет заголовка."),
            'unit_visual_params[unitBgColor].*'         => __("Некорректный параметр цвет заливки блока."),
            'unit_visual_params[unitBorderColor].*'     => __("Некорректный параметр цвет обводки блока."),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $unit_params = [
            'name'    => $this->input->post('unit_params[name]'),
            'min_cpc' => round($this->input->post('unit_params[min_cpc]'), 2),
            'min_cpv' => round($this->input->post('unit_params[min_cpv]'), 2),
            'params'  => json_encode(array_merge(
                $this->input->post('unit_params[params]'),
                $this->input->post('unit_visual_params')
            )),

            'allowed_payments' => implode(',', $this->input->post('unit_params[allowed_payments]')),
            'updated_at'       => gmdate('Y-m-d H:i:s'),
        ];


        $where = [
            'user_id' => userdata()->id,
            'site_id' => $this->input->post('site_id'),
            'unit_id' => $this->input->post('unit_id')
        ];

        if ($this->Unit2->update($where, $unit_params)) {
            exit_json(0, __('Настройки блока обновлены!'));
        }

        exit_json(1, __('Ошибка!'));
    }


    public function add_mobileunit()
    {
        $min_cpc = config_item('min_cpc');
        $max_cpc = config_item('max_cpc');
        $min_cpv = config_item('min_cpv');
        $max_cpv = config_item('max_cpv');

        $this->validation->make([
            'site_id'               => "required|is_exists[sites.site_id]|callback__is_user_site",
            'name'                  => "required|min_length[1]",
            'min_cpc'               => "required|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'min_cpv'               => "required|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'params[position]'      => "required|in_list[top,bottom]",
            'params[show_delay]'    => "required|is_natural|less_than[300]",
            'params[hidden_period]' => "required|is_natural|less_than[86400]",
            'allowed_payments[]'    => "required|in_list[cpc,cpv]",
        ], [
            "site_id.*"               => __("Некорректный ID сайта!"),
            'name.*'                  => __("Некорректное имя блока!"),
            'min_cpc.*'               => __("Ошибка цены клика!"),
            'min_cpv.*'               => __("Ошибка цены показа!"),
            'params[position].*'      => __("Ошибка параметров блока!"),
            'params[show_delay].*'    => __("Период задержки показа должен быть не более {param} секунд!"),
            'params[hidden_period].*' => __("Скрытый период должен быть не более {param} секунд!"),
            'allowed_payments[].*'    => __("Установите тип оплаты блока."),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $mobile_unit_params = [
            'hash_id'          => 'm' . md5(uniqid('', true)),
            'user_id'          => userdata()->id,
            'site_id'          => $this->input->post('site_id'),
            'name'             => $this->input->post('name'),
            'status'           => 1,
            'type'             => 'mobile',
            'min_cpc'          => round($this->input->post('min_cpc'), 2),
            'min_cpv'          => round($this->input->post('min_cpv'), 2),
            'params'           => json_encode($this->input->post('params')),
            'allowed_payments' => implode(',', $this->input->post('allowed_payments')),
            'created_at'       => gmdate('Y-m-d H:i:s'),
        ];

        if ($unit_id = $this->Unit2->add($mobile_unit_params)) {
            exit_json(0, __('Рекламный блок успешно создан!'), ['unit_id' => $unit_id]);
        }

        exit_json(1, __('Ошибка!'));
    }


    public function update_mobileunit()
    {
        $min_cpc = config_item('min_cpc');
        $max_cpc = config_item('max_cpc');
        $min_cpv = config_item('min_cpv');
        $max_cpv = config_item('max_cpv');

        $this->validation->make([
            'name'                  => "required|min_length[1]",
            'min_cpc'               => "required|greater_than_equal_to[{$min_cpc}]|less_than_equal_to[{$max_cpc}]",
            'min_cpv'               => "required|greater_than_equal_to[{$min_cpv}]|less_than_equal_to[{$max_cpv}]",
            'params[position]'      => "required|in_list[top,bottom]",
            'params[show_delay]'    => "required|is_natural|less_than[300]",
            'params[hidden_period]' => "required|is_natural|less_than[86400]",
            'allowed_payments[]'    => "required|in_list[cpc,cpv]",
        ], [
            'name.*'                  => __("Некорректное имя блока!"),
            'min_cpc.*'               => __("Ошибка цены клика!"),
            'min_cpv.*'               => __("Ошибка цены показа!"),
            'params[position].*'      => __("Ошибка параметров блока!"),
            'params[show_delay].*'    => __("Период задержки показа должен быть не более {param} секунд!"),
            'params[hidden_period].*' => __("Скрытый период должен быть не более {param} секунд!"),
            'allowed_payments[].*'    => __("Установите тип оплаты блока."),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $where = [
            'user_id' => userdata()->id,
            'site_id' => $this->input->post('site_id'),
            'unit_id' => $this->input->post('unit_id')
        ];

        $mobile_unit_params = [
            'name'             => $this->input->post('name'),
            'min_cpc'          => round($this->input->post('min_cpc'), 2),
            'min_cpv'          => round($this->input->post('min_cpv'), 2),
            'params'           => json_encode($this->input->post('params')),
            'allowed_payments' => implode(',', $this->input->post('allowed_payments')),
            'updated_at'       => gmdate('Y-m-d H:i:s'),
        ];

        if ($unit_id = $this->Unit2->update($where, $mobile_unit_params)) {
            exit_json(0, __('Настройки блока обновлены!'));
        }

        exit_json(1, __('Ошибка!'));
    }


    public function get()
    {
        $unit = $this->Unit2->get([
            'user_id' => userdata()->id,
            'unit_id' => $this->input->post_get('unit_id')
        ]);

        exit_json(0, '', $unit);
    }


    public function fetch()
    {
        $units = $this->Unit2->fetch_dt([
            'user_id' => userdata()->id,
            'site_id' => $this->input->post('site_id')
        ]);

        exit(json_encode($units + ['error' => 0], JSON_PRETTY_PRINT));
    }


    public function play()
    {
        $ret = $this->Unit2->play($this->input->post('unit_id'), [
            'user_id' => userdata()->id
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось изменить статус рекламного блока!'));
        }

        exit_json(0, __('Рекламный блок успешно запущен.'));
    }


    public function stop()
    {
        $ret = $this->Unit2->stop($this->input->post('unit_id'), [
            'user_id' => userdata()->id
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось изменить статус рекламного блока!'));
        }

        exit_json(0, __('Рекламный блок успешно остановлен.'));
    }


    public function delete()
    {
        $ret = $this->Unit2->delete($this->input->post('unit_id'), [
            'user_id' => userdata()->id
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось удалить рекламный блок!'));
        }

        exit_json(0, __('Рекламный блок успешно удален.'));
    }


    public function _is_user_site($site_id)
    {
        return $this->Site2->exists([
            'site_id' => $site_id,
            'user_id' => userdata()->id,
        ]);
    }


}
