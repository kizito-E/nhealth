<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="pay-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php _e('Пополнение баланса') ?></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><?php _e('Сумма платежа'); ?></label>
                    <div class="input-group">
                        <input id="input-amount"
                               type="text"
                               class="form-control input-lg"
                               value="10.00"
                               data-min="<?php echo config_item('min_payment') ?>"
                               data-max="<?php echo config_item('max_payment') ?>"
                               autofocus>

                        <div class="input-group-addon">
                            <?php echo get_globalsettings('current_currency', 'USD');?>
                        </div>
                    </div>
                </div>

                <?php if (get_globalsettings('paypal_payments') && get_globalsettings('admin_paypal_account')): ?>

                    <form id="paypal-form" method='post' action='<?php echo $paypal_api_url; ?>' class="form-group">
                        <input type='hidden' name='business'
                               value='<?php echo get_globalsettings('admin_paypal_account') ?>'/>
                        <input type='hidden' name='rm' value='2'/>
                        <input type='hidden' name='cmd' value='_xclick'/>
                        <input type='hidden' name='currency_code' value='<?php echo get_globalsettings('current_currency', 'USD')?>'/>
                        <input type="hidden" name="amount" value="10">
                        <input type='hidden' name='quantity' value='1'/>
                        <input type='hidden' name='return' value='<?php echo base_url('/api/pay/paypal_success') ?>'/>
                        <input type='hidden' name='cancel_return'
                               value='<?php echo base_url('/api/pay/paypal_error') ?>'/>
                        <input type='hidden' name='notify_url' value='<?php echo base_url('/api/pay/paypal_ipn') ?>'/>
                        <input type='hidden' name='item_name' value='AdFlex advertiser account replenishment'/>
                        <input type='hidden'
                               name='custom'
                               value='<?php
                               echo json_encode([
                                   'user_id'     => userdata()->id,
                                   'payment_hid' => md5(uniqid(random_string(), true))
                               ])
                               ?>'/>
                        <button id="pay-paypal-btn" class="btn btn-block btn-lg btn-warning">Pay with <b>PayPal</b>
                        </button>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                $("#paypal-form").on("submit", function () {
                                    $("#pay-paypal-btn").prop("disabled", true).html("<i class='fa fa-circle-o-notch fa-spin fa-fw'></i>");
                                    $("#pay-stripe-btn").prop("disabled", true);
                                });
                            });
                        </script>

                    </form>

                <?php endif; ?>


                <?php if (get_globalsettings('stripe_payments')): ?>

                    <form id="stripe-form" action="/api/pay/stripe" method="POST">
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="<?php echo get_globalsettings('admin_stripe_pub_key') ?>"
                                data-currency="<?php echo get_globalsettings('current_currency', 'USD')?>"
                                data-name="AdFlex"
                                data-description="<?php _e('Пополнение аккаунта рекламодателя AdFlex') ?>"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto">
                        </script>
                        <input type="hidden" name="amount" value="1000">
                        <button id="pay-stripe-btn" class="btn btn-block btn-lg">Pay with <b>Stripe</b></button>
                    </form>

                <?php endif; ?>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Закрыть') ?></button>
            </div>

        </div>
    </div>
</div>

