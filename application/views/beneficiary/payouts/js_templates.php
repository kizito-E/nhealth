<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script id="gateway" type="text/html">
    {% if (o.payout_gateway.toLowerCase() == 'paypal') { %}
    <i class="fa fa-fw fa-paypal fa-lg" style="color:#002E82;"></i> PayPal
    {% } else if(o.payout_gateway.toLowerCase() == 'stripe') { %}
    <i class="fa fa-fw fa-cc-stripe fa-lg" style="color:#646EDE;"></i> Stripe
    {% } %}
</script>


<script id="payout-details" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default btn-sm payout-details-btn" data="{%=o.json%}">
            <i class="fa fa fa-info-circle"></i>
            <?php _e('Детали платежа'); ?>
        </button>
    </div>
</script>


<script id="payout-details-modal" type="text/html">
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title"><?php _e('Платеж: '); ?>{%=o.id%}</h4>
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
                                <td>{%=o.id%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Статус'); ?></td>
                                <td>{%=o.status%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Шлюз'); ?></td>
                                <td>{%=o.payout_gateway%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Аккаунт'); ?></td>
                                <td>{%=o.payout_account%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Сумма'); ?></td>
                                <td>{%=numeral(o.amount).format('0,0.00')%}</td>
                            </tr>
                            <tr>
                              <td><?php _e('Валюта'); ?></td>
                              <td>{%=o.currency%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Дата создания заявки'); ?></td>
                                <td>{%=o.created_at%} UTC</td>
                            </tr>
                            <tr>
                                <td><?php _e('Дата исполнения заявки'); ?></td>
                                <td>{%= o.completed_at ? o.completed_at + " UTC" : ''%} </td>
                            </tr>

                            <tr>
                                <td><?php _e('Описание'); ?></td>
                                <td>{%=o.details%} </td>
                            </tr>

                        </tbody>
                    </table>

<!--                    {% if(Object.keys(o.details).length) { %}

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2"><?php _e('Дополнительная информация'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for (var i in o.details) { %}
                            <tr>
                                <td>{%=i%}</td>
                                <td>{%=o.details[i]%}</td>
                            </tr>
                            {% } %}
                        </tbody>
                    </table>

                    {% } %}-->

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


