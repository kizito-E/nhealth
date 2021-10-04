<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script id="gateway" type="text/html">
    {% if (o.gateway.toLowerCase() == 'paypal') { %}
    <i class="fa fa-fw fa-paypal fa-lg" style="color:#002E82;"></i> PayPal
    {% } else if(o.gateway.toLowerCase() == 'stripe') { %}
    <i class="fa fa-fw fa-cc-stripe fa-lg" style="color:#646EDE;"></i> Stripe
    {% } else if(o.gateway.toLowerCase() == 'manual') { %}
    <i class="fa fa-fw fa-cogs fa-lg"></i> Manual
    {% } %}
</script>



<script id="updown" type="text/html">
    {% if (o.up == 1) { %}
    <i class="fa fa-arrow-up text-success"></i> <?php _e('Зачисление'); ?>
    {% } else { %}
    <i class="fa fa-arrow-down text-danger"></i> <?php _e('Списание'); ?>
    {% } %}
</script>


<script id="payment-details" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default btn-sm payment-details-btn" data-payment-id="{%=o.payment_id%}">
            <i class="fa fa fa-info-circle"></i>
            <?php _e('Детали платежа'); ?>
        </button>
    </div>
</script>


<script id="payment-details-modal" type="text/html">
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title"><?php _e('Платеж: '); ?>{%=o.payment_id%}</h4>
                </div>
                <div class="modal-body">    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2"><?php _e('Основная информация'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php _e('ID платежа'); ?></td>
                                <td>{%=o.payment_id%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('ID пользователя'); ?></td>
                                <td>{%=o.user_id%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Имя пользователя'); ?></td>
                                <td>{%=o.username%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('E-mail пользователя'); ?></td>
                                <td>{%=o.email%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Шлюз'); ?></td>
                                <td>{%=o.gateway%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Сумма'); ?></td>
                                <td>{%=numeral(o.amount).format('0,0.00')%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Валюта'); ?></td>
                                <td>{%=o.currency.toUpperCase()%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Описание'); ?></td>
                                <td>{%=o.description%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Дата'); ?></td>
                                <td>{%=o.created_at%} UTC</td>
                            </tr>
                        </tbody>
                    </table>

                    {% if(o.payment_data && Object.keys(o.payment_data).length) { %}

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2"><?php _e('Дополнительная информация'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for (var i in o.payment_data) { %}
                            <tr>
                                <td>{%=i%}</td>
                                <td>{%=o.payment_data[i]%}</td>
                            </tr>
                            {% } %}
                        </tbody>
                    </table>

                    {% } %}

                </div>
                <div class="modal-footer">
                    <button  class="btn btn-default" data-dismiss="modal">
                        <?php _e('Закрыть'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</script>


