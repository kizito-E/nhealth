<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pay extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        exit;
    }


    public function stripe()
    {
        is_advertiser() OR redirect("/auth/login/");

        $token          = (string) $this->input->post('stripeToken');
        $amount_cents   = (integer) $this->input->post('amount');
        $amount_dollars = round(($amount_cents / 100), 2);

        $min_payment = config_item('min_payment');
        $max_payment = config_item('max_payment');

        // min / max payment validation
        if (($amount_dollars < $min_payment) || ($amount_dollars > $max_payment)) {
            $message = sprintf(__('Ошибка! Деньги с вашего счета не списаны! Сумма платежа должна быть не менее %s и не более %s %s'),
                $min_payment,
                $max_payment,
                get_globalsettings('current_currency', 'USD')
            );
            $this->session->set_flashdata('payment_message', $message);
            redirect('/advertiser/payments');
        }

        //pre validation token
        if (strlen($token) < 10) {
            $message = __('Ошибка! Деньги с вашего счета не списаны! Некорректный проверочный токен!');
            $this->session->set_flashdata('payment_message', $message);
            redirect('/advertiser/payments');
        }

        try {
            // set secret key
            \Stripe\Stripe::setApiKey(get_globalsettings('admin_stripe_secret_key'));

            // make payment
            $charge = \Stripe\Charge::create([
                        "amount"      => $amount_cents,
                        "currency"    => strtolower(get_globalsettings('current_currency', 'USD')),
                        "source"      => $token,
                        "description" => 'Advertiser balance replenishment.'
            ]);
        } catch (\Stripe\Error\Card $e) {
            $message = __('При пополнении баланса произошла ошибка! ') . $e->getMessage();
            $this->session->set_flashdata('payment_message', $message);
            redirect('/advertiser/payments');
        }

        $amount = round(($charge->amount / 100), 2);

        $this->User2->up_advertiser_balance(userdata()->id, $amount);

        $payment_obj = $this->Payment2->add([
            'user_id'      => userdata()->id,
            'amount'       => $amount,
            'gateway'      => 'stripe',
            'description'  => 'Advertiser balance replenishment.',
            'currency'     => $charge->currency,
            'payment_data' => null,
            'created_at'   => gmdate('Y-m-d H:i:s')
        ]);

        event('payment.add', $payment_obj);

        $message = sprintf(__('Баланс успешно пополнен на сумму %s ') . get_globalsettings('current_currency', 'USD'), round(($charge->amount / 100), 2));
        $this->session->set_flashdata('payment_message', $message);
        redirect('/advertiser/payments');
    }


    public function paypal_success()
    {
        $this->session->set_flashdata('payment_message', __('Успешное пополнение! Деньги поступят на ваш баланс в течении нескольких минут.'));
        redirect('/advertiser/payments');
    }


    public function paypal_error()
    {
        $this->session->set_flashdata('payment_message', __('Ошибка пополнения баланса!'));
        redirect('/advertiser/payments');
    }


    public function paypal_ipn()
    {
        if (!$this->paypal->ipn_validate()) {
            return false;
        }

        if (!$this->paypal->is_complete_transaction()) {
            return false;
        }

        if ($this->paypal->is_duplicate_transaction() === true) {
            return false;
        }

        $amount       = floatval($this->input->post('mc_gross'));
        $payment_data = $this->paypal->payment_data();

        $this->User2->up_advertiser_balance($payment_data['custom']['user_id'], $amount);

        $payment_obj = $this->Payment2->add([
            'payment_hid'  => $payment_data['custom']['payment_hid'],
            'user_id'      => $payment_data['custom']['user_id'],
            'amount'       => $amount,
            'gateway'      => 'paypal',
            'description'  => 'Advertiser balance replenishment.',
            'currency'     => strtoupper($payment_data["mc_currency"]),
            'payment_data' => serialize($payment_data),
            'created_at'   => gmdate('Y-m-d H:i:s')
        ]);

        event('payment.add', $payment_obj);

        header("HTTP/1.1 200 OK");
    }


}
