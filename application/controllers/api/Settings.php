<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_administrator() or exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() or exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function get()
    {
        exit_json(0, null, [
            'lang'                    => get_usersettings('lang', 'en'),
            'timezone'                => get_usersettings('timezone', 'Europe/London'),
            'enable_payouts'          => get_globalsettings('enable_payouts', 0),
            'users_registration'      => get_globalsettings('users_registration', 1),
            'admin_paypal_account'    => get_globalsettings('admin_paypal_account'),
            'paypal_payments'         => get_globalsettings('paypal_payments', 0),
            'paypal_sandbox'          => get_globalsettings('paypal_sandbox', 0),
            'stripe_payments'         => get_globalsettings('stripe_payments', 0),
            'current_currency'        => get_globalsettings('current_currency', 'USD'),
            'admin_stripe_pub_key'    => get_globalsettings('admin_stripe_pub_key'),
            'admin_stripe_secret_key' => get_globalsettings('admin_stripe_secret_key'),
            'comission'               => get_globalsettings('comission', 20),
            'adunit_visible_tip'      => get_globalsettings('adunit_visible_tip', 0),
            'customName'              => htmlspecialchars_decode(get_globalsettings('custom_name')),
            'customLogo'              => htmlspecialchars_decode(get_globalsettings('custom_logo')),
        ]);
    }


    public function update()
    {
        $langs = implode(',', config_item('interface_langs'));
        $time_zones = implode(',', DateTimeZone::listIdentifiers());
        $allowedCurrencies = implode(',', config_item('allowed_payment_currencies'));

        $this->validation->make([
            'lang'                    => "required|in_list[{$langs}]",
            'timezone'                => "required|in_list[{$time_zones}]",
            'enable_payouts'          => "required|in_list[0,1]",
            'users_registration'      => "required|in_list[0,1]",
            'comission'               => "required|greater_than_equal_to[1]|less_than_equal_to[80]",
            'stripe_payments'         => "in_list[0,1]|callback__is_set_admin_stripe_account",
            'paypal_payments'         => "in_list[0,1]|callback__is_set_admin_paypal_account",
            'paypal_sandbox'          => "in_list[0,1]",
            'admin_paypal_account'    => "valid_email",
            'admin_stripe_pub_key'    => "min_length[10]",
            'admin_stripe_secret_key' => "min_length[10]",
            'current_currency'        => "required[in_list[{$allowedCurrencies}]]",
            'customName'              => "min_length[1]|max_length[100]",
            'customLogo'              => "min_length[1]|max_length[2000]",
            'adunit_visible_tip'      => "in_list[0,1]",
        ], [
            'lang.*'                                       => __('Некорректный язык интерфейса!'),
            'timezone.*'                                   => __('Некорректная временная зона!'),
            'enable_payouts.*'                             => __('Некорректный параметр {field}'),
            'users_registration.*'                         => __('Некорректный параметр {field}'),
            'paypal_payments.in_list'                      => __('Некорректный параметр {field}'),
            'paypal_payments._is_set_admin_paypal_account' => __('Сначала укажите PayPal аккаунт!'),
            'stripe_payments.in_list'                      => __('Некорректный параметр {field}'),
            'stripe_payments._is_set_admin_stripe_account' => __('Сначала укажите Stripe ключи!'),
            'comission.*'                                  => __('Некорректный параметр {field}'),
            'admin_paypal_account.*'                       => __('Некорректный параметр {field}'),
            'admin_stripe_pub_key.*'                       => __('Некорректный параметр {field}'),
            'admin_stripe_secret_key.*'                    => __('Некорректный параметр {field}'),
            'customName'                                   => __('Некорректный параметр {field}'),
            'customLogo'                                   => __('Некорректный параметр {field}'),
            'current_currency'                             => __('Некорректный параметр {field}'),
            'adunit_visible_tip'                           => __('Некорректный параметр {field}'),

        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        // set required user settings
        set_usersettings('lang', $this->input->post('lang'));
        set_usersettings('timezone', $this->input->post('timezone'));

        // set required global settings
        set_globalsettings('enable_payouts', $this->input->post('enable_payouts'));
        set_globalsettings('users_registration', $this->input->post('users_registration'));
        set_globalsettings('stripe_payments', $this->input->post('stripe_payments'));
        set_globalsettings('comission', $this->input->post('comission'));
        set_globalsettings('current_currency', $this->input->post('current_currency'));

        // optional
        set_globalsettings('adunit_visible_tip', $this->input->post('adunit_visible_tip'));
        set_globalsettings('paypal_payments', $this->input->post('paypal_payments'));
        set_globalsettings('paypal_sandbox', $this->input->post('paypal_sandbox'));
        set_globalsettings('admin_paypal_account', $this->input->post('admin_paypal_account'));
        set_globalsettings('admin_stripe_pub_key', $this->input->post('admin_stripe_pub_key'));
        set_globalsettings('admin_stripe_secret_key', $this->input->post('admin_stripe_secret_key'));
        set_globalsettings('custom_name', empty($this->input->post('customName')) ? null : htmlspecialchars($this->input->post('customName')));
        set_globalsettings('custom_logo', empty($this->input->post('customLogo')) ? null : htmlspecialchars($this->input->post('customLogo')));

        // optional setting: set new password
        if ($this->input->post('old_password') && $this->input->post('new_password')) {
            $this->_set_new_password();
        }

        exit_json(0, __("Настройки обновлены!"));
    }


    public function set_custom_logo()
    {
        $key = "customLogoFile";

        $config = [
            'upload_path'   => './' . config_item('images_dir') . '/',
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size'      => '4092',
            'width'         => '400',
            'height'        => '100',
            'encrypt_name'  => true
        ];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($key)) {

            $image_data = $this->upload->data();

            if ($image_data['is_image'] != 1) {
                @unlink($image_data['full_path']);
                exit_json(1, __("Файл должен быть изображением!"));
            }

            set_globalsettings("custom_logo", $image_data['file_name']);

            exit_json(0, "", [
                "customLogo"    => $image_data['file_name'],
                "customLogoUrl" => image($image_data['file_name'])->url,
            ]);
        }

        exit_json(1, __("Ошибка загрузки файла!"));
    }


    public function _set_new_password()
    {
        $this->validation->make([
            'old_password' => "required|callback__check_old_password",
            'new_password' => "required|differs[old_password]|min_length[8]|max_length[20]",
        ], [
            'old_password.required'            => __('Введите старый пароль!'),
            'old_password._check_old_password' => __('Неверный старый пароль!'),
            'new_password.differs'             => __('Новый пароль должен отличаться от старого!'),
            'new_password.min_length'          => __('Пароль слишком короткий!'),
            'new_password.max_length'          => __('Пароль слишком длинный!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $this->User2->set_password(userdata()->id, $this->input->post('new_password'));
    }


    public function _check_old_password($old_password)
    {
        return $this->User2->exists([
            'id'       => userdata()->id,
            'password' => superhash($old_password)
        ]);
    }


    /**
     * Проверяет установлен ли PayPal аккаунт администратора
     *
     * @return boolean
     */
    public function _is_set_admin_paypal_account($param)
    {
        if (!$param) {
            return true;
        }

        return (bool) filter_var($this->input->post('admin_paypal_account'), FILTER_VALIDATE_EMAIL);
    }


    /**
     * Проверяет установлены ли stripe ключи
     *
     * @return boolean
     */
    public function _is_set_admin_stripe_account($param)
    {
        if (!$param) {
            return true;
        }

        return (bool) $this->input->post('admin_stripe_secret_key') && $this->input->post('admin_stripe_pub_key');
    }


}
